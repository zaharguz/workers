<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'full_name',
        'job',
        'hire_date',
        'salary',
        'photo',
        'chief_id',
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
