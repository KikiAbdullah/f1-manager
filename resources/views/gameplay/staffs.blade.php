@extends('layouts.header')

@section('content')
    <div class="container">
        @include('layouts.menu-gameplay')

        <div class="row">
            {{-- Tech Director --}}
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body text-center">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTB34XUhJSbOjPLLYYAj3EJfRLoHX5JVeg1sg&s"
                                alt="{{ $staffs->techDirector->name ?? '' }}" class="img-fluid rounded-4">

                            <div class="mt-4 mb-3">
                                <h6 class="mb-0">{{ $staffs->techDirector->name ?? '' }}</h6>
                                <p class="mb-0 small">Technical Director</p>
                            </div>

                            @foreach ([
                                    'chassis' => 'ri-settings-2-line|Chassis',
                                    'powertrain' => 'ri-battery-2-charge-line|Powertrain',
                                    'durability' => 'ri-shield-check-line|Durability',
                                    'suspension' => 'ri-car-line|Suspension',
                                    'cooling' => 'ri-snowy-line|Cooling',
                                    'innovation' => 'ri-lightbulb-line|Innovation'
                                ] as $field => $meta)
                                    @php [$icon, $label] = explode('|', $meta); @endphp
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between">
                                            <p><i class="{{ $icon }} me-2"></i>{{ $label }}</p>
                                            <p>{{ $staffs->techDirector->$field }}</p>
                                        </div>
                                        <div class="progress" style="height: 10px">
                                            <div class="progress-bar bg-secondary" role="progressbar"
                                                style="width: {{ $staffs->techDirector->$field }}%"
                                                aria-valuenow="{{ $staffs->techDirector->$field }}" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>
                                    </div>
                            @endforeach

                        </div>
                    </div>
                </div>

                {{-- Aero Chief --}}
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body text-center">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTB34XUhJSbOjPLLYYAj3EJfRLoHX5JVeg1sg&s"
                                alt="{{ $staffs->aeroChief->name ?? '' }}" class="img-fluid rounded-4">

                            <div class="mb-3 mt-4">
                                <h6 class="mb-0">{{ $staffs->aeroChief->name ?? '' }}</h6>
                                <p class="mb-0 small">Aerodynamics Chief</p>
                            </div>

                            @foreach ([
                                    'front_aero' => 'ri-arrow-up-line|Front Aero',
                                    'rear_aero' => 'ri-arrow-down-line|Rear Aero',
                                    'drag_efficiency' => 'ri-windy-line|Drag Efficiency',
                                    'wind_tunnel' => 'ri-building-line|Wind Tunnel',
                                    'ground_effect' => 'ri-roadster-line|Ground Effect',
                                    'aero_innovation' => 'ri-lightbulb-flash-line|Aero Innovation'
                                ] as $field => $meta)
                                    @php [$icon, $label] = explode('|', $meta); @endphp
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between">
                                            <p><i class="{{ $icon }} me-2"></i>{{ $label }}</p>
                                            <p>{{ $staffs->aeroChief->$field }}</p>
                                        </div>
                                        <div class="progress" style="height: 10px">
                                            <div class="progress-bar bg-secondary" role="progressbar"
                                                style="width: {{ $staffs->aeroChief->$field }}%"
                                                aria-valuenow="{{ $staffs->aeroChief->$field }}" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>
                                    </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Race Engineer --}}
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body text-center">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTB34XUhJSbOjPLLYYAj3EJfRLoHX5JVeg1sg&s"
                                alt="{{ $staffs->raceEngineer->name ?? '' }}" class="img-fluid rounded-4">

                            <div class="mb-3 mt-4">
                                <h6 class="mb-0">{{ $staffs->raceEngineer->name ?? '' }}</h6>
                                <p class="mb-0 small">Race Engineer</p>
                            </div>

                            @foreach ([
                                    'strategy' => 'ri-git-branch-line|Strategy',
                                    'tyre_management' => 'ri-tire-line|Tyre Management',
                                    'communication' => 'ri-chat-1-line|Communication',
                                    'adaptability' => 'ri-shuffle-line|Adaptability',
                                    'fuel_management' => 'ri-gas-station-line|Fuel Management',
                                    'data_analysis' => 'ri-bar-chart-line|Data Analysis'
                                ] as $field => $meta)
                                    @php [$icon, $label] = explode('|', $meta); @endphp
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between">
                                            <p><i class="{{ $icon }} me-2"></i>{{ $label }}</p>
                                            <p>{{ $staffs->raceEngineer->$field }}</p>
                                        </div>
                                        <div class="progress" style="height: 10px">
                                            <div class="progress-bar bg-secondary" role="progressbar"
                                                style="width: {{ $staffs->raceEngineer->$field }}%"
                                                aria-valuenow="{{ $staffs->raceEngineer->$field }}" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>
                                    </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        </div>
@endsection
@section('customjs')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Tampilkan detail mobil pertama secara default saat halaman dimuat
            const firststaffDetail = document.querySelector('[id^="staff-detail-"]');
            if (firststaffDetail) {
                firststaffDetail.style.display = 'block';
            }
        });

        function staffDetail(el, id, e) {
            e.preventDefault();

            // Sembunyikan semua elemen detail mobil
            document.querySelectorAll('[id^="staff-detail-"]').forEach(function (element) {
                element.style.display = 'none';
            });

            // Tampilkan elemen detail mobil yang sesuai
            const staffDetailElement = document.getElementById('staff-detail-' + id);
            if (staffDetailElement) {
                staffDetailElement.style.display = 'block';
            }
        }
    </script>
@endsection