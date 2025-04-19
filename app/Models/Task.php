<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', // restrict the fields that will be used
        // with mass assignment
        'is_done',
        'project_id',
    ];

    protected $casts = [
        'is_done' => 'boolean',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected static function booted()
    {
        static::addGlobalScope('member', function (Builder $builder) {
            $builder -> where('creator_id', Auth::id())
                     -> orWhereIn('project_id', Auth::user()->memberships->pluck('id'));
        });
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function comments() {

        return $this->morphMany(Comment::class, 'commentable');
    }

    public function project()
    {

        return $this->belongsTo(Project::class);
    }
}
