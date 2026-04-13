<?php

namespace App\Models;

use App\IdeaStatus;
use ArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Idea extends Model
{
    /** @use HasFactory<\Database\Factories\IdeaFactory> */
    use HasFactory;
   
    protected $casts =[
        "links" => ArrayObject::class,
        "status" => IdeaStatus::class,
    ];


    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }


    public function steps(): HasMany {
        return $this->hasMany(Step::class);
    }
}
