<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>FKI Library</title>
    <meta name="description" content="Evolucent ">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="{{asset('images/logo.png')}}">
    <link rel="shortcut icon" href="{{asset('images/logo.png')}}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.0/css/flag-icon.min.css">
    <link rel="stylesheet" href="{{asset('css/cs-skin-elastic.css')}}">
    <link rel="stylesheet" href="{{asset('css/lib/datatable/dataTables.bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{ asset('/plugin/select2/select2.min.css') }}">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
    <script src="{{asset('js/main.js')}}"></script>
    
    <script src="{{url('plugin/ApexChart/dist/apexcharts.min.js')}}"></script>

    <script src="{{asset('js/lib/data-table/datatables.min.js')}}"></script>
    <script src="{{asset('js/lib/data-table/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{asset('js/lib/data-table/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('js/lib/data-table/buttons.bootstrap.min.js')}}"></script>
    <script src="{{asset('js/lib/data-table/jszip.min.js')}}"></script>
    <script src="{{asset('js/lib/data-table/vfs_fonts.js')}}"></script>
    <script src="{{asset('js/lib/data-table/buttons.html5.min.js')}}"></script>
    <script src="{{asset('js/lib/data-table/buttons.print.min.js')}}"></script>
    <script src="{{asset('js/lib/data-table/buttons.colVis.min.js')}}"></script>
    <script src="{{asset('js/init/datatables-init.js')}}"></script>
    <style type="text/css">

        .open.sub-menu.subtitle {
            display: none !important;
        }

        .sub-menu.subtitle {
            display: block !important;
        }

        .redtext{
            color:red;
            font-weight: bold;
        }

        .dt-buttons a.btn.btn-default{
            border: 1px solid black;
            margin-bottom: 10px;
            color: black;
        }

        .dt-buttons a.btn.btn-default:hover{
            background: grey;
            color:white;
        }
        @if( !Auth::check() || ($me && $me->type == "Student") )
            .small-device .right-panel{
                margin-left: 0px !important;
            }
            .right-panel {
                margin-left: 0px !important;
            }
        @endif

        .carousel-item {
          /*width: 100px;*/
          margin-top: 30px;
          height: 40vh;
          min-height: 350px;
          background: no-repeat center center scroll;
          -webkit-background-size: cover;
          -moz-background-size: cover;
          -o-background-size: cover;
          background-size: cover;
          background: black;
        }
        .carouselContent{
          width: 100%;
          position: absolute;
          display: block;
          bottom: 10vh;
          text-align: center;
          /*left: 15%;*/
        }
        .carouselImage{
          margin-left: 10%;
          width: 150px;
          height: 200px;
        }

    </style>

</head>
<body>
    <!-- Left Panel -->

    @if( Auth::check() && ($me && $me->type !== "Student") )
    <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">

            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="{{url('/')}}"><i class="menu-icon fa fa-laptop"></i>Dashboard </a>
                    </li>
                    <li class="menu-title">Resource Management</li><!-- /.menu-title -->
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-users"></i>User Management</a>
                        <ul class="sub-menu children dropdown-menu">                            
                            <li><i class="fa fa-user"></i><a href="{{url('users')}}">Users List</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-address-book"></i>Book Management</a>
                        <ul class="sub-menu children dropdown-menu">                      
                            <li><i class="fa fa-book"></i><a href="{{url('returnbookForm')}}">Return Book Form</a></li>      
                            <li><i class="fa fa-book"></i><a href="{{url('books')}}">Book</a></li>
                            <li><i class="fa fa-list"></i><a href="{{url('shelves')}}">Shelves</a></li>
                            <li><i class="fa fa-history"></i><a href="{{url('bookLogs')}}">Book Log</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-pie-chart"></i>Report Management</a>
                        <ul class="sub-menu children dropdown-menu">                            
                            <li><i class="fa fa-bar-chart"></i><a href="{{url('report')}}">Report</a></li>
                        </ul>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside><!-- /#left-panel -->
    @endif

    <!-- Left Panel -->

    <!-- Right Panel -->

    <div id="right-panel" class="right-panel">

        <!-- Header-->
        <header id="header" class="header">
            <div class="top-left">
                <div class="navbar-header">
                    <a class="navbar-brand" href="./"><img src="{{asset('images/logo.png')}}" alt="Logo" style="height: 40px;"></a>
                    <a class="navbar-brand hidden" href="./"><img src="{{asset('images/logo.png')}}" alt="Logo"></a>
                    <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
                </div>
            </div>
            <div class="top-right">
                <div class="header-menu">
                    <!-- Top Menu -->
                    <div class="topmenu">

                    </div>

                    <div class="header-left">
                        <div class="row" style="padding-top: 10px;">
                                <div class="col-md-10">
                                    <input type="text" name="usersearch" class="form-control" placeholder="Search Book">
                                </div>
                                <div class="col-md-2" style="padding-top: 5px;">
                                    <i class="fa fa-search" onclick="Search()"></i>
                                </div>
                        </div>
                    </div>

                    <div class="user-area dropdown float-right">
                        <a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="user-avatar rounded-circle" src="{{asset('/images/user.png')}}" alt="User Avatar">
                        </a>

                        <div class="user-menu dropdown-menu">
                            @if(Auth::check())
                            <a class="nav-link" href="#"><i class="fa fa-user"></i>My Profile</a>
                            <a class="nav-link" href="{{url('logout')}}"><i class="fa fa-power-off"></i>Logout</a>
                            @else
                            <a class="nav-link" href="{{url('login')}}"><i class="fa fa-power-off"></i>Login</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </header><!-- /header -->
        <!-- Header-->

        @yield('content')


        <div class="clearfix"></div>

        <footer class="site-footer">
            <div class="footer-inner bg-white">
                <div class="row">
                    <div class="col-sm-12">
                        Copyright &copy; {{date('Y')}} FKI
                    </div>
                </div>
            </div>
        </footer>

    </div><!-- /#right-panel -->

    <!-- Right Panel -->

    <script type="text/javascript">
    function PostAjax(param,callback)
    {
        /*
          param
          - button (button id)
          - modal (modal id)
          - myurl (route url)
          - refresh (1/0)
          - form (1/0)
          - data (data to post)
          - hide (1/0)
          - onSuccess (success message)
          - loader (loader id)
        */

        //set default values
        param.button = param.button ? param.button : ""; 
        param.modal = param.modal ? param.modal : ""; 
        param.refresh = param.refresh ? param.refresh : 0; 
        param.form = param.form ? param.form : 0; 
        param.data = param.data ? param.data : ""; 
        param.hide = param.hide ? param.hide : 0; 
        param.loader = param.loader ? param.loader : ""; 
        param.return = param.return ? param.return : "";
        var message = param.onSuccess ? param.onSuccess : "Success";
        
        $('#'+param.button).prop('disabled',true);
        $('#'+param.loader).show();
        $.ajaxSetup({
            headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
        });

        $.ajax({
            url: param.myurl,
            method: "POST",
            data: param.data,
            processData: param.form ? false : true,
            contentType: param.form ? false : 'application/x-www-form-urlencoded; charset=UTF-8',
            success: function(response){
                if(param.hide)
                {
                    $('#'+param.modal).modal('hide');
                }
                $('#oTable').DataTable().ajax.reload();
                showMessage("alert",message,param.modal);
                $('#'+param.button).prop('disabled',false);
                $('#'+param.loader).hide();
            },
            error : function(data){
                if(param.hide)
                {
                    $('#'+param.modal).modal('hide');
                }
                var errors = data.responseJSON;
                var message = "";
                for (var error in errors)
                {
                    message = message + errors[error] + "<br>"
                }
                showMessage("warning",message,param.modal);
                $('#'+param.button).prop('disabled',false);
                $('#'+param.loader).hide();
            }
         });

    }

    function showMessage(type,message,modal)
    {
        closeMessageBlock();
        var extension = modal ? "" : "2"
        $('#'+type+'message'+extension).html(message);
        $('#'+type+extension).show();
    }

    function closeMessageBlock()
    {
        // $('#alert').hide();
        // $('#warning').hide();
        $('.alert').hide();
    }

    function Search()
    {
        var search = $('input[name="usersearch"]').val();
        window.location.href = "{{url('searchresult')}}?usersearch=" + search;
    }
    
    </script>


</body>
</html>
