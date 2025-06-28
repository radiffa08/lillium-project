@extends('templates.main')

@section('title')
    Lilium - Home
@endsection

@section('head-content')
    <style>
        .empty-block-200 {
            min-width: 200px;
            display: inline-block;
        }

        #scroll-row {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        #scroll-row::-webkit-scrollbar {
            display: none;
        }
    </style>
@endsection

@section('content')

    <div class ="container-fluid bg-stars">
        <div class="container">
            <div class="row">
                <div class="col py-5 text-light d-flex justify-content-center">
                    <title-text class="text-center my-5 py-5">
                        <div class="row">
                            <h3> Welcome to </h3>
                            <h1> The Lillium Project </h1>
                        </div>
                        <div class="mt-4 row d-flex justify-content-center">
                            <a href="/store" class="col-auto card btn">
                                <div> View Our Collection </div>
                            </a>
                        </div>
                    </title-text>
                </div>
            </div>
        </div>
    </div>


    <div class="container py-5">
        <div class="row d-flex justify-content-center">
            <div class="col-6 text-light">
                <h1 class="text-center my-3"> About Us </h1>

                <p class="text-light text-start">
                    The Lillium Project aims to make ethically-sourced, magical artifacts more accessible to individuals
                    around the
                    globe.
                    We hold a large collection of high quality trinkets with reasonable prices, delivered right to
                    your
                    doorstep via our Jump technology. Take a look at our <a href="/store" class="text-bg-secondary">
                        collection. </a>
                </p>
                <p class="text-light text-start">
                    We also aim to document every artifact and anomaly discovered worldwide, to spread awareness about their
                    risks, as well as their utilities and quirks. We are a <span
                        class="fw-bold text-decoration-underline">non-profit</span> organization; all of the money collected
                    from
                    your purchases will be used to further expand our research in the paranormal.
                </p>
            </div>
        </div>
    </div>

    @if (count($featured) > 0)
        <div class="container mb-5 text-light">
            <h1 class="text-center mb-3"> Featured Products </h1>

            <div id="scroll-row" class="sideways-scroll-row row">
                <div class="col sideways-scroll-item">
                    @for ($i = 0; $i < ceil(50 / count($featured)); $i++)
                        @foreach ($featured as $f)
                            <a class="item-card card d-inline-block text-light text-decoration-none p-2" href="#">
                                <div class="ratio ratio-1x1" style="width: 200px;">
                                    <img class="img-fluid object-fit-cover border border-3 rounded-3"
                                        src="{{ $f->image_directory != null ? 'storage/' . $f->image_directory : 'https://placehold.co/200' }}">
                                </div>
                                <h5 class="pt-2 my-0 text-truncate" style="width: 200px; "> {{ $f->product_name }}</h5>
                                <hr class="my-1">
                                <h5 class="my-0 text-end"> ${{ $f->price }} </h5>
                                <hr class="my-1">
                            </a>
                        @endforeach
                    @endfor
                </div>
            </div>
        </div>
    @endif

    <script>
        const container = document.getElementById("scroll-row");
        let velocity = 0;
        let lastFrameTime = 0;

        function validateScrollPosition() {
            const maxScroll = container.scrollWidth;
            const current = container.scrollLeft;

            if (current >= maxScroll * 0.75) {
                container.scrollLeft = current - (maxScroll / 2);
            }

            if (current <= maxScroll * 0.25) {
                container.scrollLeft = current + (maxScroll / 2);
            }
        }

        function animateScroll(timestamp) {
            if (!lastFrameTime) lastFrameTime = timestamp;
            const delta = timestamp - lastFrameTime;
            lastFrameTime = timestamp;

            if (Math.abs(velocity) > 0.1) {
                container.scrollLeft += velocity * delta / 16;

                velocity *= 0.9985;
                validateScrollPosition();
                requestAnimationFrame(animateScroll);

            } else {
                velocity = 0;
                lastFrameTime = 0;
            }
        }

        window.addEventListener("load", () => {
            container.scrollLeft = container.scrollWidth / 2;
        });

        container.addEventListener("wheel", (e) => {
            e.preventDefault();

            // container.scrollLeft += e.deltaY;
            velocity += e.deltaY / 4;
            requestAnimationFrame(animateScroll);
        }, {
            passive: false
        });

        container.addEventListener("scroll", () => {
            window.requestAnimationFrame(animateScroll);
        });
    </script>
@endsection
