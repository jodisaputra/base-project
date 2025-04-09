@extends('adminlte::page')

@section('title', 'Edit User')

@section('content_header')
    <h1>Edit User</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                <x-adminlte-input name="name" label="Name" placeholder="Enter name" icon="fas fa-user"
                    value="{{ old('name', $user->name) }}" required />

                <x-adminlte-input name="email" type="email" label="Email" placeholder="Enter email"
                    icon="fas fa-envelope" value="{{ old('email', $user->email) }}" required />

                <x-adminlte-input name="password" type="password" label="Password (leave empty to keep current)"
                    placeholder="Enter new password" icon="fas fa-lock" />

                <x-adminlte-input name="password_confirmation" type="password" label="Confirm Password"
                    placeholder="Confirm new password" icon="fas fa-lock" />

                <x-adminlte-button type="submit" label="Update User" theme="primary" icon="fas fa-save" />
                <x-adminlte-button label="Cancel" theme="secondary" icon="fas fa-times"
                    onclick="window.location='{{ route('admin.users.index') }}'" />
            </form>
        </div>
    </div>
@endsection
