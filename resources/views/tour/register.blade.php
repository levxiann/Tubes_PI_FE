@include('layouts.header')

<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Create Account!</h1>
                                </div>
                                @if (session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                <form method="POST" action="{{url('/register')}}" class="user">
                                @csrf
                                    <div class="form-group">
                                        <input name="name" type="text" class="form-control form-control-user"
                                            id="exampleInputEmail" aria-describedby="nameHelp"
                                            placeholder="Name" @error('name') is-invalid @enderror value="{{old('name')}}" required>
                                        @error('name')
                                            <p class="text-danger small">
                                                <strong>{{$message}}</strong>
                                            </p>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input name="username" type="text" class="form-control form-control-user"
                                            id="exampleInputEmail" aria-describedby="nameHelp"
                                            placeholder="Username" @error('username') is-invalid @enderror value="{{old('username')}}" required>
                                        @error('username')
                                            <p class="text-danger small">
                                                <strong>{{$message}}</strong>
                                            </p>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input name="email" type="email" class="form-control form-control-user"
                                            id="exampleInputEmail" aria-describedby="emailHelp"
                                            placeholder="Email" @error('email') is-invalid @enderror value="{{old('email')}}" required>
                                        @error('email')
                                            <p class="text-danger small">
                                                <strong>{{$message}}</strong>
                                            </p>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input name="phone" type="number" class="form-control form-control-user"
                                            id="exampleInputEmail" aria-describedby="numberHelp"
                                            placeholder="Phone Number" @error('phone') is-invalid @enderror value="{{old('phone')}}" required>
                                        @error('phone')
                                            <p class="text-danger small">
                                                <strong>{{$message}}</strong>
                                            </p>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input name="password" type="password" class="form-control form-control-user"
                                            id="exampleInputPassword" placeholder="Password" @error('password') is-invalid @enderror required>
                                        @error('password')
                                            <p class="text-danger small">
                                                <strong>{{$message}}</strong>
                                            </p>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input name="password_confirmation" type="password" class="form-control form-control-user"
                                            id="exampleInputPassword" placeholder="Repeat Password" @error('password_confirmation') is-invalid @enderror required>
                                        @error('password_confirmation')
                                            <p class="text-danger small">
                                                <strong>{{$message}}</strong>
                                            </p>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Register
                                    </button>
                                </form>
                                <div class="text-center">
                                    <a class="small" href="{{url('/')}}">Already have an account? Login!</a>
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