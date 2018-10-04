@extends('layouts.dashboard',["active"=> "merchant"])

@section('content')
    <div class="panel success">
        <div class="panel-heading">
            Edit Merchant
        </div>
        <div class="panel-body">
            {{--url('merchants/'.$merchant->id--}}
            <form method="post" action="{{action('MerchantController@update' , $merchant->id)}}">
                @csrf

                <div class="row form-group">
                    <div class="col-md-2">
                        <label for="name">Name: </label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="merchant_name" value="{{$merchant->merchant_name}}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2">
                        <label for="type">Type: </label>
                    </div>
                    <div class="col-md-8">
                        <select class="form-control" name="type">
                            @foreach($types as $type)
                                @if ($type->id == $merchant->type)
                                <option value="{{$type->id}}" selected>{{$type->name}}</option>
                                @else
                                <option value="{{$type->id}}">{{$type->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-offset-4">
                        <input type="submit" class="btn btn-success" value="Edit">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection