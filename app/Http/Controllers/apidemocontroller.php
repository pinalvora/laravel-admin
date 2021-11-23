public function site(Request $request){
        $site = Site::all();
        if($site){
            return response()->json([
                'success' => true,
                'data' => $site,
                'message' => 'Success'
            ]);
        }else{
            return response()->json([
                'success' => true,
                'data' => array(),
                'message' => 'Data Not Found'
            ]);
        }   
    } 
    public function getSerialNumber(Request $request){
        $rules = [
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
           $serial_no = SerialNumber::where('site_id',$siteval)->where('status',1)->get();
           return response()->json([
                'status' => true,
                'data' => $serial_no,
                'message'=> 'Success'
            ]);
        }
    }
    public function updateSerialNumber(Request $request){
        $id = $request->id;
        $rules = [
            'serial_number' => 'required',
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
                $serial_no = SerialNumber::find($id);
                $serial_no->serial_number = $request->serial_number;

                $serial_number_id = $serial_no->id;
                $site_id = $serial_no->site_id;

                $serial_no_count_data = SerialNumberValidate::where('serial_number_id',$serial_number_id)->where('site_id',$site_id)->where('is_validated',1)->get()->toArray();

                $serial_no_log_data = SerialNumbersLogs::where('serial_number_id',$serial_number_id)->where('site_id',$site_id)->get()->toArray();

                if($serial_no->update()){
                    return response()->json([
                        'status' => true,
                        'serial_number_data' => $serial_no->toArray(),
                        'serial_number_count_data' => $serial_no_count_data,
                        'serial_number_log_data' => $serial_no_log_data,
                        'message' => 'Your Data Updated SuccessFully'
                    ]);
                }else{
                    return response()->json([
                        'status' => false,
                        'data' => $serial_no->toArray(),
                        'message' => 'Data can not be updated'
                    ]);
                }
            }
        }
        public function destroySerialNumber(Request $request)
        {
            $id = $request->id;
            $serial_no = SerialNumber::find($id);
            if (!$serial_no){
                return response()->json([
                    'success' => false,
                    'message' => 'Data not found'
                ]);
            }
            if ($serial_no) {
                    $serial_no->status = 0;
                    $serial_no->save();
                    return response()->json([
                        'success' => true,
                        'data' => $serial_no->toArray(),
                        'message' => 'Data Successfully deleted'
                    ]);
            }else{
                return response()->json([
                    'success' => false,
                    'data' => $actor->toArray(),
                    'message' => 'Data can not be deleted'
                ]);
            }
        }
public function destroyCountSerialNumber(Request $request){
                $id = $request->id;
                $serial_no_count = SerialNumberValidate::find($id);
                $serial_no_count_id = $serial_no_count->id;

                if (!$serial_no_count){
                    return response()->json([
                        'success' => false,
                        'message' => 'Data not found'
                    ]);
                }
                if ($serial_no_count) {
                    $serial_no_count->is_validated = 0;
                    $serial_no_count->save();

                    $serial_no_log_data = SerialNumbersLogs::whereIn('serial_number_count_id',explode(",",$serial_no_count_id))->delete();
                    
                    return response()->json([
                        'success' => true,
                        'data' => $serial_no_count,
                        'message' => 'Data Successfully deleted'
                    ]);
                }else{
                    return response()->json([
                        'success' => false,
                        'data' => $serial_no_count,
                        'message' => 'Data can not be deleted'
                    ]);
                }
            }