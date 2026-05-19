@extends('templates.main')

@section('title')
    Lillium - Bought Product
@endsection

@section('content')
    <div class="container text-light">
        <div class="row">
            <div class="col">
                <h1>
                    Thank You
                </h1>
                <h2> for buying <span class="text-decoration-underline">{{ $product->product_name }} <span> </h2>
            </div>
        </div>

        <hr class="border-light">

        <div class="row">
            <div class="col border border-1 rounded-4 p-4">
                <form method="POST" action="/product/comment" class="row">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->product_id }}">

                    <div class="h2 form-group mb-3 col-12 col-lg-10">
                        <label for="product_comment"> Leave a Comment </label>
                        @error('product_comment')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror

                        <textarea class="form-control" id="product_comment" name="product_comment" rows="4"></textarea>

                        <hr class="border-light">

                    </div>


                    <div class="form-group mb-3 col-12 col-lg-10">
                        <h2> Do you recommend this product? </h2>

                        <div class="rating my-4">
                            <div class="form-group">
                                <input name="like" id="yes" type="radio" value="1">
                                <label for="up">I like this product</label>
                            </div>

                            <div class="form-group">
                                <input name="like" id="no" type="radio" value="-1">
                                <label for="down">I don't like this product</label>
                            </div>

                            <div class="form-group">
                                <input name="like" id="neither" type="radio" value="0" checked>
                                <label for="down">Prefer not to say</label>
                            </div>
                        </div>

                        <hr class="border-light">
                    </div>

                    <div class="col-12 d-flex justify-content-center mt-5">
                        <button type="submit" class="col-auto col-lg-3 btn btn-white border border-1 fs-4 p-3"> Submit
                        </button>
                    </div>

                </form>
            </div>

        </div>



    </div>
@endsection
