<?php

declare(strict_types=1);

namespace App\DTO;


use DateTime;
use InvalidArgumentException;

class FreetimeUpdateDTO
{
    private DateTime $dateFrom;
    private DateTime $dateTo;
    private int $freetimeId;


    public function __construct(DateTime $date_from, DateTime $date_to, int $id)
    {
        $this->dateFrom = $date_from;
        $this->dateTo = $date_to;
        $this->freetimeId = $id;
    }

    public static function fromArray(array $data, int $id): FreetimeUpdateDTO
    {
        if (!isset($data['date_from'], $data['date_to'])) {
            throw new InvalidArgumentException('cannot create DTO from array');
        }

        return new self(new DateTime($data['date_from']), new DateTime($data['date_to']), $id);
    }

    public function getDateFrom(): DateTime
    {
        return $this->dateFrom;
    }

    public function getDateTo(): DateTime
    {
        return $this->dateTo;
    }

    public function getFreetimeId(): int
    {
        return $this->freetimeId;
    }

    public function getDateRange(): array
    {
        return [
            $this->dateFrom,
            $this->dateTo,
        ];
    }

}
