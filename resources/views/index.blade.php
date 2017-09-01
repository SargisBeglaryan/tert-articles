@extends('templates.layouts.default')

@section('title', 'Web & Mobile Applications Development Company')

@section('keywords', 'Web, Mobile, Applications, Development Company, Helix, Tert')
@section('description', 'Web, Mobile, Applications, Development Company, Helix, Tert')
@section('head')
	<link rel="stylesheet" href="{{asset('css/home.css')}}" type="text/css">
@endsection

@section('content')
	<div class='container'>
		<div class="token">{{ csrf_token() }}</div>
		<div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
			<a class="admin" href="{{asset('panel')}}">Admin</a>
		</div>
		<div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
			<a class="articles" href="{{asset('articles')}}">Articles</a>
		</div>
	</div>

@endsection

@section('script')
	<script src="{{asset('js/home.js')}}"></script>
@endsection
