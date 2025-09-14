@extends('layouts.header')

@section('content')
    <div class="container">
        @include('layouts.menu-gameplay')

        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    @foreach ($cars as $car)
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <img src="https://i.pinimg.com/736x/4f/df/af/4fdfaf092e8db342f1056c1685e96abd.jpg" alt=""
                                        class="img-fluid mb-5">
                                    <div class="d-flex justify-content-between mt-4">
                                        <div>
                                            <h6 class="mb-0">{{ $car->name ?? '' }}</h6>
                                            <p class="mb-0 small">{{ $car->engine->name ?? '' }}</p>
                                        </div>
                                        <div class="avatar">
                                            <div class="avatar-initial bg-label-primary rounded">
                                                <a href="#!" onclick="carDetail(this, '{{ $car->id }}', event)">
                                                    <i class="ri-arrow-right-s-line ri-24px scaleX-n1-rtl"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-6">
                @foreach ($cars as $car)
                    <div id="car-detail-{{ $car->id }}" style="display: none;" class="mb-3">
                        <div class="card">
                            <div class="card-header bg-secondary text-white">
                                <h6 class="mb-0  text-white">{{ $car->name ?? '' }}</h6>
                                <p class="mb-0 small">{{ $car->engine->name ?? '' }}</p>
                            </div>
                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <p><i class="ri-fire-line me-2"></i>Top Speed</p>
                                                <p>{{ $car->top_speed ?? 0}}</p>
                                            </div>
                                            <div class="progress" style="height: 10px">
                                                <div class="progress-bar bg-secondary" role="progressbar"
                                                    style="width: {{ $car->top_speed ?? 0}}%"
                                                    aria-valuenow="{{ $car->top_speed ?? 0}}" aria-valuemin="0"
                                                    aria-valuemax="100">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <p><i class="ri-corner-right-down-line me-2"></i>Cornering</p>
                                                <p>{{ $car->cornering ?? 0}}</p>
                                            </div>
                                            <div class="progress" style="height: 10px">
                                                <div class="progress-bar bg-secondary" role="progressbar"
                                                    style="width: {{ $car->cornering ?? 0}}%"
                                                    aria-valuenow="{{ $car->cornering ?? 0}}" aria-valuemin="0"
                                                    aria-valuemax="100">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <p><i class="ri-shield-check-line me-2"></i>Reliability</p>
                                                <p>{{ $car->reliability ?? 0}}</p>
                                            </div>
                                            <div class="progress" style="height: 10px">
                                                <div class="progress-bar bg-secondary" role="progressbar"
                                                    style="width: {{ $car->reliability ?? 0}}%"
                                                    aria-valuenow="{{ $car->reliability ?? 0}}" aria-valuemin="0"
                                                    aria-valuemax="100">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <p><i class="ri-gas-station-line me-2"></i>Fuel Efficiency</p>
                                                <p>{{ $car->fuel_efficiency ?? 0}}</p>
                                            </div>
                                            <div class="progress" style="height: 10px">
                                                <div class="progress-bar bg-secondary" role="progressbar"
                                                    style="width: {{ $car->fuel_efficiency ?? 0}}%"
                                                    aria-valuenow="{{ $car->fuel_efficiency ?? 0}}" aria-valuemin="0"
                                                    aria-valuemax="100">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <p><i class="ri-steering-line me-2"></i>Tyre Management</p>
                                                <p>{{ $car->tyre_management ?? 0}}</p>
                                            </div>
                                            <div class="progress" style="height: 10px">
                                                <div class="progress-bar bg-secondary" role="progressbar"
                                                    style="width: {{ $car->tyre_management ?? 0}}%"
                                                    aria-valuenow="{{ $car->tyre_management ?? 0}}" aria-valuemin="0"
                                                    aria-valuemax="100">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <p><i class="ri-snowy-line me-2"></i>Cooling</p>
                                                <p>{{ $car->cooling ?? 0}}</p>
                                            </div>
                                            <div class="progress" style="height: 10px">
                                                <div class="progress-bar bg-secondary" role="progressbar"
                                                    style="width: {{ $car->cooling ?? 0}}%"
                                                    aria-valuenow="{{ $car->cooling ?? 0}}" aria-valuemin="0"
                                                    aria-valuemax="100">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <p><i class="ri-speed-up-line me-2"></i>Acceleration</p>
                                                <p>{{ $car->acceleration ?? 0}}</p>
                                            </div>
                                            <div class="progress" style="height: 10px">
                                                <div class="progress-bar bg-secondary" role="progressbar"
                                                    style="width: {{ $car->acceleration ?? 0}}%"
                                                    aria-valuenow="{{ $car->acceleration ?? 0}}" aria-valuemin="0"
                                                    aria-valuemax="100">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <p><i class="ri-stop-circle-line me-2"></i>Braking</p>
                                                <p>{{ $car->braking ?? 0}}</p>
                                            </div>
                                            <div class="progress" style="height: 10px">
                                                <div class="progress-bar bg-secondary" role="progressbar"
                                                    style="width: {{ $car->braking ?? 0}}%"
                                                    aria-valuenow="{{ $car->braking ?? 0}}" aria-valuemin="0"
                                                    aria-valuemax="100">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <p><i class="ri-windy-line me-2"></i>Aero Efficiency</p>
                                                <p>{{ $car->aero_efficiency ?? 0}}</p>
                                            </div>
                                            <div class="progress" style="height: 10px">
                                                <div class="progress-bar bg-secondary" role="progressbar"
                                                    style="width: {{ $car->aero_efficiency ?? 0}}%"
                                                    aria-valuenow="{{ $car->aero_efficiency ?? 0}}" aria-valuemin="0"
                                                    aria-valuemax="100">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <p><i class="ri-refresh-line me-2"></i>Adaptability</p>
                                                <p>{{ $car->adaptability ?? 0}}</p>
                                            </div>
                                            <div class="progress" style="height: 10px">
                                                <div class="progress-bar bg-secondary" role="progressbar"
                                                    style="width: {{ $car->adaptability ?? 0}}%"
                                                    aria-valuenow="{{ $car->adaptability ?? 0}}" aria-valuemin="0"
                                                    aria-valuemax="100">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <p><i class="ri-tools-line me-2"></i>Pit Stop Speed</p>
                                                <p>{{ $car->pit_stop_speed ?? 0}}</p>
                                            </div>
                                            <div class="progress" style="height: 10px">
                                                <div class="progress-bar bg-secondary" role="progressbar"
                                                    style="width: {{ $car->pit_stop_speed ?? 0}}%"
                                                    aria-valuenow="{{ $car->pit_stop_speed ?? 0}}" aria-valuemin="0"
                                                    aria-valuemax="100">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="table-dark">
                                        <td>
                                            <div class="d-flex justify-content-between fw-bold">
                                                <p><i class="ri-trophy-line me-2"></i>Overall Score</p>
                                                <p>{{ $car->overall_score ?? 0}}</p>
                                            </div>
                                            <div class="progress" style="height: 12px">
                                                <div class="progress-bar bg-success" role="progressbar"
                                                    style="width: {{ $car->overall_score ?? 0}}%"
                                                    aria-valuenow="{{ $car->overall_score ?? 0}}" aria-valuemin="0"
                                                    aria-valuemax="100">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
@section('customjs')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Tampilkan detail mobil pertama secara default saat halaman dimuat
            const firstCarDetail = document.querySelector('[id^="car-detail-"]');
            if (firstCarDetail) {
                firstCarDetail.style.display = 'block';
            }
        });

        function carDetail(el, id, e) {
            e.preventDefault();

            // Sembunyikan semua elemen detail mobil
            document.querySelectorAll('[id^="car-detail-"]').forEach(function (element) {
                element.style.display = 'none';
            });

            // Tampilkan elemen detail mobil yang sesuai
            const carDetailElement = document.getElementById('car-detail-' + id);
            if (carDetailElement) {
                carDetailElement.style.display = 'block';
            }
        }
    </script>
@endsection