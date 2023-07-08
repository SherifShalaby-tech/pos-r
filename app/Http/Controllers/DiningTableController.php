<?php

namespace App\Http\Controllers;

use App\Models\DiningRoom;
use App\Models\DiningTable;
use App\Models\TableReservation;
use App\Models\Transaction;
use App\Utils\Util;
use Carbon\Carbon;
use DateTime;
use DateTimeImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class DiningTableController extends Controller
{
    /**
     * All Utils instance.
     *
     */
    protected $commonUtil;

    /**
     * Constructor
     *
     * @param ProductUtils $product
     * @return void
     */
    public function __construct(Util $commonUtil)
    {
        $this->commonUtil = $commonUtil;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dining_tables = DiningTable::get();

        return view('dining_table.index')->with(compact(
            'dining_tables'
        ));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $from_setting = !empty(request()->from_setting) ? true : false;
        $dining_room = DiningRoom::find(request()->room_id);
        $dining_rooms = DiningRoom::pluck('name', 'id');

        return view('dining_table.create')->with(compact(
            'dining_room',
            'dining_rooms',
            'from_setting',
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:dining_tables,name',
            'dining_room_id' => 'required'
        ]);

        if ($validator->fails()) {
            $output = [
                'success' => false,
                'msg' => $validator->getMessageBag()->first()
            ];
            return $output;
        }
        try {
            $data = $request->only('name', 'dining_room_id');
            $data['status'] = 'available';
            $data['created_by'] =auth()->user()->id;
            $dining_table = DiningTable::create($data);
            TableReservation::create([
                'dining_table_id'=>$dining_table->id,
                'status'=>'available',
            ]);
            $output = [
                'success' => true,
                'dining_table_id' => $dining_table->id,
                'msg' => __('lang.success')
            ];
        } catch (\Exception $e) {
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('lang.something_went_wrong')
            ];
        }

        if ($request->ajax()) {
            return $output;
        }
        return redirect()->back()->with('status', $output);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $dining_rooms = DiningRoom::pluck('name', 'id');
        $dining_table = DiningTable::find($id);

        return view('dining_table.edit')->with(compact(
            'dining_rooms',
            'dining_table',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            ['name' => ['required', 'max:255']],
        );

        try {
            $data = $request->except('_token', '_method');

            DB::beginTransaction();
            DiningTable::where('id', $id)->update($data);


            DB::commit();
            $output = [
                'success' => true,
                'msg' => __('lang.success')
            ];
        } catch (\Exception $e) {
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('lang.something_went_wrong')
            ];
        }

        return redirect()->back()->with('status', $output);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $dining_table=DiningTable::find($id);
            $table_reserve=TableReservation::where('dining_table_id',$dining_table->id)->delete();
            $merge_tables=TableReservation::whereNotNull('merge_table_id')->get();
            if(!empty($merge_tables)){
                foreach($merge_tables as $mergeTable){
                    if(in_array($dining_table->id,$mergeTable->merge_table_id)){
                        DiningTable::find($mergeTable->dining_table_id)->delete();
                        $mergeTable->delete();
                    }
                }
            }
            $dining_table->delete();
            $output = [
                'success' => true,
                'msg' => __('lang.success')
            ];
        } catch (\Exception $e) {
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('lang.something_went_wrong')
            ];
        }

        return $output;
    }

    public function checkDiningTableName(Request $request)
    {
        $name = $request->name;

        $dining_table = DiningTable::where('name', $name)->first();

        if ($dining_table) {
            $output = [
                'success' => false,
                'msg' => __('lang.dining_table_name_already_exist')
            ];
            return $output;
        }
    }

    /**
     * get the table action modal
     *
     * @param int $id
     * @return void
     */
    public function getDiningAction(Request $request,$id)
    {
        $dining_table=TableReservation::where('dining_table_id',$id)->where(function($query){;
        if(!empty(request()->reservation_id)){
        $query->where('id',request()->reservation_id);
        }})->first();

        $status='';
        // $dining_table = DiningTable::find($table_reserve->dining_table_id);
        $status_array = ['order' => __('lang.order'), 'reserve' => __('lang.reserve')];
        if ($dining_table->status == 'reserve') {
            $status_array = ['order' => __('lang.order'), 'cancel_reservation' => __('lang.cancel_reservation')];
        }
        if(!empty($request->type) && $request->type=='edit_reserve'){
            $status='edit';
        }
        return view('sale_pos.partials.dining_table_action')->with(compact(
            'dining_table',
            'status_array',
            'status'
        ));
    }
    /**
     * update table data
     *
     * @param int $id
     * @return void
     */
    public function updateDiningTableData($id, Request $request)
    {
        $data = $request->except('_token');

        try {
            $table_status=TableReservation::where('dining_table_id',$id)->where(function($query){;
            if(!empty(request()->reservation_id)){
            $query->where('id',request()->reservation_id);
            }})->first();
            $dining_table = DiningTable::find($table_status->dining_table_id);
            if ($data['status'] == 'reserve') {
                if($table_status->status=='reserve'){
                    $new_reserve=TableReservation::create([
                        'dining_table_id'=>$dining_table->id,
                        'status'=>!empty($data['status']) ?$data['status']:'',
                        'customer_mobile_number'=>!empty($data['customer_mobile_number'])?$data['customer_mobile_number']:'',
                        'customer_name'=>!empty($data['customer_name']) ?$data['customer_name']:"",
                        'date_and_time'=>!empty($data['date_and_time'])?Carbon::createFromTimestamp(strtotime($data['date_and_time']))->format('Y-m-d H:i:s'):''
                    ]);
            }else{
                    // return $table_status;
                    if (!empty($data['customer_name'])) {
                        $table_status->customer_name = $data['customer_name'];
                    }
                    if (!empty($data['customer_mobile_number'])) {
                        $table_status->customer_mobile_number = $data['customer_mobile_number'];
                    }
                    if (!empty($data['status'])) {
                        $table_status->status = $data['status'];
                    }
                    if (!empty($data['date_and_time'])) {
                        $table_status->date_and_time = Carbon::createFromTimestamp(strtotime($data['date_and_time']))->format('Y-m-d H:i:s');
                    }
                    $table_status->save();
                }
            }
            if ($data['status'] == 'edit-reserve') {
                if (!empty($data['customer_name'])) {
                    $table_status->customer_name = $data['customer_name'];
                }
                if (!empty($data['customer_mobile_number'])) {
                    $table_status->customer_mobile_number = $data['customer_mobile_number'];
                }
                if (!empty($data['date_and_time'])) {
                    $table_status->date_and_time = Carbon::createFromTimestamp(strtotime($data['date_and_time']))->format('Y-m-d H:i:s');
                }
                $table_status->save();
            }
            if ($data['status'] == 'cancel_reservation') {
                $cancel_reserve_count=TableReservation::where('dining_table_id',$table_status->dining_table_id)->count();
                if($cancel_reserve_count>1){
                    $table_status->delete();
                }else{
                    $table_status->customer_name = null;
                    $table_status->customer_mobile_number = null;
                    $table_status->date_and_time = null;
                    $table_status->status = 'available';
                    $table_status->save();
                }

            }

            if ($data['status'] == 'another_reservation') {
                $new_reserve=TableReservation::create([
                    'dining_table_id'=>$dining_table->id,
                    'status'=>!empty($data['status']) ?'reserve':'',
                    'customer_mobile_number'=>!empty($data['customer_mobile_number'])?$data['customer_mobile_number']:'',
                    'customer_name'=>!empty($data['customer_name']) ?$data['customer_name']:"",
                    'date_and_time'=>!empty($data['date_and_time'])?Carbon::createFromTimestamp(strtotime($data['date_and_time']))->format('Y-m-d H:i:s'):''
                ]);
            }
            

            $output = [
                'success' => true,
                'msg' => __('lang.success')
            ];
        } catch (\Exception $e) {
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('lang.something_went_wrong')
            ];
        }

        return $output;
    }

    /**
     * get the table details
     *
     * @param int $id
     * @return void
     */
    public function getTableDetails($id,Request $request)
    {
        $table_status=TableReservation::where('dining_table_id',$id)->first();
        // return $table_status->status;
        $dining_table = DiningTable::find($table_status->dining_table_id);
        $dining_room = DiningRoom::find($dining_table->dining_room_id);
        $status_array = ['order' => __('lang.order'), 'reserve' => __('lang.reserve')];
        if ($table_status->status == 'reserve' || ($table_status->status=='available'&& $request->status=='reserve')) {
            $status_array = ['order' => __('lang.order'),'reserve' => __('lang.reserve')];
        }
        return [
            'dining_table' => $dining_table,
            'dining_room' => $dining_room,
            'status_array'=> $status_array,
            'table_status'=>$table_status
        ];
    }

    /**
     * get dropdown by dining room
     *
     * @param int $id
     * @return void
     */
    public function getDropdownByDiningRoom($id)
    {
        $dining_tables = DiningTable::where('dining_room_id', $id)->pluck('name', 'id');

        return $this->commonUtil->createDropdownHtml($dining_tables, __('lang.all'));
    }
    public function checkTimeRserveAvailability($id,Request $request){
        // $table_status=TableReservation::where('dining_table_id',$id)->first();
        if(!empty($request->old_value)&& $request->old_value==true){
            $all_table_reservation = TableReservation::where('dining_table_id',$id)->where('id','!=',$request->reservation_id)->get();
        }else{
            $all_table_reservation = TableReservation::where('dining_table_id',$id)->get();
        }
        $originalTime = new DateTimeImmutable(Carbon::createFromTimestamp(strtotime($request->date_and_time))->format('Y-m-d H:i:s'));
        $isMoreHour=true;
        
        foreach($all_table_reservation as $table){
            if(isset($table->date_and_time)){
            $targedTime = new DateTimeImmutable($table->date_and_time);
            $interval = $originalTime->diff($targedTime);
            $diff= $interval->format("%H:%I:%S");
            if($diff >= "01:00:00"){
                $isMoreHour=true;
            }else{
                $isMoreHour=false;
            }
        }
        }
        if($isMoreHour){
            return response()->json(['msg'=>'ok']);
        }else{
            return response()->json(['msg'=>__('lang.this_time_is_not_available')]);
        }
    }
    public function mergeTable(Request $request,$id)
    {
        $table=TableReservation::where('dining_table_id',$id)->where('status','order')->first();
        if(!empty($table)){
            $transactionForThisTable=Transaction::where('dining_table_id',$table->dining_table_id)->where('status','!=','canceled')->latest()->first();
        }
        // $transactionForThisTable=Transaction::find(75);
        if(!empty($transactionForThisTable)){
            
            return $transactionForThisTable->transaction_sell_lines;
        }else{
            return 'No Product Added';
        }
        
    }
    public function editReservationTableData($id)
    {
        $data=TableReservation::find($id);
        return $data;
    }
    public function getTableNewAdditions()
    {
        return DiningTable::where('is_new','new')->count();
    }
    public function readNewTables()
    {
        DiningTable::where('is_new','new')->update([
            'is_new'=>'old'
        ]);
    }
    public function getTablesForMerge($room_id)
    {
        $tables=DiningTable::with('table_reservations')->whereRelation('table_reservations','merge_table_id',null)->where('dining_room_id',$room_id)->pluck('name', 'id');
        $html = '';
        // if (!empty($append_text)) {
            $html = '<option value="">' . __('lang.please_select') . '</option>';
        // }
        foreach ($tables as $key => $value) {
            $html .= '<option value="' . $key . '">' . $value . '</option>';
        }
        return $html;
    }
}
