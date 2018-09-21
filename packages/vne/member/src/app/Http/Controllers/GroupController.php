<?php

namespace Vne\Member\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;

use Vne\Member\App\Repositories\GroupRepository;

use Vne\Member\App\Models\Group;
use Vne\Member\App\Models\GroupHasMember;
use Vne\Member\App\Models\Member;

use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;

use Validator,DateTime,DB,Cache;
class GroupController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );

    public function __construct(GroupRepository $groupRepository)
    {
        parent::__construct();
        $this->group = $groupRepository;
    }

    public function manage()
    {
        return view('VNE-MEMBER::modules.member.group.manage');
    }

    public function create()
    {
        return view('VNE-MEMBER::modules.member.group.create');
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:1|max:200',
        ], $this->messages);
        if (!$validator->fails()) {
            $name = $request->input('name');
            $groups = new Group();
            $groups->name = $name;
            $groups->type = $request->input('type');
            $groups->image = $request->input('image');
            $groups->desc = $request->input('desc');
            $groups->alias = strtolower(preg_replace('([^a-zA-Z0-9])', '', self::stripUnicode($name)));
            $groups->created_at = new DateTime();
            $groups->updated_at = new DateTime();

            if ($groups->save()) {
                Cache::forget('member_group');
                activity('group')
                    ->performedOn($groups)
                    ->withProperties($request->all())
                    ->log('User: :causer.email - Add group - name: :properties.name, group_id: ' . $groups->group_id);

                return redirect()->route('vne.member.group.manage')->with('success', trans('vne-member::language.messages.success.create'));
            } else {
                return redirect()->route('vne.member.group.manage')->with('error', trans('vne-member::language.messages.error.create'));
            }
        } else {
            return $validator->messages();
        }
    }

    public function show(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'group_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            $group_id = $request->input('group_id');
            $group = $this->group->find($group_id);
            if($group==null) {
                return redirect()->route('vne.member.group.manage')->with('error', trans('vne-member::language.messages.error.update'));   
            }
            $data = [
                'group' => $group
            ];

            return view('VNE-MEMBER::modules.member.group.edit', $data);
        } else {
            return $validator->messages();
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'group_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            $group_id = $request->input('group_id');
            $name = $request->input('name');
            $group = $this->group->find($group_id);
            $group->name = $name;
            $group->type = $request->input('type');
            $group->image = $request->input('image');
            $group->desc = $request->input('desc');
            $group->alias = strtolower(preg_replace('([^a-zA-Z0-9])', '', self::stripUnicode($name)));
            $group->updated_at = new DateTime();
            if ($group->save()) {
                Cache::forget('member_group');
                activity('group')
                    ->performedOn($group)
                    ->withProperties($request->all())
                    ->log('User: :causer.email - Update group - group_id: :properties.group_id, name: :properties.name');

                return redirect()->route('vne.member.group.manage')->with('success', trans('vne-member::language.messages.success.update'));
            } else {
                return redirect()->route('vne.member.group.show', ['group_id' => $request->input('group_id')])->with('error', trans('vne-member::language.messages.error.update'));
            }
        } else {
            return $validator->messages();    
        }
    }

    public function getModalDelete(Request $request)
    {
        $model = 'group';
        $type = 'delete';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'group_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $confirm_route = route('vne.member.group.delete', ['group_id' => $request->input('group_id')]);
                return view('VNE-MEMBER::modules.member.modal.modal_confirmation', compact('type','error', 'model', 'confirm_route'));
            } catch (GroupNotFoundException $e) {
                return view('VNE-MEMBER::modules.member.modal.modal_confirmation', compact('type','error', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }

    public function delete(Request $request)
    {
        $group_id = $request->input('group_id');
        $group = $this->group->find($group_id);

        if (null != $group) {
            $this->group->delete($group_id);
            Cache::forget('member_group');
            activity('group')
                ->performedOn($group)
                ->withProperties($request->all())
                ->log('User: :causer.email - Delete group - group_id: :properties.group_id, name: ' . $group->name);

            return redirect()->route('vne.member.group.manage')->with('success', trans('vne-member::language.messages.success.delete'));
        } else {
            return redirect()->route('vne.member.group.manage')->with('error', trans('vne-member::language.messages.error.delete'));
        }
    }

    public function log(Request $request)
    {
        $model = 'group';
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
        if (Cache::has('member_group')) {
            $groups = Cache::get('member_group');
        } else{
            $groups = $this->group->all();    
            Cache::put('member_group', $groups);
        }
        return Datatables::of($groups)
            ->addIndexColumn()
            ->addColumn('actions', function ($groups) {
                $actions = '';
                if ($this->user->canAccess('vne.member.group.log')) {
                    $actions .= '<a href=' . route('vne.member.group.log', ['type' => 'group', 'id' => $groups->group_id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log group"></i></a>';
                }
                if ($this->user->canAccess('vne.member.group.show')) {
                    $actions .= '<a href=' . route('vne.member.group.show', ['group_id' => $groups->group_id]) . '><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="update group"></i></a>';
                }
                if ($this->user->canAccess('vne.member.group.confirm-delete')) {        
                    $actions .= '<a href=' . route('vne.member.group.confirm-delete', ['group_id' => $groups->group_id]) . ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete group"></i></a>';
                }
                if ($this->user->canAccess('vne.member.group.manage.add.member')) {
                    $actions .= '<a href=' . route('vne.member.group.manage.add.member', ['group_id' => $groups->group_id]) . '><i class="livicon" data-name="plus-alt" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="add member group"></i></a>';
                }
                return $actions;
            })
            ->addColumn('created_at', function ($groups) {
                $date = new DateTime($groups->created_at);
                $created_at = date_format($date, 'd-m-Y');
                return $created_at;   
            })
            ->rawColumns(['actions','created_at'])
            ->make();
    }

    public function manageAddGroup(Request $request) {
        $validator = Validator::make($request->all(), [
            'group_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            $group_id = $request->input('group_id');
            $data = [
                'group_id' => $group_id
            ];
            return view('VNE-MEMBER::modules.member.group.addMember',$data); 
        } else {
            return $validator->messages();
        }   
    }

    public function addMember(Request $request){
        $validator = Validator::make($request->all(), [
            'group_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {

            $group_id = $request->input('group_id');
            $members = $request->list_members;
            $group = $this->group->find($group_id);
            if (null != $group && !empty($members)) {
                $data_insert = array();
                if(!empty($members)){
                    foreach ($members as $key => $member) {
                        if (!GroupHasMember::where([
                            'group_id' => $group_id,
                            'member_id' => $member,
                        ])->exists()
                        )
                        {
                            $data_insert[] = [
                                'group_id' => $group_id,
                                'member_id' => $member
                            ];
                        }
                    }
                }
                if(!empty($data_insert)){
                    DB::table('vne_group_has_member')->insert($data_insert);
                }
                activity('group')
                    ->performedOn($group)
                    ->withProperties($request->all())
                    ->log('User: :causer.email - Add single member group - group_id: :properties.group_id, name: ' . $group->name);
                return redirect()->route('vne.member.group.manage.add.member',['group_id' => $group_id])->with('success', trans('vne-member::language.messages.success.add_member'));
            }
            else{
                return redirect()->route('vne.member.group.manage.add.member',['group_id' => $group_id])->with('error', trans('vne-member::language.messages.error.add_member'));
            }
        } else {
            return $validator->messages();
        }
    }

    public function getModalDeleteMember(Request $request)
    {
        $model = 'member';
        $type = 'delete';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'group_id' => 'required|numeric',
            'member' => 'required',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $confirm_route = route('vne.member.group.delete.member', ['group_id' => $request->input('group_id'),'member' => $request->input('member')]);
                return view('VNE-MEMBER::modules.member.modal.modal_confirmation', compact('error', 'type' , 'model', 'confirm_route'));
            } catch (GroupNotFoundException $e) {
                return view('VNE-MEMBER::modules.member.modal.modal_confirmation', compact('error', 'type' , 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }

    public function deleteMember(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'group_id' => 'required|numeric',
            'member' => 'required',
        ], $this->messages);
        if (!$validator->fails()) {
            
            $group_id = $request->input('group_id');
            $group = $this->group->find($group_id);
            $members = explode(",",$request->input('member'));
            if (!empty($members)) {
                foreach ($members as $key => $member) {
                    DB::table('vne_group_has_member')->where(['group_id' => $group_id,'member_id' => $member])->delete();
                }
                activity('group')
                    ->performedOn($group)
                    ->withProperties($request->all())
                    ->log('User: :causer.email - Delete member group - group_id: :properties.group_id, name: ' . $group->name);

                return redirect()->route('vne.member.group.manage.add.member',['group_id' => $group_id])->with('success', trans('vne-member::language.messages.success.delete'));
            } else {
                return redirect()->route('vne.member.group.manage.add.member',['group_id' => $group_id])->with('error', trans('vne-member::language.messages.error.delete'));
            }

        } else {
            return $validator->messages();
        }   
    }

    public function dataMember(Request $request)
    {
        $group_id = $request->input('group_id');
        $group = Group::where('group_id', $group_id)->with('getMember')->first();
        $members = $group->getMember;
        return Datatables::of($members)
            ->addIndexColumn()
            ->addColumn('actions', function ($members) use ($group_id) {
                $actions = '<input id="'.$members->member_id.'" type="checkbox" value="" class="select-member">';
                return $actions;
            })
            ->addIndexColumn()
            ->rawColumns(['actions'])
            ->make();
    }

    public function searchMember(Request $request) {
        $data = [];
        if ($request->ajax()) {
            $keyword = $request->input('keyword');
            $group_id = $request->input('group_id');
            if(!empty($keyword)){
                $list_member_old = GroupHasMember::where('group_id',$group_id)->select('member_id')->get();
                $list_members = Member::where('name', 'like', '%' . $keyword . '%')->whereNotIn('member_id', $list_member_old)->get();
                if(!empty($list_members)){
                    foreach($list_members as $member){
                        $data[] = [
                            'name' => $member->name,
                            'member_id' => $member->member_id,
                            'position_current' => $member->position_current
                        ];
                    }
                }
            }
        }
        echo json_encode($data);
    }

    public function test(){
        return view('VNE-MEMBER::modules.member.group.xedit'); 
    }

    public function apiList(Request $request){
        $groups =  $this->group->all();
        $list_group = array();
        foreach ($groups as $key => $value) {
            $list_group[] = [
                'group_id' => $value->group_id,
                'name' => $value->name,
                'type' => $value->type
            ];   
        } 
        return json_encode($list_group);  
    }

}
