@extends('templates.main')

@section('title')
    Lilium - Listing
@endsection


@section('content')
    <div class="container text-light">
        <div class="row">
            <div class="col">
                <h1>
                    Product Listing
                </h1>
            </div>
        </div>
        <hr class="border-light">

        <div class="row d-flex justify-content-center">
            <div class="col-12">
                <div class="row mb-3">
                    <div class="col-12 mb-4 mb-md-0">
                        <h3> Properties </h3>
                        {{-- categories --}}
                        @include('partials.elements.categorymenu', ['compact_mode' => true])
                    </div>
                </div>
                <div class="card back-card rounded-4 text-light pb-1">
                    <div class="row p-2">
                        <form class="d-flex justify-content-lg-end justify-content-center" method="POST"
                            action="{{ route('listing.new') }}">
                            @csrf
                            <button type="submit" class="col-6 col-lg-4 btn btn-white border border-1 fs-3 py-3">New
                                Product <i class="bi bi-plus-circle"></i></button>

                        </form>
                    </div>
                    <div class="row d-flex justify-content-center align-items-end pt-3">
                        <div class="col-8">
                            {{-- page controls --}}
                            @include('partials.elements.paginatorcontrols')
                            <hr class="mt-4 mb-2 opacity-50">
                        </div>
                    </div>
                    <div class="row my-2 mx-2 mb-3 d-flex justify-content-between align-items-end">
                        {{-- Showing --}}
                        <div class="col-auto">
                            @include('partials.elements.pageslabel')
                        </div>

                        <div class="col-auto d-flex align-items-center justify-content-end border p-2 rounded-3">
                            {{-- search bar --}}
                            @include('partials.elements.searchbar')
                        </div>
                    </div>

                    <div class="row m-0">
                        @php
                            $id_classes = 'col-2 col-md-1 border-end border-2 py-3 h-100';
                            $main_img_classes = 'col-3 border-end border-2 py-3 d-none d-md-block h-100';
                            $name_classes = 'col-4 col-md-3 border-end border-2 py-3 h-100';
                            $price_classes = 'col-3 col-md-2 border-end border-2 py-3 h-100';
                            $edit_classes = 'col-3 col-md-3 h-100 p-2';
                        @endphp
                        <div class="col item-card card rounded-top-4 p-3">
                            {{-- header --}}
                            <div class="p-0 row text-light d-flex">
                                <div class="{{ $id_classes }}">
                                    <h3 class="text-center m-0"> ID </h3>
                                </div>
                                <div class="{{ $main_img_classes }}">
                                    <h3 class="text-center m-0"> Img </h3>
                                </div>
                                <div class="{{ $name_classes }}">
                                    <h3 class="text-center m-0"> Name </h3>
                                </div>
                                <div class="{{ $price_classes }}">
                                    <h3 class="text-center m-0"> Price </h3>
                                </div>
                                <div class="{{ $edit_classes }}">
                                    <h3 class="text-center m-0 py-3"> Edit </h3>
                                </div>
                            </div>
                            <div class="row">
                                <hr class="border-5 m-0 border-light opacity-50">
                            </div>
                            {{-- items --}}
                            @foreach ($paginator as $p)
                                <div class="p-0 row d-flex align-items-center text-light">
                                    {{-- ID --}}
                                    <div class="{{ $id_classes }}">
                                        <h6 class="text-start m-0"> {{ $p->product_id }} </h6>
                                    </div>
                                    {{-- Image --}}
                                    <div class="{{ $main_img_classes }}">
                                        <h6 class="text-center m-0 d-block ratio ratio-1x1"> <img
                                                class="img-fluid object-fit-cover border-2 border rounded-3"
                                                src="{{ $p->image_directory != null ? 'storage/' . $p->image_directory : 'https://placehold.co/200' }}">
                                        </h6>
                                    </div>
                                    {{-- Name --}}
                                    <div class="{{ $name_classes }} d-flex align-items-center justify-content-center">
                                        <h6 class="text-start m-0 "> {{ $p->product_name }} </h6>
                                    </div>
                                    {{-- Price --}}
                                    <div class="{{ $price_classes }} d-flex align-items-center justify-content-end">
                                        <h6 class="text-end m-0"> ${{ $p->price }} </h6>
                                    </div>
                                    <div class="{{ $edit_classes }} d-flex justify-content-center align-items-center">
                                        <div class="row d-flex justify-content-center">

                                            <div class="col-auto my-2 my-md-0 order-2 order-md-1">
                                                {{-- Delete Item --}}
                                                <form
                                                    action="{{ route('listing.delete', ['product_id' => $p->product_id]) }}"
                                                    method="POST" onsubmit="return confirm('Are you sure?')">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger border rounded-3">
                                                        <i class="h1 bi bi-trash3"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            {{-- Edit Item --}}
                                            <div class="col-auto order-1 order-md-2">
                                                <a href="{{ route('listing.productedit', ['product_id' => $p->product_id]) }}"
                                                    class="btn btn-white border rounded-3">
                                                    <i class="h1 bi bi-pencil"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <hr class="border-2 m-0 border-light opacity-50">
                                </div>
                            @endforeach
                            {{-- footer --}}
                            <div class="p-0 row text-light d-flex">
                                <div class="{{ $id_classes }}">
                                </div>
                                <div class="{{ $main_img_classes }}">
                                </div>
                                <div class="{{ $name_classes }}">
                                </div>
                                <div class="{{ $price_classes }}">
                                </div>
                                <div class="{{ $edit_classes }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
