<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'chief_id',
        'full_name',
        'job',
        'hire_date',
        'salary',
    ];

    public function chief()
    {
        return $this->belongsTo(self::class, 'chief_id');
    }

    public function subordinates()
    {
        return $this->hasMany(self::class, 'chief_id');
    }
}
