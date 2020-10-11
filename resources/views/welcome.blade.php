@extends('layouts.app2')

@section('content')
    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel" data-interval="2500" data-pause="hover">
          <div class="carousel-inner">
            <div class="carousel-item active" style="background-color: red;">
              <img src="/images/truck.jpg" class="d-block w-100" alt="truck">
            </div>
            <div class="carousel-item"  style="background-color: yellow;">
              <img src="/images/warehouse.jpg" class="d-block w-100" alt="warehouse">
            </div>
            <div class="carousel-item"  style="background-color: blue;">
              <img src="/images/norimono01_11.png" class="d-block w-100" alt="folklift">
            </div>
          </div>
          <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
    </div>

@endsection