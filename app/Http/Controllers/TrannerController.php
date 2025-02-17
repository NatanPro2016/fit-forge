<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Tranner;
use App\Models\TrannerWorkout;
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
        $fields['video'] = $this->convertToEmbedLinkIfNeeded(strip_tags($fields['video']));
        $fields['description'] = strip_tags($fields['description']);
        $fields['image'] = $request->file('image')->store('images', 'public');
        $fields['tranner_id'] = Auth::guard('tanner')->user()->id;
        Workout::create($fields);
        return back()->with('success', 'created successfully');
    }
    private function convertToEmbedLinkIfNeeded($url)
    {
        $parsedUrl = parse_url($url);

        // Check if the host is YouTube
        if (isset($parsedUrl['host']) && strpos($parsedUrl['host'], 'youtube.com') !== false) {
            parse_str($parsedUrl['query'] ?? '', $queryParams);

            // If it's a watch link with a `v` parameter, convert it
            if (isset($queryParams['v'])) {
                return "https://www.youtube.com/embed/" . $queryParams['v'];
            }
        }

        // If already an embed link or not a YouTube link, return as is
        return $url;
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

        ]);

        // Sanitize inputs (optional)
        $fields['title'] = strip_tags($fields['title']);
        $fields['description'] = strip_tags($fields['description']);
        $fields['type'] = strip_tags($fields['type']);
        $fields['tranner_id'] = Auth::guard('tanner')->user()->id;
        $fields['count'] = 0;





        // Save data to the database
        $plan = Plan::create($fields);

        // Redirect or return success message
        return back()->with(['success' => 'Plan created successfully', 'plan_id' => $plan->id]);


    }
    public function createWorkoutPlanView()
    {
        return view('tranner.tranner-create-workout-plan');
    }
    public function createWorkoutPlan(Request $request)
    {
        $fields = $request->validate([
            'duration' => ['required', 'integer'],
            'incrimination' => ['required', 'integer'],
            'Mon' => ['nullable'],
            'Tues' => ['nullable'],
            'Wed' => ['nullable'],
            'Thurs' => ['nullable'],
            'Fri' => ['nullable'],
            'Sat' => ['nullable'],
            'Sun' => ['nullable'],
            'plan_id' => ['required', 'integer'],
            'workout_id' => ['required', 'integer'],
        ]);

        // Sanitizing inputs
        $fields['duration'] = strip_tags($fields['duration']);
        $fields['incrimination'] = strip_tags($fields['incrimination']);
        $fields['plan_id'] = strip_tags($fields['plan_id']);
        $fields['workout_id'] = strip_tags($fields['workout_id']);

        // For checkboxes, check if they're set. If not, set them to false.
        $fields['Mon'] = $request->has('Mon') ? true : false;
        $fields['Tues'] = $request->has('Tues') ? true : false;
        $fields['Wed'] = $request->has('Wed') ? true : false;
        $fields['Thurs'] = $request->has('Thurs') ? true : false;
        $fields['Fri'] = $request->has('Fri') ? true : false;
        $fields['Sat'] = $request->has('Sat') ? true : false;
        $fields['Sun'] = $request->has('Sun') ? true : false;

        // Now you can create or update your model with the sanitized data



        Workout_plan::create($fields);


        return redirect()
            ->intended('/trainer/show-workout-plan?id=' . $fields['plan_id'])
            ->with(['success' => 'Plan created successfully']);

    }
    public function showWorkoutPlan()
    {
        return view('tranner.tranner-show-workout-plan');

    }
    public function getWorkoutPlan(Request $request)
    {
        if ($id = $request->query('id')) {
            $data = Workout_plan::
                join('workouts', 'workout_plans.workout_id', '=', 'workouts.id')
                ->where('workout_plans.plan_id', '=', $id);
            return response()->json($data->paginate(5));

        }
    }
    public function dicoverPlansView()
    {
        return view('tranner.tranner-discover-plan');
    }
    public function dicoverPlans(Request $request)
    {
        if ($id = $request->query('id')) {
            $data = Plan::
                join('workout_plans', 'plans.id', '=', 'workout_plans.plan_id')
                ->join('workouts', 'workout_plans.workout_id', '=', 'workouts.id')
                ->where('plans.id', '=', $id)
                ->select('plans.*', 'workouts.*', 'workouts.title as workout_title', 'workouts.description as workout_description', 'workouts.type as workout_type');
            return response()->json($data->paginate(5));

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
    public function getWorkouts(Request $request)
    {
        if ($workout_id = $request->query('id')) {
            $data = Workout::where('id', '=', $workout_id);
            return response()->json($data->get());

        }
        $query = Workout::query();

        // Apply search
        if ($search = $request->query('search')) {
            $query->where('title', 'like', "%$search%");
        }

        // Apply filters (e.g., category)
        if ($type = $request->query('type')) {
            $query->where('type', $type);
        }
        if ($request->query('saved')) {
            $query->where('id', 'in', Auth::guard('tanner')->user()->id);

            TrannerWorkout::where('tranner_id', Auth::guard('tanner')->user()->id);
        }



        if (empty($query->get()) || $query->count() == 0) {
            return response()->json([
                'data' => []
            ]);
        }

        $data = $query->paginate(5);
        $trannerId = Auth::guard('tanner')->user()->id;

        $data->getCollection()->transform(function ($workout) use ($trannerId) {
            $workout->is_aved = TrannerWorkout::
                where('tranner_id', $trannerId)
                ->where('workout_id', $workout->id)
                ->exists();

            return $workout;
        });
        return response()->json($data);
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

        TrannerWorkout::create($data);
        return back()->with('success', 'saved');

    }


}
