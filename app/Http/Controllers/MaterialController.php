<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\DecidesRequests;
use App\Http\Controllers\Concerns\StoresAttachments;
use App\Mail\MaterialStatusNotification;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;

class MaterialController extends Controller
{
    use DecidesRequests;
    use StoresAttachments;

    private const LIMIT = 10;
    private const PUBLIC_PATH = 'public/documents';

    /**
     * Display a listing of the materials.
     *
     * @return View|Application|Factory
     */
    public function index(): View|Application|Factory
    {
        $materials = Material::with('user')->paginate(self::LIMIT);
        return view('admin.material_management.index', compact('materials'));
    }

    /**
     * Display the specified material.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function show(int $id): Application|View|Factory
    {
        $material = Material::findOrFail($id);
        return view('admin.material_management.show', compact('material'));
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function accept($id): RedirectResponse
    {
        $material = Material::findOrFail($id);

        return $this->decide($material, self::ACCEPTED, MaterialStatusNotification::class, 'material-management.index', __('Equipment request') . ' "' . $material->title . '"');
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function reject($id): RedirectResponse
    {
        $material = Material::findOrFail($id);

        return $this->decide($material, self::REJECTED, MaterialStatusNotification::class, 'material-management.index', __('Equipment request') . ' "' . $material->title . '"');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string',
            'specification' => 'required|string',
            'attached_file' => 'nullable|file|mimes:' . self::ATTACHMENT_MIMES . '|max:2048',
        ]);

        $attachedFile = null;

        if ($request->hasFile('attached_file')) {
            $attachedFile = $this->storeAttachment($request->file('attached_file'));
        }

        $material = Material::create([
            'title' => $request->title,
            'specification' => $request->specification,
            'attached_file' => $attachedFile,
            'user_id' => auth()->id(),
        ]);
        return redirect()->route('dashboard')->with('success', 'Material Request created successfully.');
    }


    /**
     * @return View|Application|Factory
     */
    public function create(): View|Application|Factory
    {
        return view('collaborator.material_request.create');
    }

    /**
     * Remove the specified material from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $material = Material::findOrFail($id);
        if ($material->attached_file) {
            Storage::delete(self::PUBLIC_PATH . '/' . $material->attached_file);
        }
        $material->delete();
        return redirect()
            ->route('material-management.index')
            ->with('success', $material->title . ' deleted successfully.');
    }
}
