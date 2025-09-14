<nav class="navbar navbar-expand-lg navbar-light rounded mb-3">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-ex-8">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbar-ex-8">
            <div class="navbar-nav me-auto">
                <a class="nav-link {{ $title == 'Home' ? 'active' : '' }}" href="{{ route('gameplay.index') }}">
                    <i class="tf-icons navbar-icon ri-home-line me-1"></i>Home
                </a>
                <a class="nav-link {{ $title == 'Drivers' ? 'active' : '' }}" href="{{ route('gameplay.drivers') }}">
                    <i class="tf-icons navbar-icon ri-group-3-line me-1"></i>Drivers
                </a>
                <a class="nav-link {{ $title == 'Staffs' ? 'active' : '' }}" href="{{ route('gameplay.staffs') }}">
                    <i class="tf-icons navbar-icon ri-user-settings-line me-1"></i>Staffs
                </a>
                <a class="nav-link {{ $title == 'Cars' ? 'active' : '' }}" href="{{ route('gameplay.cars') }}">
                    <i class="tf-icons navbar-icon  ri-car-line me-1"></i>Cars
                </a>
                <a class="nav-link {{ $title == 'Schedule' ? 'active' : '' }}"
                    href="{{ route('gameplay.schedules.index') }}">
                    <i class="tf-icons navbar-icon  ri-calendar-line me-1"></i>Schedules
                </a>
            </div>
            <ul class="navbar-nav ms-lg-auto">
                <li class="nav-item">
                    <a class="nav-link {{ $title == 'Finances' ? 'active' : '' }}"
                        href="{{ route('gameplay.finances') }}">
                        <i class="tf-icons navbar-icon ri-money-dollar-circle-line me-1"></i>Finances
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>