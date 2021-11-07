<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $primary = 'id';
    public $keyType = 'string';

    protected $fillable = [
                'title',
                'company',
                'company_logo',
                'location',
                'salary',
                'description',
                'benefits',
                'type',
                'category',
                'work_condition',
                ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
