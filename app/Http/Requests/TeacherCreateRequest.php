<?php declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeacherCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'phone' => 'required|integer|digits:10',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'theme_ids' => 'required|array',
            'theme_ids.*' => 'integer|exists:themes,id',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ];
    }
}
