@extends('layouts.main')

@section('content')
            <!-- Begin Page Content -->
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Add Stock</h1>
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

                <form method="POST" action="{{url('/product/addstock/'.$product)}}" class="user">
                    @csrf
                    @method('PATCH')
                        <div class="form-group">
                            <input name="stock" type="number" class="form-control form-control-user"
                                aria-describedby="nameHelp"
                                placeholder="Add Product Stock" @error('stock') is-invalid @enderror value="{{old('stock')}}" required>
                            @error('stock')
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