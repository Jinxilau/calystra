@extends('layout.default')

@section('title', 'Calystra Studio - Profile Management')

@section('assets')
@vite('resources\css\home.css')
@endsection

@section('content')
<x-slot name="header">
    <h2 class="h2 fw-semibold text-dark mb-0">
        {{ __('Profile') }}
    </h2>
</x-slot>

<!-- Main Content -->
<div class="py-5">
    <div class="container">
        <div class="row justify-content-center g-4">
            <!-- Profile Information Card -->
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-body p-4 p-md-5">
                        <div class="mx-auto" style="max-width: 500px;">
                            <livewire:profile.update-profile-information-form />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Update Password Card -->
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-body p-4 p-md-5">
                        <div class="mx-auto" style="max-width: 500px;">
                            <livewire:profile.update-password-form />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delete Account Card -->
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-body p-4 p-md-5">
                        <div class="mx-auto" style="max-width: 500px;">
                            <livewire:profile.delete-user-form />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection