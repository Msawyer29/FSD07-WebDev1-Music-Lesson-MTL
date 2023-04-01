<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class Lesson extends Model
{
    use HasFactory;

    public $timestamps = false; // Add this line to disable timestamps 'updated_at' and 'created_at' which Laravel automatically creates

    protected $fillable = [
        'startDateTime',
        'teacherId',
        'studentId',
        'lessonType',
        'status',
        'paymentConfirmation',
    ];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacherId');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'studentId');
    }

    public function getEndDateTimeAttribute()
    {
        return Carbon::parse($this->startDateTime)->addHour();
    }
}
