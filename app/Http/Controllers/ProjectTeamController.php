<?php

namespace App\Http\Controllers;

use App\User;
use App\Project;
use App\Http\Requests\UserCreateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectTeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserCreateRequest $request, $id)
    {

        $project = Project::find($id);

        foreach ($project->users as $user) {
            if ($user->id == $request->id) {
                return redirect()->back()->with('alreadyExists', 'Gebruiker zit al in uw project.');
            }
        }

        $project->users()->attach($request->id, [
            'role_id' => 2
        ]);
        return redirect()->back()->with('created', 'Gebruiker Toegevoegd!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $allUsers = User::all(['id', 'name']);

        $profile = Auth::id();
        // Check if Project exists
        $projectExists = Project::where('id', $id)->exists();

        // show 404 not found page
        abort_unless($projectExists, 404);

        $project = Project::find($id);
        $userProjects = $project->users()->wherePivot('project_id', '=', $id)->get();
        

        // Authenticated user's id
        $user_id = Auth::id();

        // Get user_id from pivot table
        $userProjectsCheck = $project->users()->wherePivot('user_id', '=', $user_id)->get();

        // loop and check if authenticated user owns the project
        foreach ($userProjectsCheck as $userproject) {
            if ($user_id == $userproject->id) {
                return view('projects.members.index', compact('project', 'userProjects', 'userproject', 'profile', 'allUsers'));
            }
        }
        // If authtenticated user doesn't have access show 403 forbidden page
        abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (auth::user()->id == $id) {
            return redirect()->back()->with('loggedUser', 'U mag jezelf niet uit een project verwijderen.');
        } else {
            $user->projects()->detach();

            return redirect()->back()->with('notLoggedUser', 'Gebruiker is verwijderd uit het project');
        }
    }
}
