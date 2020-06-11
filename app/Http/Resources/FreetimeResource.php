<?php declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FreetimeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'freetime' => $this->id,
            'teacher_id' => $this->teacher->id,
            'teacher_name' => $this->teacher->user->fullName,
            'event_id' => $this->event->id,
            'date_from' => $this->event->date_from,
            'date_to' => $this->event->date_to,
            'type' => $this->event->type,
        ];
    }
}
