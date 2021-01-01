@extends('layouts.dashboard')    

@section('content')

<script type="text/javascript">
var oTable;
$(document).ready(function() {
    $('#ajaxloader').hide();
    $('.alert').hide();
    oTable = $('#oTable').DataTable({
        dom: "Brtp",
        rowId: 'id',
        bAutoWidth: true,
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url" : "{{ url('getSearchResult') }}",
            "data" : {
                "usersearch" : "{{$usersearch}}",
                "catalog" : "{{$catalog}}",
                "book" : "{{$book}}"
            }
        },
        columnDefs: [
        { "visible": false, "targets": [1] }, 
        { "width": "2%", "targets": [0] },
        { "width": "20%", "targets": [-1] },
        ],
        columns: [
            { data: 'DT_RowIndex', title:"No"},
            { data: 'id'},
            { data: 'bookName', title: 'Name'},
            { data: 'ISBN', title: 'ISBN'},
            { data: 'description', title: 'Description'},
            { data: 'available', title: 'Available'},
            { data: 'catalog', title: 'Catalog'},
            { data: 'shelf', title: 'Shelf'},
            { data: 'image', title: 'Image'},
            { data: 'action', title : 'Action'}
        ],
        initComplete: function () {
                
                $('tr.search input').on('keyup', function () {
                        var index = $(this).attr('name');
                        oTable.columns(index).search($(this).val()).draw();
                });

        },
        buttons: [

        ]
    });

    $('form').submit(function( event ){
        event.preventDefault();
        return false;
    });


});
</script>

<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Book List</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="#">Resource Management</a></li>
                            <li><a href="#">Book Management</a></li>
                            <li class="active">Book List</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="animated fadeIn">

        <div class="modal modal-fade" id="ActionModal" role="dialog" aria-labelledby="actionModalLabel">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="actionModalTitle">Detail</h4>
              </div>
              <div class="modal-body">

                  <div id="warning" class="alert alert-danger">
                    <i class="fa fa-times" aria-hidden="true" onclick="$('#warning').hide()" style="float:right;"></i>
                    <div id="warningmessage"></div>
                  </div>

                <form id="upload_form" enctype="multipart/form-data" method="POST" action="">
                  {{ csrf_field() }}
                <div id="modal_text">
                    
                </div>
                <div id="form_fields">

                </div>
                <br><br>
                <div class="modal-footer">
                  <center><img src="{{asset('images/ajax-loader.gif')}}" width="50px" height="50px" alt="Loading" id="ajaxloader"></center>
                  <button type="button" id="submitBtn" class="btn btn-success" onclick="Submit()">Submit</button>
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
                </form>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <strong class="card-title">Book List</strong>
                </div>
                <div class="card-body">

                    <div id="alert" class="alert alert-success">
                        <i class="fa fa-times" aria-hidden="true" onclick="$('#alert').hide()" style="float:right;"></i>
                        <div id="alertmessage"></div> 
                    </div>

                    <table id="oTable" class="table table-striped table-bordered">
                        <thead>
                            <tr class="search">
                              @foreach($list as $key=>$value)
                                @if ($key==0)
                                  <?php $i = 0; ?>
                                  @foreach($value as $field=>$a)
                                      <th align='center'><input type='text' class='search_init form-control' name='{{$i}}'  placemark='{{$a}}'></th>
                                  <?php $i ++; ?>
                                  @endforeach
                                @endif
                              @endforeach
                            </tr>
                            <tr>
                                @foreach($list as $key => $value)
                                    @if($key == 0)
                                        @foreach($value as $field => $data)
                                        <td>{{$field}}</td>
                                        @endforeach
                                    @endif
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($list as $key => $value)
                                <tr>
                                    @foreach($value as $field => $data)
                                    <td>{{$data}}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div><!-- .animated -->
</div><!-- .content -->

<script type="text/javascript">
    function Submit()
    {   
        var param = {
            'data' : new FormData($("#upload_form")[0]),
            'myurl' : "{{ url('/updateBooks') }}",
            'form' : 1,
            'button' : "submitBtn",
            'modal' : "ActionModal",
            'onSuccess' : "Data Updated",
            'refresh' : 0,
            'hide' : 1,
            'loader' : 'ajaxloader'
        };

        PostAjax(param);

    }
</script>
@endsection