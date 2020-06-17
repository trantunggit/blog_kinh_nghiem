<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Validator;
use App\pages;
define('RESPONSE_STATUS_FORBIDDEN', 403);
define('RESPONSE_STATUS_OK', 200);

class pagesController extends Controller
{
    //13
    public function index()
    {
        $pages= pages::get();
        return response()->json($pages, RESPONSE_STATUS_OK);
    }
    //14
    public function show($id)
    {
        return response()->json(pages::find($id), RESPONSE_STATUS_OK);
    }
    //15
    function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'title' => 'required',
            'description' => 'required',
            'content' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), RESPONSE_STATUS_FORBIDDEN);
        }    
        $pages= new pages;
        $pages->name = $request->name;
        $pages->title = $request->title;
        $pages->slug = Str::of($request->title)->slug('-');
        $pages->description = $request->description;
        $pages->content = $request->content;
        $pages->save();
        return response() -> json("Tạo mới thành công!", RESPONSE_STATUS_OK);
    }
    //16
    function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'title' => 'required',
            'description' => 'required',
            'content' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), RESPONSE_STATUS_FORBIDDEN);
        }    
        $pages= pages::find($id);
        $pages->name = $request->name;
        $pages->title = $request->title;
        $pages->slug = Str::of($request->title)->slug('-');
        $pages->description = $request->description;
        $pages->content = $request->content;
        $pages->save();
        return response() -> json("Cập nhật thành công!", RESPONSE_STATUS_OK);
    }
    //17
    function delete(Request $request,pages $pages)
    {
        if ($pages->delete()) {
            return response() -> json("Xóa thành công!", RESPONSE_STATUS_OK);
        } else {
            return response() -> json("Xóa không thành công!");
        }
    }
}
