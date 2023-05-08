@extends('layouts.main')

@section('content')
            <!-- Begin Page Content -->
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Edit Shop</h1>
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

                <form method="POST" action="{{url('/shop/edit/'.$shop->pk)}}" class="user">
                    @csrf
                    @method('PUT')
                        <input name="shoppos" type="hidden" value="{{$shoppos}}">
                        <div class="form-group">
                            <input name="name" type="text" class="form-control form-control-user"
                                aria-describedby="nameHelp"
                                placeholder="Shop Name" @error('name') is-invalid @enderror value="{{old('name', $shop->name)}}" required>
                            @error('name')
                                <p class="text-danger small">
                                    <strong>{{$message}}</strong>
                                </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input name="location" type="text" class="form-control form-control-user"
                                aria-describedby="nameHelp"
                                placeholder="Shop Location" @error('location') is-invalid @enderror value="{{old('location', $shop->location)}}" required>
                            @error('location')
                                <p class="text-danger small">
                                    <strong>{{$message}}</strong>
                                </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <select name="status" class="form-control form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                                <option value="1" @if(old('status', $shop->status) == "1") selected @endif>Active</option>
                                <option value="0" @if(old('status', $shop->status) == "0") selected @endif>Non Active</option>
                            </select>
                            @error('status')
                                <p class="text-danger small">
                                    <strong>{{$message}}</strong>
                                </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <select name="admin" class="form-control form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                                    <option value="{{$admin->pk}}">{{$admin->username}}</option>
                                @foreach ($admins as $admin)
                                    <option value="{{$admin->pk}}" @if(old('admin') == $admin->pk) selected @endif>{{$admin->username}}</option>
                                @endforeach
                            </select>
                            @error('admin')
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

