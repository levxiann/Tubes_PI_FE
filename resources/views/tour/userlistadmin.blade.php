@extends('layouts.main')

@section('content')
            <!-- Begin Page Content -->
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">User List</h1>
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

                <a href="{{ url('/user/addemployee/'.$shop) }}" class="btn btn-primary mb-3">Add Employee</a>
                <table id="dataTable" class="table table-striped">
                    <thead>
                      <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Username</th>
                        <th scope="col">Phone Number</th>
                        <th scope="col">Level</th>
                        <th scope="col"></th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <th scope="row">{{$user->user->pk}}</th>
                            <td>{{$user->user->name}}</td>
                            <td>{{$user->user->email}}</td>
                            <td>{{$user->user->username}}</td>
                            <td>{{$user->user->phone_number}}</td>
                            <td>
                                @if ($user->user->level == 'SA')
                                    Super Admin
                                @elseif ($user->user->level == 'A')
                                    Admin
                                @elseif ($user->user->level == 'E')
                                    Employee
                                @else
                                    Customer
                                @endif
                            </td>
                            <td>
                                @if ($user->user->pk != Session::get('user')->data->pk)
                                    <form method="GET" action="{{url('/user/editemployee/'.$user->user->pk) }}" style="display: inline-block;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-warning"> Edit</button>
                                    </form>
                                    <form method="POST" action="{{url('/user/deleteemployee/'.$user->user->pk) }}" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus User?')"> Delete</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                  </table>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->
@endsection
