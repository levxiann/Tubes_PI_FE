@extends('layouts.main')

@section('content')
            <!-- Begin Page Content -->
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">User Profile</h1>
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

                <table class="table table-striped">
                    <thead>
                      <tr>
                        <th scope="col">Id</th>
                        <th>{{$user->pk}}</th>
                      </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">Name</th>
                            <td>{{$user->name}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Email</th>
                            <td>{{$user->email}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Username</th>
                            <td>{{$user->username}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Phone Number</th>
                            <td>{{$user->phone_number}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Level</th>
                            <td>
                                @if ($user->level == 'SA')
                                    Super Admin
                                @elseif ($user->level == 'A')
                                    Admin
                                @elseif ($user->level == 'E')
                                    Employee
                                @else
                                    Customer
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
                    <form method="GET" action="{{url('/user/profile/edit') }}" style="display: inline-block;">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-warning"> Edit</button>
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