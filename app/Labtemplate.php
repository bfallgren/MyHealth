<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Labtemplate extends Model
{
    protected $fillable = [
        'patientID','tmplName', 'testDate', 'component', 'measuredValue', 'goodRange', 'comments', 
    ];
}
