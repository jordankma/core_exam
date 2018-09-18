<?php

namespace Adtech\Core\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Adtech\Core\App\Repositories\JsonRepository;
use Adtech\Core\App\Http\Requests\JsonRequest;
use Adtech\Core\App\Models\JsonVersion;
use Adtech\Core\App\Models\Json;
use Adtech\Core\App\Models\Domain;
use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Illuminate\Database\QueryException;
use Illuminate\Filesystem\Filesystem;
use Adtech\Core\App\Models\Locale;
use Validator;
use Cache;

class JsonController extends Controller
{
    /**
     * @var Filesystem
     */
    protected $files;

    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );

    public function __construct(JsonRepository $jsonRepository, Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
        $this->json = $jsonRepository;
    }

    public function add(JsonRequest $request)
    {
        $json = new Json($request->all());
        $json->save();

        if ($json->json_id) {

            activity('json')
                ->performedOn($json)
                ->withProperties($request->all())
                ->log('User: :causer.email - Add Json - name: :properties.name, json_id: ' . $json->json_id);

            return redirect()->route('adtech.core.json.manage', ['domain_id' => $request->input('domain_id')])->with('success', trans('adtech-core::messages.success.create'));
        } else {
            return redirect()->route('adtech.core.json.manage', ['domain_id' => $request->input('domain_id')])->with('error', trans('adtech-core::messages.error.create'));
        }
    }

    public function create(Request $request)
    {
        $domain_id = $request->input('domain_id', 0);

        return view('ADTECH-CORE::modules.core.json.create', compact('domain_id'));
    }

    public function delete(JsonRequest $request)
    {
        $json_id = $request->input('json_id');
        $json = $this->json->find($json_id);

        if (null != $json) {

            $this->json->delete($json_id);
            activity('json')
                ->performedOn($json)
                ->withProperties($request->all())
                ->log('User: :causer.email - Delete Json - json_id: :properties.json_id, name: ' . $json->name);

            return redirect()->route('adtech.core.json.manage')->with('success', trans('adtech-core::messages.success.delete'));
        } else {
            return redirect()->route('adtech.core.json.manage')->with('error', trans('adtech-core::messages.error.delete'));
        }
    }

    public function manage(Request $request)
    {
        $domains = Domain::all(['domain_id', 'name']);
        $domain_id = $this->domainDefault;
        if ($request->has('domain_id')) {
            $domain_id = $request->input('domain_id');
        }

        return view('ADTECH-CORE::modules.core.json.manage', compact('domains', 'domain_id'));
    }

    public function getModalExport(JsonRequest $request)
    {
        $model = 'json';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'json_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {

            Cache::forget('locales' . $this->domainDefault);
            if (Cache::has('locales' . $this->domainDefault)) {
                $locales = Cache::get('locales' . $this->domainDefault);
            } else {
                $locales = Locale::where('domain_id', $this->domainDefault)->get();
                Cache::put('locales' . $this->domainDefault, $locales);
            }

            try {
                $confirm_route = route('adtech.core.json.export', ['json_id' => $request->input('json_id')]);
                return view('ADTECH-CORE::modules.core.json.modal_confirmation', compact('error', 'model', 'confirm_route', 'locales'));
            } catch (GroupNotFoundException $e) {
                return view('ADTECH-CORE::modules.core.json.modal_confirmation', compact('error', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }

    public function export(Request $request)
    {
        $language = $request->input('language');
        $json_id = $request->input('json_id');
        $locale = $request->input('locale');

        Cache::forget('locales' . $this->domainDefault);
        if (Cache::has('locales' . $this->domainDefault)) {
            $locales = Cache::get('locales' . $this->domainDefault);
        } else {
            $locales = Locale::where('domain_id', $this->domainDefault)->get();
            Cache::put('locales' . $this->domainDefault, $locales);
        }
        if ($language == 'all') {
            $locale = [];
            if (count($locales) > 0) {
                foreach ($locales as $item) {
                    $locale[] = $item->alias;
                }
            }
        }
        if (count($locale) > 0) {
            foreach ($locale as $locale) {
                $version = '0.0.1';
                $item = JsonVersion::where('json_id', $json_id)
                    ->where('locale', $locale)->latest()->first();

                if (null != $item) {
                    $versionArr = explode('.', $item->version);
                    if ($versionArr[2] < 20) {
                        $version = $versionArr[0] . '.' . $versionArr[1] . '.' . ($versionArr[2] + 1);
                    } elseif ($versionArr[1] < 20) {
                        $version = $versionArr[0] . '.' . ($versionArr[1] + 1) . '.0';
                    } else {
                        $version = ($versionArr[0] + 1) . '.0.0';
                    }
                }

                $versionItem = new JsonVersion();
                $versionItem->json_id = $json_id;
                $versionItem->locale = $locale;
                $versionItem->version = $version;
                $versionItem->save();

                $dataExport = null;
                $json = $this->json->find($json_id);
                if (null != $json) {
                    switch ($json->path) {
                        case '/resource/dev/get/version':
                            $dataExport = app('Nhvv\Api\App\Http\Controllers\SettingsController')->settingVersion();
                            break;
                        case '/resource/dev/get/setting':
                            $dataExport = app('Nhvv\Api\App\Http\Controllers\SettingsController')->settingNew();
                            break;
                        case '/resource/dev/get/listMaterialMarketSetting':
                            $dataExport = app('Nhvv\Api\App\Http\Controllers\SettingsController')->settingCart();
                            break;
                        case '/resource/dev/get/listBundle':
                            $dataExport = app('Nhvv\Api\App\Http\Controllers\SettingsController')->settingListBundle();
                            break;
                        case '/resource/dev/get/listStaff':
                            $dataExport = app('Nhvv\Itemsmanager\App\Http\Controllers\ApiController')->listStaff()->content();
                            $dataExport = json_encode(json_decode($dataExport)->data);
                            break;
                        case '/resource/dev/get/listMaterialData':
                            $dataExport = app('Nhvv\Itemsmanager\App\Http\Controllers\ApiController')->listMaterialData()->content();
                            $dataExport = json_encode(json_decode($dataExport)->data);
                            break;
                        case '/resource/dev/get/listDecoration':
                            $dataExport = app('Nhvv\Itemsmanager\App\Http\Controllers\ApiController')->listDecoration()->content();
                            $dataExport = json_encode(json_decode($dataExport)->data);
                            break;
                        case '/resource/dev/get/listFoodRecipe':
                            $dataExport = app('Nhvv\Itemsmanager\App\Http\Controllers\ApiController')->listFoodRecipe()->content();
                            $dataExport = json_encode(json_decode($dataExport)->data);
                            break;
                        case '/resource/dev/get/listInventoryUpgrade':
                            $dataExport = app('Nhvv\Itemsmanager\App\Http\Controllers\ApiController')->listInventoryUpgrade()->content();
                            $dataExport = json_encode(json_decode($dataExport)->data);
                            break;
                        case '/resource/dev/get/listMuster':
                            $dataExport = app('Nhvv\Diemdanhngay\App\Http\Controllers\DiemdanhController')->getapi()->content();
                            $dataExport = json_encode(json_decode($dataExport)->data);
                            break;
                        case '/resource/dev/get/listIAP':
                            $dataExportCombo = app('Nhvv\Iap\App\Http\Controllers\ComboController')->getAllCombo()->content();
                            $dataExportGoldgem = app('Nhvv\Iap\App\Http\Controllers\GoldgemController')->getAllGoldgem()->content();
                            $dataExport = '{
                                "list_iap_pack": '. json_encode(json_decode($dataExportCombo)->data) .',
                                "list_gold_pack": '. json_encode(json_decode($dataExportGoldgem)->data) .'
                            }';
                            break;
                    }
                }

                if (null == $dataExport) {
                    return abort(404);
                }
                $directory = 'json';
                if (!$this->files->isDirectory($directory)) {
                    mkdir($directory, 0755, true);
                }
                $directoryCurrent = 'json/current';
                if (!$this->files->isDirectory($directoryCurrent)) {
                    mkdir($directoryCurrent, 0755, true);
                }
                $directory = 'json/' . $version;
                if (!$this->files->isDirectory($directory)) {
                    mkdir($directory, 0755, true);
                }
                $directory = 'json/' . $version . '/' . $locale;
                if (!$this->files->isDirectory($directory)) {
                    mkdir($directory, 0755, true);
                }

                $filename = str_replace('/', '_', $json->path) . '.json';
                $pathFile = $directory . '/' . $filename;
                file_put_contents($pathFile, $dataExport);
                shell_exec('cd ../ && cp -r public/json/' . $version . '/' . $locale . '/' . $filename . ' public/json/current/' . $locale);
            }
        }

        return redirect()->route('adtech.core.json.manage', ['domain_id' => $json->domain_id])->with('success', trans('adtech-core::messages.success.update'));
    }

    public function download(Request $request) {
        $dataExport = null;
        $dir = 'resource_zip';
        if (!$this->files->isDirectory($dir)) {
            mkdir($dir, 0755, true);
        }
        $dir = 'resource';
        if (!$this->files->isDirectory($dir)) {
            mkdir($dir, 0755, true);
        }

        $json_id = $request->input('json_id');
        $json = $this->json->find($json_id);
        if (null != $json) {
            $item = JsonVersion::where('json_id', $json_id)
                ->where('locale', config('app.locale'))->latest()->first();
            if (null != $item) {
                $version = $item->locale . '_' . $item->version;
                $dir = 'resource/' . $version;
                if (!$this->files->isDirectory($dir)) {
                    mkdir($dir, 0755, true);
                }
                switch ($json->path) {
                    case '/resource/dev/get/setting':
                        $dataExport = app('Nhvv\Api\App\Http\Controllers\SettingsController')->settingNew();
                        $dataExport = json_decode($dataExport);
                        $arrResource = array_merge($dataExport->musicResource, $dataExport->mapObjectData->listObject);
                        if (count($arrResource) > 0) {

                            $dir = $dir . '/' . str_replace('/', '_', $json->path);
                            if (!$this->files->isDirectory($dir)) {
                                mkdir($dir, 0755, true);
                            }
                            foreach ($arrResource as $resource) {
                                $dirFile = '';
                                if (isset($resource->resource->bundleName))
                                    $dirFile = $dir . '/' . $resource->resource->bundleName;
                                elseif (isset($resource->sound->bundleName))
                                    $dirFile = $dir . '/' . $resource->sound->bundleName;

                                if ($dirFile != '') {
                                    if (!$this->files->isDirectory($dirFile)) {
                                        mkdir($dirFile, 0755, true);
                                    }
                                    shell_exec('cd ../ && cp -r public/' . $resource->files . ' public/' . $dirFile);
                                }
                            }
                            $arrBundle = [];
                            $ls = @scandir($dir);
                            if ($ls) {
                                foreach ($ls as $index => $bundle) {
                                    if ($bundle === '.' || $bundle === '..') {
                                        continue;
                                    }
                                    $arrBundle[] = $bundle;
                                }
                            }

                            //
                            $filename=str_replace('/', '_', $json->path) . '.tar.gz';
                            $myfile = 'resource_zip/' . str_replace('/', '_', $json->path) . '.tar.gz';
                            shell_exec('cd resource_zip/ && tar -cvzf - ../'.$dir.'/* > '.$filename);
                            header("Cache-Control: public");
                            header("Content-Description: File Transfer");
                            header("Content-Disposition: attachment; filename=$myfile");
                            header("Content-Type: application/octet-stream");
                            header('Content-Length: ' . filesize($myfile));
                            header("Content-Transfer-Encoding: binary");

                            // read the file from disk
                            readfile($myfile);
                        }
                        break;
                    case '/resource/dev/get/listMaterialMarketSetting':
                        $dataExport = app('Nhvv\Api\App\Http\Controllers\SettingsController')->listMaterialMarketSetting();
                        $dataExport = json_decode($dataExport);
                        $arrResource = array_merge($dataExport->data->settingCart);
                        if (count($arrResource) > 0) {

                            $dir = $dir . '/' . str_replace('/', '_', $json->path);
                            if (!$this->files->isDirectory($dir)) {
                                mkdir($dir, 0755, true);
                            }
                            foreach ($arrResource as $resource) {
                                $dirFile = '';
                                if (isset($resource->resource->bundleName))
                                    $dirFile = $dir . '/' . $resource->resource->bundleName;
                                elseif (isset($resource->sound->bundleName))
                                    $dirFile = $dir . '/' . $resource->sound->bundleName;

                                if ($dirFile != '') {
                                    if (!$this->files->isDirectory($dirFile)) {
                                        mkdir($dirFile, 0755, true);
                                    }
                                    shell_exec('cd ../ && cp -r public/' . $resource->files . ' public/' . $dirFile);
                                }
                            }
                            $arrBundle = [];
                            $ls = @scandir($dir);
                            if ($ls) {
                                foreach ($ls as $index => $bundle) {
                                    if ($bundle === '.' || $bundle === '..') {
                                        continue;
                                    }
                                    $arrBundle[] = $bundle;
                                }
                            }

                            //
                            $filename=str_replace('/', '_', $json->path) . '.tar.gz';
                            $myfile = 'resource_zip/' . str_replace('/', '_', $json->path) . '.tar.gz';
                            shell_exec('cd resource_zip/ && tar -cvzf - ../'.$dir.'/* > '.$filename);
                            header("Cache-Control: public");
                            header("Content-Description: File Transfer");
                            header("Content-Disposition: attachment; filename=$myfile");
                            header("Content-Type: application/octet-stream");
                            header('Content-Length: ' . filesize($myfile));
                            header("Content-Transfer-Encoding: binary");

                            // read the file from disk
                            readfile($myfile);
                        }
                        break;
                    case '/resource/dev/get/listMaterialData':
                        $dataExport = app('Nhvv\Itemsmanager\App\Http\Controllers\ApiController')->listMaterialData()->content();
                        $dataExport = json_decode($dataExport);
                        $arrResource = array_merge($dataExport->data->ListMaterial);
                        if (count($arrResource) > 0) {

                            $dir = $dir . '/' . str_replace('/', '_', $json->path);
                            if (!$this->files->isDirectory($dir)) {
                                mkdir($dir, 0755, true);
                            }
                            foreach ($arrResource as $resource) {
                                $dirFile = '';
                                if (isset($resource->resource->bundleName))
                                    $dirFile = $dir . '/' . $resource->resource->bundleName;
                                elseif (isset($resource->icon->bundleName))
                                    $dirFile = $dir . '/' . $resource->icon->bundleName;

                                if ($dirFile != '') {
                                    if (!$this->files->isDirectory($dirFile)) {
                                        mkdir($dirFile, 0755, true);
                                    }
                                    shell_exec('cd ../ && cp -r public/files/photos/' . $resource->icon->bundleName.'/'.$resource->icon->resourceName . '.png public/' . $dirFile);
                                }
                            }
                            $arrBundle = [];
                            $ls = @scandir($dir);
                            if ($ls) {
                                foreach ($ls as $index => $bundle) {
                                    if ($bundle === '.' || $bundle === '..') {
                                        continue;
                                    }
                                    $arrBundle[] = $bundle;
                                }
                            }

                            //
                            $filename=str_replace('/', '_', $json->path) . '.tar.gz';
                            $myfile = 'resource_zip/' . str_replace('/', '_', $json->path) . '.tar.gz';
                            shell_exec('cd resource_zip/ && tar -cvzf - ../'.$dir.'/* > '.$filename);
                            header("Cache-Control: public");
                            header("Content-Description: File Transfer");
                            header("Content-Disposition: attachment; filename=$myfile");
                            header("Content-Type: application/octet-stream");
                            header('Content-Length: ' . filesize($myfile));
                            header("Content-Transfer-Encoding: binary");

                            // read the file from disk
                            readfile($myfile);
                        }
                        break;
                    case '/resource/dev/get/listDecoration':
                        $dataExport = app('Nhvv\Itemsmanager\App\Http\Controllers\ApiController')->listDecoration()->content();
                        $dataExport = json_decode($dataExport);
                        $arrResource = array_merge($dataExport->data->listDecoration);
                        if (count($arrResource) > 0) {

                            $dir = $dir . '/' . str_replace('/', '_', $json->path);
                            if (!$this->files->isDirectory($dir)) {
                                mkdir($dir, 0755, true);
                            }
                            foreach ($arrResource as $resource) {
                                $dirFile = '';
                                if (isset($resource->resource->bundleName))
                                    $dirFile = $dir . '/' . $resource->resource->bundleName;
                                elseif (isset($resource->icon->bundleName))
                                    $dirFile = $dir . '/' . $resource->icon->bundleName;

                                if ($dirFile != '') {
                                    if (!$this->files->isDirectory($dirFile)) {
                                        mkdir($dirFile, 0755, true);
                                    }
                                    shell_exec('cd ../ && cp -r public/files/photos/' . $resource->icon->bundleName.'/'.$resource->icon->resourceName . '.png public/' . $dirFile);
                                }
                            }
                            $arrBundle = [];
                            $ls = @scandir($dir);
                            if ($ls) {
                                foreach ($ls as $index => $bundle) {
                                    if ($bundle === '.' || $bundle === '..') {
                                        continue;
                                    }
                                    $arrBundle[] = $bundle;
                                }
                            }

                            //
                            $filename=str_replace('/', '_', $json->path) . '.tar.gz';
                            $myfile = 'resource_zip/' . str_replace('/', '_', $json->path) . '.tar.gz';
                            shell_exec('cd resource_zip/ && tar -cvzf - ../'.$dir.'/* > '.$filename);
                            header("Cache-Control: public");
                            header("Content-Description: File Transfer");
                            header("Content-Disposition: attachment; filename=$myfile");
                            header("Content-Type: application/octet-stream");
                            header('Content-Length: ' . filesize($myfile));
                            header("Content-Transfer-Encoding: binary");

                            // read the file from disk
                            readfile($myfile);
                        }
                        break;
                    case '/resource/dev/get/listStaff':
                        $dataExport = app('Nhvv\Itemsmanager\App\Http\Controllers\ApiController')->listStaff()->content();
                        $dataExport = json_decode($dataExport);
                        $arrResource = array_merge($dataExport->data->ListStaffs,$dataExport->data->listStaffPackage);
                        if (count($arrResource) > 0) {

                            $dir = $dir . '/' . str_replace('/', '_', $json->path);
                            if (!$this->files->isDirectory($dir)) {
                                mkdir($dir, 0755, true);
                            }
                            foreach ($arrResource as $resource) {
                                $dirFile = '';
                                if (isset($resource->resource->bundleName))
                                    $dirFile = $dir . '/' . $resource->resource->bundleName;
                                elseif (isset($resource->icon->bundleName))
                                    $dirFile = $dir . '/' . $resource->icon->bundleName;

                                if ($dirFile != '') {
                                    if (!$this->files->isDirectory($dirFile)) {
                                        mkdir($dirFile, 0755, true);
                                    }
                                    shell_exec('cd ../ && cp -r public/files/photos/' . $resource->icon->bundleName.'/'.$resource->icon->resourceName . '.png public/' . $dirFile);
                                }
                            }
                            $arrBundle = [];
                            $ls = @scandir($dir);
                            if ($ls) {
                                foreach ($ls as $index => $bundle) {
                                    if ($bundle === '.' || $bundle === '..') {
                                        continue;
                                    }
                                    $arrBundle[] = $bundle;
                                }
                            }

                            //
                            $filename=str_replace('/', '_', $json->path) . '.tar.gz';
                            $myfile = 'resource_zip/' . str_replace('/', '_', $json->path) . '.tar.gz';
                            shell_exec('cd resource_zip/ && tar -cvzf - ../'.$dir.'/* > '.$filename);
                            header("Cache-Control: public");
                            header("Content-Description: File Transfer");
                            header("Content-Disposition: attachment; filename=$myfile");
                            header("Content-Type: application/octet-stream");
                            header('Content-Length: ' . filesize($myfile));
                            header("Content-Transfer-Encoding: binary");

                            // read the file from disk
                            readfile($myfile);
                        }
                        break;
                    case '/resource/dev/get/listFoodRecipe':
                        $dataExport = app('Nhvv\Itemsmanager\App\Http\Controllers\ApiController')->listFoodRecipe()->content();
                        $dataExport = json_decode($dataExport);
                        $arrResource = array_merge($dataExport->data->listFoodRecipe);
                        if (count($arrResource) > 0) {

                            $dir = $dir . '/' . str_replace('/', '_', $json->path);
                            if (!$this->files->isDirectory($dir)) {
                                mkdir($dir, 0755, true);
                            }
                            foreach ($arrResource as $resource) {
                                $dirFile = '';
                                if (isset($resource->resource->bundleName))
                                    $dirFile = $dir . '/' . $resource->resource->bundleName;
                                elseif (isset($resource->icon->bundleName))
                                    $dirFile = $dir . '/' . $resource->icon->bundleName;

                                if ($dirFile != '') {
                                    if (!$this->files->isDirectory($dirFile)) {
                                        mkdir($dirFile, 0755, true);
                                    }
                                    shell_exec('cd ../ && cp -r public/files/photos/' . $resource->icon->bundleName.'/'.$resource->icon->resourceName . '.png public/' . $dirFile);
                                }
                            }
                            $arrBundle = [];
                            $ls = @scandir($dir);
                            if ($ls) {
                                foreach ($ls as $index => $bundle) {
                                    if ($bundle === '.' || $bundle === '..') {
                                        continue;
                                    }
                                    $arrBundle[] = $bundle;
                                }
                            }

                            //
                            $filename=str_replace('/', '_', $json->path) . '.tar.gz';
                            $myfile = 'resource_zip/' . str_replace('/', '_', $json->path) . '.tar.gz';
                            shell_exec('cd resource_zip/ && tar -cvzf - ../'.$dir.'/* > '.$filename);
                            header("Cache-Control: public");
                            header("Content-Description: File Transfer");
                            header("Content-Disposition: attachment; filename=$myfile");
                            header("Content-Type: application/octet-stream");
                            header('Content-Length: ' . filesize($myfile));
                            header("Content-Transfer-Encoding: binary");

                            // read the file from disk
                            readfile($myfile);
                        }
                        break;
                    case '/resource/dev/get/listInventoryUpgrade':
                        $dataExport = app('Nhvv\Itemsmanager\App\Http\Controllers\ApiController')->listInventoryUpgrade()->content();
                        $dataExport = json_decode($dataExport);
                        $arrResource = array_merge($dataExport->data->listInventoryUpgrade);
                        if (count($arrResource) > 0) {

                            $dir = $dir . '/' . str_replace('/', '_', $json->path);
                            if (!$this->files->isDirectory($dir)) {
                                mkdir($dir, 0755, true);
                            }
                            foreach ($arrResource as $resource) {
                                $dirFile = '';
                                if (isset($resource->resource->bundleName))
                                    $dirFile = $dir . '/' . $resource->resource->bundleName;
                                elseif (isset($resource->icon->bundleName))
                                    $dirFile = $dir . '/' . $resource->icon->bundleName;

                                if ($dirFile != '') {
                                    if (!$this->files->isDirectory($dirFile)) {
                                        mkdir($dirFile, 0755, true);
                                    }
                                    shell_exec('cd ../ && cp -r public/files/photos/' . $resource->icon->bundleName.'/'.$resource->icon->resourceName . '.png public/' . $dirFile);
                                }
                            }
                            $arrBundle = [];
                            $ls = @scandir($dir);
                            if ($ls) {
                                foreach ($ls as $index => $bundle) {
                                    if ($bundle === '.' || $bundle === '..') {
                                        continue;
                                    }
                                    $arrBundle[] = $bundle;
                                }
                            }

                            //
                            $filename=str_replace('/', '_', $json->path) . '.tar.gz';
                            $myfile = 'resource_zip/' . str_replace('/', '_', $json->path) . '.tar.gz';
                            shell_exec('cd resource_zip/ && tar -cvzf - ../'.$dir.'/* > '.$filename);
                            header("Cache-Control: public");
                            header("Content-Description: File Transfer");
                            header("Content-Disposition: attachment; filename=$myfile");
                            header("Content-Type: application/octet-stream");
                            header('Content-Length: ' . filesize($myfile));
                            header("Content-Transfer-Encoding: binary");

                            // read the file from disk
                            readfile($myfile);
                        }
                        break;
                    case '/resource/dev/get/listMuster':
                        $dataExport = app('Nhvv\Diemdanhngay\App\Http\Controllers\DiemdanhController')->getapi()->content();
                        $dataExport = json_decode($dataExport);
                        $arrResource = array_merge($dataExport->data->ListDailyReward);
                        if (count($arrResource) > 0) {

                            $dir = $dir . '/' . str_replace('/', '_', $json->path);
                            if (!$this->files->isDirectory($dir)) {
                                mkdir($dir, 0755, true);
                            }
                            foreach ($arrResource as $resource) {
                                $dirFile = '';
                                if (isset($resource->resource->bundleName))
                                    $dirFile = $dir . '/' . $resource->resource->bundleName;
                                elseif (isset($resource->icon->bundleName))
                                    $dirFile = $dir . '/' . $resource->icon->bundleName;

                                if ($dirFile != '') {
                                    if (!$this->files->isDirectory($dirFile)) {
                                        mkdir($dirFile, 0755, true);
                                    }
                                    shell_exec('cd ../ && cp -r public/files/photos/' . $resource->icon->bundleName.'/'.$resource->icon->resourceName . '.png public/' . $dirFile);
                                }
                            }
                            $arrBundle = [];
                            $ls = @scandir($dir);
                            if ($ls) {
                                foreach ($ls as $index => $bundle) {
                                    if ($bundle === '.' || $bundle === '..') {
                                        continue;
                                    }
                                    $arrBundle[] = $bundle;
                                }
                            }

                            //
                            $filename=str_replace('/', '_', $json->path) . '.tar.gz';
                            $myfile = 'resource_zip/' . str_replace('/', '_', $json->path) . '.tar.gz';
                            shell_exec('cd resource_zip/ && tar -cvzf - ../'.$dir.'/* > '.$filename);
                            header("Cache-Control: public");
                            header("Content-Description: File Transfer");
                            header("Content-Disposition: attachment; filename=$myfile");
                            header("Content-Type: application/octet-stream");
                            header('Content-Length: ' . filesize($myfile));
                            header("Content-Transfer-Encoding: binary");

                            // read the file from disk
                            readfile($myfile);
                        }
                        break;
                }
            }

        }

        return abort(404);
    }

    public function show(JsonRequest $request)
    {
        $json_id = $request->input('json_id');
        $json = $this->json->find($json_id);
        $data = [
            'json' => $json
        ];

        return view('ADTECH-CORE::modules.core.json.edit', $data);
    }

    public function update(JsonRequest $request)
    {
        $json_id = $request->input('json_id');
        $json = $this->json->find($json_id);

        if (null != $json) {
            $json->name = $request->input('name');
            try {
                if ($json->save()) {

                    activity('json')
                        ->performedOn($json)
                        ->withProperties($request->all())
                        ->log('User: :causer.email - Update Json - json_id: :properties.json_id, name: :properties.name');

                    return redirect()->route('adtech.core.json.manage', ['domain_id' => $request->input('domain_id')])->with('success', trans('adtech-core::messages.success.update'));
                } else {
                    return redirect()->route('adtech.core.json.show', ['json_id' => $request->input('json_id'), 'domain_id' => $request->input('domain_id')])->with('error', trans('adtech-core::messages.error.update'));
                }
            } catch (QueryException $e) {
                return redirect()->route('adtech.core.json.show', ['json_id' => $request->input('json_id'), 'domain_id' => $request->input('domain_id')])->with('error', trans('adtech-core::messages.error.update'));
            }
        }
    }

    public function getModalDelete(JsonRequest $request)
    {
        $model = 'json';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'json_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $confirm_route = route('adtech.core.json.delete', ['json_id' => $request->input('json_id')]);
                return view('includes.modal_confirmation', compact('error', 'model', 'confirm_route'));
            } catch (GroupNotFoundException $e) {
                return view('includes.modal_confirmation', compact('error', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }

    public function log(Request $request)
    {
        $model = 'json';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $logs = Activity::where([
                    ['log_name', $model],
                    ['subject_id', $request->input('id')]
                ])->get();
                return view('includes.modal_table', compact('error', 'model', 'confirm_route', 'logs'));
            } catch (GroupNotFoundException $e) {
                return view('includes.modal_table', compact('error', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }

    //Table Data to index page
    public function data(Request $request)
    {
        $locale = config('app.locale');
        if ($request->has('domain_id')) {
            $domains = $this->json->findAll($request->input('domain_id'), $locale);
            return Datatables::of($domains)
                ->addColumn('actions', function ($jsons) {

                    $actions = '<a href=' . route('adtech.core.json.confirm-export', ['json_id' => $jsons->json_id]) . ' data-toggle="modal" data-target="#export"><i class="livicon" data-name="upload-alt" data-size="18" data-loop="true" data-c="#75C76F" data-hc="#75C76F" title="Export jsons"></i></a>';
                    $actions .= '&nbsp;<a href=' . route('adtech.core.json.download', ['json_id' => $jsons->json_id]) . '><i class="livicon" data-name="download-alt" data-size="18" data-loop="true" data-c="#4C8BCA" data-hc="#4C8BCA" title="Download bundle"></i></a>';
                    if ($this->user->canAccess('adtech.core.json.log')) {
                        $actions .= '<a href=' . route('adtech.core.json.log', ['type' => 'json', 'id' => $jsons->json_id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="Log jsons"></i></a>';
                    }
                    if ($this->user->canAccess('adtech.core.json.show')) {
                        $actions .= '<a href=' . route('adtech.core.json.show', ['json_id' => $jsons->json_id]) . '><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="update json"></i></a>';
                    }
                    if ($this->user->canAccess('adtech.core.json.confirm-delete')) {
                        $actions .= '<a href=' . route('adtech.core.json.confirm-delete', ['json_id' => $jsons->json_id]) . ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete jsons"></i></a>';
                    }

                    return $actions;
                })
                ->addColumn('version', function ($jsons) {
                    if (isset($jsons->version)) {
                        if (count($jsons->version) > 0) {
                            $versionList = $jsons->version->sortKeysDesc();
                            $locale = config('app.locale');
                            foreach ($versionList as $version) {
                                if ($locale == $version->locale) {
                                    return $version = 'Đã xuất ver ' . $version->version;
                                }
                            }
                        }
                    }
                    return 'Chưa xuất';
                })
                ->addIndexColumn()
                ->rawColumns(['actions', 'version'])
                ->make();
        }
        return null;
    }
}
