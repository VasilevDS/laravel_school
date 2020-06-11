<?php declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeacherUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'phone' => 'integer|digits:10',
            'first_name' => 'string|max:255',
            'last_name' => 'string|max:255',
            'theme_ids' => 'array',
            'theme_ids.*' => 'integer|exists:themes,id',
            'email' => 'email',
            'password' => 'min:8',
        ];
    }
}
