<?php

namespace Contest\Contestmanage\App\Http\Controllers;

use Contest\Contestmanage\App\ContestEnvironment;
use Contest\Contestmanage\App\Http\Requests\TopicRequest;
use Contest\Contestmanage\App\Models\ContestTopic;
use Contest\Contestmanage\App\Models\TopicConfig;
use Contest\Contestmanage\App\Repositories\ContestRoundRepository;
use Contest\Contestmanage\App\Repositories\ContestSeasonRepository;
use Contest\Contestmanage\App\Repositories\ContestTopicRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Illuminate\Support\Facades\Schema;
use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator;

class ContestTopicController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );
    private $type = ['online' => 'Online', 'offline' => 'Offline'];

    public function __construct( ContestTopicRepository $topicRepository)
    {
        parent::__construct();
        $this->topic = $topicRepository;
        $this->env = new ContestEnvironment();
    }

    public function add(TopicRequest $request)
    {

        $topic = new ContestTopic();
        $topic->display_name = $request->name;
        $topic->topic_name = str_slug($request->name);
        $topic->description = $request->description;
        $topic->rule_text = $request->rules;
        $topic->end_notify = $request->end_notify;
        $start_date = date_create_from_format('d-m-Y H:m',$request->start_date);
        $end_date = date_create_from_format('d-m-Y H:m',$request->end_date);
        $topic->start_date = $start_date;
        $topic->end_date = $end_date;
        $topic->order = $request->number;
        $topic->round_id = $request->round_id;
        $topic->status = '1';
        $topic->exam_repeat_time = $request->exam_repeat_time;
        $topic->exam_repeat_time_wait = !empty($request->exam_repeat_time_wait)?$request->exam_repeat_time_wait:0;
        $topic->total_time_limit = !empty($request->total_time_limit)?$request->total_time_limit:0;
        try{
            $topic->save();
            if(!empty($request->environment)){
                $config_arr = [];
                foreach ( $request->environment as $key=>$value){
                    $config_arr[] = [
                        'environment' => $value,
                        'config_id' => $request->config_id[$key],
                        'topic_id' => $topic->topic_id,
                        'status' => '1'
                    ];
                }
                TopicConfig::insert($config_arr);
            }
            activity('contest_topic')
                ->performedOn($topic)
                ->withProperties($request->all())
                ->log('User: :causer.email - Add topic - name: :properties.name, topic_id: ' . $topic->topic_id);

            return redirect()->route('contest.contestmanage.contest_topic.manage')->with('success', trans('card-cardmanage::language.messages.success.create'));
        }
        catch(\Exception $e) {
            return redirect()->route('contest.contestmanage.contest_topic.manage')->with('error', trans('card-cardmanage::language.messages.error.create'));
        }

    }

    public function create()
    {
        $data_view = [
            'type' => $this->type,
            'environment' => $this->env->getEnvironment()
        ];
        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.contest_topic.create', $data_view);
    }

    public function delete(Request $request)
    {
        $product_id = $request->input('product_id');
        $card_product = $this->contestRound->find($product_id);

        if (null != $card_product) {
            $this->contestRound->delete($product_id);

            activity('cardProduct')
                ->performedOn($card_product)
                ->withProperties($request->all())
                ->log('User: :causer.email - Delete cardProduct - product_id: :properties.product_id, name: ' . $card_product->product_name);

            return redirect()->route('contest.contestmanage.contest_topic.manage')->with('success', trans('card-cardmanage::language.messages.success.delete'));
        } else {
            return redirect()->route('contest.contestmanage.contest_topic.manage')->with('error', trans('card-cardmanage::language.messages.error.delete'));
        }
    }

    public function manage()
    {
        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.contest_topic.manage');
    }

    public function show(Request $request)
    {
        $product_id = $request->input('product_id');
        $card_product = $this->contestRound->find($product_id);
        $data = [
            'card_product' => $card_product,
        ];

        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.contest_topic.edit', $data);
    }

    public function update(CardProductRequest $request)
    {
        $product_id = $request->input('product_id');
        $card_product = $this->contestRound->find($product_id);
        $card_product->product_name=$request->input('name');
        $card_product->product_code=strtoupper($request->input('code'));
        $card_product->description=$request->input('description');
        if ($card_product->save()) {

            activity('cardProduct')
                ->performedOn($card_product)
                ->withProperties($request->all())
                ->log('User: :causer.email - Update cardProduct - product_id: :properties.product_id, name: :properties.product_name');

            return redirect()->route('contest.contestmanage.contest_topic.manage')->with('success', trans('card-cardmanage::language.messages.success.update'));
        } else {
            return redirect()->route('contest.contestmanage.contest_topic.show', ['product_id' => $request->input('product_id')])->with('error', trans('card-cardmanage::language.messages.error.update'));
        }
    }

    public function getModalDelete(Request $request)
    {
        $model = 'cardProduct';
        $tittle='Xác nhận xóa';
        $type=$this->contestRound->find($request->input('product_id'));
        $content='Bạn có chắc chắn muốn xóa loại: '.$type->product_name.'?';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $confirm_route = route('contest.contestmanage.contest_topic.delete', ['product_id' => $request->input('product_id')]);
                return view('CARD-CARDMANAGE::modules.cardmanage.includes.modal_confirmation', compact('error','tittle','content', 'model', 'confirm_route'));
            } catch (GroupNotFoundException $e) {
                return view('includes.modal_confirmation', compact('error', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }

    public function log(Request $request)
    {
        $model = 'cardProduct';
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
                return view('includes.modal_table', compact('error', 'model', 'confirm_route', 'logs'));
            } catch (GroupNotFoundException $e) {
                return view('includes.modal_table', compact('error', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }

    //Table Data to index page
    public function data()
    {
        return Datatables::of($this->topic->findAll())
            ->addColumn('actions', function ($topic) {
                $actions = '<a href=' . route('contest.contestmanage.contest_topic.log', ['type' => 'contest_topic', 'id' => $topic->topic_id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log cardProduct"></i></a>';
//                        <a href=' . route('contest.contestmanage.contest_topic.confirm-delete', ['product_id' => $card_product->product_id]) . ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete cardProduct"></i></a>';

                return $actions;
            })
            ->rawColumns(['actions'])
            ->make();
    }


}