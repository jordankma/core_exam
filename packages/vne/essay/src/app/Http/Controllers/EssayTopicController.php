<?php

namespace Vne\Essay\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Vne\Essay\App\Repositories\EssayTopicRepository;
use Vne\Essay\App\Models\EssayTopic;
use Vne\Essay\App\Models\Essay;
use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator,Storage;

class EssayTopicController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );

    public function testUploadGG(){
        dd(Storage::disk('google')->put('test.txt', 'Hello World'));
        return 'File was saved to Google Drive';
    }

    public function __construct(EssayTopicRepository $essayTopicRepository)
    {
        parent::__construct();
        $this->essay_topic = $essayTopicRepository;
    }

    public function manage()
    {
        return view('VNE-ESSAY::modules.essay.topic.manage');
    }

    public function create()
    {
        return view('VNE-ESSAY::modules.essay.topic.create');
    }

    public function add(Request $request)
    {
        $name = $request->input('name');
        $essay_topic = new EssayTopic();
        $essay_topic->name = $name;
        $essay_topic->alias = self::to_slug($name);

        if ($essay_topic->save()) {

            activity('essay_topic')
                ->performedOn($essay_topic)
                ->withProperties($request->all())
                ->log('User: :causer.email - Add essay_topic - name: :properties.name, essay_topic_id: ' . $essay_topic->demo_id);

            return redirect()->route('vne.essay.topic.manage')->with('success', trans('vne-essay::language.messages.success.create'));
        } else {
            return redirect()->route('vne.essay.topic.manage')->with('error', trans('vne-essay::language.messages.error.create'));
        }
    }

    public function show(Request $request)
    {
        $essay_topic_id = $request->input('essay_topic_id');
        $essay_topic = $this->essay_topic->find($essay_topic_id);
        $data = [
            'essay_topic' => $essay_topic
        ];

        return view('VNE-ESSAY::modules.essay.topic.edit', $data);
    }

    public function update(Request $request)
    {
        $essay_topic_id = $request->input('essay_topic_id');

        $essay_topic = $this->essay_topic->find($essay_topic_id);
        $essay_topic->name = $request->input('name');

        if ($essay_topic->save()) {

            activity('essay_topic')
                ->performedOn($essay_topic)
                ->withProperties($request->all())
                ->log('User: :causer.email - Update essay_topic - essay_topic_id: :properties.essay_topic_id, name: :properties.name');

            return redirect()->route('vne.essay.topic.manage')->with('success', trans('vne-essay::language.messages.success.update'));
        } else {
            return redirect()->route('vne.essay.topic.show', ['essay_topic_id' => $request->input('essay_topic_id')])->with('error', trans('vne-essay::language.messages.error.update'));
        }
    }

    public function getModalDelete(Request $request)
    {
        $model = 'topic';
        $type = 'delete';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'essay_topic_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            $essay = Essay::find($request->input('essay_topic_id'));
            if(!empty($essay)){
                $error = 'Đề tài này đã có bài thi không thể xóa';    
            }
            try {
                $confirm_route = route('vne.essay.topic.delete', ['essay_topic_id' => $request->input('essay_topic_id')]);
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
        $essay_topic_id = $request->input('essay_topic_id');
        $essay_topic = $this->essay_topic->find($essay_topic_id);

        if (null != $essay_topic) {
            $this->essay_topic->delete($essay_topic_id);

            activity('essay_topic')
                ->performedOn($essay_topic)
                ->withProperties($request->all())
                ->log('User: :causer.email - Delete essay_topic - essay_topic_id: :properties.essay_topic_id, name: ' . $essay_topic->name);

            return redirect()->route('vne.essay.topic.manage')->with('success', trans('vne-essay::language.messages.success.delete'));
        } else {
            return redirect()->route('vne.essay.topic.manage')->with('error', trans('vne-essay::language.messages.error.delete'));
        }
    }

    public function log(Request $request)
    {
        $model = 'essay_topic';
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
        $essay_topics = $this->essay_topic->findAll();
        return Datatables::of($essay_topics)
            ->addColumn('actions', function ($essay_topics) {
                $actions = '';
                if ($this->user->canAccess('vne.essay.topic.log')) {
                    $actions .= '<a href=' . route('vne.essay.topic.log', ['type' => 'essay_topic', 'id' => $essay_topics->essay_topic_id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log essay_topic"></i></a>';
                }
                if ($this->user->canAccess('vne.essay.topic.show')) {
                    $actions .= '<a href=' . route('vne.essay.topic.show', ['essay_topic_id' => $essay_topics->essay_topic_id]) . '><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="update essay_topic"></i></a>';
                }
                if ($this->user->canAccess('vne.essay.topic.confirm-delete')) {
                    $actions .= '<a href=' . route('vne.essay.topic.confirm-delete', ['essay_topic_id' => $essay_topics->essay_topic_id]) . ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete essay_topic"></i></a>';
                }
                return $actions;
            })
            ->addIndexColumn()
            ->rawColumns(['actions'])
            ->make();
    }
}
