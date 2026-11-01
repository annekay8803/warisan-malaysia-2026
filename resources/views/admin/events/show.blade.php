
@extends('layouts.app')

@section('title', $event->title . ' | Manage Events')

@push('styles')
<style>
    .details-container {
        max-width: 850px;
        margin: 50px auto;
        padding: 0 25px;
    }

    .details-container h1 {
        color: #6b3f2a;
        margin-bottom: 8px;
    }

    .back-link {
        color: #6b3f2a;
        text-decoration: none;
    }

    .details-card {
        background: white;
        padding: 30px;
        margin-top: 25px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .event-image {
        width: 100%;
        max-height: 350px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 25px;
    }

    .event-info {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .info-item {
        border-bottom: 1px solid #eee;
        padding-bottom: 12px;
    }

    .info-item strong {
        display: block;
        color: #6b3f2a;
        margin-bottom: 7px;
    }

    .description {
        margin-top: 25px;
        line-height: 1.7;
    }

    .description strong {
        color: #6b3f2a;
    }

    .form-actions {
        display: flex;
        gap: 10px;
        margin-top: 30px;
    }

    .btn {
        padding: 10px 18px;
        border-radius: 5px;
        text-decoration: none;
        display: inline-block;
        font-size: 14px;
    }

    .edit-btn {
        background: #6b3f2a;
        color: white;
    }

    .back-btn {
        background: #eee;
        color: #333;
    }

    @media (max-width: 600px) {
        .event-info {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')

<div class="details-container">

    <a class="back-link" href="{{ route('admin.events.index') }}">
        ← Back to Manage Events
    </a>

    <h1>{{ $event->title }}</h1>
    <p>View complete event information.</p>

    <div class="details-card">

        @php
            $imagePath = $event->image ?: 'images/event-' . $event->id . '.jpg';
        @endphp

        @if(file_exists(public_path($imagePath)))
            <img
                src="{{ asset($imagePath) }}"
                alt="{{ $event->title }}"
                class="event-image"
            >
        @endif

        <div class="event-info">

            <div class="info-item">
                <strong>Category</strong>
                {{ $event->category }}
            </div>

            <div class="info-item">
                <strong>Event Date</strong>
                {{ $event->event_date->format('d F Y') }}
            </div>

            <div class="info-item">
                <strong>Location</strong>
                {{ $event->location_name ?: ($event->location->name ?? '-') }}
            </div>

            <div class="info-item">
                <strong>Performer / Organizer</strong>
                {{ $event->organizer ?: ($event->performer->name ?? '-') }}
            </div>

            <div class="info-item">
                <strong>Status</strong>
                {{ ucfirst($event->status) }}
            </div>

        </div>

        <div class="description">
            <strong>Description</strong>
            <p>{{ $event->description ?: 'No description available.' }}</p>
        </div>

        <div class="form-actions">

            <a href="{{ route('admin.events.edit', $event) }}" class="btn edit-btn">
                Edit Event
            </a>

            <a href="{{ route('admin.events.index') }}" class="btn back-btn">
                Back
            </a>

        </div>

    </div>

</div>

@endsection
