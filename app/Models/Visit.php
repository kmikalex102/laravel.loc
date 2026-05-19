<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Visit extends Model
{
    protected $fillable = ['ip', 'city', 'country', 'device', 'url'];

    public function visitedSite()
    {
        return $this->belongsTo(VisitedSite::class);
    }
}
