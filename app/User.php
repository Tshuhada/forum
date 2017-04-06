<?php

namespace App;
use App\Topic;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'firstname', 'lastname'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getName()
    {
        if ($this->firstname && $this->lastname) {
          return "{$this->firstname} {$this->lastname}";
        }
        return null;
    }

    public function getNameOrUsername()
    {
        return $this->getName() ?: $this->username;
    }

    public function topics()
    {
        return $this->hasmany(Topic::class);
    }

    public function getAvatar()
    {
        return "https://www.gravatar.com/avatar/" . md5($this->email) . "?d=mm&s=50"; 
    }
}
