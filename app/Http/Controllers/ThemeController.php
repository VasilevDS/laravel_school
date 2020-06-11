<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\WebModelNotFoundException;
use App\Http\Requests\ThemeRequest;
use App\Models\Theme;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ThemeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $paginatedThemes = Theme::paginate(10);
        return view('themes.index', compact('paginatedThemes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('themes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ThemeRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $theme = new Theme($data);
        $result = $theme->save();

        if (!$result) {
            return back()
                ->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
        }

        return redirect()
            ->route('theme.create')
            ->with(['success' => 'Успешное сохранение']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     */
    public function edit(Theme $theme): View
    {
        return view('themes.edit', compact('theme'));
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(ThemeRequest $request, int $id): RedirectResponse
    {
        try {
            $theme = Theme::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new WebModelNotFoundException($id);
        }


        $data = $request->validated();
        $result = $theme->update($data);

        if (!$result) {
            return back()
                ->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
        }

        return redirect()
            ->route('theme.edit', $theme->id)
            ->with(['success' => 'Успешное сохранение']);
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy(int $id): RedirectResponse
    {
        try {
            $theme = Theme::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new WebModelNotFoundException($id);
        }

        $result = $theme->delete();

        if (!$result) {
            return back()
                ->withErrors(['msg' => 'Ошибка удаления'])
                ->withInput();
        }

        return redirect()
            ->route('theme.index')
            ->with(['success' => "Успешное удаление записи id=[{$id}]"]);
    }
}
