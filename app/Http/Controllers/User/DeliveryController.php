<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Curriculum;
use App\Models\CurriculumProgress;
use App\Models\DeliveryTime;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DeliveryController extends Controller
{
    public function showDelivery($id) {
        $model = new Curriculum;
        $curriculum = $model -> getCurriculums($id); //授業データ取得

        $always_flg = $curriculum ->alway_delivery_flg; //常時公開フラグの取得

        $progressModel = new CurriculumProgress;
        $clear_flg = $progressModel -> getClearflg($id); //授業の受講状態の取得

//ここから公開時間の処理※常時公開フラグが0だった場合に処理
        if($always_flg == 0){

        $TimeModel = new DeliveryTime;
        $deliveryTime = $TimeModel ->getDeliveryTime($id); //公開期間の取得

        $now = Carbon::now(); //現在時間の取得
        $nowTime= $now->format('Y-m-d H:i:s'); //現在時間の形式を変換

        $startTime = $deliveryTime -> delivery_from;
        $endTime = $deliveryTime -> delivery_to;
        }
        
       //以下$display_flgが1の場合は公開,0の場合は非公開

        if($always_flg == 1){ //常時公開フラグが１なら$display_flgは1
            $display_flg = 1; 
        }elseif($startTime <= $now && $now <= $endTime){ //配信期間が１なら$display_flgは1
            $display_flg = 1;  
        }else{
            $display_flg = 0; //それ以外なら$display_flgは0
        }

        return view('user.delivery',['curriculum'=>$curriculum, 'clear_flg'=>$clear_flg,'display_flg'=>$display_flg,]);
    }

    public function updateClearFlg($id){

        DB::beginTransaction();

        try {

        $model = new CurriculumProgress;
        $model -> updateClearflg($id);

        DB::commit();
    } catch (\Exception $e) {
        DB::rollback();
        return back();
    }
        return redirect() -> route('user.show.delivery',$id);

    }


}
