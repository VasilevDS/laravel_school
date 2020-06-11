<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class CheckLessonDatesToCreate implements Rule
{
    private $idFreetime;
    private $date_from;
    private $error = 'The validation error';

    /**
     * Create a new rule instance.
     *
     * @param int|null $idFreetime
     * @param $date_from
     */
    public function __construct($idFreetime, $date_from)
    {
        $this->idFreetime = $idFreetime;
        $this->date_from = $date_from;
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
        $data = DB::select(
            '
             select e.date_from, e.date_to, e.type
             from events e
             join freetime f on f.event_id = e.id and f.id = :idFreetime
             where e.date_from <= :date_to and e.date_to >= :date_from

             union all

             select e.date_from, e.date_to, e.type
             from events e
             join lessons l on l.event_id = e.id and l.freetime_id = :idFreetime
             where e.date_from <= :date_to and e.date_to >= :date_from
            '
            , ['idFreetime' => $this->idFreetime, 'date_to' => $value, 'date_from' => $this->date_from]
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
