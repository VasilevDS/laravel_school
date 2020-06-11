<?php


namespace App\Rules;


use DateTime;
use Illuminate\Support\Facades\DB;

class RuleForCreateIntersectsLeeWithOtherFreetime implements RuleForService
{
    private int $teacherId;
    private DateTime $dateFrom;
    private DateTime $dateTo;
    private string $errorMessage;

    public function __construct(int $teacher_id, DateTime $date_from, DateTime $date_to)
    {
        $this->teacherId = $teacher_id;
        $this->dateFrom = $date_from;
        $this->dateTo = $date_to;
    }


    public function passes()
    {
        $crossing_dates = DB::table('events')
            ->join('freetime', function ($join) {
                $join->on('freetime.event_id', '=', 'events.id')->where('freetime.teacher_id', '=', $this->teacherId);
            })
            ->where([['events.date_from', '<=', $this->dateTo], ['events.date_to', '>=', $this->dateFrom]])
            ->select('events.date_from', 'events.date_to')
            ->get();
        if ($crossing_dates->isNotEmpty()) {
            $this->errorMessage = "Intersects with time: {$crossing_dates[0]->date_from} - {$crossing_dates[0]->date_to}.";
            return false;
        }

        return true;
    }

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }
}
