<a href="{{ action('ArticlesController@edit', $article->id) }}">Изменить</a>
@if ($article->published == true)
    <a href="{{ action('ArticlesController@deactivate', $article->id) }}">Деактивировать</a>
@else
    <a href="{{ action('ArticlesController@activate', $article->id) }}">Активировать</a>
@endif