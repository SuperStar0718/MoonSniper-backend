<?php

namespace App\Http\Controllers;

use App\Models\CoinsData;
use App\Models\CoinsList;
use App\Models\UnlockingPdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class UnlockingController extends Controller
{
    public function coinsForAutoSuggest(Request $request)
    {
        $coins = CoinsList::where('name', 'like', '%' . $request->key . '%')->select('coin_id', 'name')->get();
        return response()->json($coins);
    }
    public function loadSingleCoin(Request $request)
    {
        $coin = DB::table('coins')->where('coin_data.coin_id', $request->coinid)
            ->Join('coin_data', 'coins.coin_id', '=', 'coin_data.coin_id')
            ->first();
       return $coin;
    }
    public function updateCoinData(Request $request)
    {
         $coin = CoinsData::where('coin_id', $request->coinid)->first();

         $coin->total_locked = $request->total_locked;
         $coin->next_unlock_date = $request->next_unlock_date;
         $coin->next_unlock_date_text = $request->next_unlock_date_text;
         $coin->next_unlock_number_of_tokens = $request->next_unlock_number_of_tokens;
         $coin->next_unlock_percent_of_tokens = $request->next_unlock_percent_of_tokens;
         $coin->next_unlock_size = $request->next_unlock_size;
         $coin->first_vc_unlock = $request->first_vc_unlock;
         $coin->end_vc_unlock = $request->end_vc_unlock;
         $coin->first_vc_unlock_text = $request->total_locked;                                          
         $coin->end_vc_unlock_text = $request->end_vc_unlock_text;
         $coin->three_months_unlock_number_of_tokens = $request->three_months_unlock_number_of_tokens;
         $coin->three_months_unlock_percent_of_tokens = $request->three_months_unlock_percent_of_tokens;
         $coin->three_months_unlock_size = $request->three_months_unlock_size;
         $coin->six_months_unlock_number_of_tokens = $request->six_months_unlock_number_of_tokens;
         $coin->six_months_unlock_percent_of_tokens = $request->six_months_unlock_percent_of_tokens;
         $coin->six_months_unlock_size = $request->six_months_unlock_size;
         $coin->save();
         return response()->json(['status'=>'success']);
    }
    public function UploadPDF(Request $request)
    {
        
        if ($request->hasFile('pdfFile')) {
            $addPdf = new UnlockingPdf();
            $filenameWithExt =  $request->file('pdfFile')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension =  $request->file('pdfFile')->getClientOriginalExtension();
            $filenameWithExt = $filename . '_' . rand(100, 9999);
            $fileNameToStore = $filenameWithExt . '.' . $extension;
            $request->file('pdfFile')->storeAs('public\unlocking/pdfs', $fileNameToStore);
            $paths = $fileNameToStore;
            $addPdf->file = $paths;
            $addPdf->save();
            return response()->json(['status' => 'success']);
    }else{
        return response()->json(['status' => 'failed']);
    }
    }

}
