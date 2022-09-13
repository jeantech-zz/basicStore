@extends('layouts.app')

@section('template_title')
    Order
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Order') }}
                            </span>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>

										<th>User Id</th>
										<th>Customer Name</th>
										<th>Customer Email</th>
										<th>Customer Mobile</th>
										<th>Total</th>
										<th>Currency</th>
										<th>Status</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>{{ ++$i }}</td>

											<td>{{ $order->user_id }}</td>
											<td>{{ $order->customer_name }}</td>
											<td>{{ $order->customer_email }}</td>
											<td>{{ $order->customer_mobile }}</td>
											<td>{{ $order->total }}</td>
											<td>{{ $order->currency }}</td>
											<td>{{ $order->status }}</td>
                                            <td>
                                                <a class="btn btn-sm btn-success" href="{{ route('orders.edit',$order) }}"><i class="fa fa-fw fa-edit"></i> Pay </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $orders->links() !!}
            </div>
        </div>
    </div>
@endsection
