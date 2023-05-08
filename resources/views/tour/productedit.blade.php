@extends('layouts.main')

@section('content')
            <!-- Begin Page Content -->
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Edit Product</h1>
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

                <form method="POST" action="{{url('/product/edit/'.$product->pk)}}" class="user">
                    @csrf
                    @method('PATCH')
                        <div class="form-group">
                            <input name="name" type="text" class="form-control form-control-user"
                                aria-describedby="nameHelp"
                                placeholder="Product Name" @error('name') is-invalid @enderror value="{{old('name', $product->name)}}" required>
                            @error('name')
                                <p class="text-danger small">
                                    <strong>{{$message}}</strong>
                                </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input name="price" type="number" class="form-control form-control-user"
                                aria-describedby="nameHelp"
                                placeholder="Product Price" @error('price') is-invalid @enderror value="{{old('price', $product->price)}}" required>
                            @error('price')
                                <p class="text-danger small">
                                    <strong>{{$message}}</strong>
                                </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <select name="status" class="form-control form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                                <option value="1" @if(old('status', $product->status) == "1") selected @endif>Active</option>
                                <option value="0" @if(old('status', $product->status) == "0") selected @endif>Non Active</option>
                            </select>
                            @error('status')
                                <p class="text-danger small">
                                    <strong>{{$message}}</strong>
                                </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input name="description" type="text" class="form-control form-control-user"
                                aria-describedby="nameHelp"
                                placeholder="Product Description" @error('description') is-invalid @enderror value="{{old('description', $product->description)}}" required>
                            @error('description')
                                <p class="text-danger small">
                                    <strong>{{$message}}</strong>
                                </p>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary btn-user btn-block">
                            Add
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

