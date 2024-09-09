<!-- Footer -->
<div class="navbar navbar-sm navbar-footer border-top">
    <div class="container">
        <span>&copy; @if (env('APP_TAHUN') == date('Y'))
                {{ env('APP_TAHUN') }}
            @else
                {{ env('APP_TAHUN') . ' - ' . date('Y') }}
            @endif <a href="#">{{ env('APP_NAME') }}</a></span>

        <ul class="nav">
            <li class="nav-item">
                <a href="#" class="navbar-nav-link navbar-nav-link-icon rounded">
                    <div class="d-flex align-items-center mx-md-1">
                        <span class="d-none d-md-inline-block fs-sm ms-2 me-1">Made with </span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#EF4444" viewBox="0 0 256 256">
                            <rect width="256" height="256" fill="none"></rect>
                            <path
                                d="M176,32a60,60,0,0,0-48,24A60,60,0,0,0,20,92c0,71.9,99.9,128.6,104.1,131a7.8,7.8,0,0,0,3.9,1,7.6,7.6,0,0,0,3.9-1,314.3,314.3,0,0,0,51.5-37.6C218.3,154,236,122.6,236,92A60,60,0,0,0,176,32Z">
                            </path>
                        </svg>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</div>
<!-- /footer -->
