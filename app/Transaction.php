<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['order_id', 'transaction_id', 'provider', 'status', 'extra_data'];
}
