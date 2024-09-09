@if (array_key_exists('vedit', $url))
    <a href="{{ route($url['vedit'], $id) }}" class="btn flex-column btn-float py-2 mx-2 text-uppercase text-dark fw-semibold editBtn"><i class="ph-pencil-simple-line ph-2x text-indigo"></i>VIEW /
        EDIT</a>
@endif

@if (array_key_exists('edit', $url))
    <a href="{{ route($url['edit'], $id) }}" class="btn flex-column btn-float py-2 mx-2 text-uppercase text-dark fw-semibold editBtn"><i class="ph-pencil-simple-line ph-2x text-indigo"></i>EDIT</a>
@endif

@if (array_key_exists('show', $url))
    <a href="{{ route($url['show'], $id) }}" class="btn flex-column btn-float py-2 mx-2 text-uppercase text-dark fw-semibold btnShow"><i class="ph-pencil-simple-line ph-2x text-indigo"></i>EDIT</a>
@endif

@if (array_key_exists('destroy', $url))
    {!! Form::open(['route' => [$url['destroy'], $id], 'method' => 'DELETE', 'class' => 'delete', 'style' => 'display: contents']) !!}
    <a href="#" class="btn flex-column btn-float py-2 mx-2 text-uppercase text-dark fw-semibold deleteBtn"><i class="ph-trash ph-2x text-danger"></i>DELETE</a>
    {!! Form::close() !!}
@endif
