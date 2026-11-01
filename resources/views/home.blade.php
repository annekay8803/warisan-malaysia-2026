

@extends('layouts.app')

@section('title', 'Warisan Malaysia | Cultural & Heritage Events')

@section('before-navbar')
    <section class="hero" style="background-image: linear-gradient(90deg, rgba(0,0,0,0.58), rgba(0,0,0,0.12)), url('{{ asset('images/hero-banner.jpg') }}');">
        <div class="hero-content">

            <h1>Celebrate the Culture That Makes Us Malaysia.</h1>

            <p>
                Explore cultural festivals, traditional performances and heritage events
                from different communities across Malaysia. Discover the stories, people
                and traditions behind every celebration.
            </p>

        </div>
    </section>
@endsection

@section('content')

<section class="section" id="events">

    <div class="section-heading">
        <h2>Featured Cultural Events</h2>
        <p>Discover celebrations and traditions from across Malaysia.</p>
    </div>

    <div class="event-grid">

        @forelse($events as $event)

            @php
                $imagePath = $event->image ?: 'images/event-' . $event->id . '.jpg';
                $fullImagePath = public_path($imagePath);
            @endphp

            <article class="event-card">

                @if(file_exists($fullImagePath))
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

                    <p class="event-description">
                        {{ $event->description }}
                    </p>

                    <p class="event-meta">
                        {{ $event->event_date->format('d M Y') }}
                        ·
                        {{ $event->location_name ?: ($event->location->name ?? 'Malaysia') }}
                    </p>

                    <a
                        href="{{ route('events.show', $event) }}"
                        class="view-link"
                    >
                        View Details →
                    </a>

                </div>

            </article>

        @empty

            <p>No events available at the moment.</p>

        @endforelse

    </div>

</section>

@endsection
