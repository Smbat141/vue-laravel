<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPayments extends Model
{
    protected $fillable = ['post_pay'];

    protected $table = 'users_payments';
}
