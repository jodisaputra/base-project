@extends('adminlte::page')

@section('title', 'Menu Management')

@section('content_header')
    <h1>Menu Management</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Menu Structure</h3>
                </div>
                <div class="card-body">
                    <div class="dd" id="nestable">
                        @if ($menus->count() > 0)
                            <ol class="dd-list">
                                @include('admin.menus.menu-items', ['items' => $menus])
                            </ol>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-sitemap fa-4x text-secondary mb-4 d-block"></i>
                                <h5 class="text-secondary mb-2">No Menus Available</h5>
                                <p class="text-muted">Create your first menu using the form on the right.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title" id="formTitle">Add New Menu</h3>
                </div>
                <div class="card-body">
                    <form id="menuForm">
                        @csrf
                        <input type="hidden" name="id" id="menu_id">

                        <div class="form-group">
                            <x-adminlte-input name="name" label="Name" placeholder="Enter menu name" required />
                        </div>

                        <div class="form-group">
                            <x-adminlte-input name="icon" label="Icon (FontAwesome)" placeholder="fas fa-users" />
                        </div>

                        <div class="form-group">
                            <x-adminlte-input name="route" label="Route" placeholder="admin.dashboard" />
                        </div>

                        <div class="form-group">
                            <label>Roles</label>
                            <div class="select2-purple">
                                <select class="select2" name="roles[]" id="roles" multiple="multiple"
                                    data-placeholder="Select roles">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" id="saveButton" class="btn btn-primary">Save Menu</button>
                            <button type="button" id="cancelButton" class="btn btn-secondary"
                                style="display: none;">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css"
        rel="stylesheet">
    <style>
        .dd-handle {
            height: auto !important;
            margin: 5px 0;
            padding: 10px 10px;
            border-radius: 3px;
            background: #f8f9fa;
            border: 1px solid #ddd;
        }

        .dd-handle:hover {
            background: #f0f0f0;
        }

        .dd-item>.dd-handle .menu-title {
            font-weight: bold;
            margin-left: 10px;
        }

        .dd-actions {
            position: absolute;
            right: 10px;
            top: 8px;
            display: none;
        }

        .dd-item:hover>.dd-actions {
            display: block;
        }

        .dd-empty {
            border: 1px dashed #b6bcbf;
            min-height: 100px;
            background-color: #f8f9fa;
            background-size: 60px 60px;
        }

        .dd-placeholder {
            background: rgba(0, 0, 0, .03);
            border: 1px dashed #b6bcbf;
        }

        .select2-container {
            display: block;
            width: 100% !important;
        }

        .select2-container .select2-selection--multiple {
            min-height: 38px;
        }

        .select2-container--bootstrap4 .select2-selection--multiple .select2-selection__rendered {
            display: block;
            padding: 0 0.375rem;
        }

        .select2-container--bootstrap4 .select2-selection--multiple .select2-search__field {
            width: 100% !important;
            margin-left: 0;
            border: 0;
        }

        .select2-container--bootstrap4 .select2-selection--multiple .select2-selection__choice {
            background-color: #007bff !important;
            color: #fff;
            border: none;
            border-radius: 3px;
            padding: 3px 8px;
            margin: 4px 4px;
        }

        .select2-container--bootstrap4 .select2-selection__choice__remove {
            color: #fff !important;
            margin-right: 5px;
        }

        .select2-container--bootstrap4 .select2-selection__choice__remove:hover {
            color: #fff !important;
            opacity: 0.8;
        }

        .select2-container--bootstrap4 .select2-results__option--highlighted[aria-selected] {
            background-color: #007bff !important;
            color: #fff;
        }
    </style>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('#roles').select2({
                theme: 'bootstrap4',
                width: '100%',
                dropdownParent: $('.select2-purple')
            });

            // Initialize Nestable
            $('#nestable').nestable({
                maxDepth: 3,
                group: 1
            });

            // Add this for menu ordering
            $('#nestable').on('change', function() {
                var data = $('#nestable').nestable('serialize');
                $.ajax({
                    url: '{{ route('admin.menus.update-order') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        items: data
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Menu order updated successfully',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to update menu order'
                        });
                    }
                });
            });

            // Form submission
            $('#menuForm').on('submit', function(e) {
                e.preventDefault();
                var id = $('#menu_id').val();
                var url = id ? '{{ route('admin.menus.update', '') }}/' + id :
                    '{{ route('admin.menus.store') }}';
                var method = id ? 'PUT' : 'POST';

                $.ajax({
                    url: url,
                    type: method,
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Success', 'Menu saved successfully', 'success').then(
                                function() {
                                    location.reload();
                                });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Error', 'Failed to save menu', 'error');
                    }
                });
            });

            // Edit menu
            $(document).on('click', '.edit-menu', function(e) {
                e.stopPropagation();
                var btn = $(this);
                var rolesData = btn.data('roles');
                var roles = typeof rolesData === 'string' ? rolesData.split(',') : rolesData;

                $('#menu_id').val(btn.data('id'));
                $('input[name="name"]').val(btn.data('name'));
                $('input[name="icon"]').val(btn.data('icon'));
                $('input[name="route"]').val(btn.data('route'));
                $('#roles').val(roles).trigger('change');

                $('#formTitle').text('Edit Menu');
                $('#cancelButton').show();
                $('#saveButton').text('Update Menu');
            });

            // Delete menu
            $(document).on('click', '.delete-menu', function(e) {
                e.stopPropagation();
                var id = $(this).data('id');

                Swal.fire({
                    title: 'Delete Menu',
                    text: "Are you sure you want to delete this menu?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: '{{ route('admin.menus.destroy', '') }}/' + id,
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire('Success', 'Menu Deleted successfully',
                                        'success').then(
                                        function() {
                                            location.reload();
                                        });
                                }
                            },
                            error: function() {
                                Swal.fire('Error!', 'Failed to delete menu', 'error');
                            }
                        });
                    }
                });
            });

            // Cancel edit
            $('#cancelButton').click(function() {
                $('#menu_id').val('');
                $('#menuForm')[0].reset();
                $('#roles').val(null).trigger('change');
                $('#formTitle').text('Add New Menu');
                $('#cancelButton').hide();
                $('#saveButton').text('Save Menu');
            });
        });
    </script>
@endsection

@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)
