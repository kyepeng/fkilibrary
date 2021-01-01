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
            "url" : "{{ url('getLogData') }}",
            'data' : {
                'startdate' : "{{$start}}",
                'enddate' : "{{$end}}"
            }
        },
        columnDefs: [
        { "visible": false, "targets": [{{$me->type == "Student" ? 1 : ''}}] }, 
        { "width": "2%", "targets": [0] },
        ],
        columns: [
            { data: 'DT_RowIndex', title:"No"},
            { data: 'user', title:"Student"},
            { data: 'ISBN', title:"ISBN"},
            { data: 'bookName', title:"Book"},
            { data: 'start_date', title:"Borrow Date"},
            { data: 'end_date', title:"Return Date"},
            { data: 'fine', title:"Fine (RM)"},
            { data: 'badge', title:"Status"}
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

});
</script>

<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Fine Report</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="#">Report Management</a></li>
                            <li><a href="#">Report Management</a></li>
                            <li class="active">Log Report</li>
                            
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="animated fadeIn">

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <strong class="card-title">Log Report</strong>
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

</script>
@endsection