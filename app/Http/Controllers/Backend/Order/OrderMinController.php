<?php

namespace App\Http\Controllers\Backend\Order;

use Illuminate\Http\Request;
use App\OrderMin;
use App\Http\Controllers\Controller;

class OrderMinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $order=OrderMin::paginate(10);
        return view('adminlte::backend.order.orderminprice',compact('order'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('adminlte::backend.order.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->isMethod("post")) {

            //action add a new
            $this->validate($request, [
                'price'=>'required|numeric',
                'date'=>'required'
            ]);
            //category ??
            $checkDate = OrderMin::whereDate('order_date',$request->date)->first();
            if($request->price < 0){
                $request->session()->flash( 'errorMessage',
                    "Min không được nhỏ hơn 0 !" );
                return redirect()->back();
            }
            if(count($checkDate)>0){
                $request->session()->flash( 'errorMessage',
                    "Đã tồn tại ngày này nhé !" );
                return redirect()->back();
            }
            $order = new OrderMin();
            $order->price = $request->price;
            $order->order_date = $request->date;
            if($order->save()){
                $request->session()->flash( 'successMessage',
                    trans("adminlte_lang::news.success") );
            }else{
                $request->session()->flash( 'errorMessage',
                    trans("adminlte_lang::news.error") );
            }

            return redirect('ordermin');
        }

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
        //get data news
        $order = OrderMin::where('id',$id)->first();

        return view('adminlte::backend.order.edit',["order"=>$order]);
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
        if ( $request->isMethod("put") ) {
            $this->validate($request, [
                'price'=>'required|numeric'
            ]);
            //category ??
            $dataInsert = [
                'price' => $request->price,
            ];
            if( OrderMin::where('id',$id)
                ->update($dataInsert) ){
                $request->session()->flash( 'successMessage',
                    trans("adminlte_lang::news.success_update") );
            }else{
                Log::error("Cannot edit");
                $request->session()->flash( 'errorMessage',
                    trans("adminlte_lang::news.error_update") );
            }
            return redirect('ordermin');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
