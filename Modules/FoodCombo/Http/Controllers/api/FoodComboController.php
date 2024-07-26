<?php

namespace Modules\FoodCombo\Http\Controllers\api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\FoodCombo\Entities\FoodCombo;
use Modules\FoodCombo\Http\Requests\CreateFoodComboRequest;
use Modules\FoodCombo\Http\Requests\UpdateFoodComboRequest;

class FoodComboController extends Controller
{
    public function index(Request $request)
    {
        $foodCombos = FoodCombo::all();

        return response()->json($foodCombos);
    }

    public function create()
    {
        // For an API, we usually don't need a create method since the form is handled by the frontend
        return response()->json(['message' => 'Method not allowed'], 405);
    }

    public function store(Request $request)
    {
        $foodCombo = FoodCombo::create($request->all());
        return response()->json(['data' => $foodCombo, 'message' => 'Thêm thành công'], 201);
    }

    public function show($id)
    {
        $foodCombo = FoodCombo::find($id);
        if (!$foodCombo) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return response()->json(['data' => $foodCombo]);
    }

    public function edit($id)
    {
        // For an API, we usually don't need an edit method since the form is handled by the frontend
        return response()->json(['message' => 'Method not allowed'], 405);
    }

    public function update(UpdateFoodComboRequest $request, $id)
    {
        $foodCombo = FoodCombo::find($id);
        if (!$foodCombo) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        $foodCombo->update($request->all());
        return response()->json(['data' => $foodCombo, 'message' => 'Cập nhật thành công']);
    }

    public function destroy($id)
    {
        $foodCombo = FoodCombo::find($id);
        if (!$foodCombo) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        $foodCombo->delete();
        return response()->json(['message' => 'Xóa thành công!']);
    }
}
