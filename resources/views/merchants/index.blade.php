@extends('layouts.dashboard',["active"=> "merchant"])

@section('content')
    <h2>Merchants</h2>
    <a href="{{url('/merchants/create')}}">
        <button class="btn btn-success">

            Create New Merchants

        </button>
    </a>
    <table class="table table-hover" id="dataTable" style="margin-top: 100px;">
        <thead class="alert alert-primary">
        <td>Name</td>
        <td>Type</td>
        <td></td>
        </thead>
        <tbody>
        @forelse($merchants as $merchant)
            <tr>
                <td>{{$merchant->merchant_name}}</td>
                <td>{{$merchant->types->name}}</td>
                <td>
                    <a href="{{url('/merchants/'.$merchant->id.'/edit')}}">
                            <button class="btn btn-primary">Edit</button>
                    </a>
                    <button class="btn btn-danger" onclick="del('{{ $merchant->id }}','{{url('/merchants')}}');">Delete</button>
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
                            window.location.href = "/merchants";
                        }
                    }
                });
            }
        </script>
        </tbody>
    </table>

@endsection