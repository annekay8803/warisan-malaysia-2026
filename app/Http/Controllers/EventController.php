<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with(['location', 'performer'])
            ->where('status', '!=', 'cancelled');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhere('location_name', 'like', "%{$search}%")
                    ->orWhere('organizer', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('month')) {
            $month = (int) $request->month;

            if ($month >= 1 && $month <= 12) {
                $query->whereMonth('event_date', $month);
            }
        }

        if ($request->filled('location')) {
            $query->where('location_name', $request->location);
        }

        $sort = $request->get('sort', 'asc');

        if (!in_array($sort, ['asc', 'desc'])) {
            $sort = 'asc';
        }

        $events = $query->orderBy('event_date', $sort)->get();

        $categories = Event::whereNotNull('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        $locations = Event::whereNotNull('location_name')
            ->where('location_name', '!=', '')
            ->distinct()
            ->orderBy('location_name')
            ->pluck('location_name');

        return view('events.index', compact(
            'events',
            'categories',
            'locations'
        ));
    }

    public function show(Event $event)
    {
        $event->load(['location', 'performer', 'schedules']);

        return view('events.show', compact('event'));
    }
}
