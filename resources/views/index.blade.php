@extends('templates.layouts.default')

@section('title', 'Web & Mobile Applications Development Company')

@section('keywords', 'Web, Mobile, Applications, Development Company, Helix, Tert')
@section('description', 'Web, Mobile, Applications, Development Company, Helix, Tert')
@section('head')
	<link rel="stylesheet" href="{{asset('css/home.css')}}" type="text/css">
@endsection

@section('content')
	<div class='container'>
		<div class="loader"></div>
		<div class="token">{{ csrf_token() }}</div>
		<div class='col-xs-12 col-sm-4 col-md-4 col-lg-4'>
			<a class="admin btn" href="{{asset('panel')}}"><span>Admin</span></a>
		</div>
		<div class='col-xs-12 col-sm-4 col-md-4 col-lg-4'>
			<a class="articles btn" href="{{asset('articles')}}"><span>Articles</span></a>
		</div>
		<div class='col-xs-12 col-sm-4 col-md-4 col-lg-4'>
			<button type='button' class="btn updateArticles"><span>Update Articles</span></a>
		</div>
	</div>

@endsection

@section('script')
	<script src="{{asset('js/home.js')}}"></script>
@endsection
