@extends('layouts.app2')
@section('content')
  @if(Auth::check())
    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel" data-interval="2500" data-pause="hover">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="/images/inside.gif" class="d-block w-100" alt="truck">
        </div>
        <div class="carousel-item">
          <img src="/images/outside-warehouse.gif" class="d-block w-100" alt="warehouse">
        </div>
        <div class="carousel-item">
          <img src="/images/folk.gif" class="d-block w-100" alt="folklift">
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
  @else
        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel" data-interval="2500" data-pause="hover">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="/images/inside.gif" class="d-block w-100" alt="truck">
        </div>
        <div class="carousel-item">
          <img src="/images/outside-warehouse.gif" class="d-block w-100" alt="warehouse">
        </div>
        <div class="carousel-item">
          <img src="/images/folk.gif" class="d-block w-100" alt="folklift">
        </div>
        
        <button>{!! link_to_route('signup.get','会員登録',[],['class'=>'signup']) !!}</button>
        <button>{!! link_to_route('login','ログイン',[],['class'=>'login']) !!}</button>
        
        //<a href = "{{ route('warehouses.stocksSelect') }}">
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
  @endif
  
    {{--<div class='m-3'>
        {!! link_to_route('signup.get','会員登録',[],['class'=>'btn btn-lg btn-primary']) !!}
    </div>
    <div class='m-3'>
        {!! link_to_route('login','ログイン',[],['class'=>'btn btn-lg btn-primary']) !!}
    </div>
    
    
    <div class = "top">
      <img src = "/images/outside-warehouse.jpg" class = "d-block w-100">
      <button>{!! link_to_route('signup.get','会員登録',[],['class'=>'btn']) !!}</button>
    </div>
    --}}
@endsection
@push('css')
    <link href="{{ asset('css/welcome.css') }}" rel="stylesheet">
@endpush