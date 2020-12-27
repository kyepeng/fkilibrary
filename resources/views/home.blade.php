@extends('layouts.dashboard')    

@section('content')
<style type="text/css">

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
                        <!-- Top 10 Most Popular Book -->
                        <div class="col-md-12">
                            <div class="chart box">
                                <div id="popular"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Most Active Year -->
                        <div class="col-md-6">
                            <div class="chart box">
                                <div id="activeyear"></div>
                            </div>
                        </div>
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

    //popular
    var options = {
      series: [{
      name: "Borrow Times",
      data: {!! json_encode($populardata) !!}
    }],
      chart: {
      type: 'bar',
      height: 350
    },
    plotOptions: {
      bar: {
        horizontal: true,
      }
    },
    xaxis: {
      categories: {!! json_encode($populartitle) !!},
    },
    title: {
        text: "Top 10 Books"
    }
    };

    var chart = new ApexCharts(document.querySelector("#popular"), options);
    chart.render();

    //active year
    var options = {
        series: [{
          name: 'Borrow Times',
          data: {!! json_encode($activedata) !!}
        }],
          chart: {
          type: 'bar',
          height: 350
        },
        plotOptions: {
          bar: {
            horizontal: false,
            // columnWidth: '55%',
            // endingShape: 'rounded'
          },
        },
        dataLabels: {
          // enabled: false
        },
        stroke: {
          show: true,
          width: 2,
          colors: ['transparent']
        },
        xaxis: {
          categories: {!! json_encode($activetitle) !!},
        },
        yaxis: {
        },
        fill: {
          opacity: 1,
          colors: ['#03fcb1']
        },
        tooltip: {
          y: {
          }
        },
        title: {
          text: "Most Active Year"
        }
    };

    var chart = new ApexCharts(document.querySelector("#activeyear"), options);
    chart.render();

    // Total Student
    var options = {
      series: {!! json_encode($studentdata) !!},
      chart: {
      // width: 380,
      height: 350,
      type: 'pie',
    },
    labels: {!! json_encode($studenttitle) !!},
    responsive: [{
      breakpoint: 480,
      options: {
        chart: {
          width: 200
        },
        legend: {
          position: 'bottom'
        }
      },
    }],
    title:{
        text: "Total Students"
    }
    };

    var chart = new ApexCharts(document.querySelector("#student"), options);
    chart.render();
    
    // Book Log
    var options = {
      series: {!! json_encode($bookdata) !!},
      chart: {
      type: 'donut',
      height: 350
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
    }
    };

    var chart = new ApexCharts(document.querySelector("#booklog"), options);
    chart.render();

    // Fine Collected
    var options = {
      series: [{{$fine}}],
      chart: {
      height: 350,
      type: 'pie',
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
    }
    };

    var chart = new ApexCharts(document.querySelector("#fine"), options);
    chart.render();
      
});

</script>
@endsection