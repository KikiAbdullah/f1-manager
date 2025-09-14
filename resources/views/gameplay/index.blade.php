@extends('layouts.header')

@section('content')
    <div class="container">
        @include('layouts.menu-gameplay')

        <div class="row mb-6">
            <div class="col-md-4">
                <div class="card card-border-shadow">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="me-4">
                                <i class="ri-circle-fill ri-2x" style="color: {{ $team->color_primary ?? '' }}"></i>
                                <i class="ri-circle-fill ri-2x" style="color: {{ $team->color_secondary ?? '' }}"></i>
                            </div>
                            <h4 class="mb-0 fw-semibold">{{ $team->name ?? '' }}</h4>
                        </div>
                        <h6 class="mb-0 fw-normal">{{  $team->manager_name }}</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card ">
                    <div class="d-flex justify-content-between">
                        @foreach ($team->drivers as $driver)
                            <div class="card-body p-1 text-center">
                                <img src="{{ $driver->driver->image }}" alt="{{  $driver->driver->name ?? ''  }}"
                                    class="img-fluid rounded-4 mb-2">
                                <div>
                                    <h6 class="mb-3">{{ $driver->driver->name ?? '' }}</h6>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <img src="https://i.pinimg.com/736x/4f/df/af/4fdfaf092e8db342f1056c1685e96abd.jpg" alt="Cars"
                            class="img-fluid rounded-4 mb-2">

                        <div class="row">
                            @foreach ($team->cars as $car)
                                <div class="col-md-6">

                                    <h6 class="mb-0">{{ $car->name ?? '' }}</h6>
                                    <p class="mb-3 small">{{ $car->engine->name ?? '' }}</p>


                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div>
                                            <h6 class="mb-0">Top Speed</h6>
                                        </div>
                                        <div class="avatar">
                                            <div class="avatar-initial bg-label-primary rounded">
                                                {{ $car->top_speed ?? '' }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div>
                                            <h6 class="mb-0">Cornering</h6>
                                        </div>
                                        <div class="avatar">
                                            <div class="avatar-initial bg-label-primary rounded">
                                                {{ $car->cornering ?? '' }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div>
                                            <h6 class="mb-0">Reliability</h6>
                                        </div>
                                        <div class="avatar">
                                            <div class="avatar-initial bg-label-primary rounded">
                                                {{ $car->reliability ?? '' }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div>
                                            <h6 class="mb-0">Fuel Efficiency</h6>
                                        </div>
                                        <div class="avatar">
                                            <div class="avatar-initial bg-label-primary rounded">
                                                {{ $car->fuel_efficiency ?? '' }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div>
                                            <h6 class="mb-0">Tyre Management</h6>
                                        </div>
                                        <div class="avatar">
                                            <div class="avatar-initial bg-label-primary rounded">
                                                {{ $car->tyre_management ?? '' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('customjs')
@endsection