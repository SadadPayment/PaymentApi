
<!DOCTYPE html>
<html>
<head>

    <title>E-Pay Dashboard</title>

    <link href="{{ asset ('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset ('css/sb-admin.css')}}" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="{{ asset ('css/plugins/morris.css')}}" rel="stylesheet">
    <link href="{{asset ('font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset ('css/datepicker.css')}}" rel="stylesheet" type="text/css">

</head>
<body>


<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="APanel">Dashboard</a>
                </div>
                <!-- Top Menu Items -->
                <ul class="nav navbar-right top-nav">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> Admin <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
                            </li>


                            <li class="divider"></li>
                            <li>
                                <a href="{{url('/logout')}}"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav side-nav">

                        <li class="{{$active == "home" ? "active" : ""}}">
                            <a href="{{url ('/home')}}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                        </li>
                        <li class="{{$active == "bank" ? "active" : ""}}">
                            <a href="pages/bank.jsp"><i class="fa fa-bank"></i> Manage Banks</a>
                        </li>
                        <li class="{{$active == "bank_branch" ? "active" : ""}}">
                            <a href="pages/bank_branch.jsp"><i class="fa fa-bank"></i> Manage Branches</a>
                        </li>
                        <li class="{{$active == "bank_account" ? "active" : ""}}">
                            <a href="pages/merchant_bank_account.jsp"><i class="fa fa-bank"></i> Manage Banks Accounts</a>
                        </li>
                        <li class="{{$active == "merchant" ? "active" : ""}}">
                            <a href="{{url('/merchants')}}"><i class="fa fa-cc"></i> Manage Merchants</a>
                        </li>
                        <li class="{{$active == "merchant_services" ? "active" : ""}}">
                            <a href="{{url("/services")}}"><i class="fa fa-cogs"></i> Manage Services</a>
                        </li>
                        <li class="{{$active == "user" ? "active" : ""}}">
                            <a href="pages/manage_users.jsp"><i class="fa fa-users"></i> Manage Users</a>
                        </li>
                        <li class="{{$active == "transaction" ? "active" : ""}}">
                            <a href="{{url('/transactions')}}"><i class="fa fa-cog"></i> Transactions</a>
                        </li>

                        <li>
                            <a href="pages/Report.jsp"><i class="fa fa-file-text-o"></i> Reports</a>
                        </li>

                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </nav>

            <div id="page-wrapper">

                <div class="container" style="margin-top: 5%; width: 90%;">

                    <!-- Page Heading -->
                    @yield('content')
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- /#page-wrapper -->

        </div>

        <!-- JS Include -->
<script src="{{asset ('js/jquery.js')}}"></script>
<script src="{{asset ('js/bootstrap.js')}}"></script>
<script src ="{{asset ('js/jquery.dataTables.min.js')}}"></script>
<script src ="{{asset ('js/dataTables.bootstrap.min.js')}}"></script>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
</script>
    </body>
</html>
