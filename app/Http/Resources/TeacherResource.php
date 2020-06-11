<?php declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TeacherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'teacher_id' => $this->id,
            'full_name' => $this->user->fullName,
            'themes' => $this->themes()->pluck('name'),
            'teacher_phone' => $this->phone,
            'email' => $this->user->email,
        ];
    }
}
