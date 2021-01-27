<?php

namespace App\Http\Controllers;

use App\Retrospective;
use App\Sprint;
use Illuminate\Http\Request;
use App\Http\Requests\CreateRetrospectiveRequest;


class RetrospectiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($project_id, $sprint_id)
    {
        $sprints = Sprint::all()->where("project_id" , $project_id)->where("id" , $sprint_id);
        $goodRetrospectives = Retrospective::all()->where("sprint_id" , $sprint_id)->where("status", 1);
        $betterRetrospectives = Retrospective::all()->where("sprint_id" , $sprint_id)->where("status", 2);
        $badRetrospectives = Retrospective::all()->where("sprint_id" , $sprint_id)->where("status", 3);


        return view('projects.sprints.retrospective', compact('sprints', 'goodRetrospectives', 'betterRetrospectives', 'badRetrospectives'));
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
    public function store(CreateRetrospectiveRequest $request)
    {
        $data = $request->validated();
        Retrospective::create($data);



        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Retrospective  $retrospective
     * @return \Illuminate\Http\Response
     */
    public function show(Retrospective $retrospective)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Retrospective  $retrospective
     * @return \Illuminate\Http\Response
     */
    public function edit(Retrospective $retrospective)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Retrospective  $retrospective
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Retrospective $retrospective)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Retrospective  $retrospective
     * @return \Illuminate\Http\Response
     */
    public function destroy(Retrospective $retrospective)
    {
        //
    }
}
