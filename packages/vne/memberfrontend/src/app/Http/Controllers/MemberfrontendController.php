<?php

namespace Vne\Memberfrontend\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\MController as Controller;
use Spatie\Activitylog\Models\Activity;

use Vne\Member\App\Models\Member;
use Vne\Member\App\Repositories\MemberRepository;

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
        $list_member = Member::orderBy('member_id','desc')->paginate(5);
        $data = [
            'list_member' => $list_member,
            'list_object' => $list_object,
            'list_table' => $list_table,
            'list_city' => $list_city,
            'list_district' => $list_district,
            'list_school' => $list_school,
            'list_class' => $list_class
        ];
        return view('VNE-MEMBERFRONTEND::modules.memberfrontend.list',$data);
    }

    public function show(Request $request)
    {
        $member = Auth::guard('member')->user();
        $class_old = DB::table('vne_classes')->where('class_id',$member->class_id)->first();
        $list_object = DB::table('vne_object')->get();
        $list_table = DB::table('vne_table')->get();
        $list_city = DB::table('vne_city')->get();
        $list_district = DB::table('vne_district')->where('city_id',$member->city_id)->get();
        $list_school =  DB::table('vne_school')->where('district_id',$member->district_id)->get();

        $data = [
            'member' => $member,
            'class_old' => $class_old,
            'list_object' => $list_object,
            'list_table' => $list_table,
            'list_city' => $list_city,
            'list_district' => $list_district,
            'list_school' => $list_school,
        ];
        return view('VNE-MEMBERFRONTEND::modules.memberfrontend.update',$data);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:4|max:50',
            'object_id' => 'required',
            'city_id' => 'required',
            'district_id' => 'required',
            'school_id' => 'required',
            'class_id' => 'required'
        ], $this->messages);
        if (!$validator->fails()) {
            $member_id = $request->input('member_id');
            $member = $this->member->find($member_id); 

            $member->name = $request->input('name');
            if($member->is_reg==0){
                $member->email = $request->input('email');
            }
            $member->birthday = $request->input('birthday');
            $member->gender = $request->input('gender');
            $member->object_id = $request->input('object_id');
            $member->city_id = $request->input('city_id');
            $member->district_id = $request->input('district_id');
            $member->school_id = $request->input('school_id');
            $member->class_id = $request->input('class_id');
            $member->is_reg = 1;

            $member->updated_at = new DateTime();
            if ($member->save()) {
                Cache::forget('member');
                return redirect()->route('vne.memberfrontend.show');
            } else {
                return redirect()->route('vne.member.member.manage');
            }
        }
        else{
            return $validator->messages();    
        }    
    }

}
