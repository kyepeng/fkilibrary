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
            "url" : "{{ url('getBookLogs') }}",
            "data" : {
                id : "{{$id}}",
                status : function() { return $('#statusfilter').val() },
            }
        },
        columnDefs: [
        { "visible": false, "targets": [1] }, 
        {"className": "dt-center", "targets": "_all"},
        { "width": "2%", "targets": [0] }
        ],
        columns: [
            { data: 'DT_RowIndex', title:"No"},
            { data: 'id'},
            { data: 'bookName', title: 'Book Name'},
            { data: 'ISBN', title: 'Book ISBN'},
            { data: 'matric', title: 'Student'},
            { data: 'start_date', title: 'Start Date'},
            { data: 'end_date', title: 'End Date'},
            { data: 'fine', title: 'Fine'},
            { data: 'paid', title: 'Paid'},
            { data: 'badge', title : 'Status'}
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
                    <strong class="card-title">Book Logs</strong>
                </div>
                <div class="card-body">

                    <div id="alert" class="alert alert-success">
                        <i class="fa fa-times" aria-hidden="true" onclick="$('#alert').hide()" style="float:right;"></i>
                        <div id="alertmessage"></div> 
                    </div>

                    <div class="col-md-4">
                        <label>Status</label>
                        <select id="statusfilter" class="form-control select2" onchange="RefreshTable()">
                            <option value="">All</option>
                            <option value="Borrow">Issued Book</option>
                            <option value="Returned">Returned Book</option>
                            <option value="Expired">Non-returned Book</option>
                        </select>
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
     function openModal(button)
    {
        var type = $(button).data('type') ? $(button).data('type') : "New";
        var id = $(button).data('id') ? $(button).data('id') : 0;
        closeMessageBlock();
        $('#submitBtn').prop('disabled',false);
        $('#form_fields').empty();
        $('#modal_text').html("");
        appendSection(id,type);

        $('#ActionModal').modal('show');
    }

    function appendSection(id,type)
    {
        var data =  oTable.row("#"+id).data();
        var formfields = `
            <input type="hidden" name="id">
            <label>Book</label>
            <select name="bookId" class="form-control select2">
                @foreach($books as $book)
                <option value="{{$book->id}}">{{$book->bookName}} [{{$book->ISBN}}]</option>
                @endforeach
            </select>
            <label>Student</label>
            <select name="userId" class="form-control select2">
                @foreach($users as $user)
                <option value="{{$user->id}}">{{$user->name}}</option>
                @endforeach
            </select> 
        `;

        if( type == "Edit" )
        {
            formfields += `
            <label>Action</label>
            <select name="action" class="form-control select2">
                <option>Renew</option>
                <option>Return</option>
            </select>
            `
        }

        $('#form_fields').append(formfields);

        if(data)
        {
            $.each(data,function(key,value){
                $(`input[name="${key}"]`).val(value)
                $(`select[name="${key}"]`).val(value).change();
            });
        }
    }

    function Submit()
    {   
        var param = {
            'data' : new FormData($("#upload_form")[0]),
            'myurl' : "{{ url('/updateBookLogs') }}",
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

    function RefreshTable()
    {
        $('#oTable').DataTable().ajax.reload();   
    }
</script>
@endsection