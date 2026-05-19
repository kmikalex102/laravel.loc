<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitedSite extends Model
{
    protected $fillable = ['domain'];
    public function visits()
    {
        return $this->hasMany(Visit::class);
    }
}
