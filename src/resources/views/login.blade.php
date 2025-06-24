<!DOCTYPE html>

<html>

<head>
    @include('partials.head')
    <title>
        Lillium - Login
    </title>

</head>

<body class="bg-stars">

    <main class="container-fluid d-flex flex-column m-0 p-0 min-vh-100">
        @include('partials.navbar', ['background_off' => true])

        <div class="container d-flex flex-fill align-items-center justify-content-center pb-5">
            <div class="row w-100 text-light d-flex justify-content-center mb-5 pb-5">
                <div class="col-8 col-md-6 col-lg-5 mb-5">
                    <h1 class="mb-0"> Welcome&nbsp;Traveller </h1>
                    <hr class="mt-1 mb-3 border-5">
                    <div class="card bg-dark-translucent border-1 border-light px-3 py-3 text-light rounded-4">
                        <h4>
                            Login
                        </h4>

                        <hr class="my-1">

                        <form action="/login/post" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="email"> Email </label>
                                <input type="email" class="form-control" name="email" id="email"
                                    placeholder="Enter Email">
                            </div>
                            <hr class="my-3">
                            <div class="form-group">
                                <label for="password"> Password </label>
                                <input type="password" class="form-control" name="password" id="password"
                                    placeholder="Enter Password">
                            </div>

                            <div class="row d-flex justify-content-center mt-5">
                                <div class="col-6">
                                    <button type="submit" class="btn btn-white w-100 border border-1">Login</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        @include('partials.footer')

    </main>

    @include('partials.tail')
</body>

</html>
