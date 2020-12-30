@extends('layouts.dashboard')    

@section('content')

<script type="text/javascript">
var oTable;
$(document).ready(function() {

});
</script>

<div class="content">
    <div class="animated fadeIn">

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <strong class="card-title">Introduction</strong>
                </div>
                <div class="card-body">
                    <p>
                        FKI Library is a mini library for faculty multimedia and faculty information and computing.
                        We provide vital support for students, researchers and staff, complementing academic activities.
                        Easier and manageable self-service book borrowing library.
                    </p> 
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <strong class="card-title">Operating Hours</strong>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <td>During Semester</td>
                                <td>Exam Period</td>
                                <td>Semester Holiday</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Mon - Fri</td>
                                <td>Mon - Fri</td>
                                <td>Mon - Fri</td>
                            </tr>
                            <tr>
                                <td>08:30am-05:00pm</td>
                                <td>08:30am-05:00pm</td>
                                <td>08:30am-05:00pm</td>
                            </tr>
                            <tr>
                                <td>Sat - Sun & P.Holiday</td>
                                <td>Sat - Sun & P.Holiday</td>
                                <td>Sat - Sun & P.Holiday</td>
                            </tr>
                            <tr>
                                <td>Close</td>
                                <td>Close</td>
                                <td>Close</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <strong class="card-title">Contact Us</strong>
                </div>
                <div class="card-body">
                     <h4>fkilibrary@gmail.com</h4>
                </div>
            </div>
        </div>

    </div><!-- .animated -->
</div><!-- .content -->

<script type="text/javascript">
     function openModal(button)
    {
        var id = $(button).data('id');
        var data =  oTable.row("#"+id).data();
        closeMessageBlock();
        $('#submitBtn').prop('disabled',false);
        $('#id').val(data.id);
        $('#bookId').val(data.id);
        $('#ActionModal').modal('show');
    }

    function Submit()
    {   
        var param = {
            'data' : new FormData($("#upload_form")[0]),
            'myurl' : "{{ url('/submitBookForm') }}",
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