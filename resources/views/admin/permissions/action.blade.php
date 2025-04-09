<a href="{{ route('admin.permissions.edit', $permission) }}" class="btn btn-warning btn-sm">Edit</a>
<button type="button" class="btn btn-danger btn-sm" onclick="deletePermission({{ $permission->id }})">Delete</button>
