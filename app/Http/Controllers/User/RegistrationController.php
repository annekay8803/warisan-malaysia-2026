<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\Event;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function index(Request $request)
    {
        $registrations = Registration::with('event.location')
            ->where('user_id', auth()->id())
            ->when($request->search, function ($query, $search) {
                $query->whereHas('event', function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('category', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->get();

        return view('user.registrations.index', compact('registrations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'attendee_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'number_of_tickets' => 'required|integer|min:1',
        ]);

        $event = Event::findOrFail($validated['event_id']);

        if ($event->status !== 'upcoming' || $event->event_date->lt(today())) {
            return back()->with('error', 'This event is not available for registration.');
        }

        if (Registration::where('user_id', auth()->id())
            ->where('event_id', $event->id)->exists()) {
            return back()->with('error', 'You have already registered for this event.');
        }

        Registration::create([
            'user_id' => auth()->id(),
            'event_id' => $event->id,
            'registration_date' => today(),
            'status' => 'registered',
            'attendee_name' => $validated['attendee_name'],
            'phone' => $validated['phone'],
            'number_of_tickets' => $validated['number_of_tickets'],
        ]);

        return redirect()->route('user.registrations.index')
            ->with('success', 'Your registration has been submitted successfully!');
    }

    public function edit(Registration $registration)
    {
        abort_unless($registration->user_id === auth()->id(), 403);

        $events = Event::where('status', 'upcoming')
            ->whereDate('event_date', '>=', today())
            ->orderBy('event_date')
            ->get();

        return view('user.registrations.edit', compact('registration', 'events'));
    }

    public function update(Request $request, Registration $registration)
    {
        abort_unless($registration->user_id === auth()->id(), 403);

        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'attendee_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'number_of_tickets' => 'required|integer|min:1',
        ]);

        $event = Event::findOrFail($validated['event_id']);

        if ($event->status !== 'upcoming' || $event->event_date->lt(today())) {
            return back()->with('error', 'This event is not available.');
        }

        if (Registration::where('user_id', auth()->id())
            ->where('event_id', $event->id)
            ->where('id', '!=', $registration->id)
            ->exists()) {
            return back()->with('error', 'You are already registered for this event.');
        }

        $registration->update([
            'event_id' => $event->id,
            'attendee_name' => $validated['attendee_name'],
            'phone' => $validated['phone'],
            'number_of_tickets' => $validated['number_of_tickets'],
        ]);

        return redirect()->route('user.registrations.index')
            ->with('success', 'Registration updated successfully!');
    }

    public function destroy(Registration $registration)
    {
        abort_unless($registration->user_id === auth()->id(), 403);

        $registration->delete();

        return redirect()->route('user.registrations.index')
            ->with('success', 'Registration cancelled successfully.');
    }
}