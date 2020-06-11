<?php


namespace App\Rules;


interface RuleForService
{
    public function passes();

    public function getErrorMessage();
}
