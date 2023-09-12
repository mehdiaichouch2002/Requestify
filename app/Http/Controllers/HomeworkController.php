<?php

namespace App\Http\Controllers;

use App\Mail\HomeworkStatusNotification;
use App\Models\Homework;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application as FoundationApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class HomeworkController extends Controller
{
    public function index()
    {
        $data = Homework::all();
        return view('admin.home_office.index', ['data' => $data]);
    }
    public function create()
    {
        // Display the registration form
        return view('collaborator.homework.create');
    }
  //validate data:
  public function store(Request $request)
  {
    // Validation passed, proceed with your logic
    if($request->has('is_lifetime')){
       $value=true;
    }
    else{
        $value=false;
    }
    if ($request->has('is_lifetime')) {
      $rules = [
          'description' => ['required'],
          'is_lifetime' => ['required'],
      ];
    }else{
          $rules['description'] = ['required'];
          $rules['from_date'] = ['required', 'date'];
          $rules['to_date'] = ['required', 'date', 'after:from_date'];
      }

      $validator = Validator::make($request->all(), $rules);

      if ($validator->fails()) {
          return redirect()->back()->withErrors($validator)->withInput();
      }


//create and save date :
        $entity = Homework::create([
            'description' => $request->input('description'),
            'from_date' => $request->input('from_date'),
            'to_date' => $request->input('to_date'),
            'user_id' => auth()->user()->id,
            'is_lifetime'=>$value,

        ]);

//return message success:
            return redirect()->route('dashboard')->with('success', 'Les données ont été enregistrées avec succès.');
    }
    public function update(Request $request, $id)
    {
        $role = $request->input('role');
        $user = Homework::findOrFail($id);
        $user->role = $role;
        $user->save();

        return redirect()->back()->with('success','Role updated to ' . $role);
    }
    public function destroy($id)
    {
        $homework=Homework::findOrFail($id);
        $homework->delete();
        return redirect()->route('homework-management.index')->with('success', $homework->firstname . ' ' . $homework->lastname . ' deleted successfully.');
    }
    public function show($id)
    {
        $homework=Homework::findOrFail($id);

        return view('admin.home_office.show',compact('homework'));
    }
        /**
     * @param $id
     * @return RedirectResponse
     */
    public function accept($id): RedirectResponse
    {
        $homework = Homework::findOrFail($id);
        $homework->status = 1;
        $homework->save();

        // Send notification email
        Mail::to($homework->user->email)->send(new HomeworkStatusNotification($homework, 1));

        return redirect()->route('homework-management.index')->with('success', 'Homework ' . $homework->title . ' ' . ($homework->status === 1 ? 'accepted' : 'rejected') . ' successfully');
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function reject($id): RedirectResponse
    {
        $homework = Homework::findOrFail($id);
        $homework->status = 2;
        $homework->save();

        // Send notification email
        Mail::to($homework->user->email)->send(new HomeworkStatusNotification($homework, 2));

        return redirect()->route('homework-management.index')->with('success', 'Homework ' . $homework->title . ' ' . ($homework->status === 1 ? 'accepted' : 'rejected') . ' successfully');
    }
    }

