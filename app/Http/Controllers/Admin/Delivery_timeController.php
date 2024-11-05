<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Curriculum;
use App\Models\DeliveryTime;
use App\Http\Controllers\Controller;

class Delivery_timeController extends Controller
{
    public function show($id)
    {
        $curriculum_id = $id;
        // ここでタイトルを定義
        $title = Curriculum::where('id', $id)->first(['title'])->title;

        $delivery_times_data = DeliveryTime::where('curriculums_id', $id)->get();
        $delivery_times = []; //空の配列を用意

        foreach ($delivery_times_data as $item) {
            // delivery_fromを日付と時間に分ける
            $start_date = \Carbon\Carbon::parse($item->delivery_from)->format('Y-m-d');
            $start_time = \Carbon\Carbon::parse($item->delivery_from)->format('H:i:s');

            // delivery_toを日付と時間に分ける
            $end_date = \Carbon\Carbon::parse($item->delivery_to)->format('Y-m-d');
            $end_time = \Carbon\Carbon::parse($item->delivery_to)->format('H:i:s');

            // 加工したデータを新しい配列に追加
            $delivery_times[] = [
                'id' => $item->id,
                'start_date' => $start_date,
                'start_time' => $start_time,
                'end_date' => $end_date,
                'end_time' => $end_time,
            ];
        }

        // タイトルとスケジュールをBladeに渡す
        return view('admin.delivery_time', compact('title', 'delivery_times', 'curriculum_id'));
    }


    public function store(Request $request)
    {
        try {
            // フォームから送信されたデータをバリデーション
            $validated = $request->validate([
                'curriculum_id' => 'required|integer|exists:curriculums,id',
                'data' => 'required|array',
            ]);

            // カリキュラムIDを取得
            $curriculumId = $validated['curriculum_id'];

            // データ保存または更新の処理
            foreach ($validated['data'] as $item) {
                // delivery_from と delivery_to を結合して作成
                $delivery_from = \Carbon\Carbon::parse($item['start_date'] . ' ' . $item['start_time']);
                $delivery_to = \Carbon\Carbon::parse($item['end_date'] . ' ' . $item['end_time']);

                if (!empty($item['delivery_time_id'])) {
                    // 既存のレコードを更新
                    $delivery_time = DeliveryTime::find($item['delivery_time_id']);
                    if ($delivery_time) {
                        $delivery_time->delivery_from = $delivery_from;
                        $delivery_time->delivery_to = $delivery_to;
                        $delivery_time->save();
                    }
                } else {
                    // 新しいレコードを作成
                    DeliveryTime::create([
                        'curriculums_id' => $curriculumId,
                        'delivery_from' => $delivery_from,
                        'delivery_to' => $delivery_to,
                    ]);
                }
            }
            $gradeId = Curriculum::find($curriculumId)->grade_id;
            // 保存完了後、別のページへリダイレクト
            return redirect()->route('admin.curriculum.index', ['gradeId' => $gradeId])->with('success', 'スケジュールが保存されました');
        } catch (\Exception $e) {
            return redirect()->route('admin.delivery_time.show', ['id' => $request->input('curriculum_id')])->withErrors(['error' => 'スケジュールの保存に失敗しました: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $delivery_time = DeliveryTime::findOrFail($id);
            $delivery_time->delete();

            return response()->json(['message' => '削除が成功しました'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => '削除に失敗しました'], 500);
        }
    }
}
