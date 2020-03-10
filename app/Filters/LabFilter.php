<?php

// BlogFilter.php
// required for search filter

namespace App\Filters;

use App\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class LabFilter extends AbstractFilter
{
    protected $filters = [
       // 'patientName' => PatientFilter::class
    	'compName' => CompFilter::class
    ];
}