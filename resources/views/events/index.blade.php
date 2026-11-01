
@extends('layouts.app')

@section('title', 'Events | Warisan Malaysia')

@push('styles')
<style>
    .events-container {
        max-width: 1200px;
        width: 86%;
        margin: 40px auto;
        min-height: 55vh;
    }

    .filter-card {
        background: white;
        border: 1px solid #e8e1d5;
        border-radius: 7px;
        padding: 22px;
        margin-bottom: 28px;
    }

    .filter-card h2 {
        font-size: 19px;
        margin-bottom: 16px;
    }

    .filter-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 13px;
    }

    .filter-grid input,
    .filter-grid select {
        width: 100%;
        padding: 11px 12px;
        border: 1px solid #d8d1c6;
        border-radius: 4px;
        background: white;
        font: inherit;
        font-size: 14px;
    }

    .filter-actions {
        display: flex;
        gap: 10px;
        margin-top: 16px;
    }

    .event-results {
        color: #706b61;
        font-size: 14px;
        margin-bottom: 18px;
    }

    .events-container .event-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 22px;
    }

    .events-container .event-card {
        background: white;
        border: 1px solid #e8e1d5;
        border-radius: 7px;
        overflow: hidden;
    }

    .events-container .event-card img,
    .events-container .event-placeholder {
        width: 100%;
        height: 210px;
        object-fit: cover;
        display: block;
    }

    .events-container .event-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        background: #e8dcc6;
        color: #705b42;
    }

    .events-container .event-info {
        padding: 18px;
    }

    .events-container .event-info h3 {
        margin: 7px 0;
        font-size: 19px;
    }

    .events-container .event-info p {
        color: #706b61;
        font-size: 14px;
    }

    .events-container .event-info .event-description {
        margin: 10px 0;
        line-height: 1.5;
    }

    .events-container .event-info .event-meta {
        font-size: 13px;
        line-height: 1.8;
    }

    .empty-state {
        background: white;
        border: 1px solid #e8e1d5;
        border-radius: 7px;
        padding: 45px 20px;
        text-align: center;
    }

    .empty-state p {
        color: #706b61;
        margin-top: 8px;
    }

    @media (max-width: 900px) {
        .events-container .event-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .filter-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 600px) {
        .events-container {
            width: 90%;
        }

        .events-container .event-grid,
        .filter-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')

<main class="events-container">

    <section class="filter-card">
        <h2>Find an Event</h2>

        <form action="{{ route('events.index') }}" method="GET">

            <div class="filter-grid">

                <input
                    type="text"
                    name="search"
                    placeholder="Search events..."
                    value="{{ request('search') }}"
                >

                <select name="category">
                    <option value="">All Categories</option>

                    @foreach ($categories as $category)
                        <option value="{{ $category }}"
                            {{ request('category') == $category ? 'selected' : '' }}>
                            {{ $category }}
                        </option>
                    @endforeach
                </select>

                <select name="month">
                    <option value="">All Months</option>

                    @foreach (range(1, 12) as $month)
                        <option value="{{ $month }}"
                            {{ request('month') == $month ? 'selected' : '' }}>
                            {{ date('F', mktime(0, 0, 0, $month, 1)) }}
                        </option>
                    @endforeach
                </select>

                <select name="location">
                    <option value="">All Locations</option>

                    @foreach ($locations as $location)
                        <option value="{{ $location }}"
                            {{ request('location') == $location ? 'selected' : '' }}>
                            {{ $location }}
                        </option>
                    @endforeach
                </select>

                <select name="sort">
                    <option value="asc"
                        {{ request('sort', 'asc') == 'asc' ? 'selected' : '' }}>
                        Date: Earliest First
                    </option>

                    <option value="desc"
                        {{ request('sort') == 'desc' ? 'selected' : '' }}>
                        Date: Latest First
                    </option>
                </select>

            </div>

            <div class="filter-actions">
                <button type="submit" class="btn">
                    Apply Filters
                </button>

                <a href="{{ route('events.index') }}" class="btn btn-light">
                    Clear Filters
                </a>
            </div>

        </form>
    </section>

    <p class="event-results">
        Showing {{ $events->count() }} event(s)
    </p>

    @if ($events->count() > 0)

        <div class="event-grid">

            @foreach ($events as $event)

                <article class="event-card">

                    @php
                        $imagePath = $event->image ?: 'images/event-' . $event->id . '.jpg';

                        $fullImagePath = public_path($imagePath);
                    @endphp

                    @if (file_exists($fullImagePath))
                        <img
                            src="{{ asset($imagePath) }}"
                            alt="{{ $event->title }}"
                        >
                    @else
                        <div class="event-placeholder">
                            Event Image
                        </div>
                    @endif

                    <div class="event-info">

                        <small>{{ $event->category }}</small>

                        <h3>{{ $event->title }}</h3>

                        <p class="event-meta">
                            <strong>Date:</strong>
                            {{ $event->event_date->format('d M Y') }}
                        </p>

                        <p class="event-meta">
                            <strong>Location:</strong>
                            {{ $event->location_name ?: ($event->location->name ?? 'Malaysia') }}
                        </p>

                        <p class="event-meta">
                            <strong>Organizer:</strong>
                            {{ $event->organizer ?: ($event->performer->name ?? 'Not specified') }}
                        </p>

                        <p class="event-description">
                            {{ \Illuminate\Support\Str::limit($event->description, 110) }}
                        </p>

                        <a
                            href="{{ route('events.show', $event) }}"
                            class="view-link"
                        >
                            View Details →
                        </a>

                    </div>
                </article>

            @endforeach

        </div>

    @else

        <div class="empty-state">
            <h3>No Events Found</h3>
            <p>Try changing your search or filter options.</p>
        </div>

    @endif

</main>

@endsection
