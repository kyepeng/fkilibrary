@extends('layouts.dashboard')    

@section('content')
<style type="text/css">
    .chart{
        border: 1px solid grey;
        height: 400px;
        border-radius: 16px;
        margin: 5px;
        padding: 10px;
    }
</style>
<div class="content">
    <div class="animated fadeIn">

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <strong class="card-title">Report</strong>
                </div>
                <div class="card-body">

                    <div class="col-md-5">
                      <div class="form-group">
                          <label class=" form-control-label">Date Range</label>
                          <div class="input-group">
                              <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                              <input class="form-control" id="range">
                          </div>
                      </div>
                    </div>

                    <div class="row">
                        <!-- Fine Collected Today -->
                        <div class="col-md-6">
                            <div class="chart box">
                                <a href="{{url('finereport')}}/{{$start}}/{{$end}}"><div id="fine"></div></a>
                            </div>
                        </div>

                        <!-- Total Book Today -->
                        <div class="col-md-6">
                            <div class="chart box">
                                <a href="{{url('logreport')}}/{{$start}}/{{$end}}"><div id="booklog"></div></a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>


    </div><!-- .animated -->
</div><!-- .content -->
<link href="{{ asset('/plugin/daterangepicker/daterangepicker.css') }}" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="{{ asset('/plugin/daterangepicker/daterangepicker.js') }}"></script>
<script type="text/javascript">

  $('#range').daterangepicker(
      {
        locale: {
          format: 'YYYY-MM-DD'
      },
      startDate: '{{$start}}',
      endDate: '{{$end}}'
  });

  $('#range').on('apply.daterangepicker', function(ev, picker) {
      var range = $('#range').val().split(" - ");
      window.location.href = "{{url('report')}}/" + range[0] + "/" + range[1]; 
  });

$(document).ready(function() {


    // Book Log
    var options = {
      series: {!! json_encode($bookdata) !!},
      chart: {
      type: 'pie',
      height: 350
    },
    plotOptions: {
        pie: {
          donut: {
            labels: {
              show: true,
              name: {
                show: true,
                color: "white"
              },
              value: {
                show: true,
                formatter: function(val)
                {
                    return {{count($bookdata)}} > 1 ? val : '-';
                },
                color: "white"
              }
            }
          }
        }
    },
    tooltip: {
      y: {
        formatter: function(value, { series, seriesIndex, dataPointIndex, w }) {
           return {{count($bookdata)}} > 1 ? value : '-';
        }
      }
    },
    stroke: {
      width: 0
    },
    labels: {{ count($bookdata) }} > 1 ? {!! json_encode($booktitle) !!} : ['No History'],
    responsive: [{
      breakpoint: 480,
      options: {
        chart: {
          height: 350
        },
        legend: {
          position: 'bottom'
        }
      }
    }],
    dataLabels: {
        enabled: {{count($bookdata)}} > 1 ? true : false
    },
    title:{
        text: "Book Log"
    },
    legend:{
      show: 'true',
      position : 'bottom'
    },
    colors: ['#022CD6','#74FF00','#DA2C06']
    };

    var chart = new ApexCharts(document.querySelector("#booklog"), options);
    chart.render();

    // Fine Collected
    var options = {
      series: [{{$fine !== -1 ? $fine : 100}}],
      chart: {
      height: 350,
      type: 'pie',
    },
    plotOptions: {
        pie: {
          donut: {
            labels: {
              show: true,
              name: {
                show: true,
                color: "white"
              },
              value: {
                show: true,
                color: "white",
                formatter: function(val)
                {
                    val = {{$fine}} > 0 ? val : 0;
                    return "RM "+val;
                }
              }
            }
          }
        }
    },
    tooltip: {
      y: {
        formatter: function(value, { series, seriesIndex, dataPointIndex, w }) {
          return {{$fine}} > 0 ? "RM "+ value : 0;
        }
      }
    },
    labels: ['Fine Collected'],
    responsive: [{
      options: {
        chart: {
          width: 200
        },
        legend: {
          position: 'bottom'
        }
      }
    }],
    stroke: {
      width: 0
    },
    title:{
        text: "Fine Collected"
    },
    dataLabels: {
        enabled: false
    },
    legend:{
      show: 'true',
      position : 'bottom'
    },
    colors:['#f24b72']
    };

    var chart = new ApexCharts(document.querySelector("#fine"), options);
    chart.render();
      
});

</script>
@endsection