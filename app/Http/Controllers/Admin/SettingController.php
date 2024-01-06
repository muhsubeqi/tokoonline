<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        $storeName = Setting::where('setting', 'store_name')->first();
        $storeAddress = Setting::where('setting', 'store_address')->first();
        $storeCity = Setting::where('setting', 'store_city')->first();
        $storePhone = Setting::where('setting', 'store_phone')->first();
        $storeEmail = Setting::where('setting', 'store_email')->first();
        $announcement = Setting::where('setting', 'announcement')->first();
        $bank = Setting::where('setting', 'bank')->first();
        $facebook = Setting::where('setting', 'sosial_media_1')->first();
        $instagram = Setting::where('setting', 'sosial_media_2')->first();
        $othersm = Setting::where('setting', 'sosial_media_3')->first();
        $storeLogo = Setting::where('setting', 'store_logo')->first();
        $advertisement = Setting::where('setting', 'advertisement')->first();
        $bannerHome = Setting::where('setting', 'banner_home')->first();
        $slide1 = Setting::where('setting', 'slide_1')->first();
        $slide2 = Setting::where('setting', 'slide_2')->first();

        return view(
            'admin.setting.index',
            compact(
                'storeName',
                'storeAddress',
                'storeCity',
                'storePhone',
                'storeEmail',
                'announcement',
                'bank',
                'facebook',
                'instagram',
                'othersm',
                'storeLogo',
                'advertisement',
                'bannerHome',
                'slide1',
                'slide2',
            )
        );
    }

    public function update(Request $request)
    {
        // store name
        Setting::where('setting', 'store_name')->update([
            'tool1' => $request->store_name
        ]);

        // store address
        Setting::where('setting', 'store_address')->update([
            'tool2' => $request->store_address
        ]);

        // store city
        Setting::where('setting', 'store_city')->update([
            'tool1' => $request->store_city
        ]);

        // store phone
        Setting::where('setting', 'store_phone')->update([
            'tool1' => $request->store_phone
        ]);

        // store email
        Setting::where('setting', 'store_email')->update([
            'tool1' => $request->store_email
        ]);

        // announcement
        Setting::where('setting', 'announcement')->update([
            'tool2' => $request->announcement
        ]);

        // bank
        Setting::where('setting', 'bank')->update([
            'tool1' => $request->bank_name,
            'tool2' => $request->bank_rek,
            'tool4' => $request->bank_rek_name
        ]);

        // sosial media facebook
        Setting::where('setting', 'sosial_media_1')->update([
            'tool1' => 'facebook',
            'tool2' => $request->facebook
        ]);
        // sosial media facebook
        Setting::where('setting', 'sosial_media_2')->update([
            'tool1' => 'instagram',
            'tool2' => $request->instagram
        ]);
        // sosial media facebook
        Setting::where('setting', 'sosial_media_3')->update([
            'tool1' => $request->other_name,
            'tool2' => $request->other_link
        ]);

        $bankLogoName = $request->input('bank_logo_lama');
        if ($request->has('bank_logo')) {
            $lokasi = 'data/setting/';
            $image = $request->file('bank_logo');
            $extensi = $request->file('bank_logo')->extension();
            $new_image_name = 'Bank' . date('YmdHis') . uniqid() . '.' . $extensi;
            $upload = $image->move(public_path($lokasi), $new_image_name);
            $bankLogoName = $new_image_name;
            if ($upload) {
                $getImage = Setting::where('setting', 'bank')->first();
                if ($getImage->tool3 != null) {
                    File::delete(public_path('data/setting/' . $getImage->tool3));
                }
            }
            // store logo
            Setting::where('setting', 'bank')->update([
                'tool3' => $bankLogoName
            ]);
        }

        $storeLogoName = $request->input('store_logo_lama');
        if ($request->has('store_logo')) {
            $lokasi = 'data/setting/';
            $image = $request->file('store_logo');
            $extensi = $request->file('store_logo')->extension();
            $new_image_name = 'Logo' . date('YmdHis') . uniqid() . '.' . $extensi;
            $upload = $image->move(public_path($lokasi), $new_image_name);
            $storeLogoName = $new_image_name;
            if ($upload) {
                $getImage = Setting::where('setting', 'store_logo')->first();
                if ($getImage->tool1 != null) {
                    File::delete(public_path('data/setting/' . $getImage->tool1));
                }
            }
            // store logo
            Setting::where('setting', 'store_logo')->update([
                'tool1' => $storeLogoName
            ]);
        }


        $advertisementName = $request->input('advertisement_lama');
        if ($request->has('advertisement')) {
            $lokasi = 'data/setting/';
            $image = $request->file('advertisement');
            $extensi = $request->file('advertisement')->extension();
            $new_image_name = 'Advertisement' . date('YmdHis') . uniqid() . '.' . $extensi;
            $upload = $image->move(public_path($lokasi), $new_image_name);
            $advertisementName = $new_image_name;
            if ($upload) {
                $getImage = Setting::where('setting', 'advertisement')->first();
                if ($getImage->tool1 != null) {
                    File::delete(public_path('data/setting/' . $getImage->tool1));
                }
            }
            // store logo
            Setting::where('setting', 'advertisement')->update([
                'tool1' => $advertisementName
            ]);
        }

        // link iklan
        Setting::where('setting', 'advertisement')->update([
            'tool2' => $request->advertisement_link
        ]);

        $backgroundBanner = $request->input('banner_home_lama');
        if ($request->has('banner_home')) {
            $lokasi = 'data/setting/';
            $image = $request->file('banner_home');
            $extensi = $request->file('banner_home')->extension();
            $new_image_name = 'Banner' . date('YmdHis') . uniqid() . '.' . $extensi;
            $upload = $image->move(public_path($lokasi), $new_image_name);
            $backgroundBanner = $new_image_name;
            if ($upload) {
                $getImage = Setting::where('setting', 'banner_home')->first();
                if ($getImage->tool1 != null) {
                    File::delete(public_path('data/setting/' . $getImage->tool1));
                }
            }
            // banner
            Setting::where('setting', 'banner_home')->update([
                'tool1' => $backgroundBanner
            ]);
        }

        $slide1Name = $request->input('slide_1_lama');
        if ($request->has('slide_1')) {
            $lokasi = 'data/setting/';
            $image = $request->file('slide_1');
            $extensi = $request->file('slide_1')->extension();
            $new_image_name = 'Slide1_' . date('YmdHis') . uniqid() . '.' . $extensi;
            $upload = $image->move(public_path($lokasi), $new_image_name);
            $slide1Name = $new_image_name;
            if ($upload) {
                $getImage = Setting::where('setting', 'slide_1')->first();
                if ($getImage->tool1 != null) {
                    File::delete(public_path('data/setting/' . $getImage->tool1));
                }
            }
            // slide 1
            Setting::where('setting', 'slide_1')->update([
                'tool1' => $slide1Name
            ]);
        }

        // slide 1
        Setting::where('setting', 'slide_1')->update([
            'tool2' => $request->title1,
            'tool3' => $request->isi1
        ]);


        $slide2Name = $request->input('slide_2_lama');
        if ($request->has('slide_2')) {
            $lokasi = 'data/setting/';
            $image = $request->file('slide_2');
            $extensi = $request->file('slide_2')->extension();
            $new_image_name = 'Slide2_' . date('YmdHis') . uniqid() . '.' . $extensi;
            $upload = $image->move(public_path($lokasi), $new_image_name);
            $slide2Name = $new_image_name;
            if ($upload) {
                $getImage = Setting::where('setting', 'slide_2')->first();
                if ($getImage->tool1 != null) {
                    File::delete(public_path('data/setting/' . $getImage->tool1));
                }
            }
            // slide 2
            Setting::where('setting', 'slide_2')->update([
                'tool1' => $slide2Name
            ]);
        }

        // slide 2
        Setting::where('setting', 'slide_2')->update([
            'tool2' => $request->title2,
            'tool3' => $request->isi2
        ]);

        return redirect()->route('admin.setting')->with('success', 'Update Setting Berhasil');
    }
}