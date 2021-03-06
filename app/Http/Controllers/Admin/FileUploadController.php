<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FileUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Hash;
use DataTables;
use Session;

class FileUploadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.files.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function getFileList(Request $request , FileUpload $fileupload){
        $data = $fileupload->getData();
        return \DataTables::of($data)
            ->addColumn('Actions', function($data) {
                $actionBtn = "<a href='' data-id='".$data->id."' data-method='delete' class='delete btn btn-danger btn-sm' id='delete'>Delete</a>";
                return $actionBtn;
            })
            ->rawColumns(['Actions'])
            ->make(true);
    }
    public function create()
    {
        return view('admin.files.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $siteid = $request->session()->get('siteval');
        if($siteid){
            $file = time().'.'.request()->file->getClientOriginalExtension();
            $request->file->move(public_path('uploads'), $file);
            $fileupload = new FileUpload();
                $data = array(
                    'name' => $file,
                    'site_id' => $siteid,
                    'status' => 1,
                    'date_time' => date('Y-m-d H:i:s')
                );
            $fileupload = FileUpload::create($data);
            return redirect()->route('files.index')->with('success','Data Save SuccessFully');
        }else{
            return redirect()->route('sites.index');
        }
            
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FileUpload  $fileUpload
     * @return \Illuminate\Http\Response
     */
    public function show(FileUpload $fileUpload)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FileUpload  $fileUpload
     * @return \Illuminate\Http\Response
     */
    public function edit(FileUpload $fileupload)
    {
        $id = $fileupload->id;
        if($id){
            $fileupload['id'] = $id;
            $fileupload = FileUpload::find($id);
        }
        return view('admin.files.add',compact('fileupload'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FileUpload  $fileUpload
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FileUpload $fileupload)
    {
        $id = $request['id'];
        if($id){
            $fileupload = FileUpload::find($id);
            $file = time().'.'.request()->file->getClientOriginalExtension();
                $request->file->move(public_path('uploads'), $file);
                $fileupload = new FileUpload();
                $data = array(
                    'name' => $file,
                    'site_id' => $siteid,
                    'status' => 1,
                    'date_time' => date('Y-m-d H:i:s')
                );
            $fileupload->update($data);
        }
        
        return redirect()->route('files.index')->with('success','Data Updated SuccessFully');    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FileUpload  $fileUpload
     * @return \Illuminate\Http\Response
     */
    public function destroy(FileUpload $fileupload)
    {
        $id = $fileupload->id;
        $fileupload = FileUpload::find($id);
        if($fileupload){
            $fileupload->status = 0;
            $fileupload->save();
        }
        return response()->json(['status'=>'Data Deleted SuccessFully']);
    }
}
