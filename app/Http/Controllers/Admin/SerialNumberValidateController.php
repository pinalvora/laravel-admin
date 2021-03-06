<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Site;
use App\Models\SerialNumber;
use App\Models\SerialNumberValidate;
use App\Models\SerialNumbersLogs;

class SerialNumberValidateController extends Controller
{
    public function list()
    {
        $siteval = Session()->get('siteval');
        if($siteval != null){
            return view('admin.serialnumber.activeserialnumber');
        }else{
            return redirect()->route('dashboard')->with('error','Please Selected Site');
        } 
    }
    public function index()
    {
        return view('admin.serialnumber.checkserialnumber');
    }
    public function store(Request $request)
    {   
        $siteval = Session()->get('siteval');
        $serial_no = $request->serial_number;
        $data = SerialNumber::where('serial_number',$serial_no)->where('site_id',$siteval)->where('status',1)->first();
        if($data !== null){
        $is_validated = $data->is_validated;
        $id = $data->id;
        
        if($is_validated == 0){
            if($id){
                    $counter = $data->validate_count;
                    $total = $counter + 1;
                    $serial_number_id = $data->id;
                    $site_id = $data->site_id;
                    $store_data = SerialNumber::find($id);
                            $r = array(
                                'is_validated' => 1,
                                'validate_count' => $total,
                                'validated_on' => date('Y-m-d H:i:s')
                            );
                    $store_data->update($r);
                    $insertedId = $store_data->id;
                    $serial_no_log = SerialNumbersLogs::where('serial_number_id',$id)->get()->toArray();
                        if($serial_no_log){
                            $store_logs_data = new SerialNumbersLogs();
                                    $v = array(
                                        'serial_number_id' => $id,
                                        'site_id' =>  $siteval,
                                        'validated_on' => 0,
                                        'created_on' => date('Y-m-d H:i:s')
                                    );
                            $store_logs_data = SerialNumbersLogs::create($v);
                        }else{
                            $store_logs_data = new SerialNumbersLogs();
                                    $v = array(
                                        'serial_number_id' => $id,
                                        'site_id' =>  $siteval,
                                        'validated_on' => 1,
                                        'created_on' => date('Y-m-d H:i:s')
                                    );
                            $store_logs_data = SerialNumbersLogs::create($v);
                    }
                }
                return redirect()->route('activeSerialNumber')->with('success','Data Check SuccessFully');
            }
            if($is_validated == 1){
                    $counter = $data->validate_count;
                    $total = $counter + 1;
                    $serial_number_id = $data->id;
                    $site_id = $data->site_id;
                    $store_data = SerialNumber::find($id);
                            $r = array(
                                'is_validated' => 1,
                                'validate_count' => $total,
                                'validated_on' => date('Y-m-d H:i:s')
                            );
                    $store_data->update($r);
                    $store_logs_data = new SerialNumbersLogs();
                        $v = array(
                            'serial_number_id' => $serial_number_id,
                            'site_id' =>  $siteval,
                            'validated_on' => 0,
                            'created_on' => date('Y-m-d H:i:s')
                        );
                    $store_logs_data = SerialNumbersLogs::create($v);
                    return redirect()->route('activeSerialNumber')->with('success','Data Save SuccessFully');
                }
            }else{
                return redirect()->route('activeSerialNumber')->with('error','Serial Number Not Found');
            }
    }
    public function getSerialNumberList(Request $request)
    {
        $siteval = $request->session()->get('siteval');
        $data = SerialNumber::where('site_id',$siteval)->where('status',1)->where('is_validated',1)->get();
        return \DataTables::of($data)
            ->addColumn('validate_count', function($data) {
                $count = "<span class='badge' style='font-size:14px;margin-left: 80px;background-color:#033A71;color:white;'>".$data->validate_count."</span>";
                return $count;
            })
            ->addColumn('validate_on', function() {
                $icon = "<i class='fa fa-check' style='color:green;font-size:20px;margin-left: 80px;'></i>";
                return $icon;
            })
            ->addColumn('Actions', function($data) {
                $actionBtn = "<a href='".route('checkSerialNumber/show',$data['id'])."' class='view btn btn-default btn-sm'><i class='fas fa-eye'> View</i></a>
                    <a href='' data-id='".$data->id."' data-method='delete' class='delete btn btn-default btn-sm' id='delete'><i class='fas fa-trash'>  Delete</i></a>"; 
                return $actionBtn;
            })
            ->rawColumns(['validate_count','validate_on','Actions'])
            ->make(true);
    }
    public function show(Request $request){
       $id = $request->id;
       $serial_numbers = SerialNumber::where('id',$id)->first();
       return view('admin.serialnumber.view',compact('serial_numbers'));
    }
    public function destroy(Request $request)
    {
        $id = $request->id;
        $serial_no = SerialNumber::find($id);
        if($serial_no){
            $serial_no->status = 0;
            $serial_no->save();
            $serial_no_log_data = SerialNumbersLogs::whereIn('serial_number_id',explode(",",$id))->delete();
        }
        return response()->json(['status'=>'Data Deleted SuccessFully']);
    }
    public function getLogList(Request $request){
        $serial_no = $request->input('sr_no');
        $siteval = $request->session()->get('siteval');

        $sites = Site::where('id',$siteval)->where('status',1)->get();
        $ip_address = $sites[0]['ip_address'];

        $serial_no_data = SerialNumber::where('site_id',$siteval)->where('serial_number',$serial_no)->where('status',1)->get()->toArray();
        $id = $serial_no_data[0]['id'];

        $data = SerialNumbersLogs::join('sites_tbl','sites_tbl.id','=','serial_numbers_logs_tbl.site_id')
                            ->join('serial_numbers_tbl','serial_numbers_tbl.id','=','serial_numbers_logs_tbl.serial_number_id')
                            ->where('serial_numbers_logs_tbl.site_id',$siteval)
                            ->where('serial_numbers_logs_tbl.serial_number_id',$id)
                            ->get(['serial_numbers_logs_tbl.*','sites_tbl.ip_address as ip_address','serial_numbers_tbl.serial_number as serial_number']);
        return \DataTables::of($data)
            ->addColumn('validate_on', function($data) {
                if($data['validated_on'] == 1){
                    $icon = "<i class='fa fa-check' style='color:green;font-size:20px;margin-left: 80px;'></i>";
                    return $icon;
                }else{
                    $icon = "<i class='fa fa-times' style='color:red;font-size:20px;margin-left: 80px;'></i>";
                    return $icon;
                }
            })
            ->rawColumns(['validate_on'])
            ->make(true);
    }
}
