<?php

namespace Vne\Index\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Adtech\Application\Cms\Controllers\MController as Controller;
use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator,Auth,Config;

use Adtech\Core\App\Models\Menu;
use Vne\Banner\App\Models\Banner;
use Vne\News\App\Models\News;

use Vne\News\App\Repositories\NewsRepository;

class IndexController extends Controller
{
    protected $_menuList;
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );
    public function __construct( NewsRepository $newsRepository)
    {
        parent::__construct();
        $this->news = $newsRepository;
        $this->_user = Auth::user();
    }
    public function index()
    {
        $thongbaobtc = config('site.news_box.thongbaobtc');    
        $videonoibat = config('site.news_box.videonoibat');    
        $tintucchung = config('site.news_box.tintucchung');    
        $biendaovietnamtailieuthamkhaochocuocthi = config('site.news_box.biendaovietnamtailieuthamkhaochocuocthi');
        $thong_bao_ban_to_chuc = $this->news->getNewsByBox($thongbaobtc,2);
        $bien_dao_viet_nam = $this->news->getNewsByBox($biendaovietnamtailieuthamkhaochocuocthi,2);
        $tin_tuc_chung = $this->news->getNewsByBox($tintucchung,1);
        $video_noi_bat = $this->news->getNewsByBox($videonoibat,5);

        $banners = Banner::all();


        $data = [
            'banners' => $banners,
            'thong_bao_ban_to_chuc' => $thong_bao_ban_to_chuc,
            'bien_dao_viet_nam' => $bien_dao_viet_nam,
            'tin_tuc_chung' => $tin_tuc_chung,
            'video_noi_bat' => $video_noi_bat,
            'last_page_tin_tuc_chung' => $tin_tuc_chung->lastPage()

        ];
        return view('VNE-INDEX::modules.index.index',$data);
    } 

    public function getNewByBox(Request $request,$alias){
        $list_news = $this->news->getNewsByBox($alias,1);
        $list_news_json = array();
        if(!empty($list_news)){
            foreach ($list_news as $key => $news) {
                $list_news_json[] = [
                    'news_id' => $news->news_id,
                    'title_alias' => $news->title_alias,
                    'title' => $news->title,
                    'image' => $news->image,
                    'created_at' => date_format($news->created_at,"Y/m/d"),
                    'desc' => $news->desc,
                    'create_by' => $news->create_by
                ];
            }
        }
        return json_encode($list_news_json);
             
    }
}
