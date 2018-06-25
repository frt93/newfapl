@extends('index')

@section('content')
    <div class="container single-container clearfix">
        <h1>Редактировать новость</h1>
        <main class="clearfix">
            {!! Form::model($article, ['method' => 'PATCH', 'action' => ['ArticlesController@update', $article->id]]) !!}
                @include('articles.partials._form', ['submitButtonText' => 'Изменить',
                                                 'author' => $article->author,
                                                 'date' => $article->published_at])
            {!! Form::close() !!}
            @include('errors.ErrorList')
        </main>
    </div>
@stop

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="{{ asset('js/build2.js') }}"></script>
@stop