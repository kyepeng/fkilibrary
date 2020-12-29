@extends('layouts.dashboard')    

@section('content')

<script type="text/javascript">
$(document).ready(function() {
    $('.ajaxloader').hide();
    $('.alert').hide();
});
</script>

<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Borrow Book Form</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="#">Resource Management</a></li>
                            <li><a href="#">Book Management</a></li>
                            <li class="active">Borrow Book Form</li>
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
                    <strong class="card-title">Borrow Book Form</strong>
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

                    <form id="book_form" enctype="multipart/form-data" method="POST" action="{{url('submitBookForm')}}">
                        {{csrf_field()}}
                        <div class="col-md-12">
                            <div class="row">
                                <input type="hidden" name="bookId" value="{{$book->id}}">
                                <input type="hidden" name="userId" value="{{$me->id}}">
                                <input type="hidden" name="start_date" value="{{date('Y-m-d')}}">
                                <input type="hidden" name="status" value="{{$type}}">
                                <div class="col-md-6">
                                    <label>Book ISBN</label>
                                    <input type="text" readonly="" class="form-control" value="{{$book->ISBN}}">
                                </div>

                                <div class="col-md-6">
                                    <label>Book Title</label>
                                    <input type="text" readonly="" class="form-control" value="{{$book->bookName}}">
                                </div>

                                <div class="col-md-6">
                                    <label>Book Description</label>
                                    <input type="text" readonly="" class="form-control" value="{{$book->description}}">
                                </div>

                                <div class="col-md-6">
                                    <label>Return Date</label>
                                    <input type="text" name="end_date" readonly="" class="form-control" value="{{date('Y-m-d',strtotime('today + 7 days'))}}">
                                </div>

                            </div>
                            <br>
                            <center><img src="{{asset('images/ajax-loader.gif')}}" width="50px" height="50px" alt="Loading" class="ajaxloader" id="ajaxloader"></center>
                            <button class="btn btn-success" type="submit" onclick="showLoader(this)">Confirm</button>
                            <a href="{{url('main')}}" class="btn btn-danger">Cancel</a>
                        </div>

                    </form>

                        
                    </div>
                </div>
            </div>
        </div>

    </div><!-- .animated -->
</div><!-- .content -->

<script type="text/javascript">
    function showLoader(btn)
    {
        $('.ajaxloader').show();
        $(btn).prop('disabled',true);
        $('#book_form').submit();
    }
</script>
@endsection