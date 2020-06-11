<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\DTO\FreetimeCreateDTO;
use App\DTO\FreetimeUpdateDTO;
use App\Http\Requests\FreetimeCreateRequest;
use App\Http\Requests\FreetimeUpdateRequest;
use App\Http\Resources\FreetimeResource;
use App\Models\Freetime;
use App\Services\FreetimeService;
use App\Services\ValidatorService;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json;

class FreetimeController extends Controller
{
    private FreetimeService $freetimeService;

    public function index(): Json\AnonymousResourceCollection
    {
        $freetime = Freetime::with('teacher.user', 'event')->get();

        return FreetimeResource::collection($freetime);
    }

    public function store(FreetimeCreateRequest $request): JsonResource
    {
        $dto = FreetimeCreateDTO::fromArray($request->validated());
        $this->freetimeService = new FreetimeService(new ValidatorService());
        $freetime = $this->freetimeService->create($dto);

        return new FreetimeResource($freetime);
    }

    public function show(int $id): JsonResource
    {
        $freetime = Freetime::findOrFail($id);

        return new FreetimeResource($freetime);
    }

    public function update(FreetimeUpdateRequest $request, int $id): JsonResource
    {
        $dto = FreetimeUpdateDTO::fromArray($request->validated(), $id);
        $this->freetimeService = new FreetimeService(new ValidatorService());
        $freetime = $this->freetimeService->update($dto);

        return new FreetimeResource($freetime);
    }

    public function destroy(int $id): bool
    {
        $freetime = Freetime::findOrFail($id);
        if ($freetime->delete() && $freetime->event->delete()) {
            return true;
        }

        return false;
    }
}
