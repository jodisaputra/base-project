@extends('adminlte::page')

@section('title', 'Create User')

@section('content_header')
    <h1>Create User</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <x-adminlte-input name="name" label="Name" placeholder="Enter name"/>
            </div>

            <div class="form-group">
                <x-adminlte-input name="email" type="email" label="Email" placeholder="Enter email"/>
            </div>

            <div class="form-group">
                <x-adminlte-input name="password" type="password" label="Password" placeholder="Enter password"/>
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
                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                @endforeach
            </x-adminlte-select2>

            <x-adminlte-button type="submit" label="Create User" theme="primary"/>
        </form>
    </div>
</div>
@stop
