@extends('layouts.app')

@section('title', 'Manage Events')

@push('styles')
<style>
    .admin-container {
        max-width: 1200px;
        margin: 50px auto;
        padding: 0 25px;
    }

    .heading-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-bottom: 25px;
    }

    .admin-container h1 {
        color: #6b3f2a;
        margin-bottom: 8px;
    }

    .btn {
        padding: 10px 16px;
        border: none;
        border-radius: 5px;
        text-decoration: none;
        display: inline-block;
        cursor: pointer;
        font-size: 13px;
    }

    .add-btn, .search-btn {
        background: #6b3f2a;
        color: white;
    }

    .clear-btn {
        background: #eee;
        color: #333;
    }

    .search-form {
        display: flex;
        gap: 10px;
        margin: 25px 0;
    }

    .search-form input {
        width: 280px;
        padding: 10px 14px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .table-wrapper {
        overflow-x: auto;
        background: white;
        border-radius: 8px;
        margin-top: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 750px;
    }

    th, td {
        padding: 14px 15px;
        text-align: left;
        border-bottom: 1px solid #eee;
        font-size: 14px;
    }

    th {
        background: #6b3f2a;
        color: white;
    }

    tr:hover {
        background: #faf7f3;
    }

    .actions {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .actions a {
        color: #6b3f2a;
        text-decoration: none;
    }

    .actions a:hover {
        text-decoration: underline;
    }

    .actions form {
        margin: 0;
    }

    .delete-btn {
        background: none;
        border: none;
        padding: 0;
        color: #a94442;
        cursor: pointer;
        font-size: 14px;
    }

    .alert {
        padding: 12px;
        margin: 15px 0;
        border-radius: 5px;
        background: #dff0d8;
        color: #3c763d;
    }

    .empty-message {
        text-align: center;
        padding: 25px;
    }

    @media (max-width: 600px) {
        .heading-row {
            align-items: flex-start;
            flex-direction: column;
        }

        .search-form input {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')

<div class="admin-container">

    <div class="heading-row">
        <div>
            <h1>Manage Events</h1>
            <p>Add, view, update and delete cultural events.</p>
        </div>

        <a href="{{ route('admin.events.create') }}" class="btn add-btn">
            + Add New Event
        </a>
    </div>

    @if(session('success'))
        <div class="alert">
            {{ session('success') }}
        </div>
    @endif

    <form method="GET"
          action="{{ route('admin.events.index') }}"
          class="search-form">

        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Search events..."
        >

        <button type="submit" class="btn search-btn">
            Search
        </button>

        <a href="{{ route('admin.events.index') }}" class="btn clear-btn">
            Clear
        </a>
    </form>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Event</th>
                    <th>Category</th>
                    <th>Location</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($events as $event)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $event->title }}</td>

                        <td>{{ $event->category }}</td>

                        <td>
                            {{ $event->location_name ?: ($event->location->name ?? '-') }}
                        </td>

                        <td>
                            {{ $event->event_date->format('d M Y') }}
                        </td>

                        <td>{{ ucfirst($event->status) }}</td>

                        <td>
                            <div class="actions">

                                <a href="{{ route('admin.events.show', $event) }}">
                                    View
                                </a>

                                <a href="{{ route('admin.events.edit', $event) }}">
                                    Edit
                                </a>

                                <form
                                    action="{{ route('admin.events.destroy', $event) }}"
                                    method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this event?')"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="delete-btn">
                                        Delete
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="7" class="empty-message">
                            No events found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection
