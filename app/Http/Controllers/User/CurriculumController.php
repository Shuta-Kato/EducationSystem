<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Curriculum;
use App\Models\Grade; 
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CurriculumController extends Controller
{
    public function showCurriculumList(Request $request)
    {
        $curriculums = Curriculum::getAllCurriculums();
        $yearMonth = $request->input('month', date('Y-m'));
        $gradeId = $request->input('grade_id');

        return view('user.curriculum_list', compact('yearMonth', 'gradeId', 'curriculums'));
    }

    public function schedules($yearMonth, $grade, Request $request)
    {
    
        try {
            $startDate = Carbon::createFromFormat('Y-m', $yearMonth)->startOfMonth();
            $endDate = Carbon::createFromFormat('Y-m', $yearMonth)->endOfMonth();
        } catch (\Exception $e) {
            return response()->json(['error' => '日付の解析に失敗しました。'], 400);
        }

        try {
            $curriculumsTrue = Curriculum::getCurriculumsSchedule($grade, $startDate, $endDate, true);
            $curriculumsFalse = Curriculum::getCurriculumsSchedule($grade, $startDate, $endDate, false);
            $curriculumsAll = $curriculumsTrue->merge($curriculumsFalse);
        
            if ($curriculumsAll->isEmpty()) {
                Log::warning('指定された条件に一致するカリキュラムが見つかりません。', [
                    'yearMonth' => $yearMonth,
                    'grade' => $grade,
                ]);
                return response()->json(['error' => '指定された条件に一致するカリキュラムが見つかりません。'], 404);
            }
        
        } catch (\Exception $e) {
            Log::error('カリキュラムの取得に失敗しました: ' . $e->getMessage());
            return response()->json(['error' => 'カリキュラムの取得に失敗しました。'], 500);
        }

        $schedules = [];
        $hasExpiredSchedules = false; 
    
        foreach ($curriculumsAll as $curriculum) {
            foreach ($curriculumsAll as $curriculum) {
                foreach ($curriculum->deliveryTimes as $deliveryTime) {
                    try {
                        $deliveryFrom = $deliveryTime->delivery_from instanceof \Carbon\Carbon
                            ? $deliveryTime->delivery_from
                            : Carbon::parse($deliveryTime->delivery_from);
                        $deliveryTo = $deliveryTime->delivery_to instanceof \Carbon\Carbon
                            ? $deliveryTime->delivery_to
                            : Carbon::parse($deliveryTime->delivery_to);
            
                        if ($curriculum->alway_delivery_flg == 1) {
                            $schedules[] = [
                                'title' => $curriculum->title,
                                'thumbnail' => $curriculum->thumbnail,
                                'date' => $deliveryFrom->format('n月j日'),
                                'time' => $deliveryFrom->format('H:i') . '〜' . $deliveryTo->format('H:i'),
                                'isExpired' => false,  
                                'alway_delivery_flg' => $deliveryTime->alway_delivery_flg,
                            ];
                        } else {
                            $isExpired = Carbon::now()->greaterThan($deliveryTo);
            
                            if (!$isExpired) {
                                $schedules[] = [
                                    'title' => $curriculum->title,
                                    'thumbnail' => $curriculum->thumbnail,
                                    'date' => $deliveryFrom->format('n月j日'),
                                    'time' => $deliveryFrom->format('H:i') . '〜' . $deliveryTo->format('H:i'),
                                    'isExpired' => false,
                                    'alway_delivery_flg' => $deliveryTime->alway_delivery_flg,
                                ];
                            } else {
                                $hasExpiredSchedules = true;
                            }
                        }
                    } catch (\Exception $e) {
                        Log::error('スケジュールデータの解析に失敗しました。', ['error' => $e->getMessage()]);
                    }
                }
            }
        }
    
        if (empty($schedules) && $hasExpiredSchedules) {
            return response()->json(['message' => '配信期間が過ぎました。'], 200);
        } elseif (empty($schedules)) {
            return response()->json(['message' => 'スケジュールがありません。'], 200);
        }
    
        return response()->json($schedules);
    }

    public function logout(Request $request)
    {
        auth()->guard('user')->logout(); 
        $request->session()->invalidate();  
        $request->session()->regenerateToken();  

        return redirect('/user/auth/login');  
    }
}

