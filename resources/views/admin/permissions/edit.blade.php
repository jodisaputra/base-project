@extends('adminlte::page')

@section('title', 'Edit Permission')

@section('content_header')
    <h1>Edit Permission</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.permissions.update', $permission) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <x-adminlte-input name="name" label="Permission Name" placeholder="Enter permission name"
                        value="{{ $permission->name }}" />
                </div>

                <div class="form-group">
                    <x-adminlte-input name="guard_name" label="Guard Name" value="{{ $permission->guard_name }}" readonly
                        disabled />
                </div>

                <x-adminlte-button type="submit" label="Update Permission" theme="primary" />
                <x-adminlte-button label="Cancel" theme="secondary" icon="fas fa-times"
                    onclick="window.location='{{ route('admin.permissions.index') }}'" />
            </form>
        </div>
    </div>
@endsection
