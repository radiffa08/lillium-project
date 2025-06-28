<div
    class="container-fluid py-3 {{ isset($background_off) && $background_off == true ? '' : (isset($background_class) ? $background_class : 'bg-pal-dark-semidark-gradient-center') }}">
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg d-flex justify-content-between px-5">
            <a class="fs-1 navbar-brand text-light d-flex align-items-center m-0" href="/home">
                <img src="/logo.webp">&nbsp;LILLIUM
            </a>


            <button class="navbar-toggler border-light" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbar-content">
                <i class="bi bi-list text-light"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbar-content">
                <ul class="navbar-nav text-end ms-auto gap-lg-5 fw-semibold">
                    <li class="nav-item">
                        <a class="nav-link fs-5 text-light" href="#">Codex&nbsp;<i class="bi bi-book"></i></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link fs-5 text-light" href="/store">Store&nbsp;<i class="bi bi-shop"></i></a>
                    </li>

                    {{--
                    <li class="nav-item">
                        <a class="nav-link fs-5 text-light" href="#">Test</a>
                    </li> 
                    --}}
                </ul>

                <ul class="navbar-nav text-end fw-semibold">
                    @php
                        use Illuminate\Support\Facades\Auth;

                        $user = Auth::user();
                    @endphp

                    @if ($user == null)
                        <li class="nav-item">
                            <a class="nav-link ms-5 fs-5 text-light" href="/login">Login&nbsp;
                                <i class="bi bi-box-arrow-in-right"></i>
                            </a>
                        </li>
                    @else
                        @if ($user->privilege_level > 0)
                        <li class="nav-item">
                            <a class="nav-link ms-5 fs-5 text-light" href="/listing">Listing&nbsp;
                                <i class="bi bi-hammer"></i>
                            </a>
                        </li>
                        @endif
                        <li class="dropdown nav-item">
                            <button type="button" id="dropdown-profile" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle nav-link ms-5 fs-5 text-light">{{ $user->name }}&nbsp;
                                <i class="bi bi-person-circle"></i>
                            </button>

                            <div class="dropdown-menu" aria-labelledby="dropdown-profile">
                                <a class="dropdown-item" href="/logout">Logout</a>
                              </div>
                        </li>
                    @endif
                </ul>
            </div>

        </nav>
    </div>

    <hr class="border-light mb-0">
</div>
