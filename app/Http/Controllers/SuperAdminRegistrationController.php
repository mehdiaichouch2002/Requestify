<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application as FoundationApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SuperAdminRegistrationController extends Controller
{
    private const LIMIT = 10;
    private const PUBLIC_PATH = 'public/photos';

    /**
     * @param Request $request
     * @return Application|Factory|View|FoundationApplication
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        if ($search) {
            $search = $request->input('search');
            $data = User::where('firstname', 'like', '%' . $search . '%')->orWhere('lastname', 'like', '%' . $search . '%')->paginate(self::LIMIT);
        } else {
            $data = User::paginate(self::LIMIT);
        }
        return view('admin.user_management.index', compact('data'));
    }

    /**
     * @return Application|Factory|View|FoundationApplication
     */
    public function create()
    {
        // Display the registration form
        return view('admin.user_management.create');
    }

    /**
     * @param UserRequest $request
     * @return RedirectResponse
     */
    public function store(UserRequest $request)
    {
        $nomPhoto = null;
        if (isset($request->avatar)) {
            // Generate a unique name for the uploaded avatar file
            $nomPhoto = time().'.'.$request->avatar->extension();
            // Store the uploaded avatar file in the 'photos' directory
            $request->avatar->storeAs(self::PUBLIC_PATH, $nomPhoto);
        }

        // Create a new user
        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'role' => $request->role,
            'sexe'=>$request->sexe,
            'phone'=>$request->phone,
            'job_title' => $request->job_title,
            'avatar' => $nomPhoto,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        // Redirect to a success page or dashboard with a success message
        return redirect()->route('user-management.index')->with('success', $request->firstname.' '.$request->lastname.' created successfully.');
    }

    /**
     * @param Request $request
     * @param $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        $role = $request->input('role');
        $user = User::findOrFail($id);
        $user->role = $role;
        $user->save();

        return redirect()->back()->with('success','Role updated to ' . $role);
    }

    /**
     * @param $id
     * @return Application|Factory|View|FoundationApplication
     */
    public function show($id): FoundationApplication|View|Factory|Application
    {
        $user = User::findOrFail($id);
        return view('admin.user_management.show',compact('user'));

    }

    /**
     * @param int $id
     * @return RedirectResponse
     */

    public function destroy(int $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        if ($user->isSuperAdmin()) {
            abort(404);
        }

        $avatar = optional($user->avatar);
        if ($avatar) {
            Storage::delete(self::PUBLIC_PATH .'/'.$avatar);
        }

        $user->delete();

        return redirect()->route('user-management.index')->with('success', $user->firstname . ' ' . $user->lastname . ' deleted successfully.');
    }
}
