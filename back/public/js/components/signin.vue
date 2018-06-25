<template>
    <div>
        <div class="socialite clearfix">
             <div v-for="provider in providers" :key="provider.name" :class="provider.name" @click="social(provider.route)"></div>
        </div>

        <div class="group col-md-6" :class="[(error.user || isUserShort) ? 'error' : '', loginType]">
            <label for="email">{{ userLabel }}</label>
            <input type="text" 
                   v-model="user"
                   @input="userLength"
                   name="user"
                   required autofocus>
        </div>

        <div class="group col-md-6" :class="{'error': error.password || isPasswordShort}">
            <label for="password">{{ passwordLabel }}</label>
            <input :type="[showPass ? 'text' : 'password']" 
                   v-model="password" 
                   @input="passLength"
                   name="password" 
                   required>
        </div>

        <div class="group col-md-8" :class="{'error': error}" v-if="lockTime > 0">
            <span class="help">{{ error.exceeded }}</span>
        </div>

        <div class="group col-md-6">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="remember"> {{ label.remember }}
                    </label>
                </div>
        </div>

        <div class="group col-md-8">
            <button type="submit" class="btn btn-primary" :class="{disabled: lockTime > 0 || !canSubmit }" @click.prevent="login">
                {{ button }}
            </button>

            <a :href="routes.forgot">
                {{ label.forgot }}
            </a>

            <a href="" @click.prevent="showPass = !showPass">{{ label.show }}</a>
            <a href="" @click.prevent="checkAuth">Проверить авторизован ли?</a>

            <div>{{ userData }}</div>
        </div>
    </div>
</template>

<script type="text/babel">

    export default {
        data() {
            return {
                user: '',
                password: '',
                error: false,
                lockTime: 0,
                showPass: false,
                loginType: 'username',
                buttonValue: '',
                isPasswordShort: false,
                isUserShort: false,
                userData: ''
            }
        },
        props: {
            providers: Array,
            label: Object,
            routes: Object
        },
        computed: {
            button() {
                return this.buttonValue = (this.lockTime > 0) ? (this.label.retry + this.lockTime) : this.label.signin
            },
            canSubmit() {
                return (this.user.length > 2 && this.password.length > 5) ? true : false
            },
            passwordLabel: {
                get: function() {
                    return (this.error.password) ? 
                            this.error.password : 
                            ( (this.isPasswordShort) ? this.label.shortPass : this.label.pass )
                },

                set: function(newValue) {
                }
            },

            userLabel: {
                get: function () {
                    return (this.error.user) ? 
                        this.error.user :
                        ( (this.isUserShort) ? this.label.shortUser : this.label.login )
                },

                set: function(newValue) {
                
                }
            }
        },
        methods: {
            checkAuth() {
                axios.get( this.routes.check )
                .then(response => {              
                    this.userData = response.data
                })
                .catch( error => {
                    console.log(error);
                })
            },
            login() {
                let form = document.getElementById('auth');
                let data = new FormData(form);
                axios.post( this.routes.signin, data )
                .then(response => {
                    
                    
                    this.$store.commit('showAuthModal', false);
                    this.$store.commit('userLogged', response.data)
                })
                .catch( error => {
                    this.error = error.response.data.errors;
                    if(this.error.exceeded) {
                        this.lockTime = this.error.time;
                        this.locked()
                    }
                    console.log(this.error);
                    
                })
            },

            locked() {
                let timerId = setInterval( () => { 
                    if(this.lockTime > 0) {
                        return this.lockTime--
                    } else {
                    clearInterval(timerId)
                    };
                }, 1000 )
            },

            userLength() {
                let delay = (this.user.length < 3) ? 2000 : 20;

                setTimeout( () => {
                    this.isUserShort = (this.user.length < 3) ? true : false
                }, delay );

                if(this.error.user || ( this.error.password)) {
                    this.error = false
                }
            },

            passLength() {
                let delay = (this.password.length < 6) ? 2000 : 20;

                setTimeout( () => {
                    this.isPasswordShort = (this.password.length < 6) ? true : false
                }, delay );

                if(this.error.password) {
                    this.error = false
                }
            },

            social(url) {
                let self = this,
                    width  = 1000,
                    height = 600,
                    top = (screen.height/2) - ( height / 2 ) - 50,
                    left = (screen.width  / 2 ) - ( width  / 2 ),
                    popup = window.open(url, '', 'location=1,status=0,scrollbars=0,height=' + height + ',width=' + width + ',top=' + top + ',left=' + left);

                let watch_timer = setInterval(function () {
                    if (popup.closed) {
                        self.checkAuth();
                        clearInterval(watch_timer);
                    }
                }, 40);
            }
        },
        watch: {
            user: function(newVal, oldVal) {
                this.loginType = (newVal.indexOf('@') + 1) ? 'email' : 'username'
            },
        },
    }
</script>