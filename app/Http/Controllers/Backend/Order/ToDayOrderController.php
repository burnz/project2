<?php
/**
 * Created by PhpStorm.
 * User: huydk
 * Date: 11/30/2017
 * Time: 4:23 PM
 */

namespace App\Http\Controllers\Backend\Order;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ToDayOrderController extends Controller
{
    public function show(){
        $arrayVirtualAcc = explode(',',config('app.virtual_account'));
        return view('adminlte::backend.order.todayorder');
    }

    public function getToDayDataOrder(){
        // storing  request (ie, get/post) global array to a variable
        $requestData= $_REQUEST;

        $columns = array(
        // datatable column index  => database column name
            0 => 'name',
            1 => 'amount',
            2 => 'price',
            3 => 'total',
            4 => 'status',
            5 => 'created_at'
        );

        $count = DB::table("order_lists as a")->count();
        // getting total number records without any search
        $totalData = $count;
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        $sql = DB::table("order_lists as a")
            ->select('b.name','a.amount','a.price','a.total','a.status','a.created_at')
            ->join('users as b', 'b.id', '=', 'a.user_id');

            //bản thân cần tìm gì ở đây


// getting records as per search parameters
        if( !empty($requestData['columns'][0]['search']['value']) ){   //name
            $sql = $sql->where('b.name', 'like', '%'.$requestData['columns'][0]['search']['value'].'%');
        }
        if( !empty($requestData['columns'][1]['search']['value']) ){  //salary
            $sql = $sql->where('a.amount',$requestData['columns'][1]['search']['value'] );
        }
        if( !empty($requestData['columns'][2]['search']['value']) ){ //age
            $sql = $sql->where('a.price',$requestData['columns'][2]['search']['value'] );
        }
        if( !empty($requestData['columns'][3]['search']['value']) ){ //age
            $sql = $sql->where('a.total',$requestData['columns'][3]['search']['value'] );
        }
        if( !empty($requestData['columns'][4]['search']['value']) ){ //age
            $sql = $sql->where('a.status',$requestData['columns'][4]['search']['value'] );
        }
        if( !empty($requestData['columns'][5]['search']['value']) ){ //age
            $sql = $sql->whereDate('date(a.created_at)',$requestData['columns'][5]['search']['value'] );
        }

        $totalFiltered = $sql->count(); // when there is a search parameter then we have to modify total number filtered rows as per search result.

        $sql = $sql->orderBy($columns[$requestData['order'][0]['column']],$requestData['order'][0]['dir']);
        $sql = $sql->skip($requestData['start'])->take($requestData['length']);

        $data = array();
        $data = $sql->get();
        $tmp = array();

        foreach ($data as $key => $value) {
            $nestedData=array();
            // $nestedData[] = $value->unapproved_created_at;
            $nestedData[] = $value->name;
            $nestedData[] = $value->amount;
            $nestedData[] = $value->price;
            $nestedData[] = $value->total;


            if (Carbon::now()->format('Y-m-d') === Carbon::parse($value->created_at)->format('Y-m-d')){
                if($value->status == self::CANCEL){
                    $nestedData[] = '<b><strong>Canceled</strong></b>';
                } elseif($value->status == self::SUCCESS){
                    $nestedData[] = '<b style="color: green"><strong>Success</strong></b>';
                } else {
                    $nestedData[] = '<b style="color: orange"><strong>Processing</strong></b>';
                }
            } else {
                $nestedData[] = '<b><strong>Canceled</strong></b>';
            }
            $nestedData[] = $value->created_at;

            // $deltail = "data-ot-register-id=".$value->ot_register_id." "."data-id-usercreat=".$value->usercreat;
            $tmp[] = $nestedData;
        }

        $json_data = array(
            "draw"            => intval( $requestData['draw'] ),
            "recordsTotal"    => intval( $totalData ),
            "recordsFiltered" => intval( $totalFiltered ),
            "data"            => $tmp
        );

        echo json_encode($json_data);
    }
}