<?php

namespace Vne\Essay\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Vne\Essay\App\Repositories\EssayRepository;
use Vne\Essay\App\Models\Essay;
use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator,Storage,File,Auth;
use Vne\Member\App\Models\Member;
class EssayController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );

    public function __construct(EssayRepository $essayRepository)
    {
        parent::__construct();
        $this->essay = $essayRepository;
    }

    public function test()
    {
        return view('VNE-ESSAY::modules.essay.essay.test');
    }
    public function manage()
    {
        return view('VNE-ESSAY::modules.essay.essay.manage');
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'member_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            $name = $note = '';
            $data = [
                'name' => !empty($request->input('name')) ? $request->input('name') : '',
                'note' => !empty($request->input('note')) ? $request->input('note') : '',
                'member_id' => $request->input('member_id')
            ];
            return view('VNE-ESSAY::modules.essay.essay.create',$data);
        } else {
            return redirect()->route('vne.essay.essay.manage')->with('error', trans('vne-essay::language.messages.error.add'));
        }
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'member_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            $member_id = $request->input('member_id');
            $name = $request->input('name');
            $alias_name = self::to_slug($name) .'-'. $member_id . '-' . time();
            $note = $request->input('note');
            $data = [
                'name' => $name,
                'note' => $note
            ];
            $messages = "File không đúng định dạng";
            $folder_upload_essay = "uploads/essay/essay";
            $folder_upload_essay_icon = "uploads/essay/icon";
            //file upload
            $file_to_upload = $request->file('fileToUpload');
            $file_name = $file_to_upload->getClientOriginalName();
            $file_tmp = explode('.', $file_name);
            $file_extension = end($file_tmp);
            if($file_extension != 'pdf' && $file_extension != 'docx' && $file_extension != 'pptx' && $file_extension != 'txt'){
                return redirect()->route('vne.essay.essay.create',$data)->with('error', 'Sai định dạng file tải lên');   
            }
            $file_name_full = $alias_name .'.'. $file_extension;
            //icon upload
            if($request->has('image')){
                $icon_to_upload = $request->file('image');
                $icon_name = $icon_to_upload->getClientOriginalName();
                $icon_tmp = explode('.', $icon_name);
                $icon_extension = end($icon_tmp);
                if($icon_extension != 'png' && $icon_extension != 'jpg' && $icon_extension != 'PNG'){
                    return redirect()->route('vne.essay.essay.create',$data)->with('error', 'Sai định dạng file ảnh tải lên');   
                }
                $icon_name_full = $alias_name .'.'. $icon_extension;
            }
            if(Storage::disk('google')->put($alias_name .'.'. $file_extension, file_get_contents($file_to_upload))){
                $file_to_upload->move($folder_upload_essay, $file_name_full);
                if($request->has('image')){
                    $icon_to_upload->move($folder_upload_essay_icon, $icon_name_full);
                }
                //get info file from gg drive 
                $dir = '/';
                $recursive = false;
                $contents = collect(Storage::disk('google')->listContents($dir, $recursive));
                $file = $contents
                    ->where('type', '=', 'file')
                    ->where('filename', '=', pathinfo($file_name_full, PATHINFO_FILENAME))
                    ->where('extension', '=', pathinfo($file_name_full, PATHINFO_EXTENSION))
                    ->first();
                $essay = new Essay();
                $essay->name = $name;
                //info from gg drive
                $essay->type = $file['type'];
                $essay->path = $file['path'];
                $essay->filename = $file['filename'];
                $essay->extension = $file['extension'];
                $essay->timestamp = $file['timestamp'];
                $essay->mimetype = $file['mimetype'];
                $essay->dirname = $file['dirname'];
                $essay->basename = $file['basename'];
                //
                $essay->member_id = $member_id;
                $essay->note = $note;
                $essay->path_local = $folder_upload_essay . '/' . $file_name_full;
                if($request->has('image')){
                    $essay->image = $folder_upload_essay_icon . '/' . $icon_name_full;
                }
                if ($essay->save()) {
                    Member::where('member_id', $member_id)->update(['is_essay' => 1]);
                    activity('essay')
                        ->performedOn($essay)
                        ->withProperties($request->all())
                        ->log('User: :causer.email - Add essay - name: :properties.name, essay_id: ' . $essay->essay_id);

                    return redirect()->route('vne.essay.essay.manage')->with('success', trans('vne-essay::language.messages.success.create'));
                } else {
                    return redirect()->route('vne.essay.essay.manage')->with('error', trans('vne-essay::language.messages.error.create'));
                }
            }
        } else {
            return redirect()->route('vne.essay.essay.manage')->with('error', trans('vne-essay::language.messages.error.add'));
        }
    }

    public function show(Request $request)
    {
        $essay_id = $request->input('essay_id');
        $essay = $this->essay->find($essay_id);
        $data = [
            'essay' => $essay,
            'path' => 'https://drive.google.com/file/d/'. $essay->path .'/preview'
        ];
        return view('VNE-ESSAY::modules.essay.essay.edit', $data);
    }

    public function update(Request $request)
    {
        $essay_id = $request->input('essay_id');
        $essay = Essay::find($essay_id);
        $name = $request->input('name');
        $member_id = $essay->member_id;
        $alias_name = self::to_slug($name) .'-'. $member_id . '-' . time();
        $note = $request->input('note');
        $data = [
            'name' => $name,
            'note' => $note,
            'essay' => $essay
        ];
        $messages = "File không đúng định dạng";
        $folder_upload_essay = "uploads/essay/essay";
        $folder_upload_essay_icon = "uploads/essay/icon";
        //file upload
        if($request->has('fileToUpload')){
            $file_to_upload = $request->file('fileToUpload');
            $file_name = $file_to_upload->getClientOriginalName();
            $file_tmp = explode('.', $file_name);
            $file_extension = end($file_tmp);
            if($file_extension != 'pdf' && $file_extension != 'docx' && $file_extension != 'pptx' && $file_extension != 'txt'){
                return redirect()->route('vne.essay.essay.show',$data)->with('error', 'Sai định dạng file tải lên');   
            }
            $file_name_full = $alias_name .'.'. $file_extension;
        }
        //icon upload
        if($request->has('image')){
            $icon_to_upload = $request->file('image');
            $icon_name = $icon_to_upload->getClientOriginalName();
            $icon_tmp = explode('.', $icon_name);
            $icon_extension = end($icon_tmp);
            if($icon_extension != 'png' && $icon_extension != 'jpg'){
                return redirect()->route('vne.essay.essay.show',$data)->with('error', 'Sai định dạng file ảnh tải lên');   
            }
            $icon_name_full = $alias_name .'.'. $icon_extension;
        }
        if($request->has('fileToUpload')){
            if(Storage::disk('google')->put($alias_name .'.'. $file_extension, file_get_contents($file_to_upload))){
                $file_to_upload->move($folder_upload_essay, $file_name_full);
                if($request->has('image')){
                    $icon_to_upload->move($folder_upload_essay_icon, $icon_name_full);
                }
                //get info file from gg drive 
                $dir = '/';
                $recursive = false;
                $contents = collect(Storage::disk('google')->listContents($dir, $recursive));
                $file = $contents
                    ->where('type', '=', 'file')
                    ->where('filename', '=', pathinfo($file_name_full, PATHINFO_FILENAME))
                    ->where('extension', '=', pathinfo($file_name_full, PATHINFO_EXTENSION))
                    ->first();
                $essay->name = $name;
                $essay->note = $note;
                //info from gg drive
                $essay->type = $file['type'];
                $essay->path = $file['path'];
                $essay->filename = $file['filename'];
                $essay->extension = $file['extension'];
                $essay->timestamp = $file['timestamp'];
                $essay->mimetype = $file['mimetype'];
                $essay->dirname = $file['dirname'];
                $essay->basename = $file['basename'];

                $essay->path_local = $folder_upload_essay . '/' . $file_name_full;
                if($request->has('image')){
                    $essay->image = $folder_upload_essay_icon . '/' . $icon_name_full;
                }

                if ($essay->save()) {
                    activity('essay')
                        ->performedOn($essay)
                        ->withProperties($request->all())
                        ->log('User: :causer.email - Update essay - essay_id: :properties.essay_id, name: :properties.name');

                    return redirect()->route('vne.essay.essay.manage')->with('success', trans('vne-essay::language.messages.success.update'));
                } else {
                    return redirect()->route('vne.essay.essay.show', ['essay_id' => $request->input('essay_id')])->with('error', trans('vne-essay::language.messages.error.update'));
                }
            }
        } else {
            $essay->name = $name;
            $essay->note = $note;
            if ($essay->save()) {
                activity('essay')
                    ->performedOn($essay)
                    ->withProperties($request->all())
                    ->log('User: :causer.email - Update essay - essay_id: :properties.essay_id, name: :properties.name');

                return redirect()->route('vne.essay.essay.manage')->with('success', trans('vne-essay::language.messages.success.update'));
            } else {
                return redirect()->route('vne.essay.essay.show', ['essay_id' => $request->input('essay_id')])->with('error', trans('vne-essay::language.messages.error.update'));
            }
        }
    }

    public function getModalDelete(Request $request)
    {
        $model = 'essay';
        $type = 'delete';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'essay_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $confirm_route = route('vne.essay.essay.delete', ['essay_id' => $request->input('essay_id')]);
                return view('VNE-ESSAY::modules.essay.modal.modal_confirmation', compact('error', 'type', 'model', 'confirm_route'));
            } catch (GroupNotFoundException $e) {
                return view('VNE-ESSAY::modules.essay.modal.modal_confirmation', compact('error', 'type', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }

    public function delete(Request $request)
    {
        $essay_id = $request->input('essay_id');
        $essay = $this->essay->find($essay_id);

        if (null != $essay) {
            $this->essay->delete($essay_id);

            activity('essay')
                ->performedOn($essay)
                ->withProperties($request->all())
                ->log('User: :causer.email - Delete essay - essay_id: :properties.essay_id, name: ' . $essay->name);

            return redirect()->route('vne.essay.essay.manage')->with('success', trans('vne-essay::language.messages.success.delete'));
        } else {
            return redirect()->route('vne.essay.essay.manage')->with('error', trans('vne-essay::language.messages.error.delete'));
        }
    }
 
    public function log(Request $request)
    {
        $model = 'essay';
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
                return view('VNE-ESSAY::modules.essay.modal.modal_table', compact('error', 'model', 'confirm_route', 'logs'));
            } catch (GroupNotFoundException $e) {
                return view('VNE-ESSAY::modules.essay.modal.modal_table', compact('error', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }

    //Table Data to index page
    public function data()
    {
        $essays = $this->essay->findAll();
        
        return Datatables::of($essays)
            ->addColumn('actions', function ($essays) {
                $actions = '';
                if ($this->user->canAccess('vne.essay.essay.log')) {
                    $actions .= '<a href=' . route('vne.essay.essay.log', ['type' => 'essay', 'id' => $essays->essay_id]) . 
                    ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" 
                    data-c="#F99928" data-hc="#F99928" title="log essay"></i></a>';
                }
                if ($this->user->canAccess('vne.essay.essay.show')) {
                    $actions .= '<a href=' . route('vne.essay.essay.show', ['essay_id' => $essays->essay_id]) . 
                    '><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" 
                    data-hc="#428BCA" title="update essay"></i></a>';
                }
                if ($this->user->canAccess('vne.essay.essay.confirm-delete')) {   
                    $actions .= '<a href=' . route('vne.essay.essay.confirm-delete', ['essay_id' => $essays->essay_id]) . 
                    ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" 
                    data-c="#f56954" data-hc="#f56954" title="delete essay"></i></a>';
                }
                return $actions;
            })
            ->addColumn('member', function ($essays) {
                $member = '';
                if(!empty($essays->member)){
                    $member = $essays->member->name . ' - ' . $essays->member->u_name . ' - ' . $essays->member->phone . ' - ' . $essays->member->email;
                }
                return $member;
            })
            ->addIndexColumn()
            ->rawColumns(['actions','member'])
            ->make();
    }

    public function checkNameExist(Request $request){
        $data['valid'] = true;
        if ($request->ajax()) {
            $name_alias = self::to_slug($request->input('name'));
            $essay =  Essay::where(['alias' => $name_alias])->first();
            if ($essay) {
                $data['valid'] = false; // true là có user
            }
        }
        echo json_encode($data);
    }
}
