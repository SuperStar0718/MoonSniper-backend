<?php

namespace App\Http\Controllers;

use App\Models\Launchpad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class LaunchpadController extends Controller
{
    public function LaunchpadList(Request $request)
    {
        $input_json = $request->getContent();
        $input_array = json_decode($input_json, true);
        $query = DB::table('launchpads');
        if ($input_array["filters2"] != "") {
            $query->where( 'launchpad', 'LIKE', "%" . $input_array["filters2"] . "%");
        }
        if ($input_array["sort"][1] == "asc" || $input_array["sort"][1] == "desc") {
            $query->orderBy(DB::raw("ISNULL(" . $input_array["sort"][0] . "), " . $input_array["sort"][0]), $input_array["sort"][1]);
        }
        $LaunchList = $query->paginate($input_array["perpage"] ? $input_array["perpage"] : 6);
        return response()->json(['status' => true, 'LaunchList' => $LaunchList]);
    }
    public function fetchLaunchoadCoinAS(Request $request)
    {
        $query = DB::table('launchpads');
        $coins =$query->where('launchpad', 'LIKE', "%" . $request->key  . "%")->get();
        return response()->json($coins);

    }
    public function updateLaunchpadCoin(Request $request)
    {
        $item = Launchpad::where(['id' => $request->id])->first();
        if($item){
            if ($request->iconBase64) {
                if ($item->icon) {
                    if (Storage::exists('/public/launchpad/icons/' . $item->icon)) {
                        Storage::delete('/public/launchpad/icons/' . $item->icon);
                    }
                }
                $extension = explode('/', mime_content_type($request->iconBase64))[1];
                $image = str_replace('data:image/' . $extension . ';base64,', '', $request->iconBase64);
                $iconBase64 = base64_decode($image);
                $imageName = rand(1054545450, 999933333) . '.' . $extension;
                $file = File::put(storage_path('app/public/launchpad/icons/') . '' . $imageName, $iconBase64);
                $item->icon = $imageName;
            }
             $item->launchpad = $request->launchpad;
             $item->project = $request->project;
             $item->category = $request->category;
             $item->market_cap = $request->market_cap;
             $item->thicker = $request->thicker;
             $item->launch_time = $request->launch_time;
             $item->first_unlock_time = $request->first_unlock_time;
             $item->network = $request->network;
             $item->ido_public_number = $request->ido_public_number;
             $item->telegram = $request->telegram;
             $item->website = $request->website;
             $item->twitter = $request->twitter;
             $item->tokenomies = $request->tokenomies;
             $item->contract = $request->contract;
             $item->save();
             return response()->json(['status' =>true]);
             
        }
    }
    public function addLaunchpadCoin(Request $request)
    {
        $item = new Launchpad();
        if ($request->iconBase64) {
            $extension = explode('/', mime_content_type($request->iconBase64))[1];
            $image = str_replace('data:image/' . $extension . ';base64,', '', $request->iconBase64);
            $iconBase64 = base64_decode($image);
            $imageName = rand(1054545450, 999933333) . '.' . $extension;
            $file = File::put(storage_path('app/public/launchpad/icons/') . '' . $imageName, $iconBase64);
            $item->icon = $imageName;
        }
             $item->launchpad = $request->launchpad;
             $item->project = $request->project;
             $item->category = $request->category;
             $item->market_cap = $request->market_cap;
             $item->thicker = $request->thicker;
             $item->launch_time = $request->launch_time;
             $item->first_unlock_time = $request->first_unlock_time;
             $item->network = $request->network;
             $item->ido_public_number = $request->ido_public_number;
             $item->telegram = $request->telegram;
             $item->website = $request->website;
             $item->twitter = $request->twitter;
             $item->tokenomies = $request->tokenomies;
             $item->contract = $request->contract;
             $item->save();
             return response()->json(['status' =>true]);
             
    }
}
