<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbTestData extends Model
{
    protected $table = 'ab_testdata';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'ab_testname',
    ];
}
