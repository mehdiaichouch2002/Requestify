<?php

namespace App\Http\Controllers;

use App\Mail\DocumentStatusNotification;
use App\Mail\MaterialStatusNotification;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;

class MaterialController extends Controller
{
    private const LIMIT = 10;
    private const PUBLIC_PATH = 'public/documents';

    /**
     * Display a listing of the materials.
     *
     * @return View|Application|Factory
     */
    public function index(): View|Application|Factory
    {
        $materials = Material::paginate(self::LIMIT);
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
        $material->status = 1;
        $material->save();

        // Send notification email
        Mail::to($material->user->email)->send(new MaterialStatusNotification($material, 1));

        return redirect()->route('material-management.index')->with('success', 'Material ' . $material->title . ' ' . ($material->status === 1 ? 'accepted' : 'rejected') . ' successfully');
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function reject($id): RedirectResponse
    {
        $material = Material::findOrFail($id);
        $material->status = 2;
        $material->save();

        // Send notification email
        Mail::to($material->user->email)->send(new MaterialStatusNotification($material, 2));

        return redirect()->route('material-management.index')->with('success', 'Material ' . $material->title . ' ' . ($material->status === 1 ? 'accepted' : 'rejected') . ' successfully');
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
            'attached_file' => 'nullable|file|max:2048', // Assuming maximum file size is 2MB
        ]);

        $attachedFile = null;

        if ($request->hasFile('attached_file')) {
            $file = $request->file('attached_file');
            $timestamp = time();
            $extension = $file->getClientOriginalExtension();
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            // Limit the filename length to 30 characters
            $maxLength = 30;
            $filename = substr($originalName, 0, $maxLength - strlen($timestamp) - strlen($extension) - 1);
            $filename = $filename . '_' . $timestamp . '.' . $extension;
            $file->storeAs(self::PUBLIC_PATH, $filename);
            $attachedFile = $filename;
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
