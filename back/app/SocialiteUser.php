<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class SocialiteUser extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'provider', 'provider_user_id', 'provider_user_name'
    ];

    /**
     * A social oAuth account can have only one user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne('App\User');
    }


    /**
     * Login user via received from socialite provider data.
     * If user with received params doesn't exist - create him and login.
     *
     * @param $provider
     * @param $data
     * @return string
     */
    public static function find_user($provider, $data)
    {
        $email = $data->email;
        $user = User::where('email', $email)->first();

        if($user) {
            Auth::login($user, true);
            return '<script>window.close();</script>';
        } else {
            $userdata = [
                'username' => $data->name,
                'email' => $data->email,
                'password' => Hash::make('userpassword')
            ];

            $new_user = new User($userdata);
            $new_user->save();

            $socialite_data = [
                'user_id' => $new_user->id,
                'provider' => $provider,
                'provider_user_id' => $data->id,
                'provider_user_name' => $data->name
            ];

            $new_socialite_user = new SocialiteUser($socialite_data);
            $new_socialite_user ->save();

            Auth::login($new_user, true);
        }
    }
}
