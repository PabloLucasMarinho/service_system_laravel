<?php

namespace App\Http\Requests;

use App\Rules\Cpf;
use App\Rules\DateOfBirth;
use App\Rules\Phone;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class StoreClientRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true;
  }

  public function rules(): array
  {
    $id = $this->route('id');

    return [
      'name' => 'required|string|min:2|max:255',
      'document' => ['required', new Cpf, Rule::unique('clients', 'document')],
      'date_of_birth' => ['required', new DateOfBirth],
      'phone' => ['required', new Phone]
    ];
  }

  public function messages(): array
  {
    return [
      'name.required' => 'O :attribute é obrigatório.',
      'document.required' => 'O :attribute é obrigatório.',
      'document.unique' => 'Este :attribute já foi cadastrado.',
      'date_of_birth.required' => 'A :attribute é obrigatória.',
      'phone.required' => 'O :attribute é obrigatório.',
    ];
  }

  public function attributes(): array
  {
    return [
      'name' => 'nome',
      'document' => 'CPF',
      'date_of_birth' => 'data de nascimento',
      'phone' => 'telefone',
    ];
  }

  protected function prepareForValidation(): void
  {
    $dateOfBirth = $this->input('date_of_birth');

    if (!is_string($dateOfBirth)) {
      return;
    }

    try {
      if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $dateOfBirth)) {
        $this->merge([
          'date_of_birth' => Carbon::createFromFormat(
            'd/m/Y',
            $dateOfBirth
          )->format('Y-m-d'),
        ]);
      }
    } catch (\Throwable) {
      // Não faz nada → a validação vai falhar depois
    }
  }
}
