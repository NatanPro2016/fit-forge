<?php

namespace App\Http\Controllers;


use App\Models\CustomPlans;
use App\Models\Plan;
use App\Models\User_plan;
use App\Models\UserWorkout;
use App\Models\Workout;
use App\Models\Workout_plan;
use App\Models\WorkoutCustomPlan;
use DB;
use GrahamCampbell\ResultType\Success;
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

        $filds['name'] = strip_tags($request->input('name'));
        $filds['email'] = strip_tags($request->input('email'));
        $filds['username'] = strip_tags($request->input('username'));
        $filds['password'] = strip_tags($request->input('password'));
        $filds['age'] = strip_tags($request->input('age'));

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

        if ($workout_id = $request->query('id')) {
            $data = Workout::where('id', '=', $workout_id);
            return $data->get();

        }
        $query = Workout::query();

        // Apply search
        if ($search = $request->query('search')) {
            $query->where('title', 'like', "%$search%");
        }

        // Apply filters (e.g., category)
        if ($request->has('type') && $request->type) {
            $query->where('description', 'like', "%$search%");
        }
        if ($request->has('saved') && $request->saved) {
            $userId = auth()->id();
            $query->
                join('user_workouts', 'user_workouts.workout_id', 'workouts.id')
                ->select('workouts.*', 'user_workouts.*', 'workouts.id as id')
                ->where('user_workouts.user_id', $userId);
        }



        if (empty($query->get()) || $query->count() == 0) {
            return response()->json([
                'data' => []
            ]);
        }

        $data = $query->paginate(5);
        $userId = auth()->id();

        $data->getCollection()->transform(function ($workout) use ($userId) {
            $workout->is_aved = UserWorkout::
                where('user_id', $userId)
                ->where('workout_id', $workout->id)
                ->exists();

            return $workout;
        });
        return response()->json($data);
    }


    public function workouts(Request $request)
    {
        if ($id = $request->query('id')) {
            $user_id = auth()->id();
            $data = Workout::where('id', $id)->first();
            $data['is_saved'] = UserWorkout::
                where('user_id', '=', $user_id)
                ->where('workout_id', '=', $data->id)
                ->exists();


            return view('user.user-workouts', compact('data'));
        }
        return view('user.user-workouts');
    }


    public function saveWorkout(Request $request)
    {
        $data['workout_id'] = (int) strip_tags($request->input('workout_id'));
        $data['user_id'] = auth()->id();

        // Check if the workout already exists for the user
        $check = UserWorkout::where('user_id', $data['user_id'])
            ->where('workout_id', $data['workout_id']);

        if ($check->exists()) {
            // If the workout exists, delete it (toggle behavior)
            $check->delete();
            return response()->json([
                'message' => 'Workout removed from favorites.',
                'action' => 'removed'
            ], 200); // 200 OK status
        }

        // Otherwise, add the workout
        UserWorkout::create($data);
        return response()->json([
            'message' => 'Workout added to favorites.',
            'action' => 'added'
        ], 200); // 200 OK status
    }


    public function dicoverPlansView()
    {
        return view('user.user-discover-plans');

    }
    public function getDicoverPlans(Request $request)
    {


        if ($id = $request->query('id')) {
            $data = Plan::
                join('workout_plans', 'plans.id', '=', 'workout_plans.plan_id')
                ->join('workouts', 'workout_plans.workout_id', '=', 'workouts.id')
                ->where('plans.id', '=', $id)
                ->select('plans.*', 'workouts.*', 'plans.id as p_id', 'plans.title as p_title', 'plans.description as p_description', 'workouts.title as workout_title', 'workouts.description as workout_description', 'workouts.type as workout_type')
                ->paginate(5);


            $userId = auth()->id();


            $data->getCollection()->transform(function ($plan) use ($userId) {
                $plan->is_saved = User_plan::
                    where('user_id', $userId)
                    ->where('plan_id', $plan->id)->exists();
                return $plan;
            });

            return response()->json($data);

        }
        $query = Plan::query();

        // Apply search
        if ($search = $request->query('search')) {
            $query->where('name', 'like', "%$search%");
        }

        // Apply filters (e.g., category)
        if ($type = $request->query('type')) {
            $query->where('type', $type);
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

        ]);

        // Sanitize inputs (optional)
        $fields['title'] = strip_tags($fields['title']);
        $fields['description'] = strip_tags($fields['description']);
        $fields['type'] = strip_tags($fields['type']);
        $fields['user_id'] = auth()->id();


        // Save data to the database
        $customPlan = CustomPlans::create($fields);


        // Redirect or return success message
        return back()->with(['success' => 'Plan created successfully', 'plan_id' => $customPlan->id]);

    }
    public function showWorkoutPlan()
    {
        return view('user.user-show-workout-plan');
    }
    public function createWorkoutPlanView()
    {
        return view('user.user-create-workout-plan');
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
        $fields['Mon '] = $request->has('mon') ? true : false;
        $fields['Tues'] = $request->has('tues') ? true : false;
        $fields['Wed'] = $request->has('wed') ? true : false;
        $fields['Thurs'] = $request->has('thurs') ? true : false;
        $fields['Fri'] = $request->has('fri') ? true : false;
        $fields['Sat'] = $request->has('sat') ? true : false;
        $fields['Sun'] = $request->has('sun') ? true : false;

        // Now you can create or update your model with the sanitized data

        // return $fields;


        WorkoutCustomPlan::create($fields);


        return redirect()
            ->intended('/users/show-workout-plan?id=' . $fields['custom_plan_id'])
            ->with(['success' => 'Plan created successfully']);

    }
    public function getWorkoutPlan(Request $request)
    {
        if ($id = $request->query('id')) {
            $data = WorkoutCustomPlan::
                join('workouts', 'workout_custom_plans.workout_id', '=', 'workouts.id')
                ->where('workout_custom_plans.custom_plan_id', '=', $id);
            return response()->json($data->paginate(5));

        }
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
        $req = $request->json()->all();

        // Access specific fields
        $plan_id = $req['plan_id'] ?? null;

        $user_id = auth()->id();
        $check = User_plan::where('user_id', '=', $user_id)
            ->where('plan_id', '=', $plan_id);



        if (empty($check->get()) || $check->count() == 0) {
            return response()->json(User_plan::create(['user_id' => $user_id, 'plan_id' => $plan_id]));

        }
        return response()->json(['error', 'already saved']);

    }
    public function updatePlan(Request $request)
    {
        $data['plan_id'] = (int) strip_tags($request['plan_id']);
        $data['user_id'] = auth()->id();

        $check = User_plan::where('user_id', '=', $data['user_id'])
            ->where('plan_id', '=', $data['plan_id']);

        if (!empty($check->get()) || $check->count() >= 0) {
            if ($request['worked_dates']) {
                $check->update(['worked_dates' => strip_tags($request['worked_dates'])]);

            }
            if ($request['paued_number']) {
                $check->update(['paued_number' => strip_tags($request['paued_number'])]);

            }

            return back()->with('success', 'success');

        }
        return back()->with('error', 'error');
    }
    public function myProgressView()
    {
        return view('user.user-my-progress');
    }
    public function getMyProgress(Request $request)
    {


        if ($id = $request->query('id')) {
            $query = Plan::
                join('workout_plans', 'plans.id', '=', 'workout_plans.plan_id')
                ->join('workouts', 'workout_plans.workout_id', '=', 'workouts.id')
                ->join('user_plans', 'user_plans.plan_id', '=', 'plans.id')
                ->where('user_plans.id', '=', $id)

                ->select(
                    'plans.*',
                    'workouts.*',
                    'user_plans.*',
                    'workout_plans.*',
                    'user_plans.id as u_p_user_plans_id',
                    'plans.id as p_plan_id',
                    'workout_plans.id as w_w_workout_plans_id',
                    'workouts.id as w_workout_id',
                    'user_plans.id as u_p_user_plan_id',
                    'workouts.title as workout_title',
                    'workouts.description as workout_description',
                    'workouts.type as workout_type',
                    'plans.title as plan_title',
                    'plans.description as plan_description'
                );

            $paginated = $query->paginate(5);

            // Add index manually
            $indexedData = $paginated->getCollection()->map(function ($item, $index) use ($paginated) {
                $item->row_index = ($paginated->currentPage() - 1) * $paginated->perPage() + $index + 1;
                return $item;
            });

            // Replace the collection inside the paginator
            $paginated->setCollection($indexedData);

            return response()->json($paginated);
        }
        $plans = Plan::join('user_plans', 'user_plans.plan_id', '=', 'plans.id')
            ->where('user_id', '=', auth()->id())
            ->select('*', 'user_plans.id as user_plan_id', )
            ->paginate(5);
        return response()->json($plans);

    }
    public function updateProgress(Request $request)
    {
        $req = $request->json()->all();

        // Access specific fields
        $paued_number = $req['paued_number'] ?? null;
        $user_plan_id = $req['user_plan_id'] ?? null;
        if ($worked_dates = $req['worked_dates']) {
            $data = User_plan::
                where('user_id', auth()->id())
                ->where('id', '=', $user_plan_id)
                ->update(['paued_number' => 0, 'worked_dates' => $worked_dates]);
            return response()->json($data);

        }


        $data = User_plan::
            where('user_id', auth()->id())
            ->where('id', '=', $user_plan_id)
            ->update(['paued_number' => $paued_number]);

        return response()->json($data);
    }
}
