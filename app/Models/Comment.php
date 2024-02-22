<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = ['text', 'author', 'story_id', 'comment_id'];

    public function story()
    {
        return $this->belongsTo(Story::class);
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}
