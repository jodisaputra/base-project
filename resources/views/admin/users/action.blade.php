<div class="d-flex justify-content-center">
    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-info btn-sm mx-1" data-toggle="tooltip"
        title="Edit User">
        <i class="fas fa-pencil-alt"></i>
    </a>

    <button onclick="deleteUser({{ $user->id }})" class="btn btn-danger btn-sm mx-1" data-toggle="tooltip"
        title="Delete User">
        <i class="fas fa-trash"></i>
    </button>
</div>
