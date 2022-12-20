<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = ['currency','currency_symbol','name','system_id','leads_email','date_created','created_by','commission', 'apikey'];
}
