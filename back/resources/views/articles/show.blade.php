@extends('index')

@section('content')
		<header class="entry-head">
		<div class="container entry-head-content clearfix">
			<div class="articlehead">
				<h5>
					@foreach($article->categories as $cat)
						{{ $cat->name }}
					@endforeach
				</h5>

				<h1>{{ $article->title }}</h1>

				
					<h5>
						{{ $article->author }}
						<span>{{ $article->published_at }}</span>
					</h5>
					<h5><a href="{{ action('ArticlesController@edit', $article->id) }}">Изменить</a></h5>
				</div>

		</div>
		</header>
		<div class="container single-container clearfix">
			<div id="socialList">
                <div class="socialSticky">
                    <div class="socialShare" :class="{open: isSocialBlockOpen}" @click="isSocialBlockOpen=!isSocialBlockOpen">
                        <div class="sharebtn" role="button" tabindex="0" aria-haspopup="true">
                            <div class="icn share"></div>
                            Share
                        </div>
                        <ul class="sociallist" role="listbox">
                            <li>
                                <div onClick="window.open('https://twitter.com/intent/tweet?text=hereTitle&via=epconst&url=hereLink','sharer','toolbar=0,status=0,width=700,height=400');" href="javascript: void(0)" class="option twitter" role="option" tabindex="0">
                                    <span class="icn twitter-share"></span>
                                </div>
                            </li>
                            <li>
                                <div onClick="window.open('https://vkontakte.ru/share.php?url=hereLink','sharer','toolbar=0,status=0,width=700,height=400');" href="javascript: void(0)" class="option vkcom" role="option" tabindex="0">
                                    <span class="icn vk-share"></span>
                                </div>
                            </li>
                            <li>
                                <div onClick="window.open('https://www.facebook.com/sharer.php?u=hereLink','sharer','toolbar=0,status=0,width=700,height=400');" href="javascript: void(0)" class="option facebook" role="option" tabindex="0">
                                    <span class="icn fb-share"></span>
                                </div>
                            </li>
                            <li>
                                <div onClick="window.open('https://plus.google.com/share?url=hereLink','sharer','toolbar=0,status=0,width=700,height=400');" href="javascript: void(0)" class="option google" role="option" tabindex="0">
                                    <span class="icn google-share"></span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
			<main class="single-entry clearfix">
					<article class="single-entry clearfix">
						<span class="entry-full-img">
							Изображение
						</span>
						<span class="entry-content">
							{{ $article->body }}
						</span>
					</article>
				@unless ($article->tags->isEmpty())
					<hr>
					<h5>Теги:</h5>
					<ul>
						@foreach($article->tags as $tag)
							<li style="float:left; margin-right:15px">{{ $tag->name }}</li>
						@endforeach
					</ul>
				@endunless
				@unless ($article->players->isEmpty())
					<hr>
					<h5>Игроки:</h5>
					<ul>
						@foreach($article->players as $player)
							<li style="float:left; margin-right:15px">{{ $player->name }}</li>
						@endforeach
					</ul>
				@endunless
				@unless ($article->clubs->isEmpty())
					<hr>
					<h5>Клубы:</h5>
					<ul>
						@foreach($article->clubs as $club)
							<li style="float:left; margin-right:15px">{{ $club->name }}</li>
						@endforeach
					</ul>
				@endunless

				<div class="navigation clearfix">
					@if($previous)
						<span class="previous-entry"><a href="{{ action('ArticlesController@show', $previous) }}">Предыдущая</a></span>
					@endif
					@if($next)
						<span class="next-entry"><a href="{{ action('ArticlesController@show', $next) }}">Следующая</a></span>
					@endif
				</div>
				
				<!-- Последние новости -->
				<section class="mainWidget latest">
					<header class="clearfix">
						<h3 class="clearfix">Latest News</h3>
					</header>
					<a class="btn moreBtn" href="{{ action('ArticlesController@index') }}">More News
						<span class="icn arrow-right"></span>
					</a>
				</section>
			</main>

			
		</div>
@stop