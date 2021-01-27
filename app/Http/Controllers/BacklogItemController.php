<?php

namespace App\Http\Controllers;

use App\backlogItem;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\BacklogItemCreateRequest;
use App\Project;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;


class BacklogItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $backlogItems = BacklogItem::all();

        return view('home', compact('backlogItems'));
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
    public function store(BacklogItemCreateRequest $request)
    {

        $data = $request->validated();
        BacklogItem::create($data);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\backlogItem  $backlogItem
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $projects = Project::all()->where('id', $id);
        $profile = Auth::id();
        $project = Project::find($id);
        $backlogItems = BacklogItem::all()->where('project_id', $id);
        $left = new Carbon('2016-08-19');
        $left->year(date('Y'));
        $daysleft = Carbon::now()->diffInDays($left, false);

        // Authenticated user's id
        $user_id = Auth::id();

        // Check if Project exists
        $projectExists = Project::where('id', $id)->exists();

        // show 404 not found page
        abort_unless($projectExists, 404);

        // Get user_id from pivot table
        $userProjects = $project->users()->wherePivot('user_id', '=', $user_id)->get();

        $projectUsers = $project->users()->wherePivot('project_id', '=', $id)->get();


        // loop and check if authenticated user owns the project
        foreach ($userProjects as $userproject) {
            if ($user_id == $userproject->id) {
                return view('projects.showProject', compact('projects', 'backlogItems', 'daysleft', 'project', 'profile' , 'projectUsers'));
            }
        }
        // If authtenticated user doesn't have access show 403 forbidden page
        abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\backlogItem  $backlogItem
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $backlogItems = backlogitem::find($id);

        return view('projects.index', compact('$backlogItems'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\backlogItem  $backlogItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'role' => 'required',
            'activity' => 'required',
            'story_point' => 'required',
            'user_id',
            'project_id' => 'required' . $id
        ]);

        backlogItem::find($id)->fill($request->input())->save();
        return redirect()->back()->with('updated', 'Gebruiker is bijgewerkt!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\backlogItem  $backlogItem
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        backlogItem::find($id)->delete();

        return redirect()->back();
    }
}
