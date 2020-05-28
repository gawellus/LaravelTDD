<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $guarded = [];

    protected $dates = ['birth'];

    public function setBirthAttribute($birth)
    {
        $this->attributes['birth'] = Carbon::parse($birth);
    }
}
