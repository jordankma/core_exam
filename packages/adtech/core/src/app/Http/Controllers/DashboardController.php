<?php

namespace Adtech\Core\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Adtech\Core\App\Http\Requests\UploadRequest;
use Auth;

class DashboardController extends Controller
{
    public function backend(Request $request)
    {
//        $client = new \GuzzleHttp\Client();
//        $pathFile = base_path('public/files/chap01.pdf');
//        $res = $client->request('GET', 'http://localhost:8079/split?path=' . $pathFile);
//        echo $res->getBody();die();

        return view('ADTECH-CORE::modules.core.dashboard.backend');
    }

    public function frontend(Request $request)
    {
        return redirect()->route('backend.homepage');
//        return view('ADTECH-CORE::modules.core.dashboard.frontend');
    }

    public function filemanage()
    {
        if (env('APP_URL') == 'http://files.dhcd.vnedutech.vn') {
            $domain = '/admin/laravel-filemanager';
        } else {
            $domain = 'http://dhcd-release.vnedutech.vn/administrator/laravel-filemanager';
        }
        return view('ADTECH-CORE::modules.core.file.manage', compact('domain'));
    }

    public function fileuploadtest(UploadRequest $request)
    {
//        if ($request->isMethod('post')) {
//            if ($request->has('file_real_path')) {
//                $filePath = $request->input("file_real_path");
//
//            }
//        }
        return view('ADTECH-CORE::modules.core.file.upload');
    }
}
