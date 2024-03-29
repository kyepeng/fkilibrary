@extends('layouts.dashboard')    

@section('content')
<style type="text/css">
    .content{
      padding: 0;
      height: 100vh;
      background: no-repeat center center scroll;
      -webkit-background-size: cover;
      -moz-background-size: cover;
      -o-background-size: cover;
      background-size: cover;
      background-image: url("{{asset('images/wood.jpg')}}");
    }

    .carousel-item {
      left: 0;
      /*margin-top: 5px;*/
      height: 20vh;
      min-height: 200px;
      background: rgba(255, 255, 255, 0.7);
      /*background-image: url("{{asset('images/wood.jpg')}}");*/
    }
    .carouselContent{
      width: 100%;
      position: absolute;
      display: block;
      bottom: 8vh;
      text-align: center;
      /*left: 15%;*/
    }
    .carouselImage{
      margin-left: 5%;
      width: 80px;
      height: 100px;
    }

    .carouselImage:hover{
      width: 170px;
      height: 130px;
    }

    .right-panel{
      background: white;
    }

    .carousel-inner{
      margin-top: 10px;
    }

    #books.carousel{
      /*position: fixed;*/
      top: 20vh;
      width: 100%;
    }

    #catalog.carousel{
      /*position: fixed;*/
      top: 10vh;
      width: 100%;
    }

    .carouseltitle{
      font-weight: bold;
      color: white;
    }

</style>
<script type="text/javascript">
$(document).ready(function() {

});
</script>

<div class="content">
    <div class="animated fadeIn">

    <div id="catalog" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
      @foreach($catalog as $catkey => $catvalue)
      <li data-target="#catalog" data-slide-to="{{$catkey}}" <?php if($catkey == 0) echo 'class="active"'; ?> ></li>
      @endforeach
    </ol>
    <div class="carousel-inner" role="listbox">
      <h4 class="carouseltitle">Catalog</h4>
      @foreach($catalog as $catkey => $catvalue)
        <div class="carousel-item {{$catkey == 0 ? 'active' : ''}}">
          <div class="carouselContent">
            @foreach($catvalue as $icatvalue)
            <a href="{{url('searchresult')}}?catalog={{$icatvalue->id}}"><img src="{{asset('storage/public/catalog')}}/{{$icatvalue->image_path}}"  width="100" height="100" class="carouselImage" title="{{$icatvalue->catalogName}}"></a>
            @endforeach
          </div>
        </div>
      @endforeach

    </div>
    <a class="carousel-control-prev" href="#catalog" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
    <a class="carousel-control-next" href="#catalog" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
  </div>

   <div id="books" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
      @foreach($book as $bookkey => $bookvalue)
      <li data-target="#books" data-slide-to="{{$bookkey}}" <?php if($bookkey == 0) echo 'class="active"'; ?> ></li>
      @endforeach
    </ol>
    <div class="carousel-inner" role="listbox">

        <h4 class="carouseltitle">Books</h4>
        @foreach($book as $bookkey => $bookvalue)
          <div class="carousel-item {{$bookkey == 0 ? 'active' : ''}}">
            <div class="carouselContent">
              @foreach($bookvalue as $ibookvalue)
              <a href="{{url('searchresult')}}?book={{$ibookvalue->id}}"><img src="{{asset('storage/public/book')}}/{{$ibookvalue->image_path}}"  width="100" height="100" class="carouselImage" title="{{$ibookvalue->bookName}}"></a>
              @endforeach
            </div>
          </div>
        @endforeach

    </div>
    <a class="carousel-control-prev" href="#books" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
    <a class="carousel-control-next" href="#books" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
  </div>

    </div><!-- .animated -->
</div><!-- .content -->

<script type="text/javascript">

</script>
@endsection