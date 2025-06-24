@extends('templates.main')

@section('title')
    Lilium - Store
@endsection

@section('head-content')
    <style>
        .truncate-multiline {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
@endsection



@section('content')
    <div class="container text-light">
        <div class="row">
            <div class="col">
                <h1>
                    Store
                </h1>
            </div>
            <div class="col-6 d-flex align-items-center justify-content-end">
                @include('partials.elements.searchbar')
            </div>
        </div>
        <hr class="border-light">

        <div class="row">
            <div class="col-12 col-md-3 pe-0 mb-4 mb-md-0">
                <h3> Properties </h3>
                <div class="item-card card pt-2 px-2 text-light">

                    @foreach ($categories_map as $key => $subcats)
                        @php
                            $category = unserialize($key);
                            $collapse_id = "cat-collapse-{$category['value']}";
                        @endphp

                        <div class="p-2 mb-2 rounded-2 border border-1">
                            <div class="row h3 text-reset text-decoration-none d-flex justify-content-between">
                                <div class="col">
                                    {{ $category['value'] }}
                                </div>

                                <div class="col-auto ms-auto">
                                    <a class="text-reset text-decoration-none" id="category-collapse-{{ $collapse_id }}"
                                        data-bs-toggle="collapse" onclick="storeCollapseState('{{ $collapse_id }}')"
                                        href="#{{ $collapse_id }}">
                                        <i id="category-chevron-down-{{$collapse_id}}" class="bi bi-chevron-down d-none"></i>
                                        <i id="category-chevron-up-{{$collapse_id}}" class="bi bi-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="collapse" id={{ $collapse_id }}>
                                @foreach ($subcats as $subcat)
                                    <div class="row px-3">
                                        <hr class="m-0">
                                        <button
                                            class="btn btn-white text-decoration-none my-1 {{ in_array($subcat['key'], $active_subcats) ? 'bg-light text-dark' : '' }}"
                                            onclick="subcategoryPressed({{ $subcat['key'] }})">
                                            {{ $subcat['value'] }}
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                    <script>
                        let shown = localStorage.getItem('category-collapse-shown');

                        if (shown == null) {
                            shown = [];
                        } else {
                            shown = shown.split(",")
                        }

                        // shows elements stored in localstorage of key 'shown'
                        for (let i = 0; i < shown.length; i++) {
                            const shownId = shown[i];
                            try {
                                const shownElement = document.getElementById(shownId);
                                const chevronUp = document.getElementById("category-chevron-up-" + shownId)
                                const chevronDown = document.getElementById("category-chevron-down-" + shownId)

                                shownElement.classList.add("show")

                                chevronUp.classList.add("d-none");
                                chevronDown.classList.remove("d-none");
                            } catch (e) {
                                console.log(e);
                            }
                        }

                        // stores collapse states of category dropdowns to local storage of key 'shown'
                        function storeCollapseState(id) {
                            console.log("category-collapse-" + id)
                            const element = document.getElementById("category-collapse-" + id);
                            const ariaExpanded = element.getAttribute('aria-expanded');

                            const chevronUp = document.getElementById("category-chevron-up-" + id)
                            const chevronDown = document.getElementById("category-chevron-down-" + id)


                            if (ariaExpanded == "true") {
                                shown.push(id);
                                chevronUp.classList.add("d-none");
                                chevronDown.classList.remove("d-none");

                                localStorage.setItem('category-collapse-shown', shown);
                            } else {
                                chevronUp.classList.remove("d-none");
                                chevronDown.classList.add("d-none");

                                shown = shown.filter(x => x != id);
                                localStorage.setItem('category-collapse-shown', shown);
                            }

                        }

                        function subcategoryPressed(subcategoryId) {
                            subcategoryId = "" + subcategoryId

                            const urlParams = new URLSearchParams(window.location.search);
                            let subcategories = urlParams.get('subcats');

                            if (subcategories != null) {
                                subcategories = subcategories.split(",");


                                if (Array.isArray(subcategories)) {
                                    if (subcategories.includes(subcategoryId)) {
                                        subcategories = subcategories.filter(x => x != subcategoryId);
                                    } else {
                                        subcategories.push(subcategoryId);
                                    }
                                }
                            } else {
                                subcategories = [, subcategoryId];
                            }

                            const url = new URL(window.location.href);
                            url.searchParams.set('subcats', subcategories);
                            url.searchParams.set('page', 1);

                            window.location.href = url.toString();
                        };
                    </script>
                </div>
            </div>

            <hr class="d-md-none">

            <div class ="col-12 col-md-9">
                <div class="row d-flex justify-content-center py-3">
                    <div class="col-8">
                        <div class="row">
                            <button onclick="changePage({{ $page - 1 }})" {{ (bool) ($page > 1) ? '' : 'disabled' }}
                                class="col-1 btn btn-white d-flex align-items-center justify-content-center border-0 text-reset">

                                @if ((bool) ($page > 1))
                                    <i class="bi bi-chevron-left"></i>
                                @else
                                    <i class="bi bi-chevron-bar-left"></i>
                                @endif

                            </button>
                            @for ($i = 1; $i <= 9; $i++)
                                @php
                                    $target_page = $page + ($i - 5);
                                @endphp
                                <button onclick="changePage({{ $target_page }})"
                                    {{ (bool) ($target_page > 0) && (bool) ($target_page <= $paginator->lastPage()) ? '' : 'disabled' }}
                                    class="col-1 btn btn-white rounded-2 d-flex align-items-center justify-content-center {{ $target_page == $page ? 'text-reset border-1 border' : 'border-0' }}">
                                    {{ $target_page }}
                                </button>
                            @endfor

                            <button onclick="changePage({{ $page + 1 }})"
                                {{ (bool) ($page < $paginator->lastPage()) ? '' : 'disabled' }}
                                class="col-1 btn btn-white d-flex align-items-center justify-content-center border-0 text-reset">

                                @if ((bool) ($page < $paginator->lastPage()))
                                    <i class="bi bi-chevron-right"></i>
                                @else
                                    <i class="bi bi-chevron-bar-right"></i>
                                @endif
                            </button>
                        </div>
                    </div>
                </div>

                <div class="row my-2 mx-2 d-flex justify-content-end">
                    <div class="col-auto">
                        <span> Showing </span> {{ $paginator->count() }} <span> of </span> {{ $paginator->total() }} | <span> Page </span>
                        {{ $paginator->currentPage() }}
                    </div>
                </div>

                <div class="row d-flex justify-content-center">
                    <div class="d-inline-flex flex-wrap justify-content-start">
                        {{-- @for ($i = 0; $i < 100; $i++) --}}
                        @foreach ($paginator as $p)
                            <div class="p-1 col-4 col-lg-3 my-1">
                                <div class="item-card card border-1 text-light rounded-3 p-1">
                                    <img class="img rounded-3 w-100" src="https://picsum.photos/id/69/200">
                                    <h5 class="pt-2 my-0 text-truncate"> {{ $p->product_name }} </h5>
                                    <hr class="my-1">
                                    <h6 class="my-0 text-end"> {{ $p->price }} </h6>
                                    <hr class="my-1">
                                    <p class="fs-smaller truncate-multiline m-0">
                                        {{ $p->description }}
                                    </p>
                                    <hr class="my-1">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <script>
                function changePage(page) {
                    const url = new URL(window.location.href);

                    url.searchParams.set('page', page);
                    window.location.href = url.toString();
                }
            </script>
        </div>
    </div>
@endsection
