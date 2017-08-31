@extends('templates.layouts.default')

@section('title', 'Web & Mobile Applications Development Company')

@section('keywords', 'Web, Mobile, Applications, Development Company, Helix, Tert')
@section('description', 'Web, Mobile, Applications, Development Company, Helix, Tert')
@section('head')
	<link rel="stylesheet" href="{{asset('css/home.css')}}" type="text/css">
@endsection

@section('content')

@endsection

@section('script')
	<script src="{{asset('js/home.js').'?t='.strtotime('now')}}"></script>
@endsection
