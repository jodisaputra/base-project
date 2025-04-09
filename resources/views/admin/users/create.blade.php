@extends('adminlte::page')

@section('title', 'Create User')

@section('content_header')
    <h1>Create User</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                <x-adminlte-input name="name" label="Name" placeholder="Enter name" icon="fas fa-user"
                    value="{{ old('name') }}" required />

                <x-adminlte-input name="email" type="email" label="Email" placeholder="Enter email"
                    icon="fas fa-envelope" value="{{ old('email') }}" required />

                <x-adminlte-input name="password" type="password" label="Password" placeholder="Enter password"
                    icon="fas fa-lock" required />

                <x-adminlte-input name="password_confirmation" type="password" label="Confirm Password"
                    placeholder="Confirm password" icon="fas fa-lock" required />

                <x-adminlte-button type="submit" label="Create User" theme="primary" icon="fas fa-save" />
                <x-adminlte-button label="Cancel" theme="secondary" icon="fas fa-times"
                    onclick="window.location='{{ route('admin.users.index') }}'" />
            </form>
        </div>
    </div>
@endsection
