@extends('templates.main')

@section('title')
    Lilium - {{ $product->product_name }}
@endsection

@section('content')
    <div class="container text-light py-5">
        <div class="row">
            <div class="col">
                <h1>
                    Edit - {{ $product->product_name }}
                </h1>
            </div>
        </div>

        <hr class="border-light">

        {{-- deletion form --}}
        <form id="delete-form" action="{{ route('listing.delete', ['product_id' => $product->product_id]) }}" method="POST"
            style="display: none;">
            @csrf
        </form>

        {{-- add image form --}}
        <form id="delete-image" action="{{ route('listing.image.delete', ['product_id' => $product->product_id]) }}"
            method="POST" style="display: none;">
            @csrf
            <input type="hidden" name="deleted_image_id" id="deleted-image-id" value="">
            <input type="hidden" name="is_thumbnail" id="is-thumbnail" value="">
        </form>

        <script>
            function deleteProduct() {
                if (confirm('Are you sure?'))
                    document.getElementById('delete-form').submit();
            }

            function deleteImage(deletedImageId, isThumbnail) {
                if (confirm('Are you sure?')) {
                    document.getElementById(`deleted-image-id`).value = deletedImageId;
                    document.getElementById(`is-thumbnail`).value = isThumbnail;

                    document.getElementById(`delete-image`).submit();
                }
            }
        </script>


        <div class="row card item-card text-light py-3">
            <div class="col-12">
                <form method="POST" action="{{ route('listing.update', ['product_id' => $product->product_id]) }}"
                    class="row py-2" enctype=multipart/form-data>
                    @csrf
                    <div class="col-12 col-md-6">
                        <div class="form-group mb-2">
                            {{-- Name --}}
                            <label for="product_name" class="fs-4"> Product Name </label>

                            @error('product_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror

                            <input id="product_name" class="form-control" name="product_name" type="text"
                                value="{{ old('product_name', $product->product_name) }}">
                        </div>

                        <hr class="opacity-75 my-2 border-4">

                        <div class="row">
                            <div class="col-auto form-group">
                                {{-- Sale --}}
                                <label class="form-check-label fs-4" for="is_on_sale">
                                    On Sale
                                </label>

                                @error('is_on_sale')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror

                                <input class="form-check-input fs-4" name="is_on_sale" type="checkbox" id="is_on_sale"
                                    {{ (bool) old('is_on_sale', $product->is_on_sale) ? 'checked' : '' }}>
                            </div>

                            <div class="col-auto form-group">
                                {{-- Featured --}}
                                <label class="form-check-label fs-4" for="is_featured">
                                    Featured
                                </label>

                                @error('is_featured')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror

                                <input class="form-check-input fs-4" name="is_featured" type="checkbox" id="is_featured"
                                    {{ (bool) old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                            </div>
                        </div>

                        <hr class="opacity-75 my-2 border-4">

                        <div class="col-12 col-md-6 form-group mb-2">
                            {{-- Property selection --}}
                            <label class="form-check-label fs-4" for="is_featured">
                                Property
                            </label>
                            <select id="category" name="category" class="form-select">
                                @foreach ($categories as $c)
                                    <option value="{{ $c->subcategory_id }}" 
                                        @if ($c->subcategory_id == $product->subcategory_id) selected @endif>
                                        {{ $c->subcategory_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <hr class="opacity-75 my-2 border-4">

                        <div class="form-group mb-2">
                            <div class="col-12 col-md-6">
                                {{-- Price --}}
                                <label for="price" class="fs-4"> Price </label>

                                @error('price')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror

                                <input id="price" class="form-control" name="price" type="text"
                                    value="{{ old('price', $product->price) }}">
                            </div>
                        </div>

                        <hr class="opacity-75 my-2 border-4">

                        <div class="form-group mb-2">
                            <div class="col-12 col-md-6">
                                {{-- Amount in Stock --}}
                                <label for="amount_in_stock" class="fs-4"> Amount in Stock </label>

                                @error('amount_in_stock')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror

                                <input id="amount_in_stock" class="form-control" name="amount_in_stock" type="text"
                                    value="{{ old('amount_in_stock', $product->amount_in_stock) }}">
                            </div>
                        </div>

                        <hr class="opacity-75 my-2 border-4">

                        @if (count($product_images) > 0)
                            <div class="form-group mb-2">
                                {{-- Thumbnail --}}
                                <div class="col-12 col-md-8">
                                    <label for="thumbnail" class="fs-4"> Change Thumbnail </label>

                                    @error('thumbnail')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror

                                    <input type="file" class="form-control" id="thumbnail" name="thumbnail">
                                </div>
                            </div>

                            <hr class="opacity-75 my-2 border-4">
                        @endif

                        <div class="form-group mb-2">
                            {{-- Image --}}
                            <div class="col-12 col-md-8">
                                <label for="image" class="fs-4"> Insert Image </label>

                                @error('image')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror

                                <input type="file" class="form-control" id="image" name="image">
                            </div>
                        </div>

                        <hr class="opacity-75 my-2 border-4">

                        <div class="form-group mb-3">
                            {{-- Desc --}}
                            <label for="description" class="form-label fs-4">Description</label>

                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror

                            <textarea class="form-control" id="description" name="description" rows="12">{{ old('description', $product->description) }}</textarea>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="row d-flex justify-content-center align-items-start h-100">
                            <div class="col-10 col-md-8 mt-5 mt-md-0 back-card rounded-5 py-3">
                                <h4> Images </h4>
                                {{-- Image Carousel --}}
                                <div id="image-carousel" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">

                                        @php
                                            $i = 0;
                                        @endphp
                                        @foreach ($product_images as $pi)
                                            <div
                                                class="carousel-item {{ $i == 0 ? 'active' : '' }} ratio ratio-1x1 border border-5 rounded-4">
                                                <img class="d-block w-100 rounded-4 img-fluid object-fit-cover"
                                                    src="/storage/{{ $pi->image_directory }}">

                                                <div class="carousel-caption d-flex p-0">
                                                    @if ($i == 0)
                                                        <h5 class="m-0 bg-dark-translucent align-self-end p-2 rounded-3">
                                                            Thumbnail </h5>
                                                    @else
                                                        <h5
                                                            class="m-0 bg-dark-translucent align-self-end justify-self-end p-2 rounded-3">
                                                            Image
                                                            {{ $i }}</h5>
                                                    @endif
                                                </div>


                                                {{-- Delete --}}
                                                <div class="row m-0">
                                                    <div class="col-auto m-0">
                                                        <div class="position-absolute top-0 end-0">
                                                            <button type="button" class="fs-5 btn btn-danger"
                                                                onclick="deleteImage({{ $pi->image_id }}, {{ $i == 0 ? 1 : 0 }});">
                                                                <i class="h1 bi bi-trash3"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @php
                                                $i++;
                                            @endphp
                                        @endforeach
                                    </div>

                                    @if (count($product_images) == 0)
                                        <div class="carousel-inner">
                                            <div class="carousel-item active">
                                                <div class="card rounded-4 w-100 ratio ratio-1x1">
                                                    <h5 class="d-flex align-items-center justify-content-center"> No
                                                        Thumbnail
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                {{-- Controls --}}
                                <div class="row d-flex justify-content-center gap-5 mt-3">
                                    <a class="col-auto btn btn-white d-flex justify-content-center align-items-center"
                                        href="#image-carousel" role="button" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    </a>
                                    <a class="col-auto btn btn-white d-flex justify-content-center align-items-center"
                                        href="#image-carousel" role="button" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-5 mb-2 gap-4 d-flex justify-content-lg-between justify-content-center px-5">
                        <button type="button" class="col-auto col-lg-3 btn btn-danger border rounded-3 fs-4 p-3"
                            onclick="
                        deleteProduct();
                    ">
                            Delete
                        </button>
                        <a class="col-auto col-lg-3 btn btn-secondary fs-4 p-3" href="/listing">Return</a>
                        <button type="submit"
                            class="col-auto col-lg-3 btn btn-white border border-1 fs-4 p-3">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
