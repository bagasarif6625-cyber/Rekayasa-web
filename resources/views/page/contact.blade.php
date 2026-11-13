@extends('layouts.app')

@section('title', 'Contact')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="mb-4 text-center">
                <h1 class="h2">Hubungi Saya</h1>
                <p class="text-muted">Ada pertanyaan atau ingin berdiskusi? Kirim pesan lewat formulir ini.</p>
            </div>

            @if (session('success'))
                <div class="alert alert-success" role="alert">{{ session('success') }}</div>
            @endif

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('contact.send') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label" for="name">Nama</label>
                            <input class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                                type="text" value="{{ old('name') }}" maxlength="100" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="email">Email</label>
                            <input class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                                type="email" value="{{ old('email') }}" maxlength="255" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label" for="message">Pesan</label>
                            <textarea class="form-control @error('message') is-invalid @enderror" id="message"
                                name="message" rows="5" maxlength="5000" required>{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button class="btn btn-primary" type="submit">Kirim Pesan</button>
                        <a class="btn btn-outline-secondary ms-2" href="mailto:bagasarif6625@gmail.com">Email langsung</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
