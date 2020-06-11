<?php /** @noinspection PhpDocSignatureInspection */
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enum\Role;
use App\Http\Requests\StudentCreateRequest;
use App\Http\Requests\StudentUpdateRequest;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $result = Student::with('user')->get();

        return StudentResource::collection($result);
    }

    public function store(StudentCreateRequest $request): JsonResource
    {
        $data = $request->validated();
        $data['role'] = Role::STUDENT;
        $data['password'] = Hash::make($data['password']);
        $user = new User($data);
        $user->save();
        $student = new Student($data);
        $user->student()->save($student);

        return new StudentResource($student);
    }

    public function show(int $id): JsonResource
    {
        $student = Student::findOrFail($id);

        return new StudentResource($student);
    }

    public function update(StudentUpdateRequest $request, int $id): JsonResource
    {
        $student = Student::findOrFail($id);
        $data = $request->validated();

        if (array_key_exists('password', $data)) {
            $data['password'] = Hash::make($data['password']);
        }

        $user = $student->user()->first();
        $user->fill($data);
        $student->fill($data);
        $user->save();
        $student->save();

        return new StudentResource($student);
    }

    public function destroy(int $id): bool
    {
        $student = Student::findOrFail($id);

        return $student->delete();
    }
}
