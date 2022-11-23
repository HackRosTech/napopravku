<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;

class CheckPhpType implements InvokableRule
{
    /**
     * Проверка на php тип
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        if ($value->getClientMimeType() == 'application/x-httpd-php') {
            $fail('The ' . $attribute . ' is invalid.');
        }
    }
}
