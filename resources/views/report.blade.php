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
                    <strong class="card-title">Dashboard</strong>
                </div>
                <div class="card-body">

                    <div class="row">
                        <!-- Fine Collected Today -->
                        <div class="col-md-6">
                            <div class="chart box">
                                <div id="fine"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Total Student -->
                        <div class="col-md-6">
                            <div class="chart box">
                                <div id="student"></div>
                            </div>
                        </div>

                        <!-- Total Book Today -->
                        <div class="col-md-6">
                            <div class="chart box">
                                <div id="booklog"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>


    </div><!-- .animated -->
</div><!-- .content -->

<script type="text/javascript">
$(document).ready(function() {
    
    // Book Log
    var options = {
      series: {!! json_encode($bookdata) !!},
      chart: {
      type: 'donut',
      height: 350
    },
    plotOptions: {
        pie: {
          donut: {
            labels: {
              show: true,
              name: {
                show: true
              },
              value: {
                show: true
              }
            }
          }
        }
    },
    labels: {!! json_encode($booktitle) !!},
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
    title:{
        text: "Book Log Today"
    },
    colors: ['#00fa21','#008211','#bff266']
    };

    var chart = new ApexCharts(document.querySelector("#booklog"), options);
    chart.render();

    // Fine Collected
    var options = {
      series: [{{$fine !== -1 ? $fine : 100}}],
      chart: {
      height: 350,
      type: 'donut',
    },
    plotOptions: {
        pie: {
          donut: {
            labels: {
              show: true,
              name: {
                show: true
              },
              value: {
                show: true,
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
    labels: ['Fine Collected'],
    responsive: [{
      breakpoint: 480,
      options: {
        chart: {
          width: 200
        },
        legend: {
          position: 'bottom'
        }
      }
    }],
    title:{
        text: "Fine Collected Today"
    },
    dataLabels: {
        enabled: true,
        formatter: function (val,opts) {
          var value = {{$fine}} > 0 ? opts.w.config.series[opts.seriesIndex] : 0;
          return "RM " + value;
        }
      },
    noData: {
      text: undefined,
      align: 'center',
      verticalAlign: 'middle',
      offsetX: 0,
      offsetY: 0,
      style: {
        color: undefined,
        fontSize: '14px',
        fontFamily: undefined
      }
    },
    colors:['#f24b72']
    };

    var chart = new ApexCharts(document.querySelector("#fine"), options);
    chart.render();
      
});

</script>
@endsection