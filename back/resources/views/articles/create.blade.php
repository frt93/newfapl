@extends('index')

@section('content')
	<div class="container single-container clearfix">
		<h1>Создание новости</h1>
		<main class="clearfix">
			{!! Form::open(['url' => 'articles']) !!}
				@include('articles.partials._form', ['submitButtonText' => 'Опубликовать',
												 'author'=> Auth::user()->username,
												 'date' => date('Y-m-d H:i:s')])
			{!! Form::close() !!}
			@include ('errors.ErrorList')
		</main>
	</div>
@stop

@section('scripts')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
	<script src="{{ asset('js/build2.js') }}"></script>
@stop