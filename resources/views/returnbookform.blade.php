@extends('layouts.dashboard')    

@section('content')
<style type="text/css">
    .select2-container--default .select2-selection--single {
        height: 40px !important;
        padding: 5px 16px;
        font-size: 18px;
        line-height: 1.33;
        border-radius: 6px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow b {
        top: 70% !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 26px !important;
    }
    .select2-container--default .select2-selection--single {
        border: 1px solid #CCC !important;
        box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.075) inset;
        transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
    }
</style>
<script type="text/javascript">
var oTable;
$(document).ready(function() {
    $('.select2').select2();
    $('#ajaxloader').hide();
    $('.alert').hide();
    $('#renewBtn').hide();
    $('#returnBtn').hide();
    $('#payBtn').hide();
});
</script>

<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Return Book Form</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="#">Resource Management</a></li>
                            <li><a href="#">Book Management</a></li>
                            <li class="active">Return Book Form</li>
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
                    <strong class="card-title">Return Book Form</strong>
                </div>
                <div class="card-body">

                  <div id="alert" class="alert alert-success">
                    <i class="fa fa-times" aria-hidden="true" onclick="$('#alert').hide()" style="float:right;"></i>
                    <div id="alertmessage"></div> 
                  </div>

                  <div id="warning" class="alert alert-danger">
                    <i class="fa fa-times" aria-hidden="true" onclick="$('#warning').hide()" style="float:right;"></i>
                    <div id="warningmessage"></div>
                  </div>

                    <form id="book_form" enctype="multipart/form-data" method="POST">
                        {{csrf_field()}}
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="hidden" name="id" id="id">
                                    <input type="hidden" name="type" id="type">
                                    <label>Book</label>
                                    <select name="bookId" id="bookId" class="form-control select2" onchange="getLogInfo()">
                                        <option value="">Please Select</option>
                                        @foreach($books as $book)
                                        <option value="{{$book->id}}">{{$book->bookName}} [{{$book->ISBN}}]</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label>Student</label>
                                    <select name="userId" id="userId" class="form-control select2" onchange="getLogInfo()">
                                        <option value="">Please Select</option>
                                        @foreach($users as $user)
                                        <option value="{{$user->id}}">{{$user->name}} [{{$user->matric}}]</option>
                                        @endforeach
                                    </select> 
                                </div>
                                <div class="col-md-6">
                                    <label>Borrow Date</label>
                                    <input type="text" id="start_date" readonly="" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label>End Date</label>
                                    <input type="text" id="end_date" readonly="" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label>Fine</label>
                                    <input type="number" id="fine" readonly="" class="form-control">
                                </div>

                            </div>
                            <br>
                            <button class="btn btn-warning" id="payBtn" onclick="openModal('Pay')">Pay</button>
                            <button class="btn btn-primary" id="renewBtn" onclick="openModal('Renew')">Renew</button>
                            <button class="btn btn-success" id="returnBtn" onclick="openModal('Return')">Return</button>
                        </div>

                    </form>

                        
                    </div>
                </div>
            </div>
        </div>

    </div><!-- .animated -->
</div><!-- .content -->

<script type="text/javascript">

    $('form').submit(function( event ){
        event.preventDefault();
        return false;
    });

     function openModal(type)
    {   
        var fine = $('#fine').val() ? $('#fine').val() : 0;
        var message = type == "Pay" ? "The student has paid the fine? <br> Total : RM "+fine  : "Confirm to "+type+" this?"; 
        $('#modal_text').html(message);
        $('#type').val(type);
        $('#ActionModal').modal('show');
    }

    function Submit()
    {   
        var param = {
            'data' : new FormData($("#book_form")[0]),
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

        var type = $('#type').val();
        if(type == "Pay")
        {
            $('#payBtn').hide();
            $('#fine').val(0);
        }
    }

    function getLogInfo()
    {
        $('#renewBtn').hide();
        $('#returnBtn').hide();
        $('#payBtn').hide();
        $('#start_date').val("");
        $('#end_date').val("");
        $('#fine').val("");
        $('#paid').val("");

        var student = $('#userId').val();
        var book = $('#bookId').val();
        if(student && book)
        {
            $.ajax({
                url: "{{url('getLogInfo')}}",
                method: "GET",
                data: {userId : student, bookId : book},
                success: function(res){
                    $('#id').val(res.list.id);
                    $('#start_date').val(res.list.start_date);
                    $('#end_date').val(res.list.end_date);
                    $('#fine').val(res.fine);
                    $('#renewBtn').show();
                    $('#returnBtn').show();
                    if(res.fine > 0)
                    {
                        $('#payBtn').show();
                    }
                }
            });
        }
    }
</script>
@endsection