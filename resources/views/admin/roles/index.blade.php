@extends('adminlte::page')

@section('title', 'Roles Management')

@section('content_header')
    <h1>Roles Management</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Roles List</h3>
            <div class="card-tools">
                <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">Create New Role</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped" id="roles-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Permissions</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
@endsection

@section('js')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(function() {
            $('#roles-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.roles.data') }}", // Updated route name
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'name', name: 'name' },
                    { data: 'permissions', name: 'permissions', orderable: false },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });
        });

        function deleteRole(roleId) {
            if (confirm('Are you sure you want to delete this role?')) {
                $.ajax({
                    url: `/admin/roles/${roleId}`,
                    type: 'DELETE',
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#roles-table').DataTable().ajax.reload();
                        }
                    }
                });
            }
        }
    </script>
@endsection
