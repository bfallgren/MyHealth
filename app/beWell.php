<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Filters\BeWellFilter;
use Illuminate\Database\Eloquent\Builder;

class beWell extends Model
{
   public function scopeFilter(Builder $builder, $request)
    {
        return (new BeWellFilter($request))->filter($builder);
    }

    
}
