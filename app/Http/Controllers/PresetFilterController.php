<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\PresetFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PresetFilterController extends Controller
{
    public function create_preset_filter(Request $request)
    {
        $user = Auth::user();
        
        
        $input_json = $request->getContent();
        $input_array = json_decode($input_json, true);
        
        
        $preset_name = $input_array["filter_name"];
        $is_default = 0;
        $user_id = $user->id;

        if($preset_name != "")
        {
            // Insert Preset Filter in Database
                $preset_filter = PresetFilter::updateOrCreate(
                [
                   'user_id'   => $user_id,
                   'preset_name'   => $preset_name,
                   'default'   => $is_default,

                ],
                [
                   'filter_json' => $input_json
                ],
            );
        } 



        $this->get_preset_filters();

    }

    // Get Default Presets & User's Custom Presets
    public function get_preset_filters()
    {
        $user = Auth::user();
        $preset_filters = PresetFilter::where("user_id", $user->id)->orWhere("default", 1)->get();
        echo json_encode($preset_filters);
    }

    public function delete_preset_filter(Request $request)
    {
        $input_json = $request->getContent();
        $input_array = json_decode($input_json, true);
        $preset_id = $input_array["preset_id"];

        $user = Auth::user();
        $preset_filters = PresetFilter::where("user_id", $user->id)->where("id", $preset_id )->where("default", 0)->delete();
        $this->get_preset_filters();
    }
}
