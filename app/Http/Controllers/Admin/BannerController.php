<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class BannerController extends Controller
{
    public function showBannerEdit()
    {
        return view('admin.banner_edit');
    }

    public function showBannerStore(Request $request)
    {
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
    }
}
