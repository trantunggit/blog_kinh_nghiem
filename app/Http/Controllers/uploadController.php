<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\assets;
use Validator;
use Carbon\Carbon;
use File;
define('RESPONSE_STATUS_FORBIDDEN', 403);
define('RESPONSE_STATUS_OK', 200);

class uploadController extends Controller
{
    //18
    public function imageUpload(Request $request)
    {
        $curr = new Carbon();
        $file = $request->file('image');
        $filename = date('Y-m-d_hia')."_".$file->getClientOriginalName();
        $file->move('uploads/images', $filename);
        $image = new assets;
        $image->name = $filename;
        $image->location = 'uploads/images/'.$filename;
        $image->created_at = $curr;
        $image->updated_at = $curr;
        $image->save();
        return response()->json(['link' => $image->location], RESPONSE_STATUS_OK);
    }
    //19
    function postAssets(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'asset-image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if($validator->fails())
        {
            return response()->json($validator->errors(),RESPONSE_STATUS_FORBIDDEN);
        }
        //biến chứa đường link location
        $asset_images = 'news/images';

        if($request->hasFile('asset-image'))
        {
            $file = $request->{'asset-image'};
            $file_name = (string)"news_".date('m-d-Y_hia').mt_rand(100, 1000).(string)($file->getClientOriginalName());
            $file->move($asset_images, $file_name);     
            $asset = $file_name;
            assets::insert([
                'name' => $asset,
                'location' => $asset_images.'/'.$asset,
                'created_at' => new Carbon(),
                'updated_at' => new Carbon(),
            ]);
            return response()->json(['link' => $asset_images."/".$asset], RESPONSE_STATUS_OK);
        }
        return response()->json(['description' => 'errors'], RESPONSE_STATUS_FORBIDDEN);
    }
    //20
    function deleteAsset(Request $request){
        $id = $request->id;
        $asset = assets::where('id', $id)->first();
        File::delete($asset->location);
        assets::where('id', $id)->delete();
        return response()->json("delete succcess", 200);
    }

}
