<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'filename'
    ];

    protected $appends = [
        'preview_link',
    ];

    public function article()
    {
        return $this->hasOne(Article::class, 'image');
    }

    public function getPreviewLinkAttribute()
    {
        URL::forceRootUrl(config('app.url'));
        return $this->filename ? url("/preview_image/" . $this->filename) : null;
    }
}
