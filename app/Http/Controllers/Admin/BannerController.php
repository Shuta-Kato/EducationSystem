<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class BannerController extends Controller
{
    public function showBannerEdit()
    {
        $banners = DB::table('banners')->get();

        return view('admin.banner_edit', compact('banners'));
    }

    public function showBannerStore(Request $request)
    {   
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
                }
            }

            return redirect()->back()->with('success', 'バナーが保存されました');
        
        } catch (\Exception $e) {
            DB::rollBack(); 
            return redirect()->back()->with('error', 'バナーの保存に失敗しました');
        }
    }

    public function showBannerDelete($id)
    {
        try {
            $banner = DB::table('banners')->where('id', $id)->first();
            if ($banner) {
                \Storage::delete('public/' . $banner->image);
                DB::table('banners')->where('id', $id)->delete();
                return response()->json(['success' => 'バナーが削除されました']);
            } 
        } catch (\Exception $e) {
            return response()->json(['error' => '削除に失敗しました'], 500);
        }
    }
}
