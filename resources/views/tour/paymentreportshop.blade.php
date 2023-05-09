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

                <table id="dataTable" class="table table-striped">
                    <thead>
                      <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Shop Name</th>
                        <th scope="col">Location</th>
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
                                <form method="GET" action="{{url('/payment/report_sa/'.$shop->pk) }}" style="display: inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-secondary"> See Report</button>
                                </form>

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
