@extends('layouts.main')

@section('content')
            <!-- Begin Page Content -->
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Shop Detail</h1>
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
                        <th>{{$shop->shop->pk}}</th>
                      </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">Name</th>
                            <td>{{$shop->shop->name}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Location</th>
                            <td>{{$shop->shop->location}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Status</th>
                            <td>
                                @if ($shop->shop->status)
                                    <span class="text-success">Active</span>
                                @else
                                    <span class="text-danger">Non Active</span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                  </table>
                  @if (Session::get('user')->data->level == 'A')
                    <form method="GET" action="{{url('/shop/edit/'.$shop->shop->pk) }}" style="display: inline-block;">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-warning"> Edit</button>
                    </form>
                  @endif
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->
@endsection

