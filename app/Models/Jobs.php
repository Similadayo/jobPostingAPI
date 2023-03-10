<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Jobs extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "title",
        "description",
        "location",
        "salary",
        "type",
        "category",
        "company",
        "category",
        "is_active"
    ];

    public function user()
    {
       return $this->belongsTo(User::class);
    }
}
