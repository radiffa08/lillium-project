<div
    class="container-fluid py-3 {{ isset($background_off) && $background_off == true ? '' : 'bg-pal-dark-semidark-gradient-center' }}">
    <div class="container-fluid">
        <nav class="navbar navbar-expand-md d-flex justify-content-between px-5">
            <a class="fs-1 navbar-brand text-light d-flex align-items-center" href="/home">
                <img src="/logo.webp">&nbsp;LILLIUM
            </a>


            <button class="navbar-toggler border-light" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbar-content">
                <i class="bi bi-list text-light"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbar-content">
                <ul class="navbar-nav text-end ms-auto gap-md-5 fw-semibold">
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
                                <i class="bi bi-box-arrow-in-right"></i></a>
                        </li>
                    @else
                        <a class="nav-link ms-5 fs-5 text-light" href="/login">{{ $user->name }}&nbsp;
                            <i class="bi bi-person-circle"></i></a>
                    @endif
                </ul>
            </div>

        </nav>
    </div>

    <hr class="border-light">
</div>
