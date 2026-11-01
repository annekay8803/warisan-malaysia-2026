
@extends('layouts.app')

@section('title', $event->title . ' | Warisan Malaysia')

@push('styles')
<style>
    .event-detail-container {
        max-width: 1000px;
        width: 86%;
        margin: 45px auto;
        min-height: 55vh;
    }

    .event-detail-heading {
        margin-bottom: 25px;
    }

    .event-detail-heading .event-category {
        color: #8a5037;
        font-size: 13px;
        font-weight: bold;
        text-transform: uppercase;
    }

    .event-detail-heading h1 {
        font-size: 32px;
        margin-top: 8px;
        color: #30251f;
    }

   .event-detail-image {
        width: 100%;
        height: 380px;
        object-fit: cover;
        border-radius: 7px;
        margin-bottom: 25px;
    }

    .event-detail-card {
        background: white;
        border: 1px solid #e8e1d5;
        border-radius: 7px;
        padding: 25px;
        margin-bottom: 22px;
    }

    .event-detail-card h2 {
        font-size: 21px;
        margin-bottom: 16px;
    }

    .event-detail-card p {
        color: #5f5a52;
        line-height: 1.7;
        margin-bottom: 12px;
    }

    .event-detail-card p:last-child {
        margin-bottom: 0;
    }

    .event-detail-description {
        margin-bottom: 22px;
    }

    .event-detail-container .form-group {
        margin-bottom: 16px;
    }

    .event-detail-container .form-group label {
        display: block;
        margin-bottom: 7px;
        font-weight: 600;
    }

    .event-detail-container .form-group input {
        width: 100%;
        padding: 11px;
        border: 1px solid #d8d1c6;
        border-radius: 4px;
        font: inherit;
    }

    .event-detail-container .notice {
        background: #f5eee8;
        border-left: 4px solid #8a5037;
        padding: 15px;
        margin-bottom: 20px;
        color: #5f4638;
    }

    .event-detail-container .field-error {
        display: block;
        color: #b42318;
        margin-top: 5px;
    }

    @media (max-width: 600px) {
        .event-detail-container {
            width: 90%;
        }

        .event-detail-heading h1 {
            font-size: 26px;
        }

        .event-detail-card {
            padding: 18px;
        }
    }
</style>
@endpush

@section('content')

<main class="event-detail-container">

    <div class="event-detail-heading">
        <span class="event-category">{{ $event->category }}</span>
        <h1>{{ $event->title }}</h1>
    </div>

@php
    $imagePath = $event->image ?: 'images/event-' . $event->id . '.jpg';
@endphp

@if (file_exists(public_path($imagePath)))
    <img
        src="{{ asset($imagePath) }}"
        alt="{{ $event->title }}"
        class="event-detail-image"
    >
@endif

    <section class="event-detail-card">

        <h2>About This Event</h2>

        <p class="event-detail-description">
            {{ $event->description }}
        </p>

        <p>
            <strong>Date:</strong>
            {{ $event->event_date->format('d M Y') }}
        </p>

        <p>
            <strong>Location:</strong>
            {{ $event->location?->name ?? $event->location_name ?? 'Malaysia' }}
        </p>

        <p>
            <strong>Organizer / Performer:</strong>
            {{ $event->performer?->name ?? $event->organizer ?? 'Not specified' }}
        </p>

        <p>
            <strong>Status:</strong>
            {{ ucfirst($event->status) }}
        </p>

    </section>

    @auth

        @if (
            auth()->user()->role === 'user' &&
            $event->status === 'upcoming' &&
            !$event->event_date->lt(today())
        )

            <section class="event-detail-card">

                <h2>Register for This Event</h2>

                @if (session('success'))
                    <div class="alert success">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('user.registrations.store') }}" method="POST">

                    @csrf

                    <input type="hidden" name="event_id" value="{{ $event->id }}">

                    <div class="form-group">
                        <label for="attendee_name">Full Name</label>

                        <input
                            type="text"
                            id="attendee_name"
                            name="attendee_name"
                            value="{{ old('attendee_name', auth()->user()->name) }}"
                            required
                        >

                        @error('attendee_name')
                            <small class="field-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Email Address</label>

                        <input
                            type="email"
                            value="{{ auth()->user()->email }}"
                            readonly
                        >
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone Number</label>

                        <input
                            type="text"
                            id="phone"
                            name="phone"
                            value="{{ old('phone') }}"
                            required
                        >

                        @error('phone')
                            <small class="field-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="number_of_tickets">Number of Pax</label>

                        <input
                            type="number"
                            id="number_of_tickets"
                            name="number_of_tickets"
                            min="1"
                            value="{{ old('number_of_tickets', 1) }}"
                            required
                        >

                        @error('number_of_tickets')
                            <small class="field-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <button type="submit" class="btn">
                        Submit Registration
                    </button>

                </form>

            </section>

        @elseif (auth()->user()->role === 'admin')

            <p class="notice">
                Administrators can manage this event from the Manage Events page.
            </p>

        @else

            <p class="notice">
                Registration is not available for this event.
            </p>

        @endif

    @else

        <section class="event-detail-card">
            <p>
                Please
                <a href="{{ url('/login') }}">log in</a>
                to register for this event.
            </p>
        </section>

    @endauth

    <a href="{{ route('events.index') }}" class="view-link">
        ← Back to Events
    </a>

</main>

@endsection
