<?php

namespace App\Http\Controllers;

use App\Mail\VacationStatusNotification;
use App\Models\Vacation;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class VacationController extends Controller
{
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
        // Validation passed, proceed with your logic
        if ($request->has('is_lifetime')) {
            $value = true;
        } else {
            $value = false;
        }
        $nomPhoto = null;
        if (isset($request->attached_file)) {
            // Generate a unique name for the uploaded avatar file
            $nomPhoto = time() . '.' . $request->attached_file->extension();

            $filename = null;
            if ($request->has('attached_file')) {
                $value = true;
            } else {
                $value = false;
            }
            if ($request->hasFile('attached_file')) {

                $file = $request->file('attached_file');

                $timestamp = time();
                $extension = $file->getClientOriginalExtension();
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

                // Limit the filename length to 30 characters
                $maxLength = 30;
                $filename = substr($originalName, 0, $maxLength - strlen($timestamp) - strlen($extension) - 1);
                $filename = $filename . '_' . $timestamp . '.' . $extension;
                $file->storeAs('public/documents', $filename);
            }
        }
        // Validate the request data
        $request->validate([
            'description' => 'required',
            'title' => 'required',
            'from' => 'required|date|after_or_equal:today',
            'to' => 'required|date|after_or_equal:today|after_or_equal:from',
            'paid' => 'required',
        ]);
        //create and save date :
        $entity = Vacation::create([
            'description' => $request->input('description'),
            'title' => $request->input('title'),
            'from' => $request->input('from'),
            'to' => $request->input('to'),
            'paid' => $value,
            'user_id' => auth()->user()->id,
            'attached_file' => $nomPhoto,
        ]);
        //return message success:
        return redirect()->route('dashboard')->with('success', 'Les données ont été enregistrées avec succès.');
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse

    {
        $vacation = Vacation::findOrFail($id);
        if (isset($vacation->attached_file)) {
        }
        $vacation->delete();
        return redirect()->route('vacation.index')->with('success', $vacation->firstname . ' ' . $vacation->lastname . ' deleted successfully.');
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
        $vacation->status = 1;
        $vacation->save();

        // Send notification email
        Mail::to($vacation->user->email)->send(new VacationStatusNotification($vacation, 1));

        return redirect()->route('vacation-management.index')->with('success', 'Vacation ' . $vacation->title . ' ' . ($vacation->status === 1 ? 'accepted' : 'rejected') . ' successfully');
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function reject($id): RedirectResponse
    {
        $vacation = Vacation::findOrFail($id);
        $vacation->status = 2;
        $vacation->save();

        // Send notification email
        Mail::to($vacation->user->email)->send(new VacationStatusNotification($vacation, 2));

        return redirect()->route('vacation-management.index')->with('success', 'vacation ' . $vacation->title . ' ' . ($vacation->status === 1 ? 'accepted' : 'rejected') . ' successfully');
    }
}
