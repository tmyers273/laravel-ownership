<?php

namespace TMyers273\Tests\setup\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use TMyers273\Ownership\OwnsModels;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, OwnsModels;

    protected $table = 'user_models';
    protected $guarded = [];

    //------------------------
    // Relationships
    //------------------------

    public function tests() {
        return $this->hasMany(TestModel::class);
    }

}
