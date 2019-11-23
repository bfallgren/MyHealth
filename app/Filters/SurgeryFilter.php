<?php

// BlogFilter.php
// required for search filter

namespace App\Filters;

use App\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class SurgeryFilter extends AbstractFilter
{
    protected $filters = [
       // 'patientName' => PatientFilter::class
    	'doctorName' => DoctorFilter::class
    ];
}