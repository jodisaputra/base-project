@extends('adminlte::page')

@section('title', 'Create Permission')

@section('content_header')
    <h1>Create Permission</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.permissions.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <x-adminlte-input name="name" label="Permission Name" placeholder="Enter permission name" />
                </div>

                <div class="form-group">
                    <x-adminlte-input name="guard_name" label="Guard Name" value="web" readonly disabled />
                </div>

                <x-adminlte-button type="submit" label="Create Permission" theme="primary" />
                <x-adminlte-button label="Cancel" theme="secondary" icon="fas fa-times"
                    onclick="window.location='{{ route('admin.permissions.index') }}'" />
            </form>
        </div>
    </div>
@endsection
