<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Hash;
use DataTables;
use Session;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.sites.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSite(Request $request , Site $site){
        if ($request->ajax()) {
            $data = $site->getData();
            $sessionval = Session()->get('siteval');
            return \DataTables::of($data)
                ->addColumn('Actions', function($data) use ($sessionval){
                    $id = $data->id;
                    $actionBtn = "<a href='".route('sites.edit',$data['id'])."' class='edit btn btn-default btn-sm'><i class='fas fa-edit'> Edit</i></a>
                        <a href='' data-id='".$data->id."' data-method='delete' class='delete btn btn-default btn-sm' id='delete'><i class='fas fa-trash-alt'> Delete</i></a>
                        <a href='' data-id='".$data->id."' data-method='post' class='delete btn  btn-sm' id='checksite' style='color:white;'>Check Site</a>";

                        if($sessionval == $id){
                            $actionBtn =  "<a href='".route('sites.edit',$data['id'])."' class='edit btn btn-default btn-sm'><i class='fas fa-edit'> Edit</i></a>
                                <a href='' data-id='".$data->id."' data-method='delete' class='delete btn btn-default btn-sm' id='delete'><i class='fas fa-trash-alt'> Delete</i></a>
                                <a href='' data-id='".$data->id."' data-method='post' class='delete btn btn-default btn-sm'><i class='fa fa-check' aria-hidden='true'> Selected</i></a>";
                        }

                    return $actionBtn;
                })
            ->rawColumns(['Actions'])
            ->make(true);
        }
    }

    public function create()
    {
        return view('admin.sites.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*$siteval = $request->site;
        $request->session()->flush('siteval');
        $request->session()->put('siteval',$siteval);*/
        $id = $request->id;
        if($id){
            $site = Site::find($id);
            $this->update($request,$site);
        }else{
            $rules = [
                'name' => 'required',
                'status' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
               return redirect()->back()->withErrors($validator->errors());
            }else{
                $site = new Site();
                    $data = array(
                        'name' => $request->name,
                        'uid' => md5($request->title.$request->name),
                        'ip_address' => $request->ip(),
                        'status' => $request->status,
                        'created_at' => date('Y-m-d H:i:s')
                    );
                    $site = Site::create($data);
                }
            }
        return redirect()->route('sites.index')->with('success','Data Save SuccessFully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function show(Site $site)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function edit(Site $site)
    {
        $id = $site->id;
        if($id){
            $site['id'] = $id;
            $site = Site::find($id);
        }
        return view('admin.sites.add',compact('site'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Site $site)
    {
        $id = $request['id'];
        if($id){
            $site = Site::find($id);
            $data = array(
                'name' => $request->name,
                'uid' => md5($request->title.$request->name),
                'status' => $request->status,
                'updated_at' => date('Y-m-d H:i:s')
            );
        }
        $site->update($data);
        return redirect()->route('sites.index')->with('success','Data Updated SuccessFully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function destroy(Site $site)
    {
        $id = $site->id;
        $site = Site::find($id);
        if($site){
            $site->status = 0;
            $site->save();
        }
        return response()->json(['status'=>'Data Deleted SuccessFully']);
    }

    public function siteList()
    {
        $site = Site::where('status',1)->get();
        return view('admin.sites.sitelist',compact('site'));
    }
    public function checkSite(Request $request){
        $request->session()->flush('siteval');
        $session_site_val = $request->id; 
        $request->session()->put('siteval',$session_site_val);
        $siteval = $request->session()->get('siteval');
        //dd($siteval);
        return response()->json(['response'=> $siteval]);
    }
}
