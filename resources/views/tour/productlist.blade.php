@extends('layouts.main')

@section('content')
            <!-- Begin Page Content -->
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Product List</h1>
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
                @if (Session::get('user')->data->level == 'A')
                    <a href="{{ url('/product/add/'.$shop->shop->pk) }}" class="btn btn-primary mb-3">Add New Product</a>
                @endif
                <table id="dataTable" class="table table-striped">
                    <thead>
                      <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Stock</th>
                        <th scope="col">Status</th>
                        <th scope="col">Description</th>
                        <th scope="col"></th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($products as $product)
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
                            <td>
                                @if (Session::get('user')->data->level == 'A')
                                    <form method="GET" action="{{url('/product/edit/'.$product->pk) }}" style="display: inline-block;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-warning"> Edit</button>
                                    </form>
                                    <form method="POST" action="{{url('/product/delete/'.$product->pk) }}" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus Produk?')"> Delete</button>
                                    </form>
                                    <form method="GET" action="{{url('/product/addstock/'.$product->pk) }}" style="display: inline-block;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-secondary"> Add Stock</button>
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
