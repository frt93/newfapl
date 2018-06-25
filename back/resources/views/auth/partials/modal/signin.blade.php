{{--<div id="modal" class="modal" :class="{show: show}">--}}
    {{--<div class="modal-container" v-if="show"  style="height:400px; width:600px;">--}}
        {{--<div slot="form">--}}
            {{--<div class="header">--}}
                {{--<div class="title">Auth</div>--}}
            {{--</div>--}}
            {{--<div class="content">--}}
                {{--@include('auth.partials.loginform')--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}

    {{--<div class="overlay" @click="close"></div>--}}
{{--</div>--}}

<modal v-if="showAuthModal" :show.sync="showAuthModal" title="{{ Lang::get('auth.authLabel') }}">
    <div slot="content" class="content">
        <auth token="{{ csrf_token() }}"
              routes-list="{{ $authRoutes }}"
              providers-list="{{ $providers }}"
              labels-list="{{ $labels }}">
        </auth>
    </div>
</modal>
