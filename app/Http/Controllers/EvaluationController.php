<?php

namespace App\Http\Controllers;

use App\Mail\EvaluationStatusNotification;
use App\Models\Evaluation;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EvaluationController extends Controller
{
    private const LIMIT = 10;

    /**
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $evaluations = Evaluation::paginate(self::LIMIT);
        return view('admin.evaluation_management.index', compact('evaluations'));
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application
     */
    public function show(int $id)
    {
        $evaluation = Evaluation::findOrFail($id);
        return view('admin.evaluation_management.show', compact('evaluation'));
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function accept($id): RedirectResponse
    {
        $evaluation = Evaluation::findOrFail($id);
        $evaluation->status = 1;
        $evaluation->save();

        // Send notification email
        Mail::to($evaluation->user->email)->send(new EvaluationStatusNotification($evaluation, 1));

        return redirect()->route('evaluation-management.index')->with('success', 'Evaluation ' . $evaluation->title . ' ' . ($evaluation->status === 1 ? 'accepted' : 'rejected') . ' successfully');
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function reject($id): RedirectResponse
    {
        $evaluation = Evaluation::findOrFail($id);
        $evaluation->status = 2;
        $evaluation->save();

        // Send notification email
        Mail::to($evaluation->user->email)->send(new EvaluationStatusNotification($evaluation, 2));

        return redirect()->route('evaluation-management.index')->with('success', 'Evaluation ' . $evaluation->title . ' ' . ($evaluation->status === 1 ? 'accepted' : 'rejected') . ' successfully');
    }

    /**
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('collaborator.evaluation_request.create');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'day' => 'required|date|after_or_equal:today',
        ]);

        $evaluation = Evaluation::create([
            'title' => $request->title,
            'description' => $request->description,
            'day' => $request->day,
            'time' => $request->time,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Evaluation Request '. $request->title . ' created successfully.');
    }
    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $evaluation = Evaluation::findOrFail($id);
        $evaluation->delete();
        return redirect()->route('evaluation-management.index')->with('success', $evaluation->title . ' deleted successfully.');
    }

}
