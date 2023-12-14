<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'company',
        'link',
        'image',
        'content',
        'date',
        'status',
        'writer',
        'editor',
        'slug'
    ];

    public function img()
    {
        return $this->belongsTo(Image::class, 'image');
    }

    public function scopeForedit($query)
    {
        return $query->where('status', 1);
    }
    public function scopePublished($query)
    {
        return $query->where('status', 2);
    }

    public function wrote()
    {
        return $this->belongsTo(User::class, 'writer');
    }

    public function edited()
    {
        return $this->belongsTo(User::class, 'editor');
    }

    public function statusName()
    {
        return $this->belongsTo(ArticleStatus::class, 'status');
    }
}
