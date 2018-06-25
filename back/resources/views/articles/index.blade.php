@extends('index')

@section('content')

    <header class="page-wrap">
        <div class="wrap container">
            <h1 class="pageTitle">News</h1>
            <div id="socialList">
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
    </header>
    <div class="container clearfix">
        <main class="clearfix"  id="maincontent">
            <a href="{{ action('ArticlesController@create') }}" class="btn">Создать</a>
            <three-stage-content-filter api-path="{{ URL::route('api') }}"
                            model="articles"
                            container="content"
                            reset-btn-value="{{ $resetBtnValue }}"
                            search-btn-value="{{ $searchBtnValue }}"
                            competitions="{{ $competitions }}"
                            clubs="{{ $clubsList }}"
                            players="{{ $playersList }}"
                            competition-slug="{{ $competitionSlug }}"
                            competition-name="{{ $competitionName }}"
                            club-slug="{{ $clubSlug }}"
                            club-name="{{ $clubName }}"
                            player-slug="{{ $playerSlug }}"
                            player-name="{{ $playerName }}"
                            unpicked-competition="{{ $unPickedCompetitionValue }}"
                            unpicked-club="{{ $unpickedClubValue }}"
                            unpicked-player="{{ $unpickedPlayerValue }}"
                            fetch-clubs-err-msg="{{ $fetchClubsErrMsg }}"
                            fetch-players-err-msg="{{ $fetchPlayersErrMsg }}"
                            fetch-data-err-msg="{{ $fetchDataErrMsg }}"
                            exceeded-requests-msg="{{ $exceededRequestsMsg }}"
                            is-filtered="{{ $isFiltered }}">
            </three-stage-content-filter>

            <div id="content">
                @include('flash::message')
                @include('articles.partials.article')
            </div>
            <infinite-pagination api-path="{{ URL::route('api') }}"
                                 start="{{ $articles->currentPage() }}"
                                 last="{{ $articles->lastPage() }}"
                                 container="content"
                                 model="articles"
                                 load-btn-value="{{ $loadBtnValue }}"
                                 loading-text="{{ $loadingText }}"
                                 type="default"
                                 fetch-err-msg="{{ $fetchErrMsg }}">
            </infinite-pagination>
                    <div v-if="!infiniteLoading"
                         class="defaultPagination">
                        {{ $articles->render() }}
                    </div>
        </main>
    </div>
@stop