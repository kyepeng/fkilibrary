@extends('layouts.dashboard')    

@section('content')

<script type="text/javascript">
var oTable;
$(document).ready(function() {
    $('#ajaxloader').hide();
    oTable = $('#oTable').DataTable({
        dom: "Brtp",
        rowId: 'id',
        stateSave: true,
        bAutoWidth: true,
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url" : "{{ url('getUsers') }}"
        },
        columnDefs: [
        { "visible": false, "targets": [1] }, 
        {"className": "dt-center", "targets": "_all"},
        { "width": "2%", "targets": [0] }
        ],
        columns: [
            { data: 'DT_RowIndex', title:"No"},
            { data: 'id'},
            { data: 'name', title: 'Name'},
            { data: 'email', title: 'Email'},
            { data: 'matric', title: 'Matric'},
            { data: 'courseName', title: 'Course'},
            { data: 'year', title: 'Year'},
            { data: 'gender', title: 'Gender'},
            { data: 'phone', title: 'Phone'},
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
                        <h1>Users List</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="#">Resource Management</a></li>
                            <li><a href="#">User Management</a></li>
                            <li class="active">Users List</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="animated fadeIn">

        <div class="modal" id="ActionModal" role="dialog" aria-labelledby="actionModalLabel">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="actionModalTitle">Detail</h4>
              </div>
              <div class="modal-body">

                  <div id="alert" class="alert alert-success">
                    <i class="fa fa-times" aria-hidden="true" onclick="$('#alert').hide()" style="float:right;"></i>
                    <div id="alertmessage"></div> 
                  </div>

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
                    <strong class="card-title">Users List</strong>
                </div>
                <div class="card-body">
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
        else if(type == "Delete")
        {
            $('#modal_text').html('<h5 class="redtext">Are you sure to remove this?</h5>')
            formfields = `<input type="hidden" name="id" value="">`;
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
            'myurl' : "{{ url('/updateUsers') }}",
            'form' : 1,
            'button' : "submitBtn",
            'modal' : "ActionModal",
            'onSuccess' : "Data Updated",
            'refresh' : 0,
            'hide' : 1,
            'loader' : 'ajaxloader'
        };

        PostAjax(param,function(result){
            if(result.id)
            {
                $('input[name="id[]"]').val(result.id);
            }
        });

    }

    $('.check').click(function() {
        $('.check').not(this).prop('checked', false);
    });
</script>
@endsection