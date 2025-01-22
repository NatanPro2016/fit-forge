<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Tranner;
use App\Models\Workout;
use App\Models\Workout_plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use App\Tragets;

class TrannerController extends Controller
{
    //auth related 
    public function login()
    {
        return view("/tranner/tranner-login");
    }

    public function loginPost(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('tanner')->attempt($credentials)) {
            return redirect()->intended('/trainer/dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);

    }

    public function logout()
    {
        Auth::guard('tanner')->logout();
        return redirect()->intended('/trainer/login');
    }
    // auth end 
    public function dashboard()
    {
        $user = Auth::guard('tanner')->user();
        return view("tranner/tranner-dashboard", compact("user"));
    }

    // workout related

    public function createWorkoutView()
    {
        return view("tranner.tranner-create-workout");
    }
    public function createWorkout(Request $request)
    {
        $fields = $request->validate([
            'title' => ['required', 'string', 'min:3', 'max:30'],
            'target' => ['required', new Enum(Tragets::class)],


            'image' => [
                'required',
                'mimes:jpeg,png,jpg,gif,svg',
                'max:2048',
            ],
            'video' => [
                'required',
                'url',
                function ($attribute, $value, $fail) {
                    $pattern = '/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)\/(watch\?v=|embed\/|v\/|)([A-Za-z0-9_-]{11})(.*)?$/';
                    if (!preg_match($pattern, $value, $matches)) {
                        $fail('The video URL must be a valid YouTube URL.');
                    }
                },
            ],
            'description' => ['required', 'min:5'],
        ]);

        $fields['title'] = strip_tags($fields['title']);
        $fields['type'] = strip_tags($fields['target']);
        $fields['video'] = strip_tags($fields['video']);
        $fields['description'] = strip_tags($fields['description']);
        $fields['image'] = $request->file('image')->store('images', 'public');
        $fields['tranner_id'] = Auth::guard('tanner')->user()->id;
        Workout::create($fields);
        return back()->with('success', 'created successfully');
    }

    //workout plan related 

    public function createPlanView()
    {
        return view('tranner/tranner-create-plan');
    }
    public function createPlan(Request $request)
    {
        // Validate the incoming request data
        $fields = $request->validate([
            'title' => 'required|string|min:3|max:255',
            'description' => 'required|string|min:5',
            'duration' => 'required|integer',
            'type' => 'required|string',
            'count' => 'required|integer',
        ]);

        // Sanitize inputs (optional)
        $fields['title'] = strip_tags($fields['title']);
        $fields['description'] = strip_tags($fields['description']);
        $fields['type'] = strip_tags($fields['type']);
        $fields['tranner_id'] = Auth::guard('tanner')->user()->id;



        // Save data to the database
        Plan::create($fields);

        // Redirect or return success message
        return back()->with('success', 'Plan created successfully');


    }
    public function createWorkoutPlan(Request $request)
    {
        $fields = $request->validate([
            'duration' => ['required', 'integer'],
            'incrimination' => ['required', 'integer'],
            'mon' => ['nullable'],
            'tues' => ['nullable'],
            'wed' => ['nullable'],
            'thurs' => ['nullable'],
            'fri' => ['nullable'],
            'sat' => ['nullable'],
            'sun' => ['nullable'],
            'plan_id' => ['required', 'integer'],
            'workout_id' => ['required', 'integer'],
        ]);

        // Sanitizing inputs
        $fields['duration'] = strip_tags($fields['duration']);
        $fields['incrimination'] = strip_tags($fields['incrimination']);
        $fields['plan_id'] = strip_tags($fields['plan_id']);
        $fields['workout_id'] = strip_tags($fields['workout_id']);

        // For checkboxes, check if they're set. If not, set them to false.
        $fields['mon'] = $request->has('mon') ? true : false;
        $fields['tues'] = $request->has('tues') ? true : false;
        $fields['wed'] = $request->has('wed') ? true : false;
        $fields['thurs'] = $request->has('thurs') ? true : false;
        $fields['fri'] = $request->has('fri') ? true : false;
        $fields['sat'] = $request->has('sat') ? true : false;
        $fields['sun'] = $request->has('sun') ? true : false;

        // Now you can create or update your model with the sanitized data



        Workout_plan::create($fields);

        return redirect()->intended('/trainer/create-plan')->with('success', 'Plan created successfully');

    }

    public function getPlans(Request $request)
    {
        $query = Plan::query();

        // Apply search
        if ($search = $request->query('search')) {
            $query->where('name', 'like', "%$search%");
        }

        // Apply filters (e.g., category)
        if ($category = $request->query('category')) {
            $query->where('category', $category);
        }

        $data = $query->paginate(2);

        return response()->json([
            'data' => $data->items(),
            'current_page' => $data->currentPage(),
            'last_page' => $data->lastPage(),
            'total' => $data->total(),
            'per_page' => $data->perPage(),
        ]);
    }
    public function getWorkouts(Request $request)
    {
        $query = Workout::query();

        // Apply search
        if ($search = $request->query('search')) {
            $query->where('name', 'like', "%$search%");
        }

        // Apply filters (e.g., category)
        if ($category = $request->query('category')) {
            $query->where('category', $category);
        }

        $data = $query->paginate(2);

        return response()->json([
            'data' => $data->items(),
            'current_page' => $data->currentPage(),
            'last_page' => $data->lastPage(),
            'total' => $data->total(),
            'per_page' => $data->perPage(),
        ]);
    }

    public function workouts(Request $request)
    {
        if ($id = $request->query('id')) {
            $data = Workout::where('id', $id)->first();

            return view('tranner/tranner-workouts', compact('data'));

        }
        return view('tranner/tranner-workouts');
    }

    public function saveWorkout(Request $request)
    {
        $fields = $request->validate(['workout_id' => ['requierd', 'integer']]);
        $data['workout_id'] = strip_tags($fields['workout_id']);
        $data['tranner_id'] = Auth::guard('tanner')->user()->id;
        return back()->with('success', 'saved');

    }


}
