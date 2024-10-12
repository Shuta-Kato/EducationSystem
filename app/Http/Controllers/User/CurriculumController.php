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
        $model = new Curriculum();
        $curriculums = $model->showCurriculums();
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
        $curriculumsQuery = Curriculum::with(['deliveryTimes' => function ($query) use ($startDate, $endDate) {
            $query->where(function($query) use ($startDate, $endDate) {
                $query->whereBetween('delivery_from', [$startDate, $endDate])
                      ->orWhereBetween('delivery_to', [$startDate, $endDate]);
            });
        }])->whereHas('grade', function ($query) use ($grade) {
            $query->where('name', $grade);
        });
        
        $curriculums = $curriculumsQuery->get();
    
        if ($curriculums->isEmpty()) {
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
    foreach ($curriculums as $curriculum) {
        foreach ($curriculum->deliveryTimes as $deliveryTime) {
            try {
                $deliveryFrom = $deliveryTime->delivery_from instanceof \Carbon\Carbon
                    ? $deliveryTime->delivery_from
                    : Carbon::parse($deliveryTime->delivery_from);
                $deliveryTo = $deliveryTime->delivery_to instanceof \Carbon\Carbon
                    ? $deliveryTime->delivery_to
                    : Carbon::parse($deliveryTime->delivery_to);
                
                $schedules[] = [
                    'title' => $curriculum->title,
                    'thumbnail' => $curriculum->thumbnail,
                    'date' => $deliveryFrom->format('n月j日'),
                    'time' => $deliveryFrom->format('H:i') . '〜' . $deliveryTo->format('H:i'),
                ];
            } catch (\Exception $e) {
                Log::error('スケジュールデータの解析に失敗しました。', ['error' => $e->getMessage()]);
            }
        }
    }

    return response()->json($schedules);
}
}