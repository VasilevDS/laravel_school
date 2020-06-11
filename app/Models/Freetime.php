<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static findOrFail(int $id)
 * @property Event event
 */
class Freetime extends Model
{
    protected $table = 'freetime';

    protected $fillable = [
        'teacher_id',
        'event_id',
    ];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
