<?php

namespace Vne\Member\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Adtech\Core\App\HashSHA;
use MongoDB\Client;
use Vne\Member\App\Repositories\MemberRepository;
use Vne\Member\App\Models\Member;
use Vne\Member\App\Models\Group;
use Vne\Member\App\Models\GroupHasMember;
use Validator,Auth,DateTime,DB,Cache,Config;

class ApiController extends Controller
{
    public function __construct(MemberRepository $memberRepository)
    {
        parent::__construct();
        $this->member = $memberRepository;
    }
//    public function __construct(MemberRepository $memberRepository, ContestSeasonRepository $seasonRepository)
//    {
//        parent::__construct();
//        $this->member = $memberRepository;
//        $this->contestSeason = $seasonRepository;
//    }
    public function encrypt( $string) {
        $secret_key = '8bgCi@gsLbtGhO)1';
        $secret_iv = ')FQKRL57zFYdtn^!';
        $encrypt_method = "AES-256-CBC";
        $key = substr( hash( 'sha256',  $secret_key ), 0 ,32);
        $iv = substr( hash( 'sha256',  $secret_iv ), 0, 16 );
        $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
        return $output;
    }

    public function decrypt( $string) {
        $secret_key = '8bgCi@gsLbtGhO)1';
        $secret_iv = ')FQKRL57zFYdtn^!';
        $encrypt_method = "AES-256-CBC";
        $key = substr( hash( 'sha256',  $secret_key ), 0 ,32);
        $iv = substr( hash( 'sha256',  $secret_iv ), 0, 16 );
        $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
        return $output;
    }

    public function syncMongo(Request $request)
    {

        $limit = 500;
//        $offset = !empty($request->page) ? ($request->page - 1) * $limit : 0;
        $query = Member::query()->where(['sync_mongo' => '0', 'is_reg' => 1])->skip(0)->take($limit);
        $members = $query->get();
        if (!empty($members)) {
            $season = $this->contestSeason->getCurrentSeason();
            $arr = [];
            $count = Counters::find('candidate_id');
            $last_id = $count->seq;
            foreach ($members as $key => $value) {
                $last_id += 1;
                $arr[$key] = [];
                $arr[$key]['_id'] = (int)$last_id;
                $arr[$key]['season'] = !empty($season) ? $season->season_id : 1;
                $arr[$key]['city_name'] = !empty($value->city->name)?$value->city->name:'';
                $arr[$key]['district_name'] = !empty($value->district->name)?$value->district->name:'';
                $arr[$key]['school_name'] = !empty($value->school->name)?$value->school->name:'';
                foreach ($value->getAttributes() as $key1 => $value1) {
                    $arr[$key][$key1] = $value1;
                }

            }
            $collection = (new Client('mongodb://123.30.174.148'))->selectDatabase('daknong')->selectCollection('users_exam_info');
            $mongo_result = $collection->insertMany($arr);
            if (!empty($mongo_result)) {
                $count->seq = (double)($last_id);
                $count->update();
                $query->update(['sync_mongo' => '1']);
                echo "<pre>";
                print_r($mongo_result->getInsertedIds());
                echo "</pre>";
            }
        }
    }


    public function syncMongo_1(Request $request){

        $limit = !empty($request->limit)?$request->limit:100;
        $offset = !empty($request->page)?($request->page - 1)*$limit:0;
        $members = Member::query()->select('member_id')->where(['sync_mongo' => '0','is_reg' => 1])->skip($offset)->take($limit)->get();
        $id_list = [];
        if(!empty($members)){
            foreach ($members as $key => $member) {
                $id_list[] = $member->member_id;
            }
        }
        echo "<pre>";print_r(file_get_contents('http://timhieubiendao.daknong.vn/admin/api/contest/sync_candidate?data='.$this->encrypt(json_encode($id_list))));echo "</pre>";die;
    }

    public function getMemberData(Request $request){
        if(!empty($request->data)){
            $data = [];
            $member_ids = json_decode($this->decrypt($request->data),true);
            $members = Member::whereIn('member_id', $member_ids)->get();
            foreach ( $members as $key=>$value){
                $data[$key] = $value->getAttributes();
                $data[$key]['city_name'] = !empty($value->city->name)?$value->city->name:'';
                $data[$key]['district_name'] = !empty($value->district->name)?$value->district->name:'';
                $data[$key]['school_name'] = !empty($value->school->name)?$value->school->name:'';
            }
           return response()->json($data);
        }
    }

    public function updateSync(Request $request){
        if(!empty($request->data)){
            $member_ids = json_decode($this->decrypt($request->data),true);
            Member::whereIn('member_id', $member_ids)->update(['sync_mongo' => '1']);
            return response()->json(['status' => true]);
        }
    }
}
