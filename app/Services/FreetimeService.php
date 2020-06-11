<?php


namespace App\Services;


use App\DTO\FreetimeCreateDTO;
use App\DTO\FreetimeUpdateDTO;
use App\Enum\Type;
use App\Models\Event;
use App\Models\Freetime;
use App\Rules\DateFromNoEarlierToday;
use App\Rules\DateFromNoLaterThanDateTo;
use App\Rules\RuleForCreateIntersectsLeeWithOtherFreetime;
use App\Rules\RuleForUpdateIntersectsLeeWithOtherFreetime;

class FreetimeService
{
    private ValidatorService $validator;

    public function __construct(ValidatorService $validator)
    {
        $this->validator = $validator;
    }

    public function create(FreetimeCreateDTO $DTO): ?Freetime
    {
        $this->validator->rules(
            new DateFromNoLaterThanDateTo($DTO->getDateFrom(), $DTO->getDateTo()),
            new DateFromNoEarlierToday($DTO->getDateFrom(), $DTO->getDateTo()),
            new RuleForCreateIntersectsLeeWithOtherFreetime($DTO->getTeacherId(), $DTO->getDateFrom(), $DTO->getDateTo()),
        );

        $this->validator->validate();

        $event = new Event([
            'date_from' => $DTO->getDateFrom(),
            'date_to' => $DTO->getDateTo(),
            'type' => Type::FREETIME,
        ]);
        $event->save();

        $freetime = new Freetime([
            'teacher_id' => $DTO->getTeacherId(),
            'event_id' => $event->id,
        ]);
        $freetime->save();

        return $freetime;
    }

    public function update(FreetimeUpdateDTO $DTO): ?Freetime
    {
        $this->validator->rules(
            new DateFromNoLaterThanDateTo($DTO->getDateFrom(), $DTO->getDateTo()),
            new DateFromNoEarlierToday($DTO->getDateFrom(), $DTO->getDateTo()),
            new RuleForUpdateIntersectsLeeWithOtherFreetime($DTO->getFreetimeId(), $DTO->getDateFrom(), $DTO->getDateTo()),
        );

        $this->validator->validate();
        /** @var Freetime $freetime */
        $freetime = Freetime::findOrFail($DTO->getFreetimeId());
        $freetime->event->update($DTO->getDateRange());

        return $freetime;
    }
}
