<?php


namespace App\Rules;


use DateTime;

class DateFromNoEarlierToday implements RuleForService
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
        if ($this->dateFrom->getTimestamp() < time()) {
            $this->errorMessage = "The date from must be a date after today.";
            return false;
        }

        return true;
    }

    public function getErrorMessage()
    {
        return $this->errorMessage;
    }
}
