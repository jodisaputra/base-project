@extends('adminlte::page')

@section('title', 'Edit User')

@section('content_header')
    <h1>Edit User</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <x-adminlte-input name="name" label="Name" placeholder="Enter name" value="{{ $user->name }}"/>
                </div>

                <div class="form-group">
                    <x-adminlte-input name="email" type="email" label="Email" placeholder="Enter email" value="{{ $user->email }}"/>
                </div>

                <div class="form-group">
                    <x-adminlte-input name="password" type="password" label="Password" placeholder="Enter password to change"/>
                    <small class="form-text text-muted">Leave empty to keep current password</small>
                </div>

                <div class="form-group">
                    <x-adminlte-input name="password_confirmation" type="password" label="Confirm Password" placeholder="Confirm password"/>
                </div>

                @php
                    $config = [
                        'placeholder' => 'Select roles',
                        'allowClear' => true,
                    ];
                @endphp

                <x-adminlte-select2 id="roles" name="roles[]" label="Roles" :config="$config" multiple>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </x-adminlte-select2>

                <x-adminlte-button type="submit" label="Update User" theme="primary"/>
            </form>
        </div>
    </div>
@stop
