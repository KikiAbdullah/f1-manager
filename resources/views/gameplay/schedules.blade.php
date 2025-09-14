@extends('layouts.header')

@section('content')
    <div class="container">
        @include('layouts.menu-gameplay')


        <div class="row gy-6 mb-6">
            @foreach ($schedules as $schedule)
                <div class="col-sm-6 col-lg-4">
                    <div class="card p-2 h-100 shadow-none border rounded-3">
                        <div class="card-body p-3 pt-0">
                            {!! $schedule->weather_formatted !!}
                            <a href="#!" class="h5">{{ $schedule->circuit->name ?? '' }}</a>
                            <div class="row d-flex flex-wrap justify-content-between mt-3 mb-3">
                                <div class="col-sm-6">
                                    <ul class="list-unstyled mb-0">
                                        <li class="d-flex align-items-center justify-content-between">
                                            <p class="mb-0 me-3 sales-text-bg fw-medium">
                                                {{ $schedule->circuit->straight_length ?? '' }}
                                            </p>
                                            <p class="mb-0 text-truncate">Straight</p>
                                        </li>
                                        <li class="d-flex align-items-center justify-content-between">
                                            <p class="mb-0 me-3 sales-text-bg fw-medium">
                                                {{ $schedule->circuit->corner_density ?? '' }}
                                            </p>
                                            <p class="mb-0 text-truncate">Corner</p>
                                        </li>
                                        <li class="d-flex align-items-center justify-content-between">
                                            <p class="mb-0 me-3 sales-text-bg fw-medium">
                                                {{ $schedule->circuit->overtake_difficulty ?? '' }}
                                            </p>
                                            <p class="mb-0 text-truncate">Overtake</p>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-sm-6">
                                    <ul class="list-unstyled mb-0">
                                        <li class="d-flex align-items-center justify-content-between">
                                            <p class="mb-0 me-3 sales-text-bg fw-medium">
                                                {{ $schedule->circuit->tyre_wear_level }}
                                            </p>
                                            <p class="mb-0 text-truncate">Tyre Wear</p>
                                        </li>
                                        <li class="d-flex align-items-center justify-content-between">
                                            <p class="mb-0 me-3 sales-text-bg fw-medium">
                                                {{ $schedule->circuit->brake_wear_level }}
                                            </p>
                                            <p class="mb-0 text-truncate">Break Wear</p>
                                        </li>
                                    </ul>
                                </div>

                            </div>
                            <p class="d-flex align-items-center mb-1">
                                <i
                                    class="ri-calendar-line ri-20px me-1"></i>{{ formatDate('Y-m-d', 'd F Y', $schedule->race_date) }}
                            </p>
                            <div
                                class="d-flex flex-column flex-md-row gap-4 text-nowrap flex-wrap flex-md-nowrap flex-lg-wrap flex-xxl-nowrap">

                                <a class="w-100 btn btn-outline-primary d-flex align-items-center waves-effect"
                                    href="{{ route('gameplay.schedules.detail', $schedule->id) }}">
                                    <span class="me-2">Detail</span><i
                                        class="ri-arrow-right-line ri-16px lh-1 scaleX-n1-rtl"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('customjs')
@endsection