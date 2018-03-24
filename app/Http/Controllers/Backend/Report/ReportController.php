<?php

namespace App\Http\Controllers\Backend\Report;

use App\Authorizable;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Backend\Report\RepoReportController;
use Illuminate\Http\Request;
use App\UserData;

class ReportController extends Controller{

    use Authorizable;

    public function __construct(RepoReportController $repo)
    {
        $this->middleware('auth');
        $this->repo = $repo;
    }

    public function getDataReport(Request $request){
        if ( $request->type && $request->opt && $request->from_date && $request->to_date ) {
            $type = $request->type;
            $opt = $request->opt;
            $dateCustom['from_date'] = $request->from_date;
            $dateCustom['to_date'] = $request->to_date;
        } else {
            $type = 2;
            $opt = 1;
            $dateCustom = ['from_date' => $this->repo->getDateNow(), 'to_date' => $this->repo->getDateNow()];
        }
        
        $dada = $this->repo->action($type,$opt,$dateCustom);
        return view('adminlte::backend.report.member',['data'=>$dada]);
    }

    public function getDataCommissionReport(Request $request){
        if ( $request->opt && $request->from_date && $request->to_date ) {
            $opt = $request->opt;
            $dateCustom['from_date'] = $request->from_date;
            $dateCustom['to_date'] = $request->to_date;
        } else {
            $opt = 1;
            $dateCustom = ['from_date' => $this->repo->getDateNow(), 'to_date' => $this->repo->getDateNow()];
        }

        $dada = $this->repo->action_commission($opt,$dateCustom);
        return view('adminlte::backend.report.commission.index',['data'=>$dada]);
    }

    public function getDataCommissionReportUSD(Request $request){
        if ( $request->opt && $request->from_date && $request->to_date ) {
            $opt = $request->opt;
            $dateCustom['from_date'] = $request->from_date;
            $dateCustom['to_date'] = $request->to_date;
        } else {
            $opt = 1;
            $dateCustom = ['from_date' => $this->repo->getDateNow(), 'to_date' => $this->repo->getDateNow()];
        }

        $dada = $this->repo->action_commission_usd($opt,$dateCustom);
        return view('adminlte::backend.report.commission.usd',['data'=>$dada]);
    }

    public function getRankList(Request $request)
    {
        $loyaltyIdList = UserData::where('loyaltyId', '>', 0)->get();
        //get Name
        $data = ['Sapphire' => '', 'Emerald' => '', 'Diamond' => '', 'Blue Diamond' => '', 'Black Diamond' => ''];
        foreach($loyaltyIdList as $loyal)
        {
            if($loyal->loyaltyId == 1) $data['Sapphire'] .= $loyal->user->name . ', ';
            if($loyal->loyaltyId == 2) $data['Emerald'] .= $loyal->user->name . ', ';
            if($loyal->loyaltyId == 3) $data['Diamond'] .= $loyal->user->name . ', ';
            if($loyal->loyaltyId == 4) $data['Blue Diamond'] .= $loyal->user->name . ', ';
            if($loyal->loyaltyId == 5) $data['Black Diamond'] .= $loyal->user->name . ', ';
        }

        return view('adminlte::backend.report.rank_list',['data'=>$data]);
    }

}
