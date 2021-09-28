<?php

namespace App\Http\Controllers;
use App\Models\Member;

use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function getMember(){
        $data = [];
        foreach (Member::where('balance', '<=', 10000)->get() as $key) {
           $data[$key->transportation][] = $key;
        }
        return response()->json($data);
    }
    public function storeMember(){
        $data = file_get_contents(base_path()."/public/data.json");
        $dataku = json_decode($data, true);
        $data_db = [];
        foreach ($dataku as $key) {
            $data_import = [
                'name' => $key['details'][0]['name'],
                'balance' => $key['details'][0]['balance'],
                'transportation' => $key['favoriteTransportation']
            ];
            $data_db[] = $data_import;
        }
        Member::truncate();
        return Member::insert(
            $data_db
        );
    }
}
