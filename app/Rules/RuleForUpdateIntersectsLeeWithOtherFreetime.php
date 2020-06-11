<?php


namespace App\Rules;


use App\Models\Freetime;
use DateTime;
use Illuminate\Support\Facades\DB;

class RuleForUpdateIntersectsLeeWithOtherFreetime implements RuleForService
{
    private int $freetimeId;
    private DateTime $date_from;
    private DateTime $date_to;
    private string $error_msg;

    public function __construct(int $freetime_id, DateTime $date_from, DateTime $date_to)
    {
        $this->freetimeId = $freetime_id;
        $this->date_from = $date_from;
        $this->date_to = $date_to;
    }


    public function passes()
    {
        $teacherId = Freetime::findOrFail($this->freetimeId)->teacher_id;

        $crossing_dates = DB::table('events')
            ->join('freetime', function ($join) use ($teacherId) {
                $join->on('freetime.event_id', '=', 'events.id')
                    ->where('freetime.teacher_id', '=', $teacherId)
                    ->where('freetime.id', '!=', $this->freetimeId);
            })
            ->where([['events.date_from', '<=', $this->date_to], ['events.date_to', '>=', $this->date_from]])
            ->select('events.date_from', 'events.date_to')
            ->get();

        if ($crossing_dates->isNotEmpty()) {
            $this->error_msg = "Intersects with time:";
            foreach ($crossing_dates as $dates) {
                $this->error_msg .= "{$dates->date_from} - {$dates->date_to}; ";
            }
            return false;
        }

        return true;
    }

    public function getErrorMessage(): string
    {
        return $this->error_msg;
    }
}
