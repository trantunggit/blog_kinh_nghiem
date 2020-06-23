<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\posts;
use App\categories;
use Validator;

define('RESPONSE_STATUS_FORBIDDEN', 403);
define('RESPONSE_STATUS_OK', 200);

class postsController extends Controller
{
    //8
    public function index()
    {
        // $this->authorize('Full control');
        $news= posts::with('categories')->orderBy('created_at', 'desc')->get();
        return response()->json($news, RESPONSE_STATUS_OK);
    }
    //9
    public function show($id)
    {
        return response()->json(posts::find($id), RESPONSE_STATUS_OK);
    }
    //10
    function add(Request $request)
    {
        $categories = categories::get();
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'title' => 'required',
            'description' => 'required',
            'categories' => 'required',
            'content' => 'required',
            'thumbnail' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), RESPONSE_STATUS_FORBIDDEN);
        } 
        
        $news= new posts;
        $news->name = $request->name;
        $news->title = $request->title;
        $news->slug = Str::of($request->title)->slug('-');
        $news->description = $request->description;
        $news->content = $request->content;
        $news->thumbnail = $request->thumbnail;
        $news->save();
        $news->categories()->attach($request->categories);

        return response() -> json("Tạo mới thành công!", RESPONSE_STATUS_OK);
    }
    //11
    function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'title' => 'required',
            'description' => 'required',
            'categories' => 'required|exists:categories,id',
            'content' => 'required',
            'thumbnail' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), RESPONSE_STATUS_FORBIDDEN);
        }
        $news= posts::find($id);
        $news->name = $request->name;
        $news->title = $request->title;
        $news->slug = Str::of($request->title)->slug('-');
        $news->description = $request->description;
        $news->content = $request->content;
        $news->thumbnail = $request->thumbnail;
        $news->save();
        $news->categories()->sync($request->categories);

        return response() -> json("Cập nhật thành công!", RESPONSE_STATUS_OK);
    }
    //12
    function delete(Request $request,posts $news)
    {
        $news->categories()->detach();
        $news->delete();
        return response() -> json("Xóa thành công!", RESPONSE_STATUS_OK);
        
    }

}
