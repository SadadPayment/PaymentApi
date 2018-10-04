@extends('layouts.dashboard',["active"=> "services"])

@section('content')
    <h2>Merchants</h2>
    <a href="{{url('/services/create')}}">
        <button class="btn btn-success">

            Create New Service

        </button>
    </a>
    <table class="table table-hover" id="dataTable" style="margin-top: 100px;">
        <thead class="alert alert-primary">
        <td>Name</td>
        <td>Type</td>
        <td>Merchant</td>
        <td>Stander Fees</td>
        <td>Sadad Fees</td>
        <td>Total Fees</td>
        <td></td>
        </thead>
        <tbody>
        @forelse($services as $service)
            <tr>
                <td>{{$service->name}}</td>
                <td>{{$service->type->name}}</td>
                <td>{{$service->merchant->merchant_name}}</td>
                <td>{{$service->standardFess}}</td>
                <td>{{$service->sadadFess}}</td>
                <td>{{$service->totalFees}}</td>
                <td>
                    <a href="{{url('/services/'.$service->id.'/edit')}}">
                        <button class="btn btn-primary">Edit</button>
                    </a>
                    <button class="btn btn-danger" onclick="del('{{ $service->id }}','{{url('/services')}}');">Delete</button>
                    {{--<a href="{{url('/merchants/')}}">--}}
                    {{--<button class="btn btn-danger" >Delete</button>--}}
                    {{--</a>--}}
                </td>

            </tr>

        @empty
        @endforelse
        <script src="{{asset ('js/jquery.js')}}"></script>
        <script type="application/javascript">
            function del(id,url) {
                var url = url + '/' +id + '/delete';
                $.ajax({
                    url:url ,
                    type: 'GET',
                    success: function(data){
                        if (data.error){
                            window.location.href = "/services";
                        }
                    }
                });
            }
        </script>
        </tbody>
    </table>

@endsection