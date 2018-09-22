<?php

namespace Vne\Member\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Vne\Member\App\Repositories\MemberRepository;
use Vne\Member\App\Models\Member;
use Vne\Member\App\Models\Group;
use Vne\Member\App\Models\GroupHasMember;
use Vne\Member\App\Http\Requests\MemberRequest;

use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator,Auth,DateTime,DB,Cache,Config;

class MemberController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số",
        'phone.regex' =>'Sai định dạng'
    );
    public function __construct(MemberRepository $memberRepository)
    {
        parent::__construct();
        $this->member = $memberRepository;
    }

    public function manage()
    {
        return view('VNE-MEMBER::modules.member.member.manage');
    }

    public function create()
    {
        $list_group = Group::all();

        $list_object = DB::table('vne_object')->get();
        
        $list_city = DB::table('vne_city')->get();
        
        $list_table = DB::table('vne_table')->get();
        
        $data = [
            'list_group' => $list_group,
            'list_object' => $list_object,
            'list_city' => $list_city,
            'list_table' => $list_table
        ];
        return view('VNE-MEMBER::modules.member.member.create',$data);
    }

    public function add(MemberRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:4|max:50',
            'u_name' => 'required|unique:vne_member,u_name|min:3|max:50',
            'password' => 'required|min:8|regex:"^(?=.*[a-z])(?=.*[A-Z])(?=.*)(?=.*[#$^+=!*()@%&]).{8,}$"',
            'conf_password' => 'required|min:8|regex:"^(?=.*[a-z])(?=.*[A-Z])(?=.*)(?=.*[#$^+=!*()@%&]).{8,}$"',
            'email' => 'required|unique:vne_member,email',
            'phone' => 'required|unique:vne_member,phone'
        ], $this->messages);
        if (!$validator->fails()) {
            $members = new Member();

            $members->token = $request->input('token');   
            $members->name = $request->input('name');
            $members->u_name = $request->input('u_name');
            $members->password = bcrypt($request->input('password'));
            $members->email = $request->input('email');
            $members->phone = $request->input('phone');
            $members->gender = $request->input('gender');
            $members->object_id = $request->input('object_id');
            $members->table_id = $request->input('table_id');
            $members->city_id = $request->input('city_id');
            $members->district_id = $request->input('district_id');
            $members->school_id = $request->input('school_id');
            $members->class_id = $request->input('class_id');

            $members->created_at = new DateTime();
            $members->updated_at = new DateTime();
            if ($members->save()) {
                Cache::forget('member');
                activity('member')
                    ->performedOn($members)
                    ->withProperties($request->all())
                    ->log('User: :causer.email - Add member - name: :properties.name, member_id: ' . $members->member_id);

                return redirect()->route('vne.member.member.manage')->with('success', trans('vne-member::language.messages.success.create'));
            } else {
                return redirect()->route('vne.member.member.manage')->with('error', trans('vne-member::language.messages.error.create'));
            }
        }
        else{
            return $validator->messages();    
        }
    } 

    public function show(MemberRequest $request)
    {
        $list_position = Position::all();
        $list_group = Group::all();
        $list_trinh_do_ly_luan = Member::select('trinh_do_ly_luan')->groupBy('trinh_do_ly_luan')->get();
        $list_trinh_do_chuyen_mon = Member::select('trinh_do_chuyen_mon')->groupBy('trinh_do_chuyen_mon')->get();
        $member_id = $request->input('member_id');
        $list_group_id = array();
        $group_has_member = GroupHasMember::where('member_id', $member_id)->get();
        if(!empty($group_has_member)){
            foreach ($group_has_member as $key => $value) {
                $list_group_id[] = $value['group_id'];
            } 
        }
        $member = $this->member->find($member_id);
        $data = [
            'member' => $member,
            'list_position' => $list_position,
            'list_trinh_do_ly_luan' => $list_trinh_do_ly_luan,
            'list_trinh_do_chuyen_mon' => $list_trinh_do_chuyen_mon,
            'list_group' => $list_group,
            'list_group_id' => $list_group_id
        ];

        return view('VNE-MEMBER::modules.member.member.edit', $data);
    }

    public function update(MemberRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:4|max:50',
        ], $this->messages);
        if (!$validator->fails()) { 
            $member_id = $request->input('member_id');
            $member = $this->member->find($member_id);
            $name = $request->input('name');
            $email = $request->input('email');
            $phone = $request->input('phone');
            $position_id = $request->input('position_id');
            $group_id = $request->input('group_id');
            $position_current = $request->input('position_current');
            $trinh_do_ly_luan = $request->input('trinh_do_ly_luan');
            $trinh_do_chuyen_mon = $request->input('trinh_do_chuyen_mon');
            $address = $request->input('address'); 
            $don_vi = $request->input('don_vi'); 
            $gender = $request->input('gender'); 
            $dan_toc = $request->input('dan_toc'); 
            $ton_giao = $request->input('ton_giao'); 
            $token = $request->input('_token');
            $birthday = $request->input('birthday'); 
            $ngay_vao_dang = $request->input('ngay_vao_dang'); 
            $ngay_vao_doan = $request->input('ngay_vao_doan'); 
            $avatar = !empty($request->input('avatar')) ? $request->input('avatar') :'';

            $member->name = $name;
            $member->email = $email;
            $member->phone = $phone;
            $member->position_id = $position_id;
            $member->position_current = $position_current;
            $member->trinh_do_ly_luan = $trinh_do_ly_luan;
            $member->trinh_do_chuyen_mon = $trinh_do_chuyen_mon;
            $member->address = $address;
            $member->don_vi = $don_vi;
            $member->gender = $gender;
            $member->dan_toc = $dan_toc;
            $member->ton_giao = $ton_giao;
            $member->token = $token;
            $member->birthday = $birthday;
            $member->ngay_vao_dang = $ngay_vao_dang;
            $member->ngay_vao_doan = $ngay_vao_doan;
            $member->avatar = $avatar;
            $member->updated_at = new DateTime();
            if ($member->save()) {
                DB::table('vne_group_has_member')->where(['member_id' => $member_id])->delete();
                if(!empty($group_id)){
                    $data_insert = array();
                    foreach ($group_id as $key => $g_i) {
                        if (!GroupHasMember::where([
                            'group_id' => $g_i,
                            'member_id' => $member_id,
                        ])->exists()
                        )
                        {
                            $data_insert[] = [
                                'group_id' => $g_i,
                                'member_id' => $member_id
                            ];
                        }
                    }
                }
                if(!empty($data_insert)){
                    DB::table('vne_group_has_member')->insert($data_insert);
                }
                Cache::forget('member');
                $member_elastic = new MemberElastic();
                $member_elastic->saveDocument($member->member_id);
                activity('member')
                    ->performedOn($member)
                    ->withProperties($request->all())
                    ->log('User: :causer.email - Update member - member_id: :properties.member_id, name: :properties.name');
                return redirect()->route('vne.member.member.manage')->with('success', trans('vne-member::language.messages.success.update'));
            } else {
                return redirect()->route('vne.member.member.show', ['member_id' => $request->input('member_id')])->with('error', trans('vne-member::language.messages.error.update'));
            }
        }
        else{
            return $validator->messages();    
        }
    }

    public function delete(Request $request)
    {
        $member_id = $request->input('member_id');
        $member = $this->member->find($member_id);
        if (null != $member) {
            $this->member->delete($member_id);
            Cache::forget('member');
            activity('member')
                ->performedOn($member)
                ->withProperties($request->all())
                ->log('User: :causer.email - Delete member - member_id: :properties.member_id, name: ' . $member->name);

            return redirect()->route('vne.member.member.manage')->with('success', trans('vne-member::language.messages.success.delete'));
        } else {
            return redirect()->route('vne.member.member.manage')->with('error', trans('vne-member::language.messages.error.delete'));
        }
    }

    public function getModalDelete(Request $request)
    {
        $model = 'member';
        $type = 'delete';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'member_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $confirm_route = route('vne.member.member.delete', ['member_id' => $request->input('member_id')]);
                return view('VNE-MEMBER::modules.member.modal.modal_confirmation', compact('error','type', 'model', 'confirm_route'));
            } catch (GroupNotFoundException $e) {
                return view('VNE-MEMBER::modules.member.modal.modal_confirmation', compact('error','type', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }

    public function block(Request $request)
    {
        $member_id = $request->input('member_id');
        $member = $this->member->find($member_id);
        if (null != $member) {
            $member->status = 2;
            $member->save();
            Cache::forget('member');
            activity('member')
                ->performedOn($member)
                ->withProperties($request->all())
                ->log('User: :causer.email - Block member - member_id: :properties.member_id, name: ' . $member->name);

            return redirect()->route('dhcd.member.member.manage')->with('success', trans('dhcd-member::language.messages.success.block'));
        } else {
            return redirect()->route('dhcd.member.member.manage')->with('error', trans('dhcd-member::language.messages.error.block'));
        }
    }

    public function getModalBlock(Request $request)
    {
        $model = 'member';
        $type = 'block';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'member_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $confirm_route = route('dhcd.member.member.block', ['member_id' => $request->input('member_id')]);
                return view('VNE-MEMBER::modules.member.modal.modal_confirmation', compact('error','type', 'model', 'confirm_route'));
            } catch (GroupNotFoundException $e) {
                return view('VNE-MEMBER::modules.member.modal.modal_confirmation', compact('error','type', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }

    public function log(Request $request)
    {
        $model = 'member';
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
                return view('VNE-MEMBER::modules.member.modal.modal_table', compact('error', 'model', 'confirm_route', 'logs'));
            } catch (GroupNotFoundException $e) {
                return view('VNE-MEMBER::modules.member.modal.modal_table', compact('error', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }

    //Table Data to index page
    public function data()
    {
        
        if (Cache::has('member')) {
            $members = Cache::get('member');
        } else{
            $members = Member::query();
            Cache::put('member', $members);
        }
        return Datatables::of($members)
            ->addIndexColumn()
            ->addColumn('actions', function ($members) {
                $actions = '';
                if ($this->user->canAccess('vne.member.member.log')) {
                    $actions .= '<a href=' . route('vne.member.member.log', ['type' => 'member', 'id' => $members->member_id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log member"></i></a>';
                }
                if ($this->user->canAccess('vne.member.member.show')) {
                    $actions .='<a href=' . route('vne.member.member.show', ['member_id' => $members->member_id]) . '><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="update member"></i></a>';
                }
                if ($this->user->canAccess('vne.member.member.confirm-delete')) {
                    $actions .= '<a href=' . route('vne.member.member.confirm-delete', ['member_id' => $members->member_id]) . ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete member"></i></a>
                        ';
                }
                return $actions;
            })
            ->rawColumns(['actions'])
            ->make();
    }

    public function checkUserNameExist(Request $request){
        $data['valid'] = true;
        if ($request->ajax()) {
            $member =  Member::where(['u_name' => $request->u_name])->first();
            if ($member) {
                $data['valid'] = false; // true là có user
            }
        }
        echo json_encode($data);
    }

    public function checkEmailExist(Request $request){
        $data['valid'] = true;
        if ($request->ajax()) {
            $member =  Member::where(['email' => $request->email])->first();
            if ($member) {
                $data['valid'] = false; // true là có user
            }
        }
        echo json_encode($data);
    }

    public function checkPhoneExist(Request $request){
        $data['valid'] = true;
        if ($request->ajax()) {
            $member =  Member::where(['phone' => $request->phone])->first();
            if ($member) {
                $data['valid'] = false; // true là có user
            }
        }
        echo json_encode($data);
    }

    public function getImport(){
        return view('VNE-MEMBER::modules.member.member.import');    
    }

    public function postImport(Request $request){   
        $validator = Validator::make($request->all(), [
            'path' => 'required'
        ], $this->messages);
        if (!$validator->fails()) {
            $term = $request->input('path');
            $url_storage = Config::get('site.url_storage');
            $url = $url_storage.$term;
            file_put_contents('excel.xls', file_get_contents($url));
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('excel.xls');
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = [];
            foreach ($worksheet->getRowIterator() AS $row) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(FALSE); // This loops through all cells,
                $cells = [];
                foreach ($cellIterator as $cell) {
                    $cells[] = $cell->getValue();
                }
                $rows[] = $cells;
            }
            if(!empty($rows)){
                foreach ($rows as $key => $value) {
                    $member = new Member();
                    $member->name =  $value[0] .' '. $value[1];
                    $member->position_current =  $value[7];
                    $member->trinh_do_chuyen_mon =  $value[5];
                    $member->trinh_do_ly_luan =  $value[6];
                    $member->gender =  $value[2]==null ? 'female' : 'male';
                    $member->birthday =  $value[2]==null ? (int)$value[3] : (int)$value[2];
                    $member->ngay_vao_dang =  $value[4];
                    if($member->save()){
                        $group_id = (int)$value[8];
                        $member_id = $member->member_id;
                        if (!GroupHasMember::where([
                            'group_id' => $group_id,
                            'member_id' => $member_id
                        ])->exists()
                        ){
                            $dhcd_group_has_member = new GroupHasMember();
                            $dhcd_group_has_member->member_id = $member_id;
                            $dhcd_group_has_member->group_id = $group_id;
                            $dhcd_group_has_member->save();
                            // DB::table('dhcd_group_has_member')->insert(['member_id' => $member_id, 'group_id' => $group_id]);
                        }
                        // $member_elastic = new MemberElastic();
                        // $member_elastic->saveDocument($member_id);
                    }
                }        
            } else {
                return redirect()->route('dhcd.member.member.manage')->with('error', trans('dhcd-member::language.messages.error.import'));    
            }
            return redirect()->route('dhcd.member.member.manage')->with('success', trans('dhcd-member::language.messages.success.import'));
        } else {
            return $validator->messages(); 
        }
    }
    
    public function getDistrict(Request $request){
        $list_district = DB::table('vne_district')->where('city_id',$request->input('city_id'))->get();
        $list_district_json = array();
        if(!empty($list_district)){
            foreach ($list_district as $key => $district) {
                $list_district_json[] = [
                    'district_id' => $district->district_id,
                    'name' => $district->name
                ];
            }
        }
        return json_encode($list_district_json);      
    }

    public function getSchool(Request $request){
        $list_school = DB::table('vne_school')->where('district_id',$request->input('district_id'))->get();
        $list_school_json = array();
        if(!empty($list_school)){
            foreach ($list_school as $key => $school) {
                $list_school_json[] = [
                    'school_id' => $school->school_id,
                    'name' => $school->name
                ];
            }
        }
        return json_encode($list_school_json);
    }

    public function getClass(Request $request){
        $level_id = DB::table('vne_school')->where('school_id',$request->input('school_id'))->value('level_id');
        $list_class = DB::table('vne_classes')->where('level',$level_id)->get();
        $list_class_json = array();
        if(!empty($list_class)){
            foreach ($list_class as $key => $class) {
                $list_class_json[] = [
                    'class_id' => $class->class_id,
                    'name' => $class->name
                ];
            }
        }
        return json_encode($list_class_json);
    }
}