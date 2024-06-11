<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = "User management";
        $sort = $request->get('sort');
        $direction = $request->get('direction', 'desc');
        $users = User::search($request->get('q', ''))
        ->sort($sort, $direction)->paginate();
        $page = User::paginate();
        return view('Backend.user.index', compact('title', 'users' , 'page'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "User create";
        return view('Backend.user.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:8',
            're-password' => 'required|same:password',
        ]);
        $user = new User();
        $user->fill($request->except(['_token']));
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $fileName = $avatar->getClientOriginalName();
            $path = $request->file('avatar')->storeAs('/public/user', $fileName);
            $user->avatar =  $fileName;
        }
        $user->password = Hash::make($request->input('password'));
        $user->save();
        return redirect()->route('user.index');
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
        $user = User::findOrFail($id);
        $title = "User edit";
        return view('backend.user.edit', compact('user', 'title'));
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
        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id . '',
        ]);
        $user = User::findOrFail($id);
        $user->fill($request->except(['_token', 'password']));
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $fileName = $avatar->getClientOriginalName();
            $path = $request->file('avatar')->storeAs('/public/user', $fileName);
            $user->avatar =  $fileName;
        }
        $user->save();
        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::where('id', $id)->delete();
        return redirect()->route('user.index');
    }

    public function toggleActivation(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->activated = $request->input('is_active');
        $user->save();
        return back();
    }
}
