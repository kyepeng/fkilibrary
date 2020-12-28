@extends('layouts.dashboard')    

@section('content')

<script type="text/javascript">
$(document).ready(function() {

});
</script>

<div class="content">
    <div class="animated fadeIn">

    <div id="catalog" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#catalog" data-slide-to="0" class="active"></li>
      <li data-target="#catalog" data-slide-to="1"></li>
      <li data-target="#catalog" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner" role="listbox">

      <div class="carousel-item active">
        <div class="carouselContent">
          <img src="{{asset('img')}}" width="100" height="100" class="carouselImage">
          <img src="{{asset('img')}}" width="100" height="100" class="carouselImage">
          <img src="{{asset('img')}}" width="100" height="100" class="carouselImage">
          <img src="{{asset('img')}}" width="100" height="100" class="carouselImage">
        </div>
      </div>
      <!-- Slide Two - Set the background image for this slide in the line below -->
      <div class="carousel-item">
        <div class="carouselContent">
          <img src="{{asset('img')}}" width="100" height="100" class="carouselImage">
          <img src="{{asset('img')}}" width="100" height="100" class="carouselImage">
          <img src="{{asset('img')}}" width="100" height="100" class="carouselImage">
          <img src="{{asset('img')}}" width="100" height="100" class="carouselImage">
        </div>
      </div>
      <!-- Slide Three - Set the background image for this slide in the line below -->
      <div class="carousel-item">
        <div class="carouselContent">
          <img src="{{asset('img')}}" width="100" height="100" class="carouselImage">
          <img src="{{asset('img')}}" width="100" height="100" class="carouselImage">
          <img src="{{asset('img')}}" width="100" height="100" class="carouselImage">
          <img src="{{asset('img')}}" width="100" height="100" class="carouselImage">
        </div>
      </div>

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
      <li data-target="#books" data-slide-to="0" class="active"></li>
      <li data-target="#books" data-slide-to="1"></li>
      <li data-target="#books" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner" role="listbox">

      <div class="carousel-item active">
        <div class="carouselContent">
          <img src="{{asset('img')}}" width="100" height="100" class="carouselImage">
          <img src="{{asset('img')}}" width="100" height="100" class="carouselImage">
          <img src="{{asset('img')}}" width="100" height="100" class="carouselImage">
          <img src="{{asset('img')}}" width="100" height="100" class="carouselImage">
        </div>
      </div>
      <!-- Slide Two - Set the background image for this slide in the line below -->
      <div class="carousel-item">
        <div class="carouselContent">
          <img src="{{asset('img')}}" width="100" height="100" class="carouselImage">
          <img src="{{asset('img')}}" width="100" height="100" class="carouselImage">
          <img src="{{asset('img')}}" width="100" height="100" class="carouselImage">
          <img src="{{asset('img')}}" width="100" height="100" class="carouselImage">
        </div>
      </div>
      <!-- Slide Three - Set the background image for this slide in the line below -->
      <div class="carousel-item">
        <div class="carouselContent">
          <img src="{{asset('img')}}" width="100" height="100" class="carouselImage">
          <img src="{{asset('img')}}" width="100" height="100" class="carouselImage">
          <img src="{{asset('img')}}" width="100" height="100" class="carouselImage">
          <img src="{{asset('img')}}" width="100" height="100" class="carouselImage">
        </div>
      </div>

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