@extends('layouts.app')

@section('template_title')
    Product
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Product') }}
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

										<th>{{__("products.label_code")}}</th>
										<th>{{__("products.label_name")}}</th>
										<th>{{__("products.label_description")}}</th>
										<th>{{__("products.label_quantity")}}</th>
										<th>{{__("products.label_total")}}</th>
										<th>{{__("products.label_image")}}</th>
                                        <th>{{__("products.label_add_car")}}</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td>{{ ++$i }}</td>

											<td>{{ $product->code }}</td>
											<td>{{ $product->name }}</td>
											<td>{{ $product->description }}</td>
											<td>{{ $product->price }}</td>
											<td>{{ $product->quantity }}</td>
                                            <td><img src="{{ $product->image }}" width="60" height="60" /></td>
                                            <td>
                                             <form action="{{ route('products.addProductOrder',$product->id) }}" method="POST">
                                                @csrf
                                                @method('POST')
                                                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-fw fa-trash"></i> {{__("products.button_add")}}</button>
                                            </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $products->links() !!}
            </div>
        </div>
    </div>
@endsection
