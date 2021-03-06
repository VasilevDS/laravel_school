<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class CheckLessonDatesToUpdate implements Rule
{
    private $idLesson;
    private $idEvent;
    private $date_from;
    private $error = 'The validation error';

    /**
     * Create a new rule instance.
     *
     * @param int $idLesson
     * @param $date_from
     */
    public function __construct(int $idLesson, $date_from)
    {
        $this->idLesson = $idLesson;
        $this->date_from = $date_from;
        $idEvent = DB::table('lessons')->select('event_id')->find($idLesson);
        $this->idEvent = $idEvent->event_id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $dataFreetime = DB::table('lessons')->select('freetime_id')->find($this->idLesson);
        $idFreetime = $dataFreetime->freetime_id;

        $data = DB::select(
            '
             select e.*
             from events e
             join freetime f on f.event_id = e.id and f.id = :idFreetime
             where e.date_from <= :date_to and e.date_to >= :date_from

             union all

             select e.*
             from events e
             join lessons l on l.event_id = e.id and l.freetime_id = :idFreetime and l.id != :idLesson
             where e.date_from <= :date_to and e.date_to >= :date_from
            '
            , ['idFreetime' => $idFreetime, 'date_to' => $value, 'date_from' => $this->date_from, 'idLesson' => $this->idLesson]
        );

        if ($data === []) {
            $this->error = 'does not overlap with the teacher’s free time';
            return false;
        }
        foreach ($data as $row) {
            if ($row->type === 'lesson') {
                $this->error = "overlap with the time of another lesson: {$row->date_from} - {$row->date_to}";
                return false;
            }
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->error;
    }
}
