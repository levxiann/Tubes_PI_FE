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
                        <th>{{$shop->pk}}</th>
                      </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">Name</th>
                            <td>{{$shop->name}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Location</th>
                            <td>{{$shop->location}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Status</th>
                            <td>
                                @if ($shop->status)
                                    <span class="text-success">Active</span>
                                @else
                                    <span class="text-danger">Non Active</span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Product List</h1>
                </div>

                <table id="dataTable" class="table table-striped">
                    <thead>
                      <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Stock</th>
                        <th scope="col">Status</th>
                        <th scope="col">Description</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($products as $product)
                        @if (!$product->status && Session::get('user')->data->level == 'C')
                            
                        @else
                            <tr>
                                <th scope="row">{{$product->pk}}</th>
                                <td>{{$product->name}}</td>
                                <td>{{$product->price}}</td>
                                <td>{{$product->stock}}</td>
                                <td>
                                    @if ($product->status)
                                        <span class="text-success">Active</span>
                                    @else
                                        <span class="text-danger">Non Active</span>
                                    @endif
                                </td>
                                <td>{{$product->description}}</td>
                            </tr>
                        @endif
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

