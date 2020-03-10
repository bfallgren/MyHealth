<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Filters\ImageFilter;
use Illuminate\Database\Eloquent\Builder;

class Image extends Model
{
    public function scopeFilter(Builder $builder, $request)
    {
        return (new ImageFilter($request))->filter($builder);
    }
}
