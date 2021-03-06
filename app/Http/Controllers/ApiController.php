<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Site;
use App\Models\SerialNumber;
use App\Models\SerialNumbersLogs;
use Illuminate\Support\Facades\Validator; 
use Session;

class ApiController extends Controller
{
    public function uploadSerialNumber(Request $request){
        $rules = [
            'serial_number' => 'required',
            'site_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        $data = $validator->messages();
            $final_data = [];
            if($data){
                foreach($data->messages() as $key => $v){
                    $data = array(                                      
                        $key => $v[0]
                    );
                    $final_data[$key] = $v[0];
                }
            }
            if($validator->fails()){
                 return response()->json([
                    'status' => false,
                    'data' => array(),
                    'message'=>$final_data
                ]);
            }else{
                $siteval = $request->site_id;
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
                        return response()->json([
                                'success' => true,
                                'serial_number_data' => $r,
                                'serial_number_logs_data' => $serial_no_log, 
                                'message' => 'Data Check SuccessFully'
                            ]);
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
                        $sr_number_logs_data = SerialNumbersLogs::where('site_id',$site_id)->where('serial_number_id',$serial_number_id)->get()->toArray();
                        return response()->json([
                            'success' => true,
                            'serial_number_data' => $r,
                            'serial_number_logs_data' => $sr_number_logs_data,
                            'message' => 'Data Save SuccessFully'
                        ]);
                    }
                }else{
                    return response()->json([
                        'success' => false,
                        'message' => 'Serial Number Not Found'
                    ]);
                }
            }
        }
    }
