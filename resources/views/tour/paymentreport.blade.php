@extends('layouts.main')

@section('content')
            <!-- Begin Page Content -->
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Payment Report</h1>
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
                        <th scope="col">Customer Name</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Total Price</th>
                        <th scope="col">Payment Date</th>
                        <th scope="col">Buy Date</th>
                        <th scope="col">Status</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($payments as $payment)
                        <tr>
                            <th scope="row">{{$payment->pk}}</th>
                            <td>{{$payment->user->username}}</td>
                            <td>{{$payment->product->name}}</td>
                            <td>
                                @if ($payment->status == 'R')
                                    {{$payment->quantity_reject}}
                                @else
                                    {{$payment->quantity}}
                                @endif
                            </td>
                            <td>{{$payment->total_price}}</td>
                            <td>
                                @if ($payment->payment_date)
                                    {{date('d F Y', strtotime($payment->payment_date))}}
                                @endif
                            </td>
                            <td>{{date('d F Y', strtotime($payment->created))}}</td>
                            <td>
                                @if ($payment->status == 'NP')
                                    <span class="text-warning">Not Paid</span>
                                @elseif ($payment->status == 'P')
                                    <span class="text-success">Paid</span>
                                @else
                                    <span class="text-danger">Rejected</span>
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