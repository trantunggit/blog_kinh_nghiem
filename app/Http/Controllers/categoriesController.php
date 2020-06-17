<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\categories;
use Validator;
define('RESPONSE_STATUS_FORBIDDEN', 403);
define('RESPONSE_STATUS_OK', 200);

class categoriesController extends Controller
{
    //3
    public function index()
    {
        $cate= categories::get();
        return response()->json($cate, RESPONSE_STATUS_OK);
    }
    //4
    public function show($id)
    {
        return response()->json(categories::find($id), RESPONSE_STATUS_OK);
    }
    //5
    function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), RESPONSE_STATUS_FORBIDDEN);
        }    
        $cate= new categories;
        $cate->name = $request->name;
        $cate->parent = $request->parent;
        $cate->slug = Str::of($request->name)->slug('-');
        $cate->save();
        return response() -> json("Tạo mới thành công!", RESPONSE_STATUS_OK);
    }
    //6
    function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), RESPONSE_STATUS_FORBIDDEN);
        }    
        $cate= categories::find($id);
        $cate->name = $request->name;
        $cate->parent = $request->parent;
        $cate->slug = Str::of($request->name)->slug('-');
        $cate->save();
        return response() -> json("Cập nhật thành công!", RESPONSE_STATUS_OK);
    }
    //7
    function delete(Request $request,categories $cate)
    {
        if ($cate->delete()) {
            return response() -> json("Xóa thành công!", RESPONSE_STATUS_OK);
        } else {
            return response() -> json("Xóa không thành công!");
        }
    }

}
