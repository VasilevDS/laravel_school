<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LessonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'lesson' => $this->id,
            'freetime_id' => $this->freetime_id,
            'teacher_id' => $this->teacher_id,
            'teacher_name' => $this->teacher->user->fullName,
            'student_id' => $this->student_id,
            'student_name' => $this->student->user->fullName,
            'theme_id' => $this->theme_id,
            'theme_name' => $this->theme->name,
            'date_from' => $this->event->date_from,
            'date_to' => $this->event->date_to,
        ];
    }
}
