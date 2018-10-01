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

use Yajra\Datatables\Datatables;
use Validator,Auth,DB,Datetime,Cache;

class MemberfrontendController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );

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
        $list_member = $this->member->search($params);
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
            'table_id' => 'required',
        ], $this->messages);
        if (!$validator->fails()) {
            $member_id = $request->input('member_id');
            $table_id = $request->input('table_id');

            $member = $this->member->find($member_id); 

            $member->name = $request->input('name');
            if($member->is_reg==0){
                $member->email = $request->input('email');
            }

            $birthday = $request->input('day') . '-' . $request->input('month') . '-' . $request->input('year');
            $member->gender = $request->input('gender');
            $member->birthday = $birthday;
            $member->table_id = $table_id;
            $member->city_id = $request->input('city_id');
            $member->district_id = $request->input('district_id');
            $member->school_id = $request->input('school_id');
            $member->class_id = $request->input('class_id');
            $member->don_vi = $request->input('don_vi');
            $member->updated_at = new DateTime();
            if ($member->save()) {
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
}
