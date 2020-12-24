<!DOCTYPE>
<html>
<head>
<title>Page title</title>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

  <style type="text/css">
    .carousel-item {
      /*width: 100px;*/
      margin-top: 100px;
      height: 40vh;
      min-height: 350px;
      background: no-repeat center center scroll;
      -webkit-background-size: cover;
      -moz-background-size: cover;
      -o-background-size: cover;
      background-size: cover;
      background: black;
    }
    .carouselContent{
      width: 100%;
      position: absolute;
      display: block;
      bottom: 10vh;
      text-align: center;
      /*left: 15%;*/
    }
    .carouselImage{
      margin-left: 10%;
      width: 150px;
      height: 200px;
    }
    .search{
      float: right;
    }
    .ml-auto{
      margin: auto;
    }
  </style>

  <script type="text/javascript">

    carousel();
    var intervaltime = "1000";

    function carousel() {
      var i;
      var x = document.getElementsByClassName("mySlides");
      if(x.length > 0)
      {
        for (i = 0; i < x.length; i++) {
          x[i].style.display = "none";
        }
        myIndex++;

        if (myIndex > x.length) {myIndex = 1}
        x[myIndex-1].style.display = "block";

        setTimeout(carousel, intervaltime);
      }
    }

  </script>
</head>
<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
  <div class="container">
    <a class="navbar-brand" href="#">FKILibrary</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
          <a class="nav-link" href="#">Home
                <span class="sr-only">(current)</span>
              </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>

      </ul>
    </div>

    <input type="text" name="form-control" class="search" placeholder="Search"><span><i class="fa fa-search"></i></span>

  </div>
</nav>

<header>

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
        <div class="carousel-caption d-none d-md-block">
          <h2 class="display-4">Second Slide</h2>
          <p class="lead">This is a description for the second slide.</p>
        </div>
      </div>
      <!-- Slide Three - Set the background image for this slide in the line below -->
      <div class="carousel-item">
        <div class="carousel-caption d-none d-md-block">
          <h2 class="display-4">Third Slide</h2>
          <p class="lead">This is a description for the third slide.</p>
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
        <div class="carousel-caption d-none d-md-block">
          <h2 class="display-4">Second Slide</h2>
          <p class="lead">This is a description for the second slide.</p>
        </div>
      </div>
      <!-- Slide Three - Set the background image for this slide in the line below -->
      <div class="carousel-item">
        <div class="carousel-caption d-none d-md-block">
          <h2 class="display-4">Third Slide</h2>
          <p class="lead">This is a description for the third slide.</p>
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

</header>

<!-- Page Content -->
<section class="py-5">
  <div class="container">

  </div>
</section>   

</body>
</html>