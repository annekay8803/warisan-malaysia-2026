
@extends('layouts.app')

@section('title', 'Add New Event')

@push('styles')
<style>
    .create-container {
        max-width: 800px;
        margin: 50px auto;
        padding: 0 25px;
    }

    .create-container h1 {
        color: #6b3f2a;
        margin-bottom: 8px;
    }

    .back-link {
        color: #6b3f2a;
        text-decoration: none;
    }

    .form-card {
        background: white;
        padding: 30px;
        margin-top: 25px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        font-size: 14px;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        box-sizing: border-box;
        padding: 11px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-family: Arial, sans-serif;
        font-size: 14px;
    }

    .form-group textarea {
        resize: vertical;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #6b3f2a;
    }

    .field-error {
        display: block;
        color: #a94442;
        margin-top: 6px;
        font-size: 13px;
    }

    .error-alert {
        background: #f2dede;
        color: #a94442;
        padding: 12px;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    .form-actions {
        display: flex;
        gap: 10px;
        margin-top: 25px;
    }

    .btn {
        padding: 11px 20px;
        border: none;
        border-radius: 5px;
        text-decoration: none;
        display: inline-block;
        cursor: pointer;
        font-size: 14px;
    }

    .save-btn {
        background: #6b3f2a;
        color: white;
    }

    .save-btn:hover {
        background: #52301f;
    }

    .cancel-btn {
        background: #eee;
        color: #333;
    }

    @media (max-width: 600px) {
        .form-card {
            padding: 20px;
        }
    }
</style>
@endpush

@section('content')

<div class="create-container">

    <a class="back-link" href="{{ route('admin.events.index') }}">
        ← Back to Manage Events
    </a>

    <h1>Add New Event</h1>
    <p>Enter the details of the cultural event.</p>

    <div class="form-card">

        @if($errors->any())
            <div class="error-alert">
                Please check the form and correct the errors.
            </div>
        @endif

        <form action="{{ route('admin.events.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="title">Event Title</label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    value="{{ old('title') }}"
                    required
                >
                @error('title')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="category">Category</label>
                <select id="category" name="category" required>
                    <option value="">Select a category</option>

                    @foreach($categories as $category)
                        <option value="{{ $category }}"
                            @selected(old('category') === $category)>
                            {{ $category }}
                        </option>
                    @endforeach
                </select>

                @error('category')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea
                    id="description"
                    name="description"
                    rows="5"
                    required
                >{{ old('description') }}</textarea>

                @error('description')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="location_name">Location / Venue</label>
                <input
                    type="text"
                    id="location_name"
                    name="location_name"
                    value="{{ old('location_name') }}"
                    placeholder="e.g. Istana Budaya, Kuala Lumpur"
                    required
                >

                @error('location_name')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="organizer">Organizer / Performer</label>
                <input
                    type="text"
                    id="organizer"
                    name="organizer"
                    value="{{ old('organizer') }}"
                    placeholder="e.g. Malaysian Cultural Dance Group"
                >

                @error('organizer')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="event_date">Event Date</label>
                <input
                    type="date"
                    id="event_date"
                    name="event_date"
                    value="{{ old('event_date') }}"
                    required
                >

                @error('event_date')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" required>
                    @foreach(['upcoming', 'ongoing', 'completed', 'cancelled'] as $status)
                        <option value="{{ $status }}"
                            @selected(old('status', 'upcoming') === $status)>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>

                @error('status')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn save-btn">
                    Save Event
                </button>

                <a href="{{ route('admin.events.index') }}" class="btn cancel-btn">
                    Cancel
                </a>
            </div>

        </form>

    </div>

</div>

@endsection
