@extends('layouts.dashboard',["active"=> "merchant"])

@section('content')
    <div class="panel success">
        <div class="panel-heading">
            Edit Service
        </div>
        <div class="panel-body">
            {{--url('merchants/'.$merchant->id--}}
            <form method="post" action="{{action('ServiceController@update' , $service->id)}}">
                @csrf

                <div class="row form-group">
                    <div class="col-md-2">
                        <label for="name">Name: </label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="name" value="{{$service->name}}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2">
                        <label for="type">Type: </label>
                    </div>
                    <div class="col-md-8">
                        <select class="form-control" name="type">
                            @foreach($types as $type)
                                @if ($type->id == $service->type->id)
                                    <option value="{{$type->id}}" selected>{{$type->name}}</option>
                                @else
                                    <option value="{{$type->id}}">{{$type->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2">
                        <label for="type">Merchant: </label>
                    </div>
                    <div class="col-md-8">
                        <select class="form-control" name="merchant">
                            @foreach($merchants as $merchant)
                                @if ($merchant->id == $service->merchant->id)
                                    <option value="{{$merchant->id}}" selected>{{$merchant->merchant_name}}</option>
                                @else
                                    <option value="{{$merchant->id}}">{{$merchant->merchant_name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>


                <div class="row form-group">
                    <div class="col-md-2">
                        <label for="name">Stander Fees: </label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="standardFess" value="{{$service->standardFess}}">
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-2">
                        <label for="name">Sadad Fees: </label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="sadadFess" value="{{$service->sadadFess}}">
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