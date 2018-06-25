<form id="auth" class="form-horizontal" method="POST" action="{{ route('signin') }}">
        {{--<div class="form-group" :class="{'has-error': failedAttempt}">--}}
            {{--<label for="email" class="col-md-4 control-label">E-Mail Address</label>--}}

            {{--<div class="col-md-6">--}}
                {{--<input id="email" type="text" v-model="login" class="form-control" name="email" value="{{ old('email') }}" required autofocus>--}}
            {{--</div>--}}
        {{--</div>--}}

        {{--<div class="form-group" :class="{'has-error': failedAttempt}">--}}
            {{--<label for="password" class="col-md-4 control-label">Password</label>--}}

            {{--<div class="col-md-6">--}}
                {{--<input id="password" type="password" v-model="password" class="form-control" name="password" required>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="form-group" :class="{'has-error': failedAttempt || exceededAttempts}">--}}
            {{--<div class="col-md-8 col-md-offset-4">--}}
                {{--<span class="help-block" v-if="failedAttempt && !exceededAttempts">@{{ errorMsg }}</span>--}}
                {{--<span class="help-block" v-if="timer > 0">@{{ errorMsg }} @{{ timer }} @{{ secs }}</span>--}}
            {{--</div>--}}
        {{--</div>--}}

        {{--<div class="form-group">--}}
            {{--<div class="col-md-6 col-md-offset-4">--}}
                {{--<div class="checkbox">--}}
                    {{--<label>--}}
                        {{--<input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me--}}
                    {{--</label>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}

        {{--<div class="form-group">--}}
            {{--<div class="col-md-8 col-md-offset-4">--}}
                {{--<button type="submit" class="btn btn-primary" :class="{disabled: timer > 0}" @click.prevent="log">--}}
                    {{--Login--}}
                {{--</button>--}}


                {{--<div class="provider-list clearfix">--}}
                    {{--<div class="provider login-provider-vk" data-provider="Vkontakte">--}}
                        {{--<a class="social-auth-icon vk" href="{!! route('socialite.auth', 'vkontakte') !!}"></a>--}}
                    {{--</div><div class="provider login-provider-ggl" data-provider="Google">--}}
                        {{--<a class="social-auth-icon ggl" href="{!! route('socialite.auth', 'google') !!}"></a>--}}
                    {{--</div><div class="provider login-provider-fb" data-provider="Facebook">--}}
                        {{--<a class="social-auth-icon fb" href="{!! route('socialite.auth', 'facebook') !!}"></a>--}}
                    {{--</div><div class="provider login-provider-twitter" data-provider="Twitter">--}}
                        {{--<a class="social-auth-icon twitter" href="{!! route('socialite.auth', 'twitter') !!}"></a>--}}
                    {{--</div><div class="provider login-provider-Yandex hidden" data-provider="Yandex">--}}
                        {{--<a class="social-auth-icon ya" href="{!! route('socialite.auth', 'yandex') !!}"></a>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<a class="btn btn-link" href="{{ route('password.request') }}">--}}
                    {{--Forgot Your Password?--}}
                {{--</a>--}}
            {{--</div>--}}
        {{--</div>--}}
</form>
