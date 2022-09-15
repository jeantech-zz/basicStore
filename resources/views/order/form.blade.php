<div class="box box-info padding-1">
    <div class="box-body">

        <div class="form-group">
        <input id="id" name="id" type="hidden" value={{ $order->id}} >
        </div>
        <div class="form-group">
            {{ Form::label(__("orders.label_user_name")) }}
            {{ Form::text('user_id', $order->userName, ['class' => 'form-control' . ($errors->has('user_id') ? ' is-invalid' : ''), 'placeholder' => 'User Id', 'readonly']) }}
            {!! $errors->first('user_id', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label(__("orders.label_customer_name")) }}
            {{ Form::text('customer_name', $order->customer_name, ['class' => 'form-control' . ($errors->has('customer_name') ? ' is-invalid' : ''), 'placeholder' => 'Customer Name']) }}
            {!! $errors->first('customer_name', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label(__("orders.label_customer_email")) }}
            {{ Form::text('customer_email', $order->customer_email, ['class' => 'form-control' . ($errors->has('customer_email') ? ' is-invalid' : ''), 'placeholder' => 'Customer Email']) }}
            {!! $errors->first('customer_email', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label(__("orders.label_customer_mobile")) }}
            {{ Form::text('customer_mobile', $order->customer_mobile, ['class' => 'form-control' . ($errors->has('customer_mobile') ? ' is-invalid' : ''), 'placeholder' => 'Customer Mobile']) }}
            {!! $errors->first('customer_mobile', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label(__("orders.label_total")) }}
            {{ Form::text('total', $order->total, ['class' => 'form-control' . ($errors->has('total') ? ' is-invalid' : ''), 'placeholder' => 'Total' , 'readonly']) }}
            {!! $errors->first('total', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label(__("orders.label_currency")) }}
            {{ Form::text('currency', $order->currency, ['class' => 'form-control' . ($errors->has('currency') ? ' is-invalid' : ''), 'placeholder' => 'Currency' , 'readonly']) }}
            {!! $errors->first('currency', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label(__("orders.label_status")) }}
            {{ Form::text('status', $order->status, ['class' => 'form-control' . ($errors->has('status') ? ' is-invalid' : ''), 'placeholder' => 'Status' , 'readonly']) }}
            {!! $errors->first('status', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary"> {{__("orders.button_payed")}}</button>
    </div>
</div>
