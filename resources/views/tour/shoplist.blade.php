@extends('layouts.main')

@section('content')
            <!-- Begin Page Content -->
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Shop List</h1>
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

                <a href="{{ url('/shop/add') }}" class="btn btn-primary mb-3">Add New Shop</a>
                <table id="dataTable" class="table table-striped">
                    <thead>
                      <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Shop Name</th>
                        <th scope="col">Location</th>
                        <th scope="col">Status</th>
                        <th scope="col"></th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($shops as $shop)
                        <tr>
                            <th scope="row">{{$shop->pk}}</th>
                            <td>{{$shop->name}}</td>
                            <td>{{$shop->location}}</td>
                            <td>
                                @if ($shop->status)
                                    <span class="text-success">Active</span>
                                @else
                                    <span class="text-danger">Non Active</span>
                                @endif
                            </td>
                            <td>
                                @if (Session::get('user')->data->level == 'SA')
                                    <form method="GET" action="{{url('/shop/edit/'.$shop->pk) }}" style="display: inline-block;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-warning"> Edit</button>
                                    </form>
                                    <form method="POST" action="{{url('/shop/delete/'.$shop->pk) }}" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus Toko?')"> Delete</button>
                                    </form>
                                @endif
                                @if ($shop->status == true || Session::get('user')->data->level != "C")
                                    <form method="GET" action="{{url('/shop/'.$shop->pk) }}" style="display: inline-block;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-secondary"> Visit</button>
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

