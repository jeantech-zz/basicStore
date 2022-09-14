@extends('layouts.app')

@section('template_title')
    Update Order
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Update Order</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('orders.orderPay', $order) }}"  role="form" enctype="multipart/form-data">

                            @csrf

                            @include('order.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
