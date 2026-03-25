<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_name',
        'product_image',
        'brand',
        'explanation',
        'price',
        'category',
        'condition',
        'is_sold',
    ];

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function isLikedByAuthUser()
    {
        if (!Auth::check()) {
            return false;
        }

        return $this->likes()
            ->where('user_id', Auth::id())
            ->exists();
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public const CONDITIONS = [
        1 => '良好',
        2 => '目立った傷や汚れなし',
        3 => 'やや傷や汚れあり',
        4 => '状態が悪い',
    ];

    public function getConditionLabelAttribute()
    {
        return self::CONDITIONS[$this->condition] ?? '不明';
    }

    public function purchase()
    {
    return $this->hasOne(Purchase::class);
    }

    public function messages()
    {
    return $this->hasMany(Message::class);
    }

    public function user()
    {
    return $this->belongsTo(User::class);
    }
}

