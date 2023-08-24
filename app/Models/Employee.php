<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Employee extends Model
{
    use HasFactory;
    use HasUuids;

    protected $guarded = [];

    public function user(): MorphOne
    {
        return $this->morphOne(User::class, __FUNCTION__, 'type', 'employee_id');
    }
}
