@if (!empty($btn) && array_key_exists('vedit', $btn))
    <a href="{{ route($btn['vedit'], $id) }}" class="action-link-icon-text editBtn">
        <i class="ri-edit-line"></i>
        <span class="fw-semibold text-uppercase">VIEW / EDIT</span>
    </a>
@endif

@if (!empty($btn) && array_key_exists('edit', $btn))
    <a href="{{ route($btn['edit'], $id) }}" class="action-link-icon-text editBtn">
        <i class="ri-edit-line"></i>
        <span class="fw-semibold text-uppercase">EDIT</span>
    </a>
@endif

@if (!empty($btn) && array_key_exists('show', $btn))
    <a href="{{ route($btn['show'], $id) }}" class="action-link-icon-text showBtn">
        <i class="ri-search-line"></i>
        <span class="fw-semibold text-uppercase">SHOW</span>
    </a>
@endif

@if (!empty($btn) && array_key_exists('maintenance', $btn))
    <a href="{{ route($btn['maintenance'], [$id, 'maintenance']) }}" data-title="Maintenance" data-icon="question"
        data-msg="Yakin Maintenance Mobil ini?" class="action-link-icon-text text-warning btnOption">
        <i class="ri-tools-fill"></i>
        <span class="fw-semibold text-uppercase">Maintenance</span>
    </a>
@endif

@if (!empty($btn) && array_key_exists('selesai', $btn))
    <a href="{{ route($btn['selesai'], [$id, 'selesai']) }}" data-title="Selesai Maintenance" data-icon="question"
        data-msg="Yakin Selesai Maintenance Mobil ini?" class="action-link-icon-text text-success btnOption">
        <i class="ri-checkbox-circle-line"></i>
        <span class="fw-semibold text-uppercase">Selesai Maintenance</span>
    </a>
@endif

@if (!empty($btn) && array_key_exists('foto', $btn))
    <a href="{{ route($btn['foto'], $id) }}" class="action-link-icon-text text-info fotoBtn">
        <i class="ri-image-line"></i>
        <span class="fw-semibold text-uppercase">Foto</span>
    </a>
@endif

@if (!empty($btn) && array_key_exists('destroy', $btn))
    {!! Form::open([
        'route' => [$btn['destroy'], $id],
        'method' => 'DELETE',
        'class' => 'delete form-delete-inline', // Tambahkan kelas ini
    ]) !!}
    <a href="#" class="action-link-icon-text text-danger deleteBtn">
        <i class="ri-close-circle-line"></i>
        <span class="fw-semibold text-uppercase">DELETE</span>
    </a>
    {!! Form::close() !!}
@endif
