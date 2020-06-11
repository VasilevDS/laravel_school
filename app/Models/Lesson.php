<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static findOrFail(int $id)
 */
class Lesson extends Model
{
    protected $fillable = [
        'teacher_id',
        'student_id',
        'theme_id',
        'event_id',
        'freetime_id',
    ];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function theme(): BelongsTo
    {
        return $this->belongsTo(Theme::class);
    }


    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
