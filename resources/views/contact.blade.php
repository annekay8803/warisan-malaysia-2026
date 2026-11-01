
@extends('layouts.app')

@section('title', 'Contact Us | Warisan Malaysia')

@push('styles')
<style>
    .contact-container {
        max-width: 700px;
        margin: 50px auto;
        padding: 0 25px;
    }

    .contact-heading {
        text-align: center;
        margin-bottom: 30px;
    }

    .contact-heading h1 {
        color: #6b3f2a;
        margin-bottom: 10px;
    }

    .contact-heading p {
        color: #666;
    }

    .contact-card {
        background: white;
        padding: 35px;
        border-radius: 10px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.07);
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        font-size: 14px;
        color: #444;
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        box-sizing: border-box;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-family: inherit;
        font-size: 14px;
    }

    .form-group textarea {
        resize: vertical;
        min-height: 130px;
    }

    .form-group input:focus,
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

    .alert {
        padding: 12px;
        border-radius: 5px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .alert.success {
        background: #dff0d8;
        color: #3c763d;
    }

    .alert.error {
        background: #f2dede;
        color: #a94442;
    }

    .contact-btn {
        width: 100%;
        padding: 13px;
        background: #6b3f2a;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 15px;
        cursor: pointer;
    }

    .contact-btn:hover {
        background: #52301f;
    }
</style>
@endpush

@section('content')

<div class="contact-container">

    <div class="contact-heading">
        <h1>Contact Us</h1>
        <p>Have a question or feedback? Send us a message.</p>
    </div>

    <div class="contact-card">

        @if(session('success'))
            <div class="alert success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert error">
                Please check the form and correct the highlighted errors.
            </div>
        @endif

        <form action="{{ route('contact.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Full Name</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Enter your full name"
                    required
                >
                @error('name')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Enter your email"
                    required
                >
                @error('email')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="subject">Subject</label>
                <input
                    type="text"
                    id="subject"
                    name="subject"
                    value="{{ old('subject') }}"
                    placeholder="Enter message subject"
                    required
                >
                @error('subject')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="message">Message</label>
                <textarea
                    id="message"
                    name="message"
                    placeholder="Write your message here..."
                    required
                >{{ old('message') }}</textarea>
                @error('message')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="contact-btn">
                Send Message
            </button>

        </form>

    </div>

</div>

@endsection
