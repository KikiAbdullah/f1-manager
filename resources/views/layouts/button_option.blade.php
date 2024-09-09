@if (array_key_exists('vedit', $url))
    <a href="{{ route($url['vedit'], $id) }}" class="btn btn-outline-secondary waves-effect editBtn">
        VIEW / EDIT
    </a>
@endif

@if (array_key_exists('edit', $url))
    <a href="{{ route($url['edit'], $id) }}" class="btn btn-outline-secondary waves-effect editBtn">EDIT</a>
@endif

@if (array_key_exists('show', $url))
    <a href="{{ route($url['show'], $id) }}" class="btn btn-outline-primary waves-effect btnShow">SHOW</a>
@endif

@if (array_key_exists('destroy', $url))
    {!! Form::open([
        'route' => [$url['destroy'], $id],
        'method' => 'DELETE',
        'class' => 'delete',
        'style' => 'display: contents',
    ]) !!}
    <a href="#" class="btn btn-danger waves-effect deleteBtn">DELETE</a>
    {!! Form::close() !!}
@endif
