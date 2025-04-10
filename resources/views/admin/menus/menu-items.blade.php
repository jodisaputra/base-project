@foreach ($items as $item)
    <li class="dd-item" data-id="{{ $item->id }}">
        <div class="dd-handle">
            <i class="{{ $item->icon }}"></i>
            <span class="menu-title">{{ $item->name }}</span>
        </div>
        <div class="dd-actions">
            <button type="button" class="btn btn-xs btn-info edit-menu" data-id="{{ $item->id }}"
                data-name="{{ $item->name }}" data-icon="{{ $item->icon }}" data-route="{{ $item->route }}"
                data-roles="{{ htmlspecialchars($item->roles->pluck('id')) }}">
                <i class="fas fa-edit"></i>
            </button>
            <button type="button" class="btn btn-xs btn-danger delete-menu" data-id="{{ $item->id }}">
                <i class="fas fa-trash"></i>
            </button>
        </div>
        @if ($item->children->count() > 0)
            <ol class="dd-list">
                @include('admin.menus.menu-items', ['items' => $item->children])
            </ol>
        @endif
    </li>
@endforeach
