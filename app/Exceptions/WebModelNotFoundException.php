<?php declare(strict_types=1);


namespace App\Exceptions;

use Exception;
use Illuminate\Http\RedirectResponse;

class WebModelNotFoundException extends Exception
{
    private $id;

    public function __construct(int $id)
    {
        parent::__construct('Не найден id: ' . $id);
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function render(): RedirectResponse
    {
        return back()
            ->withErrors(['msg' => "Запись id=[" . $this->getId() . "] не найдена"])
            ->withInput();
    }
}
