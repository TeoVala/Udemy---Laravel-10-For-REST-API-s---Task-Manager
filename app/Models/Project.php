<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
    ];

    public function tasks()
    {

        return $this->hasMany(Task::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function members()
    {
        return $this->belongsToMany(User::class, Member::class);
    }

    protected static function booted()
    {
        static::addGlobalScope('member', function (Builder $builder) {
            $builder->whereRelation('members', 'user_id', Auth::id());
        });
    }

    public function comments() {

        return $this->morphMany(Comment::class, 'commentable');
    }
}
