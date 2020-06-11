<?php


namespace App\Rules;


use DateTime;

class DateFromNoLaterThanDateTo implements RuleForService
{
    private DateTime $dateFrom;
    private DateTime $dateTo;
    private string $errorMessage;

    public function __construct(DateTime $date_from, DateTime $date_to)
    {
        $this->dateFrom = $date_from;
        $this->dateTo = $date_to;
    }

    public function passes()
    {
        if ($this->dateFrom >= $this->dateTo) {
            $this->errorMessage = "The date from must be a date before date to.";
            return false;
        }

        return true;
    }

    public function getErrorMessage()
    {
        return $this->errorMessage;
    }
}
