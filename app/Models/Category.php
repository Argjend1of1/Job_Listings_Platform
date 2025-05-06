<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function employer() {
        return $this->hasMany(Employer::class);
    }

    public function job()
    {
        return $this->hasMany(Job::class);
    }
}
