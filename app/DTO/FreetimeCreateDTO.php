<?php

declare(strict_types=1);

namespace App\DTO;


use DateTime;
use InvalidArgumentException;

class FreetimeCreateDTO
{
    private DateTime $dateFrom;
    private DateTime $dateTo;
    private int $teacherId;


    public function __construct(DateTime $date_from, DateTime $date_to, int $teacher_id)
    {
        $this->dateFrom = $date_from;
        $this->dateTo = $date_to;
        $this->teacherId = $teacher_id;
    }

    public static function fromArray(array $data): FreetimeCreateDTO
    {
        if (!isset($data['date_from'], $data['date_to'], $data['teacher_id'])) {
            throw new InvalidArgumentException('cannot create DTO from array');
        }

        return new self(new DateTime($data['date_from']), new DateTime($data['date_to']), $data['teacher_id']);
    }

    public function getDateFrom(): DateTime
    {
        return $this->dateFrom;
    }

    public function getDateTo(): DateTime
    {
        return $this->dateTo;
    }

    public function getTeacherId(): int
    {
        return $this->teacherId;
    }

}
