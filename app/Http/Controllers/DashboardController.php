<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Evaluation;
use App\Models\Homework;
use App\Models\Material;
use App\Models\Vacation;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class DashboardController extends Controller
{
    /**
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $user = auth()->user();

        if ($user->isAdmin() || $user->isSuperAdmin()) {
            $documentPendings = Document::where('status', 0)->get();
            $homeworkPendings = Homework::where('status', 0)->get();
            $vacationPendings = Vacation::where('status', 0)->get();
            $materialPendings = Material::where('status', 0)->get();
            $evaluationPendings = Evaluation::where('status', 0)->get();
            return view('admin.dashboard', compact('documentPendings', 'homeworkPendings', 'vacationPendings', 'materialPendings', 'evaluationPendings'));
        } else {
            $oneWeekAgo = Carbon::now()->subWeek();

            $documentPendings = Document::where('user_id', $user->id)
                ->where(function ($query) use ($oneWeekAgo) {
                    $query->where('status', 0)
                        ->orWhere('updated_at', '<=', $oneWeekAgo);
                })
                ->get();

            $homeworkPendings = Homework::where('user_id', $user->id)
                ->where(function ($query) use ($oneWeekAgo) {
                    $query->where('status', 0)
                        ->orWhere('updated_at', '<=', $oneWeekAgo);
                })
                ->get();

            $vacationPendings = Vacation::where('user_id', $user->id)
                ->where(function ($query) use ($oneWeekAgo) {
                    $query->where('status', 0)
                        ->orWhere('updated_at', '<=', $oneWeekAgo);
                })
                ->get();

            $materialPendings = Material::where('user_id', $user->id)
                ->where(function ($query) use ($oneWeekAgo) {
                    $query->where('status', 0)
                        ->orWhere('updated_at', '<=', $oneWeekAgo);
                })
                ->get();

            $evaluationPendings = Evaluation::where('user_id', $user->id)
                ->where(function ($query) use ($oneWeekAgo) {
                    $query->where('status', 0)
                        ->orWhere('updated_at', '<=', $oneWeekAgo);
                })
                ->get();

            return view('collaborator.dashboard', compact('documentPendings', 'homeworkPendings', 'vacationPendings', 'materialPendings', 'evaluationPendings'));
        }
    }

    /**
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function history(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        if (auth()->user()->role === 'collaborator') {
            $documentPendings = Document::where('user_id', auth()->id())->get();
            $homeworkPendings = Homework::where('user_id', auth()->id())->get();
            $vacationPendings = Vacation::where('user_id', auth()->id())->get();
            $materialPendings = Material::where('user_id', auth()->id())->get();
            $evaluationPendings = Evaluation::where('user_id', auth()->id())->get();

            return view('collaborator.history', compact('documentPendings', 'homeworkPendings', 'vacationPendings', 'materialPendings', 'evaluationPendings'));
        } else {
            $documentPendings = Document::all();
            $homeworkPendings = Homework::all();
            $vacationPendings = Vacation::all();
            $materialPendings = Material::all();
            $evaluationPendings = Evaluation::all();

            return view('admin.history', compact('documentPendings', 'homeworkPendings', 'vacationPendings', 'materialPendings', 'evaluationPendings'));
        }
    }
}
