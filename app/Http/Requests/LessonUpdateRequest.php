<?php declare(strict_types=1);

namespace App\Http\Requests;

use App\Rules\CheckLessonDatesToUpdate;
use App\Rules\TeacherThemeCheck;
use DateTime;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

/**
 * @property DateTime date_from
 * @property DateTime date_to
 * @property int freetime_id
 *
 */
class LessonUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $lesson_id = (int)(substr(strrchr($this->path(), '/'), 1));
        return [
            'freetime_id' => ['exists:freetime,id'],
            'student_id' => ['exists:students,id'],
            'theme_id' => ['exists:themes,id', new TeacherThemeCheck($this->get('freetime_id'), $lesson_id)],
            'date_from' => ['required_with:date_to', 'date', 'before:date_to'],
            'date_to' => [
                'required_with:date_from',
                'date',
                'after:date_from',
                new CheckLessonDatesToUpdate($lesson_id, $this->get('date_from')),
            ],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            if ($this->freetime_id) {
                if (!$this->date_from || !$this->date_to)
                    $validator->errors()->add('freetime_id', 'lesson time is not indicated.');
            }
        });
    }
}
