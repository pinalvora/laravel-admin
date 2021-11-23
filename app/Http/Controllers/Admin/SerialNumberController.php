<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\SerialNumberExport;
use App\Imports\SerialNumberImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use App\Models\Site;
use App\Models\SerialNumber;
use App\Models\SerialNumberValidate;
use App\Models\SerialNumbersLogs;
use Session;


class SerialNumberController extends Controller
{
    public function importExportView()
    {
        $siteval = Session()->get('siteval');
        if($siteval != null){
            return view('admin.serialnumber.import');
        }else{
            return redirect()->route('dashboard')->with('error','Please Selected Site');
        } 
    }
    public function export(Request $request) 
    {
       return Excel::download(new SerialNumberExport, 'serialnumbers.xlsx');
    }
    public function import(Request $request) 
    {
        $siteval = Session()->get('siteval');
        $data = Site::where('id',$siteval)->get()->toArray();
        Excel::import(new SerialNumberImport,request()->file('file'));
             
        return redirect()->route('getserialnumbers')->with('success','Data Import SuccessFully');;
    }
    public function getFile(){
        $siteval = Session()->get('siteval');
        if($siteval != null){
            return view('admin.serialnumber.list');
        }else{
            return redirect()->route('dashboard')->with('error','Please Selected Site');
        } 
    }
    public function getSiteList(Request $request){
        if ($request->ajax()) {
            $siteval = Session()->get('siteval');
            $columns = array( 
                            0 =>'id', 
                            1 =>'serial_number',
                            2 =>'Actions'
                        );
            $totalData = SerialNumber::where('site_id',$siteval)->where('status',1)->count();
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');

            if(empty($request->input('search.value')))
            {     
                $articles = SerialNumber::offset($start)
                                        ->limit($limit)
                                        ->orderBy($order,$dir)
                                        ->where('site_id',$siteval)
                                        ->where('status',1)
                                        ->get();

            }else {
                $get_search = $request->input('search.value'); 

                $articles =  SerialNumber::where('id','LIKE',"%{$get_search}%")
                            ->orWhere('serial_number', 'LIKE',"%{$get_search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->where('site_id',$siteval)
                            ->where('status',1)
                            ->get();

                $totalFiltered = SerialNumber::where('id','LIKE',"%{$get_search}%")
                             ->orWhere('serial_number', 'LIKE',"%{$get_search}%")
                             ->count();
            }
        $data = array();
        if(!empty($articles))
        {
            foreach ($articles as $page)
            {
               /* $show =  route('articles.show',$page->id);
                $edit =  route('articles.edit',$page->id);*/

                $customResult['id'] = $page->id;
                $customResult['serial_number'] = $page->serial_number;
                $customResult['Actions'] = "<a href='".route('getserialnumbers/edit',$page->id)."' class='edit btn btn-default btn-sm'><i class='fas fa-edit'> Edit</i></a>
                        <a href='' data-id='".$page->id."' data-method='delete' class='delete btn btn-default btn-sm' id='delete'><i class='fas fa-trash'>  Delete</i></a>";

                $data[] = $customResult;
            }
        }
        $json_data = array(
                "draw"            => intval($request->input('draw')),  
                "recordsTotal"    => intval($totalData),  
                "recordsFiltered" => intval($totalFiltered), 
                "data"            => $data   
                );
       // dd($json_data);
        
        echo json_encode($json_data);
    }
        /*if ($request->ajax()) {
            $start = $request->start;
            $length = $request->length;
            $data = SerialNumber::offset($start)->limit($length)->get();
            $serial_no = new SerialNumber();
            $data = $serial_no->getData();
            return \DataTables::of($data)
                ->addColumn('Actions', function($data) {
                    $actionBtn = "
                        <a href='' data-id='".$data->id."' data-method='delete' class='delete btn btn-danger btn-sm' id='delete'>Delete</a>";
                    return $actionBtn;
                })
                ->rawColumns(['Actions'])
                ->make(true);
        }*/
    }
    public function edit($id){
        if($id){
            $serial_no['id'] = $id;
            $serial_no = SerialNumber::find($id);
        }
        return view('admin.serialnumber.edit',compact('serial_no'));
    }
    public function update(Request $request)
    {
        $id = $request['id'];
        $siteval = Session()->get('siteval');
        if($id){
            $serial_no = SerialNumber::find($id);
            $data = array(
                'serial_number' => $request->serial_number,
                'site_id' => $siteval,
                'status' => $request->status
            );
        }
        $serial_no->update($data);
        return redirect()->route('getserialnumbers')->with('success','Data Updated SuccessFully');
    }
    public function destroy(Request $request){
        $id = $request->id;
        $serial_nubers = SerialNumber::find($id);
        $s_no = $serial_nubers->serial_number;
        $s_id = $serial_nubers->site_id;
        if($serial_nubers){
            $serial_nubers->status = 0;
            $serial_nubers->save();
        }
        $serial_numbers_validate = SerialNumberValidate::where('serial_number',$s_no)->where('site_id',$s_id)->first()->toArray();
        $count_table_id = $serial_numbers_validate['id'];
        $validate_id = SerialNumberValidate::find($count_table_id);

        if($validate_id){
            $validate_id->is_validated = 0;
            $validate_id->save();
        }
        return response()->json(['status'=>'Data Deleted SuccessFully']);
    }
}
