<?php

namespace App\Http\Controllers;

use App\backlogItem;
use App\Http\Requests\BacklogItemCreateRequest;
use App\Sprint;
use Illuminate\Http\Request;
use App\project;
use App\Http\Requests\CreateSprintRequest;
use Illuminate\Support\Facades\Auth;
use App\User;
use Exception;

class SprintController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $sprints = Sprint::all()->where("project_id" , $id);


        return view('projects.sprints.dashboard', compact('sprints'));
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
    public function store(CreateSprintRequest $request)
    {
   
        $data = $request->validated();
        Sprint::create($data);

        return redirect()->back()->with('date', 'Sprint is aangemaakt!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sprint  $sprint
     * @return \Illuminate\Http\Response
     */
    public function show($project_id, $sprint_id)
    {
        $project = Project::find($project_id);
        $projectUsers = $project->users()->wherePivot('project_id', '=', $project_id)->get();

        $sprint = Sprint::all()->where('id', $sprint_id);
        $backlogitems = BacklogItem::all()->where('sprint_id', null)->where('project_id', $project_id);

        $sprint_backlogitems = BacklogItem::all()->where('sprint_id', $sprint_id)->where('project_id', $project_id)
            ->join('user_id', 'users.id', '=', 'backlogItems.user_id');


        $to_do_backlogitems =   BacklogItem::all()->where('sprint_id', $sprint_id)->where('project_id', $project_id)->where('status', 0);
        $doing_backlogitems =   BacklogItem::all()->where('sprint_id', $sprint_id)->where('project_id', $project_id)->where('status', 1);
        $review_backlogitems =  BacklogItem::all()->where('sprint_id', $sprint_id)->where('project_id', $project_id)->where('status', 2);
        $done_backlogitems =    BacklogItem::all()->where('sprint_id', $sprint_id)->where('project_id', $project_id)->where('status', 3);


        return view('projects.sprints.sprint', compact( 'sprint', 'backlogitems', 'backlogitems', 'sprint_backlogitems'
            ,'project_id', 'to_do_backlogitems', 'doing_backlogitems', 'review_backlogitems', 'done_backlogitems', 'projectUsers'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sprint  $sprint
     * @return \Illuminate\Http\Response
     */
    public function edit(Sprint $sprint)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sprint  $sprint
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
     
        $request->validate([
            'sprint_id' => 'required' . $id
        ]);

        Backlogitem::find($id)->update(['sprint_id' => $request->get('id')]);
        
        return redirect()->back()->with('addBacklog', 'Backlogitem is toegevoegd aan sprint!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sprint  $sprint
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        sprint::find($id)->delete();

        return redirect()->back();
    }
}
