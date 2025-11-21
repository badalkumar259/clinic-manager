<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['user_id','category_id','subcategory_id','name','price','quantity','status'];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }
    public function scopeForUser($query, $user)
    {
        return isAdmin() ? $query : $query->where('user_id', $user->id);
    }
}
