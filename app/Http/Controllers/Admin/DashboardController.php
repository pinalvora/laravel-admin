<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Site;
use Session;

class DashboardController extends Controller
{
    public function index(Request $request){
        $site = Site::where('status',1)->get();
        return view('admin.pages.dashboard',compact('site'));
    }
    public function list(Request $request){
        $siteval = $request->id;
        Session::put('siteval',$siteval);
        $getsiteval = Session()->get('siteval');
        $route = 'getserialnumbers';
        return response()->json(['route' => $route]);
    }
}
