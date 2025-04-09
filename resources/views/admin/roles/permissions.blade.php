@foreach ($role->permissions as $permission)
    <span class="badge badge-info mr-1">{{ $permission->name }}</span>
@endforeach
