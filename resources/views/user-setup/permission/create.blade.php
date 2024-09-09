<div class="card">
    <div class="card-header">
        <h6 class="mb-0">Add {{ $title }}</h6>
    </div>

    <div class="card-body  mt-3">
        {!! Form::open(['route' => $url['store'], 'method' => 'POST', 'id' => 'dform']) !!}
        @include($form)
        <div class="d-flex justify-content-end align-items-center">
            <button type="submit" class="btn btn-primary waves-effect waves-light">
                <i class="ri-send-plane-line me-2"></i>Submit
            </button>
        </div>
        {!! Form::close() !!}
    </div>
</div>
