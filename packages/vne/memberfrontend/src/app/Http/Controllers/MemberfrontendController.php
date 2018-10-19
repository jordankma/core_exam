<?php

namespace Vne\Memberfrontend\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\MController as Controller;
use Spatie\Activitylog\Models\Activity;

use Vne\Member\App\Models\Member;
use Vne\Member\App\Repositories\MemberRepository;

use Vne\Member\App\Models\Table;
use Vne\Member\App\Models\School;
use Vne\Member\App\Models\District;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

use Yajra\Datatables\Datatables;
use Validator,Auth,DB,Datetime,Cache;
use GuzzleHttp\Client;

class MemberfrontendController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );

    protected $secret_key = '8bgCi@gsLbtGhO)1';
    protected $secret_iv = ')FQKRL57zFYdtn^!';

    public function __construct(MemberRepository $memberRepository)
    {
        parent::__construct();
        $this->member = $memberRepository;
    }

    public function list(Request $request)
    {
        $list_object = DB::table('vne_object')->get();
        $list_table = DB::table('vne_table')->get();
        $list_city = DB::table('vne_city')->get();
        $list_district = DB::table('vne_district')->get();
        $list_school =  DB::table('vne_school')->get();
        $list_class =  DB::table('vne_classes')->get();
        $list_member = Member::orderBy('member_id','desc')->where('is_reg',1)->paginate(20);
        $params = [
            'table_id' => '',
            'u_name' => '',
            'name' => '',
            'city_id' => '',
            'district_id' => '',
            'school_id' => '',
            'class_id' => ''
        ];
        $data = [
            'list_member' => $list_member,
            'list_object' => $list_object,
            'list_table' => $list_table,
            'list_city' => $list_city,
            'list_district' => $list_district,
            'list_school' => $list_school,
            'list_class' => $list_class,
            'params' => $params,
        ];
        return view('VNE-MEMBERFRONTEND::modules.memberfrontend.list',$data);
    }

    public function search(Request $request){
        $params = [
            'table_id' => $request->input('table_id'),
            'u_name' => $request->input('u_name'),
            'name' => $request->input('name'),
            'city_id' => $request->input('city_id'),
            'district_id' => $request->input('district_id'),
            'school_id' => $request->input('school_id'),
            'class_id' => $request->input('class_id')
        ];

        $list_object = DB::table('vne_object')->get();
        $list_table = DB::table('vne_table')->get();
        $list_city = DB::table('vne_city')->get();
        $list_district = DB::table('vne_district')->get();
        $list_school =  DB::table('vne_school')->get();
        $list_class =  DB::table('vne_classes')->get();
        $member = new Member();
        $list_member = $member->search($params);
        $data = [
            'list_member' => $list_member,
            'list_object' => $list_object,
            'list_table' => $list_table,
            'list_city' => $list_city,
            'list_district' => $list_district,
            'list_school' => $list_school,
            'list_class' => $list_class,
            'params' => $params
        ];
        return view('VNE-MEMBERFRONTEND::modules.memberfrontend.list',$data);
    }

    public function show()
    {
        $city_id_default = config('site.city_id_default');
        
        $member = Auth::guard('member')->user();
        if($member->is_reg==1){
            return redirect()->route('index');
        }
        $list_table = DB::table('vne_table')->get();
        $city = DB::table('vne_city')->where('city_id',$city_id_default)->first();
        $list_district = DB::table('vne_district')->get();
        $list_school =  DB::table('vne_school')->where('district_id',$member->district_id)->get();
        if($member->birthday==null){
            $member->birthday ='10-10-1995';   
        }
        $data = [
            'member' => $member,
            'birthday' => explode("-",$member->birthday),
            'list_table' => $list_table,
            'list_district' => $list_district,
            'list_school' => $list_school,
            'city' => $city
        ];
        return view('VNE-MEMBERFRONTEND::modules.memberfrontend.update',$data);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:4|max:50',
            'city_id' => 'required',
            'table_id' => 'required'
        ], $this->messages);
        if (!$validator->fails()) {

            $member_id = $request->input('member_id');
            $table_id = $request->input('table_id');
            $table_name = $request->input('table_name');
            $city_id = $request->input('city_id');
            $city_name = $request->input('city_name');
            $district_id = $request->input('district_id');
            $district_name = $request->input('district_name');
            $school_id = $request->input('school_id');
            $school_name = $request->input('school_name');
            $don_vi = $request->input('don_vi');
            $gender = $request->input('gender');
            $class_id = $request->input('class_id');
            $birthday = $request->input('day') . '-' . $request->input('month') . '-' . $request->input('year');
            
            
            $member = $this->member->find($member_id); 

            $member->name = $request->input('name');
            if($member->is_reg==0){
                $member->email = $request->input('email');
            }

            $member->gender = $gender;
            $member->birthday = $birthday;
            $member->table_id = $table_id;
            $member->city_id = $city_id;
            $member->district_id = $district_id;
            $member->school_id = $school_id;
            $member->class_id = $class_id;
            $member->don_vi = $don_vi;
            $member->sync_mongo = '1';

            $member->updated_at = new DateTime();
            if ($member->save()) {
                // $data = "member_id=" . $member_id . "&u_name=" . $member->u_name . "&table_id=" . $table_id . "&table_name=" . $table_name . "&city_id=" . $city_id . "&city_name=" . $city_name . "&district_id=" . $district_id. "&district_name=" . $district_name. "&school_id=" . $school_id. "&school_name=" . $school_name. "&don_vi=" . $don_vi. "&gender=" . $gender. "&birthday=" . $birthday;
                $data = $member->getAttributes();
                $data['city_name'] = $city_name;
                $data['district_name'] = $district_name;
                $data['school_name'] = $school_name;
                $data = http_build_query($data);
                $data_encrypt = $this->my_simple_crypt($data);
                $client = new Client();
                // $res = $client->request('GET', 'http://timhieubiendao.daknong.vn/admin/api/contest/candidate_register&data=' . $data_encrypt);
                $result = file_get_contents('http://timhieubiendao.daknong.vn/admin/api/contest/candidate_register?data='. $data_encrypt);
                $result = json_decode($result);
                if($result->status == true){
                    $member->sync_mongo = '1';
                    $member->update();
                }
                if($member->is_reg==0){
                    $table = Table::find($table_id);  
                    $district = District::find($request->input('district_id'));  
                    $school = School::find($request->input('school_id'));
                    if($table_id==config('site.table_a_id')){

                        $user_reg_exam_a = $table->user_reg_exam_a;
                        $table->user_reg_exam_a = $user_reg_exam_a + 1;   
                        $table->save();

                        $user_reg_exam_a = $district->user_reg_exam_a;
                        $district->user_reg_exam_a = $user_reg_exam_a + 1;   
                        $district->save();  

                        $user_reg_exam_a = $school->user_reg_exam_a;
                        $school->user_reg_exam_a = $user_reg_exam_a + 1;   
                        $school->save(); 
                    }   
                    elseif($table_id==config('site.table_b_id')){
                        $user_reg_exam_b = $table->user_reg_exam_b;
                        $table->user_reg_exam_b = $user_reg_exam_b + 1;   
                        $table->save();

                        $user_reg_exam_b = $district->user_reg_exam_b;
                        $district->user_reg_exam_b = $user_reg_exam_b + 1;   
                        $district->save();
                        // $user_reg_exam_b = $school->user_reg_exam_b;
                        // $school->user_reg_exam_b = $user_reg_exam_b + 1;   
                        // $school->save(); 
                    }     
                }
                $member->is_reg = 1;
                $member->save();
                Cache::forget('member');
                Cache::forget('list_member_top_a');
                Cache::forget('list_member_top_b');
                return redirect()->route('index');
            } else {
                return redirect()->route('vne.member.member.manage');
            }
        }
        else{
            return $validator->messages();    
        }    
    }

    public function listTopMember(){
        $list_member_top_a = District::query()->orderBy('user_reg_exam_a','desc')->get();
        $list_member_top_b = District::query()->orderBy('user_reg_exam_b','desc')->get();
        $data = [
            'list_member_top_a' => $list_member_top_a,
            'list_member_top_b' => $list_member_top_b
        ];
        return view('VNE-MEMBERFRONTEND::modules.memberfrontend.list_reg',$data);
            
    }

    public function resultMember($member_id){
        $client = new Client();
        $res = $client->request('GET', 'http://timhieubiendao.daknong.vn/admin/api/contest/get_contest_result?user_id='.$member_id);
        $data_reponse = json_decode($res->getBody());
        foreach ($data_reponse as $key => $value) {
            $point = 0;
            if(isset($value->answers) && !empty($value->answers)){
                foreach ($value->answers as $key2 => $value2) {
                    if($key2 >= 0 &&  $key2 <= 19){
                        if($value2->correct==true){
                            $point+=5;
                        }
                    }
                    elseif( $key2 >= 20 &&  $key2 <= 29){
                        if($value2->correct==true){
                            $point+=10;
                        }    
                    }
                }
            }
            $data_reponse[$key]->total_point = $point;
        }
        $member = Member::where('member_id', $member_id)->with('city','school','classes')->first();
        $data = [
            'member' => $member,
            'result' => $data_reponse
        ];
        return view('VNE-MEMBERFRONTEND::modules.memberfrontend.result_member',$data);    
    }
    
    public function result(Request $request){
        $list_object = DB::table('vne_object')->get();
        $list_table = DB::table('vne_table')->get();
        $list_city = DB::table('vne_city')->get();
        $list_district = DB::table('vne_district')->get();
        $list_school =  DB::table('vne_school')->get();
        $list_class =  DB::table('vne_classes')->get();

        $params = [
            'table_id' => !empty($request->table_id)?$request->table_id:0,
            'u_name' => !empty($request->u_name)?$request->u_name:0,
            'name' => !empty($request->name)?$request->name:0,
            'city_id' => !empty($request->city_id)?$request->city_id:0,
            'district_id' => !empty($request->district_id)?$request->district_id:0,
            'school_id' => !empty($request->school_id)?$request->school_id:0,
            'class_id' => !empty($request->class_id)?$request->class_id:0,
            'page'=> !empty($request->page)?$request->page:1
        ];
//        $client = new Client();
        // $res = $client->request('GET', 'http://timhieubiendao.daknong.vn/admin/api/contest/search_contest_result');
        $list_member = file_get_contents('http://timhieubiendao.daknong.vn/admin/api/contest/search_contest_result?'. http_build_query($params));
        $list_member = json_decode($list_member, true);
        // dd($list_member);
        foreach ($list_member['data'] as $key => $value) {
            $point = 0;
            if(isset($value['answers']) && !empty($value['answers'])){
                foreach ($value['answers'] as $key2 => $value2) {
                    if($key2 >= 0 &&  $key2 <= 19){
                        if($value2['correct']==true){
                            $point+=5;
                        }
                    }
                    elseif( $key2 >= 20 &&  $key2 <= 29){
                        if($value2['correct']==true){
                            $point+=10;
                        }    
                    }
                }
            }
            $list_member['data'][$key]['total_point'] = $point;
        }
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $collection = new Collection($list_member['data']);
        $perPage = 20;
        $paginatedSearchResults= new LengthAwarePaginator($collection, $list_member['total'], $perPage, $currentPage,['url' => route('vne.memberfrontend.result'),'path' => 'ket-qua?'. http_build_query($params)]);

        $data = [
            'list_member' => $paginatedSearchResults,
            'list_object' => $list_object,
            'list_table' => $list_table,
            'list_city' => $list_city,
            'list_district' => $list_district,
            'list_school' => $list_school,
            'list_class' => $list_class,
            'params' => $params,
        ];
        return view('VNE-MEMBERFRONTEND::modules.memberfrontend.result',$data);     
    }

    public function searchResult(){
    	//test
    }

    public function syncMongo(Request $request){
        $limit = !empty($request->limit)?$request->limit:100;
        $offset = !empty($request->page)?($request->page - 1)*100:0;
        $members = Member::query()->select('member_id')->where(['sync_mongo' => '0','is_reg' => 1])->skip($offset)->take($limit)->get();
        echo "<pre>";print_r($members);echo "</pre>";die;
    }

    function my_simple_crypt( $string, $action = 'e' ) {
        // you may change these values to your own
        $secret_key = $this->secret_key;
        $secret_iv = $this->secret_iv;
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $key = substr( hash( 'sha256', $secret_key ), 0 ,32);
        $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
        if( $action == 'e' ) {
            $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
        }
        else if( $action == 'd' ){
            $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
        }
        return $output;
    }
}
