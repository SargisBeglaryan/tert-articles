@extends('templates.layouts.default')

@section('title', 'Web & Mobile Applications Development Company')

@section('keywords', 'Web, Mobile, Applications, Development Company, Helix, Tert')
@section('description', 'Web, Mobile, Applications, Development Company, Helix, Tert')
@section('head')
	<link rel="stylesheet" href="{{asset('css/articles.css')}}" type="text/css">
@endsection

@section('content')
	<div class='container'>
		<a class='homePageLink' href='{{asset('/')}}'>Home</a>
		@foreach($obj->articles as $article)
		<?php
			$imageFileArray = explode("/", $article->image_url);
        	$imageName = $imageFileArray[count($imageFileArray)-1];
		?>
		<div class='articleContent'>
			<h3>{{$article->title}}</h3>
			<p>{{$article->description}}</p>
			<img src="{{asset('images/').'/'.$imageName}}">
			<a href='{{$article->article_url}}' target='_blank'>Նյութի հղումը</a>
		</div>
		@endforeach
				</div>
		@if(isset($obj->articles))
			{{$obj->articles->links()}}
		@endif
	</div>

@endsection

@section('script')
@endsection
