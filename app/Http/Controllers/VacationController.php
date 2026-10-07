<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\DecidesRequests;
use App\Http\Controllers\Concerns\StoresAttachments;
use App\Mail\VacationStatusNotification;
use App\Models\Vacation;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VacationController extends Controller
{
    use DecidesRequests;
    use StoresAttachments;

    private const PUBLIC_PATH = 'public/documents';

    /**
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $data = Vacation::all();
        return view('admin.vacation.index', ['data' => $data]);
    }

    /**
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        // Display the registration form
        return view('collaborator.vacation.create');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate before touching the disk, so a rejected request leaves no orphan file
        $request->validate([
            'description' => 'required',
            'title' => 'required',
            'from' => 'required|date|after_or_equal:today',
            'to' => 'required|date|after_or_equal:today|after_or_equal:from',
            'attached_file' => 'nullable|file|mimes:' . self::ATTACHMENT_MIMES . '|max:2048',
        ]);

        $filename = $request->hasFile('attached_file') ? $this->storeAttachment($request->file('attached_file')) : null;

        Vacation::create([
            'description' => $request->input('description'),
            'title' => $request->input('title'),
            'from' => $request->input('from'),
            'to' => $request->input('to'),
            // Unchecked checkboxes are not sent at all
            'paid' => $request->boolean('paid'),
            'user_id' => auth()->id(),
            'attached_file' => $filename,
        ]);

        return redirect()->route('dashboard')->with('success', 'Les données ont été enregistrées avec succès.');
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        $vacation = Vacation::findOrFail($id);
        if ($vacation->attached_file) {
            Storage::delete(self::PUBLIC_PATH . '/' . $vacation->attached_file);
        }
        $vacation->delete();
        return redirect()->route('vacation-management.index')->with('success', $vacation->title . ' deleted successfully.');
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application
     */
    public function show($id): Application|View|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $vacation = Vacation::findOrFail($id);

        return view('admin.vacation.show', compact('vacation'));
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function accept($id): RedirectResponse
    {
        $vacation = Vacation::findOrFail($id);

        return $this->decide($vacation, self::ACCEPTED, VacationStatusNotification::class, 'vacation-management.index', __('Leave request') . ' "' . $vacation->title . '"');
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function reject($id): RedirectResponse
    {
        $vacation = Vacation::findOrFail($id);

        return $this->decide($vacation, self::REJECTED, VacationStatusNotification::class, 'vacation-management.index', __('Leave request') . ' "' . $vacation->title . '"');
    }
}
