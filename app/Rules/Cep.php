<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Cep implements ValidationRule
{
  public function validate(string $attribute, mixed $value, Closure $fail): void
  {
    $cep = preg_replace('/[^0-9]/', '', $value);

    if (strlen($cep) !== 8) {
      $fail('O CEP informado é inválido.');
      return;
    }

    if (preg_match('/^(\d)\1{7}$/', $cep)) {
      $fail('O CEP informado é inválido.');
    }
  }
}
