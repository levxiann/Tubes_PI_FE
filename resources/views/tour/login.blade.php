@include('layouts.header')

<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login-image" style="background: url('{{asset('assets/img/hitado.png')}}')"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                </div>
                                @if (session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                <form method="POST" action="{{ url('/login') }}" class="user">
                                    @csrf
                                    <div class="form-group">
                                        <input name="username" type="text" class="form-control form-control-user"
                                            id="exampleInputEmail" aria-describedby="nameHelp"
                                            placeholder="Username" @error('username') is-invalid @enderror required>
                                        @error('username')
                                            <p class="text-danger small">
                                                <strong>Username / Password Invalid</strong>
                                            </p>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input name="password" type="password" class="form-control form-control-user"
                                            id="exampleInputPassword" placeholder="Password" @error('password') is-invalid @enderror required>
                                        @error('password')
                                            <p class="text-danger small">
                                                <strong>Username / Password Invalid</strong>
                                            </p>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Login
                                    </button>
                                </form>
                                <div class="text-center">
                                    <a class="small" href="{{url('/register')}}">Create an Account!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

@include('layouts.footer')