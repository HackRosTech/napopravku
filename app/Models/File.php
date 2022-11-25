<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class File extends Model
{
    use HasFactory;

    protected $guarded = true;

    protected $fillable = [
        'id',
        'name',
        'file_name',
        'mime_type',
        'path',
        'disk',
        'file_hash',
        'collection',
        'size',
        'user_id',
        'directory_id',
        'file_retention_period_at',
    ];

    public function directory(): BelongsTo
    {
        return $this->belongsTo(Directory::class, 'directory_id', 'id');
    }

    public function links(): HasOne
    {
        return $this->hasOne(FileLink::class);
    }

    public function scopeSumSizeInDirectory(int $id): Model|Builder
    {
        return $this
            ->select( DB::raw('SUM(size) as size'))
            ->where('directory_id', $id)
            ->where('user_id', Auth::id())
            ->groupBy('size')
            ->firstOrFail();
    }

    public function scopeSumSizeOnDisk(): Model|Builder
    {
        return $this
            ->select( DB::raw('SUM(size) as size'))
            ->where('user_id', Auth::id())
            ->groupBy('size')
            ->firstOrFail();
    }
}
