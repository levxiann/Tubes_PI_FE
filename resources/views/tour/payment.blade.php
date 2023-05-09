@extends('layouts.main')

@section('content')
            <!-- Begin Page Content -->
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Payment Ongoing</h1>
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
                        <th scope="col">Buy Date</th>
                        <th scope="col"></th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($payments as $payment)
                        <tr>
                            <th scope="row">{{$payment->pk}}</th>
                            <td>{{$payment->user->username}}</td>
                            <td>{{$payment->product->name}}</td>
                            <td>{{$payment->quantity}}</td>
                            <td>{{$payment->total_price}}</td>
                            <td>{{date('d F Y', strtotime($payment->created))}}</td>
                            <td>
                                <form method="POST" action="{{url('/payment/approve/'.$payment->pk) }}" style="display: inline-block;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Approve Payment?')"> Paid</button>
                                </form>
                                <form method="POST" action="{{url('/payment/reject/'.$payment->pk) }}" style="display: inline-block;">
                                    @csrf
                                    @method('PATCH')
                                    <input name="quantity" type="hidden" value="{{$payment->quantity}}">
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Reject Payment?')"> Reject</button>
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
