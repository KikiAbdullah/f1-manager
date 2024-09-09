<div class="card">
    <div class="card-header bg-primary">
        <h6 class="mb-0 text-white">Edit {{ $title }}</h6>
    </div>

    <div class="card-body mt-3">
        {!! Form::model($item, ['route' => [$url['update'], $item->id], 'method' => 'PUT', 'id' => 'formupdate']) !!}
        @include($form)
        <div class="d-flex justify-content-end align-items-center">
            <button type="submit" class="btn btn-primary waves-effect waves-light">
                <i class="ri-check-line me-2"></i>Update
            </button>
        </div>
        {!! Form::close() !!}
    </div>
</div>
