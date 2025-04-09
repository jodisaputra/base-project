<a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-warning btn-sm">Edit</a>
<button type="button" class="btn btn-danger btn-sm" onclick="deleteRole({{ $role->id }})">Delete</button>
