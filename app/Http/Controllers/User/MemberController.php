<?php

namespace App\Http\Controllers\User;

use App\UserData;
use Illuminate\Http\Request;

use App\User;
use App\BonusBinary;
use App\UserPackage;
use App\LoyaltyUser;
use Auth;
use Session;
use App\UserTreePermission;
use App\Http\Controllers\Controller;
use App\BonusBinaryInterest;
use App\Tickets;
use Carbon\Carbon;

class MemberController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index(){
       return view('adminlte::members.genealogy');
    }
    
    public function genealogy(Request $request)
    {
        if($request->ajax()){
            if(isset($request['action'])) {
                if($request['action'] == 'getUser') {
                    if(isset($request['username']) && $request['username'] != '') {
                        $user = Auth::user();
                        $lstGenealogyUser = [];
                        if($userTreePermission = $user->userTreePermission)
                            $lstGenealogyUser = explode(',', $userTreePermission->genealogy);

                        if(is_numeric($request['username'])){
                            $user = User::where('uid', '=', $request['username'])->first();
                        }else{
                            $user = User::where('name', '=', $request['username'])->first();
                        }

                        if($user && $lstGenealogyUser && (in_array($user->id, $lstGenealogyUser) || $user->id == Auth::user()->id)) {
                            $fields = [
                                'id'     => $user->id,
                                'uid'     => $user->uid,
                                'u'     => $user->name,
                                'totalMembers' => $user->userTreePermission ? $user->userTreePermission->genealogy_total : 0,
                                'packageId'     => $user->userData->packageId,
                                'ticket'     => $this->ticketSale($user->id),
                                'leg'     => $user->userData->leftRight == 'left' ? 'L' : ($user->userData->leftRight == 'right' ? 'R' : '-'),
                                'dmc' => $user->userTreePermission && $user->userTreePermission->genealogy_total ? 1 : 0,
                                'generation'     => $this->getQualify($user->userData->packageId),
                            ];
                        } else {
                            return response()->json(['err'=>1]);
                        }
                    } else {
                        $user = Auth::user();
                        $fields = [
                            'id'     => $user->id,
                            'uid'     => $user->uid,
                            'u'     => $user->name,
                            'totalMembers' => $user->userTreePermission ? $user->userTreePermission->genealogy_total : 0,
                            'packageId'     => $user->userData->packageId,
                            'ticket'     => $this->ticketSale($user->id),
                            'leg'     => $user->userData->leftRight == 'left' ? 'L' : ($user->userData->leftRight == 'right' ? 'R' : '-'),
                            'dmc' => 3,
                            'totalAmount'=>UserPackage::getTotalAmount(Auth::user()->id),
                            'generation'     => $this->getQualify($user->userData->packageId),
                        ];
                    }
                    return response()->json($fields);
                } elseif ($request['action'] == 'getChildren') {
                    $currentuserid = Auth::user()->id;
                    $user = Auth::user();
                    $lstGenealogyUser = [];
                    if($userTreePermission = $user->userTreePermission)
                        $lstGenealogyUser = explode(',', $userTreePermission->genealogy);
                    $fields = array();
                    if(isset($request['id']) && $request['id'] > 0 && (($lstGenealogyUser && in_array($request['id'], $lstGenealogyUser)) || $currentuserid == $request['id']) ){
                        $userDatas = UserData::where('refererId', $request['id'])->get();
                        $fields = array();
                        foreach ($userDatas as $userData) {
                            $fields[] = [
                                'id' => $userData->userId,
                                'uid'     => $userData->user->uid,
                                'u' => $userData->user->name,
                                'totalMembers' => $userData->userTreePermission ? $userData->userTreePermission->genealogy_total : 0,
                                'packageId' => $userData->packageId,
                                'ticket' => $this->ticketSale($userData->userId),
                                'leg' => $userData->leftRight == 'left' ? 'L' : ($userData->leftRight == 'right' ? 'R' : '-'),
                                'dmc' => $userData->userTreePermission && $userData->userTreePermission->genealogy_total ? 1 : 0,
                                'totalAmount'=>UserPackage::getTotalAmount($userData->userId),
                                'generation'     => $this->getQualify($userData->packageId),
                            ];
                        }
                    }
                    return response()->json($fields);
                } else {
                    return response()->json(['err'=>1]);
                }
            } else {
                return response()->json(['err'=>1]);
            }
        }
        return view('adminlte::members.genealogy');
    }

    public function getQualify($packageId) {
        $result = '0';
        if($packageId > 0) $result = 'F1';
        if($packageId > 2) $result = 'F2';
        if($packageId > 4) $result = 'F3';

        return $result;
    }

    public function ticketSale($userId) {
        //
        $weeked = date('W');
        $year = date('Y');
        $weekYear = $year.$weeked;

        $oTicket = Tickets::where('user_id', $userId)->where('week_year', $weekYear)->first();

        return isset($oTicket) ? $oTicket->personal_quantity : 0;
    }
    
    public function binary(Request $request){
        $currentuserid = Auth::user()->id;
        $weeked = date('W');
        $year = date('Y');
        $weekYear = $year.$weeked;

        if($request->ajax()){
            if(isset($request['id']) && $request['id'] > 0) {
                $user = User::find($request['id']);
                $lstBinaryUser = [];
                if ($userTreePermission = Auth::user()->userTreePermission)
                    $lstBinaryUser = explode(',', $userTreePermission->binary);
                if ($user && (($lstBinaryUser && in_array($request['id'], $lstBinaryUser)) || Auth::user()->id == $request['id'])) {
                    $childLeft = UserData::where('binaryUserId', $user->id)->where('leftRight', 'left')->first();
                    $childRight = UserData::where('binaryUserId', $user->id)->where('leftRight', 'right')->first();
                    $weeklySale = self::getWeeklySale($user->id);

                    //calculator infinity interest
                    $ifLeft=$ifRight=0;
                    $infinityInterest=BonusBinaryInterest::where('userId',$user->id)->where('weekYear',$weekYear)->first();
                    if($infinityInterest)
                    {
                        $ifLeft = $infinityInterest->leftNew + $infinityInterest->leftOpen;
                        $ifRight = $infinityInterest->rightNew + $infinityInterest->rightOpen;
                    }

                    //$weeklySale=$this->getTotalSale($user->id);
                    $fields = [
                        'lvl' => 0,
                        'id' => $user->id,
                        'name' => $user->name,
                        'parentID' => $user->userData->binaryUserId,
                        'childLeftId' => $childLeft ? $childLeft->userId : 0,
                        'childRightId' => $childRight ? $childRight->userId : 0,
                        'level' => 0,
                        'weeklySale' => number_format(self::getBV($user->id)),
                        'left' => number_format($weeklySale['left'], 2),
                        'right' => number_format($weeklySale['right'], 2),
                        'packageId' => $user->userData->packageId,
                        'pkg' => 2000,
                        'lMembers' => $user->userData->leftMembers,
                        'rMembers' => $user->userData->rightMembers,
                        'posi'=>$user->userData->leftRight,
                        'ifLeft'=>number_format($ifLeft,3),
                        'ifRight'=>number_format($ifRight,3)
                    ];
                    $children = self::getBinaryChildren($user->id);
                    if ($children) {
                        $fields['children'] = $children;
                    }
                    return response()->json($fields);
                } else {
                    return response()->json(['err' => 1]);
                }
            }elseif (isset($request['action']) && $request['action'] == 'getUser'){
                if(is_numeric($request['username'])){
                    $user = User::where('uid', '=', $request['username'])->first();
                }else{
                    $user = User::where('name', '=', $request['username'])->first();
                }
                $lstBinaryUser = [];
                if ($userTreePermission = Auth::user()->userTreePermission)
                    $lstBinaryUser = explode(',', $userTreePermission->binary);

                if ($user && (($lstBinaryUser && in_array($user->id, $lstBinaryUser)) || Auth::user()->id == $user->id)) {
                    $childLeft = UserData::where('binaryUserId', $user->id)->where('leftRight', 'left')->first();
                    $childRight = UserData::where('binaryUserId', $user->id)->where('leftRight', 'right')->first();
                    $weeklySale = self::getWeeklySale($user->id);
                    //$weeklySale=$this->getTotalSale($user->id);
                    //calculator infinity interest
                    $ifLeft=$ifRight=0;
                    $infinityInterest=BonusBinaryInterest::where('userId',$user->id)->where('weekYear',$weekYear)->first();
                    if($infinityInterest)
                    {
                        $ifLeft = $infinityInterest->leftNew + $infinityInterest->leftOpen;
                        $ifRight = $infinityInterest->rightNew + $infinityInterest->rightOpen;
                    }
                    $fields = [
                        'lvl' => 0,
                        'id' => $user->id,
                        'name' => $user->name,
                        'parentID' => $user->userData->binaryUserId,
                        'childLeftId' => $childLeft ? $childLeft->userId : 0,
                        'childRightId' => $childRight ? $childRight->userId : 0,
                        'level' => 0,
                        'weeklySale' => number_format(self::getBV($user->id)),
                        'left' => number_format($weeklySale['left']),
                        'right' => number_format($weeklySale['right']),
                        'packageId' => $user->userData->packageId,
                        'pkg' => 2000,
                        'lMembers' => $user->userData->leftMembers,
                        'rMembers' => $user->userData->rightMembers,
                        'posi'=>$user->userData->leftRight,
                        'ifLeft'=>number_format($ifLeft,3),
                        'ifRight'=>number_format($ifRight,3)
                    ];
                    $children = self::getBinaryChildren($user->id);
                    if ($children) {
                        $fields['children'] = $children;
                    }
                    return response()->json($fields);
                } else {
                    return response()->json(['err' => 1]);
                }
            }else{
                $user = Auth::user();
                $childLeft = UserData::where('binaryUserId', $user->id)->where('leftRight', 'left')->first();
                $childRight = UserData::where('binaryUserId', $user->id)->where('leftRight', 'right')->first();
                $weeklySale = self::getWeeklySale($user->id);
                //$weeklySale=$this->getTotalSale($user->id);
                //calculator infinity interest
                $ifLeft=$ifRight=0;
                $infinityInterest=BonusBinaryInterest::where('userId',$user->id)->where('weekYear',$weekYear)->first();
                if($infinityInterest)
                {
                    $ifLeft = $infinityInterest->leftNew + $infinityInterest->leftOpen;
                    $ifRight = $infinityInterest->rightNew + $infinityInterest->rightOpen;
                }
                $fields = [
                    'lvl'     => 0,
                    'id'     => $user->id,
                    'name'     => $user->name,
                    'parentID'     => null,
                    'childLeftId' => $childLeft ? $childLeft->userId : 0,
                    'childRightId' => $childRight ? $childRight->userId : 0,
                    'level'     => 0,
                    'weeklySale'     => number_format(self::getBV($user->id)),
                    'left'     => number_format($weeklySale['left']),
                    'right'     => number_format($weeklySale['right']),
                    'packageId' => $user->userData->packageId,
                    'pkg'     => 2000,
                    'lMembers'     => $user->userData->leftMembers,
                    'rMembers'     => $user->userData->rightMembers,
                    'posi'=> $user->userData->leftRight,
                    'ifLeft'=>number_format($ifLeft,3),
                    'ifRight'=>number_format($ifRight,3)
                ];
                $children = self::getBinaryChildren($user->id);
                if($children){
                    $fields['children'] = $children;
                }
                return response()->json($fields);
            }
        }
        $lstUsers = UserData::where('refererId', '=',$currentuserid)->where('status', 1)->where('isBinary', '!=', 1)->get();

        $lstUserSelect = array('0'=> 'Choose a username');
        if(Auth::user()->userData->isBinary > 0){
            foreach ($lstUsers as $userData){
                $lstUserSelect[$userData->userId] = $userData->user->name;
            }
        }

        return view('adminlte::members.binary')->with('lstUserSelect', $lstUserSelect);
    }

    // Get BV - personal week sale
    function getBV($userId){
        $year = date('Y');
                
        $dt = Carbon::now();
        $weeked = $dt->weekOfYear;
        //neu la CN thi day la ve cua tuan moi
        if($dt->dayOfWeek == 0){
            $weeked = $weeked + 1;
        }

        //neu la thu 7 nhung qua 9h thi day la ve cua tuan moi
        if($dt->dayOfWeek == 6 && $dt->hour > 8){
            $weeked = $weeked + 1;
        }

        if($weeked == 53) {
            $weeked = 1;
            $year += 1;
        }

        $weekYear = $year . $weeked;

        $package = UserPackage::where('userId', $userId)
                            ->where('weekYear', '=', $weekYear)
                            ->groupBy(['userId'])
                            ->selectRaw('sum(amount_increase) as totalValue')
                            ->get()
                            ->first();
        $BV = 0;
        if($package) 
        {
            $BV = $package->totalValue;
        }

        return $BV;
    }


    // Get Loyalty
    function getLoyalty($userId){
        $userLoyalty = LoyaltyUser::where('userId', $userId)->get()->first();

        $loyalty = 0;
        if($userLoyalty) 
        {
            if($userLoyalty->isSilver == 1) $loyalty = 1;
            if($userLoyalty->isGold == 1) $loyalty = 2;
            if($userLoyalty->isPear == 1) $loyalty = 3;
            if($userLoyalty->isEmerald == 1) $loyalty = 4;
            if($userLoyalty->isDiamond == 1) $loyalty = 5;
        }

        return $loyalty;
    }

    private function getTotalSale($userId)
    {
        $allNode=UserTreePermission::where('userId','=',$userId)->first();
        $totalLeft=0;
        $totalRight=0;
        $result = ['left'=>0, 'right'=>0, 'total'=>0];
        if(!empty($allNode))
        {
            
            $totalLeft=$this->getNodeData($allNode->genealogy_left);
            $totalRight=$this->getNodeData($allNode->genealogy_right);
            $result['left'] = $totalLeft;
            $result['right'] = $totalRight;
        }
        $result['total'] = $totalLeft + $totalRight;
        return $result;
    }

    private function getNodeData($data)
    {
        $total=0;
        if($data!='')
        {
            $dataNode=explode(',',$data);
            if(!empty($dataNode))
            {
                foreach($dataNode as $nKey=>$nVal)
                {
                    if($nVal!='')
                    {
                        $total+=UserPackage::getTotalAmount($nVal);
                    }
                }
            }
        }
        return $total;
    }



    function getWeeklySale($userId, $type = 'total')
    {
        $year = date('Y');
                
        $dt = Carbon::now();
        $weeked = $dt->weekOfYear;
        //neu la CN thi day la ve cua tuan moi
        if($dt->dayOfWeek == 0){
            $weeked = $weeked + 1;
        }

        //neu la thu 7 nhung qua 9h thi day la ve cua tuan moi
        if($dt->dayOfWeek == 6 && $dt->hour > 8){
            $weeked = $weeked + 1;
        }

        if($weeked == 53) {
            $weeked = 1;
            $year += 1;
        }

        $weekYear = $year . $weeked;

        $week = BonusBinary::where('userId', '=', $userId)->where('weekYear', '=', $weekYear)->first();
        $result = ['left'=>0, 'right'=>0, 'total'=>0];

        if($week){
            $result['left'] = $week->leftNew;
            $result['right'] = $week->rightNew;
            $result['total'] = $week->leftNew + $week->rightNew;
        }

        return $result;
    }

    function getBinaryChildren($userId, $level = 0){
        $weeked = date('W');
        $year = date('Y');
        $weekYear = $year.$weeked;
        
        $currentuserid = Auth::user()->id;
        $level = $level + 1;
        $fields = array();
        if($level < 4){
            $UserDatas = UserData::where('binaryUserId', '=', $userId)->get();
            foreach ($UserDatas as $user) {
                //if($user->refererId == $currentuserid || $user->binaryUserId == $currentuserid) {
                    $childLeft = UserData::where('binaryUserId', $user->user->id)->where('leftRight', 'left')->first();
                    $childRight = UserData::where('binaryUserId', $user->user->id)->where('leftRight', 'right')->first();
                    $weeklySale = self::getWeeklySale($user->user->id);

                    //calculator infinity interest
                    $ifLeft=$ifRight=0;
                    $infinityInterest=BonusBinaryInterest::where('userId',$user->user->id)->where('weekYear',$weekYear)->first();
                    if($infinityInterest)
                    {
                        $ifLeft = $infinityInterest->leftNew + $infinityInterest->leftOpen;
                        $ifRight = $infinityInterest->rightNew + $infinityInterest->rightOpen;
                    }

                    $field = [
                        'position' => ($user->leftRight == 'left') ? 'right' : 'left',
                        'lvl' => $level,
                        'id' => $user->user->id,
                        'name' => $user->user->name,
                        'parentID' => $user->binaryUserId,
                        'childLeftId' => $childLeft ? $childLeft->userId : 0,
                        'childRightId' => $childRight ? $childRight->userId : 0,
                        'level' => 0,
                        'weeklySale'     => number_format(self::getBV($user->user->id)),
                        'left'     => number_format($weeklySale['left']),
                        'right'     => number_format($weeklySale['right']),
                        'packageId' => $user->packageId,
                        'pkg'     => 2000,
                        'lMembers' => $user->leftMembers,
                        'rMembers' => $user->rightMembers,
                        'posi'=>$user->leftRight,
                        'ifLeft'=>number_format($ifLeft,3),
                        'ifRight'=>number_format($ifRight,3)
                    ];
                    $children = self::getBinaryChildren($user->user->id, $level);
                    if ($children) {
                        $field['children'] = $children;
                    }
                    $fields[] = $field;
                //}
            }
        }
        return $fields;
    }
    
    public function refferals(){
        $currentuserid = Auth::user()->id;
        
        $users = UserData::with('user')->where('refererId', '=',$currentuserid)->where('status', 1)->orderBy('userId', 'desc')->get();
               //->paginate();
        return view('adminlte::members.refferals')->with('users', $users);
    }

    public function rankProcess()
    {
        $lstUser = User::where('active', '=', 1)->get();
        foreach($lstUser as $user){
            $userData=$user->userData;
        $packageId=$userData->packageId;
        $rank=0;
        $totalLeft=floatval($userData->totalSaleLeft);
        $totalRight=floatval($userData->totalSaleRight);
        if($totalLeft >= config('carcoin.loyalty_upgrate_silver') && 
                $totalRight >= config('carcoin.loyalty_upgrate_silver') && 
                $packageId >= 1 )
            {
                $rank=1;
            }

            if($totalLeft >= config('carcoin.loyalty_upgrate_gold') && 
                $totalRight >= config('carcoin.loyalty_upgrate_gold') && 
                $packageId >= 2)
            {
                $rank=2;
            }

            if($totalLeft >= config('carcoin.loyalty_upgrate_pear') && 
                $totalRight >= config('carcoin.loyalty_upgrate_pear') && 
                $packageId >= 3)
            {
                $rank=3;
            }

            if($totalLeft > config('carcoin.loyalty_upgrate_emerald') && 
                $totalRight > config('carcoin.loyalty_upgrate_emerald') && 
                $packageId == 4)
            {
                $rank=4;
            }

            if($totalLeft > config('carcoin.loyalty_upgrate_diamond') && 
                $totalRight > config('carcoin.loyalty_upgrate_diamond') && 
                $packageId == 4)
            {
                $rank=5;
            }
            if($userData->loyaltyId<$rank)
            {
                $userData->loyaltyId=$rank;
                $userData->save();
            }

        }
    }

    public function pushIntoTree(Request $request){

        //if($request->ajax()){
        if($request->isMethod('post')  && Auth::user()->userData->packageId > 0){
            if($request->userSelect > 0 && isset($request['legpos']) && in_array($request['legpos'], array(1,2))){

                //Get user that is added to tree
                $userData = UserData::find($request->userSelect);
                if($userData && $userData->refererId == Auth::user()->id && $userData->isBinary !== 1) {
                    $userData->isBinary = 1;
                    if($userData->lastUserIdLeft == 0) $userData->lastUserIdLeft = $userData->userId;
                    if($userData->lastUserIdRight == 0) $userData->lastUserIdRight = $userData->userId;

                    $userData->leftRight = $request['legpos'] == 1 ? 'left' : 'right';
                    $lastUserIdLeft = $lastUserIdRight = Auth::user()->id;

                    if(Auth::user()->userData 
                        && Auth::user()->userData->lastUserIdLeft 
                        && Auth::user()->userData->lastUserIdLeft > 0) {
                            $lastUserIdLeft = Auth::user()->userData->lastUserIdLeft;
                    }

                    if(Auth::user()->userData 
                        && Auth::user()->userData->lastUserIdRight 
                        && Auth::user()->userData->lastUserIdRight > 0) {
                            $lastUserIdRight = Auth::user()->userData->lastUserIdRight;
                    }

                    if($request['legpos'] == 1){
                        $userData->binaryUserId = $lastUserIdLeft;
                    }else{
                        $userData->binaryUserId = $lastUserIdRight;
                    }

                    $userData->save();

                    //Calculate binary bonus
                    User::bonusBinary(
                        $userData->userId, 
                        $userData->refererId, 
                        $userData->packageId, 
                        $userData->binaryUserId, 
                        $request['legpos'],
                        false
                    );

                    //Calculate loyalty
                    //User::bonusLoyaltyUser($userData->userId, $userData->refererId, $request['legpos']);
                    User::updateUserBinary($userData->userId);
                    //$this->rankProcess();
                    return redirect('members/binary')
                        ->with('flash_message', trans('adminlte_lang::member.msg_push_tree_success'));
                    //return response()->json(['status'=>1]);
                }
            }
        }

        if(Auth::user()->userData->packageId == 0) {
            $request->session()->flash('error', trans('adminlte_lang::member.msg_must_buy_package'));
        }
        else {
            $request->session()->flash('error', trans('adminlte_lang::member.msg_push_tree_error'));
        }
        return redirect('members/binary');
    }
    
    public function refferalsDetail($id){
        $user = User::where('uid', $id)->get()->first();

        return view('adminlte::profile.subprofile', compact('user'));
    }
}
