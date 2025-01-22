<?php

namespace App\Http\Controllers;


use App\Models\CustomPlans;
use App\Models\Plan;
use App\Models\User_plan;
use App\Models\UserWorkout;
use App\Models\Workout;
use App\Models\Workout_plan;
use App\Models\WorkoutCustomPlan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User;
use Illuminate\Validation\Rules\Enum;
use App\Sex;

class UserController extends Controller
{
    public function registerPost(Request $request)
    {
        $filds = $request->validate([
            'name' => ['required', 'string',],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'username' => ['required', 'string', 'min:3', 'max:20', Rule::unique('users', 'username')],
            'password' => ['required', 'string', 'min:3', 'max:200'],
            'sex' => ['required', new Enum(Sex::class)],
            'age' => ['required', 'integer'],

        ]);
        $filds['password'] = bcrypt($filds['password']);
        $user = User::create($filds);
        auth()->login($user);
        return redirect('/users/dashboard');


    }
    public function register()
    {
        return view('/user/user-register');
    }
    public function login()
    {
        return view('/user/user-login');
    }

    public function loginPost(Request $request)
    {
        $fileds = $request->validate(['email' => ['required', 'email'], 'password' => ['required', 'min:6']]);

        if (auth()->attempt($fileds)) {
            return redirect()->intended('/users/dashboard');
        }
        return redirect()->intended('/users/login');

    }
    public function logout()
    {
        auth()->logout();
        return redirect()->intended('/users/login');

    }
    public function dashboard()
    {
        return view('user/user-dashboard');

    }


    //workouts


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
        // if ($saved = $request->query('saved')) {
        //     $query->where('id', );
        // }

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
            return view('tranner.tranner-workouts', compact('data'));
        }
        return view('user.user-workouts');
    }

    public function saveWorkout(Request $request)
    {
        $data['workout_id'] = (int) strip_tags($request['workout_id']);
        $data['user_id'] = auth()->id();
        $check = UserWorkout::where('user_id', '=', $data['user_id'])
            ->where('workout_id', '=', $data['workout_id']);

        if (!empty($check->get()) && $check->count() > 0) {
            $check->delete();
            return back()->with('success', 'ducument unsaved');
        }
        UserWorkout::create($data);
        return back()->with('success', 'ducument saved');
    }

    public function dicoverPlansView()
    {
        return view('user.user-discover-plans');

    }
    public function getDicoverPlans(Request $request)
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


    public function createPlanView()
    {
        return view('user.user-create-plan');
    }

    public function createPlan(Request $request)
    {
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
        $fields['user_id'] = auth()->id();


        // Save data to the database
        CustomPlans::create($fields);
        // return auth()->id();

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
            'custom_plan_id' => ['required', 'integer'],
            'workout_id' => ['required', 'integer'],
        ]);

        // Sanitizing inputs
        $fields['duration'] = (int) strip_tags($fields['duration']);
        $fields['incrimination'] = (int) strip_tags($fields['incrimination']);
        $fields['custom_plan_id'] = (int) strip_tags($fields['custom_plan_id']);
        $fields['workout_id'] = (int) strip_tags($fields['workout_id']);

        // For checkboxes, check if they're set. If not, set them to false.
        $fields['mon'] = $request->has('mon') ? true : false;
        $fields['tues'] = $request->has('tues') ? true : false;
        $fields['wed'] = $request->has('wed') ? true : false;
        $fields['thurs'] = $request->has('thurs') ? true : false;
        $fields['fri'] = $request->has('fri') ? true : false;
        $fields['sat'] = $request->has('sat') ? true : false;
        $fields['sun'] = $request->has('sun') ? true : false;

        // Now you can create or update your model with the sanitized data

        // return $fields;

        WorkoutCustomPlan::create($fields);

        return redirect()->intended('/users/create-plan')->with('success', 'Plan created successfully');

    }

    public function deletePlan(Request $request)
    {
        $data['plan_id'] = (int) strip_tags($request['plan_id']);
        $data['user_id'] = auth()->id();
        $check = CustomPlans::where('user_id', '=', $data['user_id'])
            ->where('plan_id', '=', $data['plan_id']);

        if (!empty($check->get()) && $check->count() > 0) {
            $check->delete();
            return back()->with('success', 'ducument removed');
        }
        return back()->with('error', 'there is no document with that criteria');
    }
    public function savePlan(Request $request)
    {
        $data['plan_id'] = (int) strip_tags($request['plan_id']);
        $data['user_id'] = auth()->id();
        $check = User_plan::where('user_id', '=', $data['user_id'])
            ->where('plan_id', '=', $data['plan_id']);

        if (empty($check->get()) || $check->count() == 0) {
            User_plan::create($data);
            return back()->with('success', 'success');

        }
        return back()->with('error', 'alrady added ');

    }
    public function updatePlan(Request $request)
    {
        $data['plan_id'] = (int) strip_tags($request['plan_id']);
        $data['user_id'] = auth()->id();
    
        $check = User_plan::where('user_id', '=', $data['user_id'])
            ->where('plan_id', '=', $data['plan_id']);

        if (!empty($check->get()) || $check->count() >= 0) {
            if($request['worked_dates']){
                $check->update(['worked_dates' => strip_tags($request['worked_dates'])] );
                
            }
            if($request['paued_number']){
                $check->update(['paued_number' => strip_tags($request['paued_number'])] );
                
            }

            return back()->with('success', 'success');

        }
        return back()->with('error', 'error');
    }
    public function myProgressView()
    {
        return view('user.user-my-progress');
    }
    public function myProgressApi()
    {
        $plans = Plan::join('user_plans', 'user_plans.plan_id', '=', 'plans.id')
            ->where('user_id', '=', auth()->id())
            ->paginate(2);
        return $plans;

    }


}
