<?php

namespace App\Http\Controllers;

use App\Library\CovinApi\CovinLibrary;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home(){
        // $states = CovinLibrary::getState();
        $states = [];
        return view('home', compact('states'));
    }

    public function getDistrict(Request $request) {
        $stateId = $request->state_id ?? '';
        if($stateId == '') {
            return [];
        }
        $districts = CovinLibrary::getDistricts($stateId);

        return response()->json([
            'status' => 'success',
            'data'  => $districts
        ]);
    }

    public function getSearchData(Request $request) {
        
        $stateId = $request->state_id ?? '';
        $districtId = $request->district_id ?? '';
        $date = $request->date ?? '';

        $data = array(
            'stateId' => $stateId,
            'districtId' => $districtId,
            'date' => $date
        );

        if($stateId == '' || $districtId == '' || $date == '') {
            return response()->json([
                'status' => 'failed',
                'message' => 'Invalid Data'
            ]);
        }
        $getCentreData = CovinLibrary::getCentreData($data);

        return response()->json([
            'status' => 'success',
            'data'  => $getCentreData
        ]);
    }
}
