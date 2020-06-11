<?php /** @noinspection PhpDocSignatureInspection */
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\LessonCreateRequest;
use App\Http\Requests\LessonUpdateRequest;
use App\Http\Resources\LessonResource;
use App\Models\Event;
use App\Models\Freetime;
use App\Models\Lesson;
use Illuminate\Http\Resources\Json\JsonResource;

class LessonController extends Controller
{
    public function index(): array
    {
        $lesson = Lesson::with('teacher.user', 'student.user', 'event', 'theme')->get();

        return LessonResource::collection($lesson)->toArray(request());
    }

    public function store(LessonCreateRequest $request): JsonResource
    {
        $data = $request->validated();
        /** @var Freetime $freetime */
        $freetime = Freetime::findOrFail($data['freetime_id']);
        $event = new Event([
            'date_from' => $data['date_from'],
            'date_to' => $data['date_to'],
            'type' => 'lesson',
        ]);
        $event->save();

        $lesson = new Lesson([
            'teacher_id' => $freetime->teacher_id,
            'student_id' => $data['student_id'],
            'theme_id' => $data['theme_id'],
            'freetime_id' => $data['freetime_id'],
            'event_id' => $event->id,
        ]);
        $lesson->save();

        return new LessonResource($lesson);
    }

    public function show(int $id): JsonResource
    {
        $lesson = Lesson::findOrFail($id);

        return new LessonResource($lesson);
    }

    public function update(LessonUpdateRequest $request, int $id): JsonResource
    {
        $lesson = Lesson::findOrFail($id);
        $data = $request->validated();

        if (array_key_exists('freetime_id', $data)) {
            $freetime = Freetime::findOrFail($data['freetime_id']);
            $data['teacher_id'] = $freetime->teacher_id;
        }
        $lesson->fill($data);
        $lesson->event->fill($data);
        $lesson->save();
        $lesson->event->save();

        return new LessonResource($lesson);
    }

    public function destroy(int $id): bool
    {
        $lesson = Lesson::findOrFail($id);
        if ($lesson->delete() && $lesson->event->delete()) {
            return true;
        }
        return false;
    }
}
