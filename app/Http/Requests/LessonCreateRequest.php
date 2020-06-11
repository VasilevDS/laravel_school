<?php declare(strict_types=1);

namespace App\Http\Requests;

use App\Rules\CheckLessonDatesToCreate;
use App\Rules\TeacherThemeCheck;
use Illuminate\Foundation\Http\FormRequest;

class LessonCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'freetime_id' => ['required', 'exists:freetime,id'],
            'student_id' => ['required', 'exists:students,id'],
            'theme_id' => ['required', 'exists:themes,id', new TeacherThemeCheck($this->get('freetime_id'))],
            'date_from' => ['required', 'date', 'before:date_to'],
            'date_to' => [
                'required',
                'date',
                new CheckLessonDatesToCreate($this->get('freetime_id'), $this->get('date_from')),
            ],
        ];
    }
}
