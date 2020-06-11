<?php declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'student_id' => $this->id,
            'full_name' => $this->user->fullName,
            'student_phone' => $this->phone,
            'email' => $this->user->email,
        ];
    }
}
