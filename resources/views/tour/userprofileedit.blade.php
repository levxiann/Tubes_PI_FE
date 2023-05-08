@extends('layouts.main')

@section('content')
            <!-- Begin Page Content -->
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Edit User Profile</h1>
                </div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{url('/user/profile/edit')}}" class="user">
                    @csrf
                    @method('PATCH')
                        <div class="form-group">
                            <input name="name" type="text" class="form-control form-control-user"
                                id="exampleInputEmail" aria-describedby="nameHelp"
                                placeholder="Name" @error('name') is-invalid @enderror value="{{old('name', $user->name)}}" required>
                            @error('name')
                                <p class="text-danger small">
                                    <strong>{{$message}}</strong>
                                </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input name="username" type="text" class="form-control form-control-user"
                                id="exampleInputEmail" aria-describedby="nameHelp"
                                placeholder="Username" @error('username') is-invalid @enderror value="{{old('username', $user->username)}}" required>
                            @error('username')
                                <p class="text-danger small">
                                    <strong>{{$message}}</strong>
                                </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input name="email" type="email" class="form-control form-control-user"
                                id="exampleInputEmail" aria-describedby="emailHelp"
                                placeholder="Email" @error('email') is-invalid @enderror value="{{old('email', $user->email)}}" required>
                            @error('email')
                                <p class="text-danger small">
                                    <strong>{{$message}}</strong>
                                </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input name="phone" type="number" class="form-control form-control-user"
                                id="exampleInputEmail" aria-describedby="numberHelp"
                                placeholder="Phone Number" @error('phone') is-invalid @enderror value="{{old('phone', $user->phone_number)}}" required>
                            @error('phone')
                                <p class="text-danger small">
                                    <strong>{{$message}}</strong>
                                </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input name="password" type="password" class="form-control form-control-user"
                                id="exampleInputPassword" placeholder="Password" @error('password') is-invalid @enderror>
                            @error('password')
                                <p class="text-danger small">
                                    <strong>{{$message}}</strong>
                                </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input name="password_confirmation" type="password" class="form-control form-control-user"
                                id="exampleInputPassword" placeholder="Repeat Password" @error('password_confirmation') is-invalid @enderror>
                            @error('password_confirmation')
                                <p class="text-danger small">
                                    <strong>{{$message}}</strong>
                                </p>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary btn-user btn-block">
                            Edit
                        </button>
                    </form>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->
@endsection

