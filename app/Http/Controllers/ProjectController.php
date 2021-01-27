<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProjectRequest;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\BacklogItem;
use App\User;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::id();
        $profile = Auth::id();
        $projects = User::find($user_id);

        foreach ($projects->projects as $project) {
            $diff = 0;
            $date = Carbon::parse($project->deadline);
            $now = Carbon::now();
            $diff = $date->diffInDays($now);
            $project->deadlineForHumans = $diff;
            $project_new_id = $project->pivot->project_id;
            $project_id = $project->id;

            if ($project_new_id == $project_id) {
                $allProjects = Project::find($project->id);
                $project->userProjects = $userProjects = $allProjects->users()->get();
            }
        }
        return view('projects.index', compact('projects', 'profile'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProjectRequest $request)
    {
        $data = $request->validated();
        $project = new Project();
        $project->title = $data['title'];
        $project->deadline = $data['deadline'];
        $project->description = $data['description'];

        $project->save();

        $project->users()->attach(Auth::id(), [
            'role_id' => 1
        ]);

        return redirect()->back()->with('date', 'Project is aangemaakt!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::find($id);
        $currentUserProjects = Project::where('id', $id)->get();
        foreach ($currentUserProjects as $currentUserProject) {
            $date = Carbon::parse($currentUserProject->deadline);
            $now = Carbon::now();
            $diff = $date->diffInDays($now);
            $currentUserProject->deadlineForHumans = $diff;
        }
        $backlogItems = BacklogItem::all()->where('project_id', $id);
        $backlogItemTypeFeature = BacklogItem::all()->where('project_id', $id)->where('type', 'Feature');
        $backlogItemTypeBug = BacklogItem::all()->where('project_id', $id)->where('type', 'Bug');
        $backlogItemTypeEpic = BacklogItem::all()->where('project_id', $id)->where('type', 'Epic');

        $usersProjects = $project->users()->wherePivot('project_id', '=', $id)->get();

        $user_id = Auth::id();
        $profile = Auth::id();
        $projects = User::find($user_id);

        // Check if Project exists
        $projectExists = Project::where('id', $id)->exists();

        // show 404 not found page
        abort_unless($projectExists, 404);

        // Get user_id from pivot table
        $userProjectsCheck = $project->users()->wherePivot('user_id', '=', $user_id)->get();

        foreach ($projects->projects as $project) {
            $date = Carbon::parse($project->deadline);
            $now = Carbon::now();
            $diff = $date->diffInDays($now);
            $project->deadlineForHumans = $diff;
            $project_new_id = $project->pivot->project_id;
            $project_id = $project->id;

            if ($project_new_id == $project_id) {
                $allProjects = Project::find($project->id);
                $project->userProjects = $userProjects = $allProjects->users()->get();
            }
            // loop and check if authenticated user owns the project
            foreach ($userProjectsCheck as $userproject) {
                if ($user_id === $userproject->id) {
                    return view('projects.dashboard', compact(
                        'projects',
                        'project',
                        'profile',
                        'usersProjects',
                        'currentUserProjects',
                        'backlogItems',
                        'backlogItemTypeFeature',
                        'backlogItemTypeBug',
                        'backlogItemTypeEpic'
                    ));
                }
            }
        }

        abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $projects = Project::find($id)->count();

        return view('projects.index', compact('projects'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string',
            'deadline' => 'required|after_or_equal:now',
            'description' => 'required|string'
        ]);

        Project::find($id)->fill($request->input())->save();
        return redirect()->back()->with('updated', 'Project gegevens zijn bijgewerkt!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::find($id);
        $project->delete();

        return redirect()->action('ProjectController@index');
    }
}
