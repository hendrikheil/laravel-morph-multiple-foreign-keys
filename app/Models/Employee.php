<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Employee extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_id';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $hidden = [
        'user_id',
    ];

    protected $guarded = [];

    public function user(): MorphOne
    {
        return $this->morphOne(User::class, __FUNCTION__, 'type', 'employee_id');
    }
}
