```php
@extends('layouts.app')

@section('title', 'Edit Registration')

@push('styles')
<style>
    .edit-container {
        max-width: 650px;
        margin: 50px auto;
        padding: 0 25px;
    }

    .edit-form {
        background: white;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .edit-form h1 {
        color: #6b3f2a;
        margin-top: 15px;
        margin-bottom: 8px;
    }

    .back-link {
        color: #6b3f2a;
        text-decoration: none;
    }

    .edit-form label {
        display: block;
        margin-top: 18px;
        font-weight: bold;
        font-size: 14px;
    }

    .edit-form input,
    .edit-form select {
        width: 100%;
        box-sizing: border-box;
        padding: 11px;
        margin-top: 7px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 14px;
    }

    .edit-form input:focus,
    .edit-form select:focus {
        outline: none;
        border-color: #6b3f2a;
    }

    .edit-form input[readonly] {
        background: #f1f1f1;
        cursor: not-allowed;
    }

    .save-btn {
        margin-top: 25px;
        padding: 11px 20px;
        background: #6b3f2a;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
    }

    .save-btn:hover {
        background: #52301f;
    }

    .error-message {
        color: #a94442;
        background: #f2dede;
        padding: 10px;
        border-radius: 5px;
        margin-top: 10px;
        font-size: 14px;
    }

    .success-message {
        color: #3c763d;
        background: #dff0d8;
        padding: 10px;
        border-radius: 5px;
        margin-top: 10px;
    }
</style>
@endpush

@section('content')

<div class="edit-container">

    <div class="edit-form">

        <a class="back-link" href="{{ route('user.registrations.index') }}">
            ← Back to My Registrations
        </a>

        <h1>Edit Registration</h1>
        <p>Update your participant details below.</p>

        @if($errors->any())
            <div class="error-message">
                <strong>Please check the following:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('error'))
            <div class="error-message">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST"
              action="{{ route('user.registrations.update', $registration->id) }}">

            @csrf
            @method('PUT')

            <label>Event</label>
            <select name="event_id" required>
                @foreach($events as $event)
                    <option value="{{ $event->id }}"
                        {{ old('event_id', $registration->event_id) == $event->id ? 'selected' : '' }}>
                        {{ $event->title }} — {{ $event->event_date->format('d M Y') }}
                    </option>
                @endforeach
            </select>

            <label>Full Name</label>
            <input
                type="text"
                name="attendee_name"
                value="{{ old('attendee_name', $registration->attendee_name) }}"
                required
            >

            <label>Email Address</label>
            <input
                type="email"
                value="{{ $registration->user->email }}"
                readonly
            >

            <label>Phone Number</label>
            <input
                type="tel"
                name="phone"
                value="{{ old('phone', $registration->phone) }}"
                required
            >

            <label>Number of Pax</label>
            <input
                type="number"
                name="number_of_tickets"
                min="1"
                value="{{ old('number_of_tickets', $registration->number_of_tickets) }}"
                required
            >

            <button type="submit" class="save-btn">
                Save Changes
            </button>

        </form>

    </div>

</div>

@endsection
```