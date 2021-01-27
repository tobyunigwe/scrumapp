<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->get('query');
        $allUsers = User::all();
        $users = User::where('name', 'LIKE', $search . '%')->paginate(5);

        foreach ($allUsers as $user)
            if ($user->user_role_id === 1) {
                return view('admin.index', compact('users'));
            }

        abort(403);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $request->validate([
            'user_role_id' => 'required' . $id
        ]);

        User::find($id)->update(['user_role_id' => $request->get('role_id')]);

        return redirect()->back()->with('updated', 'Gebruiker is bijgewerkt!');
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
            return redirect()->back()->with('failed', 'U mag jezelf niet verwijderen!');
        } elseif ($user->user_role_id == 1) {
            return redirect()->back()->with('failedAdmin', 'U mag andere administrators niet verwijderen!');
        } else {
            $user->delete();
            return redirect()->back()->with('deleted', 'Gebruiker is verwijderd!');
        }
    }
}
