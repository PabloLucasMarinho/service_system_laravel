<?php

namespace App\Http\Requests;

use App\Rules\Cep;
use App\Rules\Cpf;
use App\Rules\DateOfBirth;
use App\Rules\Phone;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true;
  }

  public function rules(): array
  {
    return [
      'name' => 'required|string|max:255',
      'email' => 'required|email|unique:users,email',

      'document' => ['required', new Cpf, Rule::unique('user_details', 'document')],
      'date_of_birth' => ['required', new DateOfBirth],
      'phone' => ['required', new Phone],
      'address' => 'required|string|max:100',
      'address_complement' => 'nullable|string|max:50',
      'zip_code' => ['required', new Cep],
      'neighborhood' => 'required|string|max:50',
      'city' => 'required|string|max:50',
      'salary' => 'nullable|numeric|min:0|max:99999999.99',
      'admission_date' => 'required|date|before:tomorrow',
    ];
  }

  public function messages(): array
  {
    return [
      'name.required' => 'O :attribute é obrigatório.',
      'email.required' => 'O :attribute é obrigatório.',
      'email.unique' => 'Este :attribute já está cadastrado.',
      'document.required' => 'O :attribute é obrigatório.',
      'document.unique' => 'Este :attribute já está cadastrado.',
      'date_of_birth.required' => 'A :attribute é obrigatória.',
      'phone.required' => 'O :attribute é obrigatório.',
      'address.required' => 'O :attribute é obrigatório',
      'zip_code.required' => 'O :attribute é obrigatório.',
      'admission_date.required' => 'A :attribute é obrigatória.',
    ];
  }

  public function attributes(): array
  {
    return [
      'name' => 'nome',
      'email' => 'e-mail',
      'document' => 'CPF',
      'date_of_birth' => 'data de nascimento',
      'phone' => 'telefone',
      'address' => 'endereço',
      'address_complement' => 'complemento',
      'zip_code' => 'CEP',
      'neighborhood' => 'bairro',
      'city' => 'cidade',
      'salary' => 'salário',
      'admission_date' => 'data de admissão'
    ];
  }

  protected function prepareForValidation(): void
  {
    $salary = $this->input('salary');

    if ($salary) {
      $salary_correct = str_replace('.', '', $salary);
      $salary_correct = str_replace(',', '.', $salary_correct);

      $this->merge([
        'salary' => $salary_correct
      ]);
    }

    $this->normalizeDate('date_of_birth');
    $this->normalizeDate('admission_date');
  }

  private function normalizeDate(string $field, string $format = 'd/m/Y'): void
  {
    $value = $this->input($field);

    if (!is_string($value)) {
      return;
    }

    try {
      if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $value)) {
        $this->merge([
          $field => Carbon::createFromFormat($format, $value)
            ->format('Y-m-d'),
        ]);
      }
    } catch (\Throwable) {
      // Não faz nada, a validação vai falhar depois
    }
  }
}
