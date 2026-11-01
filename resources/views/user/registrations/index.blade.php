
@extends('layouts.app')

@section('title', 'My Registrations')

@push('styles')
<style>
    .registrations-container {
        max-width: 1200px;
        margin: 50px auto;
        padding: 0 25px;
    }

    .registrations-container h1 {
        color: #6b3f2a;
        margin-bottom: 8px;
    }

    .search-form {
        display: flex;
        gap: 10px;
        margin: 25px 0;
    }

    .search-form input {
        padding: 10px 14px;
        border: 1px solid #ccc;
        border-radius: 5px;
        width: 280px;
    }

    .search-form button,
    .btn {
        padding: 9px 14px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        font-size: 13px;
    }

    .search-form button,
    .edit-btn {
        background: #6b3f2a;
        color: white;
    }

    .cancel-btn {
        background: #a94442;
        color: white;
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
        min-width: 950px;
    }

    th, td {
        padding: 14px 12px;
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

    .status {
        font-weight: bold;
    }

    .message {
        padding: 12px;
        margin: 15px 0;
        background: #dff0d8;
        border-radius: 5px;
    }

    .error {
        background: #f2dede;
    }

    .empty-message {
        text-align: center;
        padding: 25px;
    }

    .action-buttons {
        display: flex;
        gap: 6px;
        align-items: center;
    }

    .action-buttons form {
        margin: 0;
    }
</style>
@endpush

@section('content')

<div class="registrations-container">

    <h1>My Registrations</h1>
    <p>View and manage your event registrations.</p>

    @if(session('success'))
        <div class="message">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="message error">{{ session('error') }}</div>
    @endif

    <form class="search-form" method="GET" action="{{ route('user.registrations.index') }}">
        <input
            type="text"
            name="search"
            placeholder="Search event..."
            value="{{ request('search') }}"
        >

        <button type="submit">Search</button>

        <a href="{{ route('user.registrations.index') }}">Clear</a>
    </form>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Event</th>
                    <th>Category</th>
                    <th>Event Date</th>
                    <th>Location</th>
                    <th>Participant</th>
                    <th>Pax</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($registrations as $registration)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $registration->event->title }}</td>

                        <td>{{ $registration->event->category }}</td>

                        <td>
                            {{ $registration->event->event_date->format('d M Y') }}
                        </td>

                        <td>
                            {{ $registration->event->location->name ?? 'Not specified' }}
                        </td>

                        <td>{{ $registration->attendee_name }}</td>

                        <td>{{ $registration->number_of_tickets }}</td>

                        <td class="status">
                            {{ ucfirst($registration->status) }}
                        </td>

                        <td>
                            <div class="action-buttons">
                                <a
                                    class="btn edit-btn"
                                    href="{{ route('user.registrations.edit', $registration->id) }}"
                                >
                                    Edit
                                </a>

                                <form
                                    method="POST"
                                    action="{{ route('user.registrations.destroy', $registration->id) }}"
                                    onsubmit="return confirm('Are you sure you want to cancel this registration?');"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn cancel-btn">
                                        Cancel
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="empty-message">
                            You have no registrations yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection
