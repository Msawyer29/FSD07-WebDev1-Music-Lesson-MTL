<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lesson extends Model
{
    use HasFactory;

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
    return $this->startDateTime->copy()->addHour();
    }
}