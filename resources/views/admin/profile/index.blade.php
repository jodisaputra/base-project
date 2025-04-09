@extends('adminlte::page')

@section('title', 'User Profile')

@section('content_header')
    <h1>User Profile</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle" src="{{ Auth::user()->adminlte_image() }}"
                            alt="User profile picture" style="width: 150px; height: 150px; object-fit: cover;">
                    </div>
                    <h3 class="profile-username text-center mt-3">{{ $profile->name }}</h3>
                    <p class="text-muted text-center">{{ $profile->email }}</p>

                    <form action="{{ route('profile.avatar') }}" method="POST" enctype="multipart/form-data"
                        class="mt-3">
                        @csrf
                        <div class="text-center">
                            <x-adminlte-input-file name="avatar" igroup-size="sm" placeholder="Choose new picture..."
                                legend="Select">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-primary">
                                        <i class="fas fa-camera"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input-file>
                            <x-adminlte-button type="submit" theme="primary" label="Update Picture" class="mt-2"
                                icon="fas fa-upload" />
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header p-2">
                    <h3 class="card-title p-1">Profile Information</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')

                        <x-adminlte-input name="name" label="Name" value="{{ old('name', $profile->name) }}"
                            icon="fas fa-user" />

                        <x-adminlte-input name="email" type="email" label="Email"
                            value="{{ old('email', $profile->email) }}" icon="fas fa-envelope" readonly />

                        <x-adminlte-input name="password" type="password" label="New Password" icon="fas fa-lock" />

                        <x-adminlte-input name="password_confirmation" type="password" label="Confirm Password"
                            icon="fas fa-lock" />

                        <div class="mt-4">
                            <x-adminlte-button type="submit" label="Save Changes" theme="primary" icon="fas fa-save" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
