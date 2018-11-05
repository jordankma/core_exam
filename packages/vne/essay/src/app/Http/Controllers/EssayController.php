<?php

namespace Vne\Essay\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Vne\Essay\App\Repositories\EssayRepository;
use Vne\Essay\App\Models\Essay;
use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator,Storage;

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

    public function manage()
    {
        return view('VNE-ESSAY::modules.essay.essay.manage');
    }

    public function show(Request $request)
    {
        
        $filename = 'test_word.pdf';
        $dir = '/';
        $recursive = false; // Có lấy file trong các thư mục con không?
        $contents = collect(Storage::disk('google')->listContents($dir, $recursive));
        $file = $contents
            ->where('type', '=', 'file')
            ->where('filename', '=', pathinfo($filename, PATHINFO_FILENAME))
            ->where('extension', '=', pathinfo($filename, PATHINFO_EXTENSION))
            ->first(); // có thể bị trùng tên file với nhau!
        //return $file; // array with file info
        dd($file);
        if($file!=null){
        $rawData = Storage::disk('google')->get($file['path']);
        // dd($rawData);
            return response($rawData, 200)
                ->header('Content-Type', $file['mimetype'])
                ->header('Content-Disposition', "attachment; filename='$filename'");
        }
        $essay_id = $request->input('essay_id');
        $essay = $this->essay->find($essay_id);
        dd($essay);
        $data = [
            'essay' => $essay
        ];
        
        return view('VNE-ESSAY::modules.essay.essay.edit', $data);
    }

    public function update(Request $request)
    {
        $demo_id = $request->input('demo_id');

        $demo = $this->demo->find($demo_id);
        $demo->name = $request->input('name');

        if ($demo->save()) {

            activity('demo')
                ->performedOn($demo)
                ->withProperties($request->all())
                ->log('User: :causer.email - Update Demo - demo_id: :properties.demo_id, name: :properties.name');

            return redirect()->route('vne.essay.demo.manage')->with('success', trans('vne-essay::language.messages.success.update'));
        } else {
            return redirect()->route('vne.essay.demo.show', ['demo_id' => $request->input('demo_id')])->with('error', trans('vne-essay::language.messages.error.update'));
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
            ->addColumn('essay_topic', function ($essays) {
                $essay_topic = '';
                if(!empty($essays->essayTopic)){
                    $essay_topic = $essays->essayTopic->name;
                }
                return $essay_topic;
            })
            ->addIndexColumn()
            ->rawColumns(['actions','essay_topic','member'])
            ->make();
    }

}
