<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\BannerRequest;


class BannerController extends Controller
{
    public function showBannerEdit()
    {
        $banners = DB::table('banners')->get();

        return view('admin.banner_edit', compact('banners'));
    }

    public function showBannerStore(BannerRequest $request)
    {
        $request->validated(); 
        $count = 0;

        try {
            if ($request->hasFile('banner_images')) 
            {
                foreach ($request->file('banner_images') as $file) {
                    $path = $file->store('banners', 'public');            
                    DB::table('banners')->insert([
                        'image' => $path,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $count++;
                }
            }
            if ($count === 1) {
                $message = '画像ファイルを1件保存しました';
            } elseif ($count > 1) {
                $message = "画像ファイルを{$count}件保存しました";
            } else {
                $message = '画像ファイルが選択されていません';
            }

            return redirect()->back()->with('success',  $message);
    
        } catch (\Exception $e) {
            DB::rollBack(); 
            return redirect()->back()->with('error', '画像ファイルの保存に失敗しました');
        }
    }

    public function showBannerDelete($id)
    {
        try {
            $banner = DB::table('banners')->where('id', $id)->first();
            if ($banner) {
                \Storage::delete('public/' . $banner->image);
                DB::table('banners')->where('id', $id)->delete();
                return response()->json(['success' => '画像ファイルが削除されました']);
            } 
        } catch (\Exception $e) {
            return response()->json(['error' => '削除に失敗しました'], 500);
        }
    }
}
