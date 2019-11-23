<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Filters\SurgeryFilter;
use Illuminate\Database\Eloquent\Builder;


class Surgery extends Model
{
    public function scopeFilter(Builder $builder, $request)
    {
        return (new SurgeryFilter($request))->filter($builder);
    }
}
