<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Filters\LabFilter;
use Illuminate\Database\Eloquent\Builder;


class Labtest extends Model
{
	public function scopeFilter(Builder $builder, $request)
    {
        return (new LabFilter($request))->filter($builder);
    }
}
