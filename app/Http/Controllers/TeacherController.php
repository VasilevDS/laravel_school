<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enum\Role;
use App\Http\Requests\TeacherCreateRequest;
use App\Http\Requests\TeacherUpdateRequest;
use App\Http\Resources\TeacherResource;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        /** @var Teacher $teacher */
        $teacher = Teacher::with('user')->get();

        return TeacherResource::collection($teacher);
    }

    public function store(TeacherCreateRequest $request): JsonResource
    {
        $data = $request->validated();
        $data['role'] = Role::TEACHER;
        $data['password'] = Hash::make($data['password']);
        $user = new User($data);
        $user->save();
        $teacher = new Teacher($data);
        $user->teacher()->save($teacher);
        if (array_key_exists('theme_ids', $data)) {
            $teacher->themes()->attach($data['theme_ids']);
        }

        return new TeacherResource($teacher);
    }

    public function show(int $id): JsonResource
    {
        /** @var Teacher $teacher */
        $teacher = Teacher::findOrFail($id);

        return new TeacherResource($teacher);
    }

    public function update(TeacherUpdateRequest $request, int $id): JsonResource
    {
        /** @var Teacher $teacher */
        $teacher = Teacher::find($id);
        $data = $request->validated();
        if (array_key_exists('theme_ids', $data)) {
            $teacher->themes()->sync($data['theme_ids']);
        }
        if (array_key_exists('password', $data)) {
            $data['password'] = Hash::make($data['password']);
        }
        $user = $teacher->user()->first();
        $user->fill($data);
        $teacher->fill($data);
        $user->save();
        $teacher->save();

        return new TeacherResource($teacher);
    }

    public function destroy(int $id): bool
    {
        /** @var Teacher $teacher */
        $teacher = Teacher::findOrFail($id);

        /** @noinspection PhpUnhandledExceptionInspection */
        return $teacher->delete();
    }
}
