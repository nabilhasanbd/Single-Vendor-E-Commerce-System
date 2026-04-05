@extends('layouts.app')

@section('title', 'Profile — ' . config('app.name'))

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h1 class="h4 mb-4">Your profile</h1>
                    <dl class="row mb-0">
                        <dt class="col-sm-4 text-muted">Name</dt>
                        <dd class="col-sm-8">{{ auth()->user()->name }}</dd>
                        <dt class="col-sm-4 text-muted">Email</dt>
                        <dd class="col-sm-8">{{ auth()->user()->email }}</dd>
                        <dt class="col-sm-4 text-muted">Role</dt>
                        <dd class="col-sm-8 text-capitalize">{{ auth()->user()->role }}</dd>
                    </dl>
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-primary mt-4">Back to dashboard</a>
                </div>
            </div>
        </div>
    </div>
@endsection
