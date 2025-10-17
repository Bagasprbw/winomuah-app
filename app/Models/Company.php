<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model {
    protected $fillable = [
        'company_name', 'about', 'address', 'phone', 'instagram', 'logo', 'banner'
    ];
}
