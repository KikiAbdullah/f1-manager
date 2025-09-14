@extends('layouts.header')

@section('content')
    <div class="container">
        @include('layouts.menu-gameplay')

        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    @foreach ($drivers as $driver)
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <img src="{{ asset('asset_materialize/img/avatars/1.jpg')  }}"
                                        alt="{{  $driver->driver->driver->name ?? ''  }}" class="img-fluid rounded-4">
                                    <div class="d-flex justify-content-between mt-4">
                                        <div>
                                            <h6 class="mb-0">{{ $driver->driver->name ?? '' }}</h6>
                                            <p class="mb-0 small">Rp
                                                {{ cleanNumber($driver->driver->salary_per_race) ?? '' }}
                                            </p>
                                        </div>
                                        <div class="avatar">
                                            <div class="avatar-initial bg-label-primary rounded">
                                                <a href="#!" onclick="driverDetail(this, '{{ $driver->driver->id }}', event)">
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
                @foreach ($drivers as $driver)
                    <div id="driver-detail-{{ $driver->driver->id }}" style="display: none;" class="mb-3">
                        <div class="card">
                            <div class="card-header bg-secondary text-white">
                                <h5 class="mb-0 text-white">{{ $driver->driver->name ?? '' }}</h5>
                                <p class="mb-0 small">Rp
                                    {{ cleanNumber($driver->driver->salary_per_race) ?? '' }}
                                </p>
                            </div>
                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <p><i class="ri-corner-right-up-line me-2"></i>Cornering</p>
                                                <p>{{ $driver->driver->cornering }}</p>
                                            </div>
                                            <div class="progress" style="height: 10px">
                                                <div class="progress-bar bg-secondary" role="progressbar"
                                                    style="width: {{ $driver->driver->cornering ?? '' }}%"
                                                    aria-valuenow="{{ $driver->driver->cornering ?? '' }}" aria-valuemin="0"
                                                    aria-valuemax="100">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <p><i class="ri-brake-warning-line me-2"></i>Braking</p>
                                                <p>{{ $driver->driver->braking }}</p>
                                            </div>
                                            <div class="progress" style="height: 10px">
                                                <div class="progress-bar bg-secondary" role="progressbar"
                                                    style="width: {{ $driver->driver->braking ?? '' }}%"
                                                    aria-valuenow="{{ $driver->driver->braking ?? '' }}" aria-valuemin="0"
                                                    aria-valuemax="100">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <p><i class="ri-flashlight-line me-2"></i>Reactions</p>
                                                <p>{{ $driver->driver->reactions }}</p>
                                            </div>
                                            <div class="progress" style="height: 10px">
                                                <div class="progress-bar bg-secondary" role="progressbar"
                                                    style="width: {{ $driver->driver->reactions ?? '' }}%"
                                                    aria-valuenow="{{ $driver->driver->reactions ?? '' }}" aria-valuemin="0"
                                                    aria-valuemax="100">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <p><i class="ri-steering-line me-2"></i>Control</p>
                                                <p>{{ $driver->driver->control }}</p>
                                            </div>
                                            <div class="progress" style="height: 10px">
                                                <div class="progress-bar bg-secondary" role="progressbar"
                                                    style="width: {{ $driver->driver->control ?? '' }}%"
                                                    aria-valuenow="{{ $driver->driver->control ?? '' }}" aria-valuemin="0"
                                                    aria-valuemax="100">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <p><i class="ri-drag-move-2-line me-2"></i>Smoothness</p>
                                                <p>{{ $driver->driver->smoothness }}</p>
                                            </div>
                                            <div class="progress" style="height: 10px">
                                                <div class="progress-bar bg-secondary" role="progressbar"
                                                    style="width: {{ $driver->driver->smoothness ?? '' }}%"
                                                    aria-valuenow="{{ $driver->driver->smoothness ?? '' }}" aria-valuemin="0"
                                                    aria-valuemax="100">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <p><i class="ri-shuffle-line me-2"></i>Adaptability</p>
                                                <p>{{ $driver->driver->adaptability }}</p>
                                            </div>
                                            <div class="progress" style="height: 10px">
                                                <div class="progress-bar bg-secondary" role="progressbar"
                                                    style="width: {{ $driver->driver->adaptability ?? '' }}%"
                                                    aria-valuenow="{{ $driver->driver->adaptability ?? '' }}" aria-valuemin="0"
                                                    aria-valuemax="100">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <p><i class="ri-roadster-line me-2"></i>Overtaking</p>
                                                <p>{{ $driver->driver->overtaking }}</p>
                                            </div>
                                            <div class="progress" style="height: 10px">
                                                <div class="progress-bar bg-secondary" role="progressbar"
                                                    style="width: {{ $driver->driver->overtaking ?? '' }}%"
                                                    aria-valuenow="{{ $driver->driver->overtaking ?? '' }}" aria-valuemin="0"
                                                    aria-valuemax="100">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <p><i class="ri-shield-user-line me-2"></i>Defending</p>
                                                <p>{{ $driver->driver->defending }}</p>
                                            </div>
                                            <div class="progress" style="height: 10px">
                                                <div class="progress-bar bg-secondary" role="progressbar"
                                                    style="width: {{ $driver->driver->defending ?? '' }}%"
                                                    aria-valuenow="{{ $driver->driver->defending ?? '' }}" aria-valuemin="0"
                                                    aria-valuemax="100">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <p><i class="ri-focus-2-line me-2"></i>Accuracy</p>
                                                <p>{{ $driver->driver->accuracy }}</p>
                                            </div>
                                            <div class="progress" style="height: 10px">
                                                <div class="progress-bar bg-secondary" role="progressbar"
                                                    style="width: {{ $driver->driver->accuracy ?? '' }}%"
                                                    aria-valuenow="{{ $driver->driver->accuracy ?? '' }}" aria-valuemin="0"
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
            const firstdriverDetail = document.querySelector('[id^="driver-detail-"]');
            if (firstdriverDetail) {
                firstdriverDetail.style.display = 'block';
            }
        });

        function driverDetail(el, id, e) {
            e.preventDefault();

            // Sembunyikan semua elemen detail mobil
            document.querySelectorAll('[id^="driver-detail-"]').forEach(function (element) {
                element.style.display = 'none';
            });

            // Tampilkan elemen detail mobil yang sesuai
            const driverDetailElement = document.getElementById('driver-detail-' + id);
            if (driverDetailElement) {
                driverDetailElement.style.display = 'block';
            }
        }
    </script>
@endsection