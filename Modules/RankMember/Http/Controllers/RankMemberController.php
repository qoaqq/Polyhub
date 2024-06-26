<?php

namespace Modules\RankMember\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\RankMember\Entities\RankMember;

class RankMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $title = "RankMember management";
        $sort = $request->get('sort');
        $direction = $request->get('direction', 'desc');
        $rankmembers = RankMember::search($request->get('q', ''))
            ->sort($sort, $direction) 
            ->paginate();
        $page = RankMember::paginate();
        return view('rankmember::index',compact('title','rankmembers','page'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $title = "RankMember create";
        return view('rankmember::create',compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'rank' => 'required|max:255',
            'min_points' => 'required|integer|min:0',
        ]);
        $rankmember = new RankMember();
        $rankmember->fill($request->except(['_token']));
        $rankmember->save();
        return redirect()->route('rankmember.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('rankmember::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $title = "RankMember edit";
        $rankmember = RankMember::findOrFail($id);
        return view('rankmember::edit',compact('title','rankmember'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'rank' => 'required|max:255',
            'min_points' => 'required|integer|min:0',
        ]);
        $rankmember = RankMember::findOrFail($id);
        $rankmember->fill($request->except(['_token']));
        $rankmember->save();
        return redirect()->route('rankmember.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        RankMember::where('id', $id)->delete();
        return redirect()->route('rankmember.index');
    }
}
