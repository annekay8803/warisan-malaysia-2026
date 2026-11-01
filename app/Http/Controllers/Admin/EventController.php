<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Location;
use App\Models\Performer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EventController extends Controller
{
    private function checkAdmin(): void
    {
        abort_unless(auth()->check() && auth()->user()->role === 'admin', 403);
    }

    private function categories(): array
    {
        return [
            'Traditional Arts & Dance',
            'Cultural Festivals',
            'Historical Heritage',
            'Arts & Crafts',
            'Music & Performance',
            'Food & Culinary Heritage',
            'Traditional Games & Sports',
            'Cultural Exhibitions',
            'Heritage & Educational Tours',
        ];
    }

    public function index(Request $request)
    {
        $this->checkAdmin();

        $events = Event::query()
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('category', 'like', "%{$search}%")
                        ->orWhere('location_name', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->get();

        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        $this->checkAdmin();

        $categories = $this->categories();

        return view('admin.events.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->checkAdmin();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => ['required', Rule::in($this->categories())],
            'description' => 'required|string',
            'location_name' => 'required|string|max:255',
            'organizer' => 'nullable|string|max:255',
            'event_date' => 'required|date',
            'status' => 'required|in:upcoming,ongoing,completed,cancelled',
        ]);

        // Automatically create or reuse the location
        $location = Location::firstOrCreate([
            'name' => trim($validated['location_name']),
        ]);

        // Automatically create or reuse the performer
        $performer = null;

        if (!empty(trim($validated['organizer'] ?? ''))) {
            $performer = Performer::firstOrCreate([
                'name' => trim($validated['organizer']),
            ]);
        }

        unset($validated['organizer']);

        $validated['location_id'] = $location->id;
        $validated['performer_id'] = $performer?->id;

        Event::create($validated);

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event added successfully!');
    }

    public function show(Event $event)
    {
        $this->checkAdmin();

        return view('admin.events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        $this->checkAdmin();

        $categories = $this->categories();

        return view('admin.events.edit', compact('event', 'categories'));
    }

    public function update(Request $request, Event $event)
    {
        $this->checkAdmin();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => ['required', Rule::in($this->categories())],
            'description' => 'required|string',
            'location_name' => 'required|string|max:255',
            'organizer' => 'nullable|string|max:255',
            'event_date' => 'required|date',
            'status' => 'required|in:upcoming,ongoing,completed,cancelled',
        ]);

        // Automatically create or reuse the location
        $location = Location::firstOrCreate([
            'name' => trim($validated['location_name']),
        ]);

        // Automatically create or reuse the performer
        $performer = null;

        if (!empty(trim($validated['organizer'] ?? ''))) {
            $performer = Performer::firstOrCreate([
                'name' => trim($validated['organizer']),
            ]);
        }

        unset($validated['organizer']);

        $validated['location_id'] = $location->id;
        $validated['performer_id'] = $performer?->id;

        $event->update($validated);

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event updated successfully!');
    }

    public function destroy(Event $event)
    {
        $this->checkAdmin();

        $event->delete();

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event deleted successfully!');
    }
}

