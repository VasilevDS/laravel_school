<?php


namespace App\Services;


use App\Rules\RuleForService;
use Dotenv\Exception\ValidationException;

class ValidatorService
{
    private RuleForService[] $rules;

    public function rules(RuleForService ...$rules): void
    {
        $this->rules = $rules;
    }

    public function validate(): void
    {
        /** @var RuleForService $rule */
        foreach ($this->rules as $rule) {
            if (!$rule->passes()) {
                throw new ValidationException($rule->getErrorMessage());
            }
        }
    }
}
