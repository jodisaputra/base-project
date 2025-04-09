@extends('adminlte::page')

@section('title', 'Create Role')

@section('content_header')
    <h1>Create Role</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.roles.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <x-adminlte-input name="name" label="Role Name" placeholder="Enter role name" />
                </div>

                <div class="form-group">
                    @php
                        $config = [
                            'placeholder' => 'Select permissions',
                            'allowClear' => true,
                        ];
                    @endphp

                    <x-adminlte-select2 id="permissions" name="permissions[]" label="Permissions" :config="$config" multiple>
                        @foreach ($permissions as $permission)
                            <option value="{{ $permission->name }}"
                                {{ in_array($permission->name, old('permissions', [])) ? 'selected' : '' }}>
                                {{ $permission->name }}
                            </option>
                        @endforeach
                    </x-adminlte-select2>
                </div>

                <x-adminlte-button type="submit" label="Create Role" theme="primary" />
                <x-adminlte-button label="Cancel" theme="secondary" icon="fas fa-times"
                    onclick="window.location='{{ route('admin.roles.index') }}'" />
            </form>
        </div>
    </div>
@endsection
