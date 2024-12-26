<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Grade;
use App\Models\DeliveryTime;
use App\Models\Curriculum;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class CurriculumController extends Controller
{
    public function index($gradeId)
    {
        // 全ての学年を取得
        $grades = Grade::all();
        $formateGrades = [];
        foreach ($grades as $grade) {
            $formateGrades[$grade->id] = $grade;
        }

        // 現在の学年情報
        $currentGrade = $formateGrades[$gradeId]->name;

        // curriculumsテーブルからデータを取得
        $curriculums = Curriculum::with('deliveryTimes')->where('grade_id', $gradeId)->get(); // 指定した学年の授業データを取得

        // 日付と時間を分割して格納
        foreach ($curriculums as $curriculum) {
            foreach ($curriculum->deliveryTimes as $deliveryTime) {
                $deliveryDateTime = Carbon::parse($deliveryTime->delivery_from);
                $deliveryTime->start_date = $deliveryDateTime->format('n月j日');
                $deliveryTime->start_time = $deliveryDateTime->format('H:i');

                $endDateTime = Carbon::parse($deliveryTime->delivery_to);
                $deliveryTime->end_time = $endDateTime->format('H:i');
            }
        }

        return view('admin.curriculum', compact('formateGrades', 'gradeId', 'currentGrade', 'curriculums'));
    }

    public function getCurriculumsByGrade($gradeId)
    {
        // curriculumsテーブルからデータを取得
        $curriculums = Curriculum::with('deliveryTimes')->where('grade_id', $gradeId)->get(); // 指定した学年の授業データを取得

        // 日付と時間を分割して格納
        foreach ($curriculums as $curriculum) {
            $curriculum->thumbnail = $curriculum->thumbnail ? asset($curriculum->thumbnail) : null;
            foreach ($curriculum->deliveryTimes as $deliveryTime) {
                $deliveryDateTime = Carbon::parse($deliveryTime->delivery_from);
                $deliveryTime->start_date = $deliveryDateTime->format('n月j日');
                $deliveryTime->start_time = $deliveryDateTime->format('H:i');

                $endDateTime = Carbon::parse($deliveryTime->delivery_to);
                $deliveryTime->end_time = $endDateTime->format('H:i');
            }
        }
        $currentGrade = Grade::findOrFail($gradeId);

        return response()->json([
            'curriculums' => $curriculums,
            'currentGrade' => $currentGrade->name,
        ]);
    }

    public function edit($id)
    {
        // 指定されたIDのカリキュラムを取得
        $curriculum = Curriculum::findOrFail($id); // IDが存在しない場合は404エラー

        // 全ての学年を取得
        $grades = Grade::all();

        // カリキュラムと学年のデータをビューに渡す
        return view('admin.curriculum_edit', compact('grades', 'curriculum'));
    }

    public function create()
    {
        // 全ての学年を取得
        $grades = Grade::all();

        // カリキュラムと学年のデータをビューに渡す
        return view('admin.curriculum_create', compact('grades'));
    }

    public function store(Request $request)
    {
        try {
            // バリデーション
            $request->validate([
                'grade_id' => 'required|integer',          // 学年IDは必須かつ整数型
                'title' => 'required|string|max:255',     // 授業名は必須、文字列、最大255文字
                'video_url' => 'required|string|max:255', // 動画URLは必須、文字列、最大255文字
                'description' => 'required|string',       // 授業概要は必須、文字列
                'thumbnail' => 'nullable|image|max:2048', // サムネイル画像は任意、最大2MB
            ]);

            // 新しいカリキュラムデータの作成
            $curriculum = new Curriculum();
            $curriculum->grade_id = $request->input('grade_id');
            $curriculum->title = $request->input('title');
            $curriculum->video_url = $request->input('video_url');
            $curriculum->description = $request->input('description');

            // サムネイルの保存処理
            if ($request->hasFile('thumbnail')) {
                $thumbnail = $request->file('thumbnail');
                $fileName = time() . '_' . $thumbnail->getClientOriginalName(); // ファイル名をユニークに
                $path = $thumbnail->storeAs('public/images', $fileName);       // 画像を 'public/images' に保存

                // データベースに保存するパスは `storage/` 以下のものを使用
                $curriculum->thumbnail = str_replace('public/', 'storage/', $path);
            } else {
                $curriculum->thumbnail = null; // サムネイルがアップロードされない場合は NULL
            }

            // カリキュラムデータを保存
            $curriculum->save();

            // 成功時のリダイレクト
            return redirect()->route('admin.curriculum.index', $request->grade_id)
                ->with('success', 'カリキュラムが正常に作成されました');
        } catch (\Exception $e) {
            // エラー時のリダイレクト
            return redirect()->route('admin.curriculum.index', $request->grade_id)
                ->withErrors(['error' => 'カリキュラムの作成に失敗しました: ' . $e->getMessage()]);
        }
    }


    public function update(Request $request)
    {
        try {
            // バリデーション
            $request->validate([
                'grade_id' => 'required|integer',
                'title' => 'required|string|max:255',
                'video_url' => 'required|string|max:255',
                'description' => 'required|string',
                'thumbnail' => 'nullable|image|max:2048',  // 画像は任意、最大2MB
            ]);

            // カリキュラムデータの取得
            $curriculum = Curriculum::findOrFail($request->id);

            // データの更新
            $curriculum->grade_id = $request->input('grade_id');
            $curriculum->title = $request->input('title');
            $curriculum->video_url = $request->input('video_url');
            $curriculum->description = $request->input('description');

            // サムネイルの保存処理
            if ($request->hasFile('thumbnail')) {
                $thumbnail = $request->file('thumbnail');
                $fileName = time() . '_' . $thumbnail->getClientOriginalName();  // ファイル名をユニークに
                $path = $thumbnail->storeAs('public/images', $fileName);  // 画像を'public/images'に保存

                // データベースに保存するパスは`storage/`以下のものを使用
                $curriculum->thumbnail = str_replace('public/', 'storage/', $path);
            }

            // カリキュラムデータを保存
            $curriculum->save();

            // 成功時のリダイレクト
            return redirect()->route('admin.curriculum.index', $request->grade_id)
                ->with('success', 'カリキュラムが正常に更新されました');
        } catch (\Exception $e) {
            // エラー時のリダイレクト
            return redirect()->route('admin.curriculum.index', $request->grade_id)
                ->withErrors(['error' => 'カリキュラムの更新に失敗しました: ' . $e->getMessage()]);
        }
    }

    public function show()
    {
        // 学年を取得してビューに渡す
        $grades = Grade::all();
        return view('admin.curriculum_edit', compact('grades'));
    }

    public function showId($id)
    {
        $grade = Curriculum::findOrFail($id);
        return view('admin.curriculum', compact('curriculum'));
    }
}
