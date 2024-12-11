<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Curriculum;
use App\Models\DeliveryTime;
use App\Http\Controllers\Controller;

class Delivery_timeController extends Controller
{
    public function show($id)
    {
        $curriculum_id = $id;
        $title = Curriculum::where('id', $id)->first(['title'])->title;

        $delivery_times_data = DeliveryTime::where('curriculums_id', $id)->get();
        $delivery_times = [];

        foreach ($delivery_times_data as $item) {
            $delivery_times[] = [
                'id' => $item->id,
                'start_date' => \Carbon\Carbon::parse($item->delivery_from)->format('Y-m-d'),
                'start_time' => \Carbon\Carbon::parse($item->delivery_from)->format('H:i'),
                'end_date' => \Carbon\Carbon::parse($item->delivery_to)->format('Y-m-d'),
                'end_time' => \Carbon\Carbon::parse($item->delivery_to)->format('H:i'),
            ];
        }

        return view('admin.delivery_time', compact('title', 'delivery_times', 'curriculum_id'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'curriculum_id' => 'required|integer|exists:curriculums,id',
                'data' => 'required|array',
            ]);

            $curriculumId = $validated['curriculum_id'];

            foreach ($validated['data'] as $item) {
                if (!empty($item['start_date']) && !empty($item['start_time']) && !empty($item['end_date']) && !empty($item['end_time'])) {
                    $delivery_from = \Carbon\Carbon::parse($item['start_date'] . ' ' . $item['start_time']);
                    $delivery_to = \Carbon\Carbon::parse($item['end_date'] . ' ' . $item['end_time']);

                    if (!empty($item['delivery_time_id'])) {
                        $delivery_time = DeliveryTime::find($item['delivery_time_id']);
                        if ($delivery_time) {
                            $delivery_time->delivery_from = $delivery_from;
                            $delivery_time->delivery_to = $delivery_to;
                            $delivery_time->save();
                        }
                    } else {
                        DeliveryTime::create([
                            'curriculums_id' => $curriculumId,
                            'delivery_from' => $delivery_from,
                            'delivery_to' => $delivery_to,
                        ]);
                    }
                }
            }

            $gradeId = Curriculum::find($curriculumId)->grade_id;
            return redirect()->route('admin.curriculum.index', ['gradeId' => $gradeId])
                ->with('success', 'スケジュールが保存されました');
        } catch (\Exception $e) {
            return redirect()->route('admin.delivery_time.show', ['id' => $request->input('curriculum_id')])
                ->withErrors(['error' => 'スケジュールの保存に失敗しました: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $delivery_time = DeliveryTime::findOrFail($id);
            $delivery_time->delete();

            return response()->json(['message' => '削除が成功しました'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => '削除に失敗しました: ' . $e->getMessage()], 500);
        }
    }
}
