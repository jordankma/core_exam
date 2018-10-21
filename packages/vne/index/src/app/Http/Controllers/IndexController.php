<?php

namespace Vne\Index\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Adtech\Application\Cms\Controllers\MController as Controller;
use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator,Auth,Config,Cache,DB;

use Adtech\Core\App\Models\Menu;
use Vne\Banner\App\Models\Banner;
use Vne\News\App\Models\News;
use Vne\Member\App\Models\Member;
use Vne\Member\App\Models\Table;
use Vne\Member\App\Models\School;
use Vne\Member\App\Models\District;

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
        $this->_user = Auth::guard('member')->user();
    }
    public function cmp($a, $b){
        return  strnatcmp($a['total'], $b['total']);
    }
    public function index()
    {
        $thongbaobtc = config('site.news_box.thongbaobtc');    
        $videonoibat = config('site.news_box.videonoibat');    
        $tintucchung = config('site.news_box.tintucchung');    
        $biendaovietnamtailieuthamkhaochocuocthi = config('site.news_box.biendaovietnamtailieuthamkhaochocuocthi');

        // $thong_bao_ban_to_chuc = $this->news->getNewsByBox($thongbaobtc,10);
        // $bien_dao_viet_nam = $this->news->getNewsByBox($biendaovietnamtailieuthamkhaochocuocthi,10);.
        $bien_dao_viet_nam = array();
        $tin_tuc_chung = $this->news->getNewsByBox($tintucchung,15);
        // $video_noi_bat = $this->news->getNewsByBox($videonoibat,5);

        if (Cache::has('tintucchung')) {
            $tintucchung = Cache::get('tintucchung');
        } else {
            $tintucchung = $this->news->getNewsByBox($tintucchung,15);
            Cache::put('tintucchung',$tintucchung);
        }

        if (Cache::has('thong_bao_ban_to_chuc')) {
            $thong_bao_ban_to_chuc = Cache::get('thong_bao_ban_to_chuc');
        } else {
            $thong_bao_ban_to_chuc = $this->news->getNewsByBox($thongbaobtc,10);
            Cache::put('thong_bao_ban_to_chuc',$thong_bao_ban_to_chuc);
        }

        if (Cache::has('video_noi_bat')) {
            $video_noi_bat = Cache::get('video_noi_bat');
        } else {
            $video_noi_bat = $this->news->getNewsByBox($videonoibat,10);
            Cache::put('video_noi_bat',$video_noi_bat);
        }

        if (Cache::has('banner')) {
            $banners = Cache::get('banner');
        } else {
            $banners = Banner::all();
            Cache::put('banner',$banners);
        }

        if (Cache::has('list_member_top_a')) {
            $list_member_top_a = Cache::get('list_member_top_a');
        } else {
        	$list_member_top_a = District::query()->orderBy('user_reg_exam_a','desc')->limit(3)->get();
            Cache::put('list_member_top_a',$list_member_top_a);
        }
        if (Cache::has('list_member_top_b')) {
            $list_member_top_b = Cache::get('list_member_top_b');
        } else {
        	$list_member_top_b = District::query()->orderBy('user_reg_exam_b','desc')->limit(3)->get();
            Cache::put('list_member_top_b',$list_member_top_b);
        }
        if (Cache::has('list_news_member')) {
            $list_news_member = Cache::get('list_news_member');
        } else {
        	$list_news_member = Member::orderBy('member_id', 'desc')->where('is_reg',1)->with('city','school','classes')->limit(8)->get();
            Cache::put('list_news_member',$list_news_member);
        }
        //get top exam
        if (Cache::has('list_district')) {
            $list_district = Cache::get('list_district');
        } else {
            $list_district = DB::table('vne_district')->get();
            Cache::put('list_district',$list_district);
        }
        
        $list_member_exam_top_a = file_get_contents('http://timhieubiendao.daknong.vn/admin/api/contest/get_top?top_type=district&table_id=1');
        $list_member_exam_top_a = json_decode($list_member_exam_top_a, true);
        usort($list_member_exam_top_a, array($this, "cmp"));
        if(!empty($list_member_exam_top_a) && !empty($list_district)){
            foreach ($list_member_exam_top_a as $key => $value) {
                foreach ($list_district as $key2 => $value2) {
                    if($value['_id']['district_id'] == $value2->district_id){
                        $list_member_exam_top_a[$key]['district_name'] = $value2->name;   
                    }        
                }    
            }
        }
        $list_member_exam_top_b = file_get_contents('http://timhieubiendao.daknong.vn/admin/api/contest/get_top?top_type=district&table_id=2');
        $list_member_exam_top_b = json_decode($list_member_exam_top_b, true);

        usort($list_member_exam_top_b, array($this, "cmp"));
        if(!empty($list_member_exam_top_b) && !empty($list_district)){
            foreach ($list_member_exam_top_b as $key => $value) {
                foreach ($list_district as $key2 => $value2) {
                    if($value['_id']['district_id'] == $value2->district_id){
                        $list_member_exam_top_b[$key]['district_name'] = $value2->name;   
                    }        
                }    
            }
        }
        $data = [
            'banners' => $banners,
            'thong_bao_ban_to_chuc' => $thong_bao_ban_to_chuc,
            'bien_dao_viet_nam' => $bien_dao_viet_nam,
            'tin_tuc_chung' => $tin_tuc_chung,
            'video_noi_bat' => $video_noi_bat,
            'last_page_tin_tuc_chung' => $tin_tuc_chung->lastPage(),
            'list_news_member' => $list_news_member,
            'list_member_top_a' => $list_member_top_a,
            'list_member_top_b' => $list_member_top_b,
            'list_member_exam_top_a' => array_reverse($list_member_exam_top_a),
            'list_member_exam_top_b' => array_reverse($list_member_exam_top_b)

        ];
        return view('VNE-INDEX::modules.index.index',$data);
    } 

    public function getNewByBox(Request $request,$alias){
        $list_news = $this->news->getNewsByBox($alias,15);
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
    public function getTryExam(Request $request){
        return '<p style="color:red;margin:22%;font-size:30px;">Thời gian thi thử kết thúc để chuẩn bị cho thi thật!!! Mời bạn quay lại sau.</p>';
        $uid = Auth::guard('member')->user()->member_id;
        $game_token = Auth::guard('member')->user()->token;
        // $game_token = 'minhnt'.$uid;
        $ip_port = 'http://123.30.174.148:4555/';
        $src = 'thi-thu';
        $src = $src.'?game_token='.$game_token.'&uid='.$uid.'&ip_port='.$ip_port;
        $data = [
            'game_token' => $game_token,
            'uid' => $uid,
            'ip_port' => $ip_port,
            'src' => $src
        ];
        return view('VNE-INDEX::modules.index.contest.index',$data);
    }

    public function getRealExam(Request $request){
        $uid = Auth::guard('member')->user()->member_id;
        // if(in_array($uid, [4448,4450,4451,4452,4453,4628,4629,4630,4631,4632,4633])){
        if(Auth::guard('member')->user()->is_reg==2){
            $game_token = Auth::guard('member')->user()->token;
            // $game_token = 'minhnt'.$uid;
            $url_result = route('vne.memberfrontend.result.member',$uid);
            $ip_port = 'http://123.30.174.148:4555/';
            $src = 'thi-thu';
            $src = $src.'?game_token='.$game_token.'&uid='.$uid.'&ip_port='.$ip_port;
            $data = [
                'game_token' => $game_token,
                'uid' => $uid,
                'ip_port' => $ip_port,
                'src' => $src,
                'url_result' => $url_result
            ];
            return view('VNE-INDEX::modules.index.contest.index_real',$data);
        }
        else {
            return redirect()->route('index');
        }
    }
}
