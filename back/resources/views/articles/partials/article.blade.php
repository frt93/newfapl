@forelse($articles as $article)
    <section class="entry clearfix">
        <div class="maincontent">
            <a href="{{ url('articles', $article->id) }}" class="entry-title-link">
                <figure class="clearfix">
                    <span class="entry-pre-img">
                        <img src="/resources/i/eden200.jpg" alt="">
                    </span>
                    <figcaption>
                        <span class="post-cat">
                            @foreach($article->categories as $cat)
                                {{ $cat->name }}
                            @endforeach
                        </span>
                        <span class="date">
                            {{ $article->published_at }}
                           <p> id: {{ $article->id }}</p>
                        </span>
                        <h2>{{ $article->title }}</h2>
                        <p>{{ $article->excerpt }}</p>
                    </figcaption>
                </figure>
            </a>

            @include('articles.partials.controllers')

        </div>
    </section>
    @empty
        <div class="contentNotFound clearfix">
            Нет новостей, удовлетворяющих запросу
        </div>
@endforelse