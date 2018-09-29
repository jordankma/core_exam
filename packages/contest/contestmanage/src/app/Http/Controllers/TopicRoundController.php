<?php

namespace Contest\Contestmanage\App\Http\Controllers;

use Contest\Contestmanage\App\ContestEnvironment;
use Contest\Contestmanage\App\Http\Requests\TopicRoundRequest;
use Contest\Contestmanage\App\Models\ContestTopic;
use Contest\Contestmanage\App\Models\TopicRound;
use Contest\Contestmanage\App\Models\TopicRoundConfig;
use Contest\Contestmanage\App\Repositories\TopicRoundRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Illuminate\Support\Facades\Schema;
use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator;

class TopicRoundController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );
    private $type = ['online' => 'Online', 'offline' => 'Offline'];

    public function __construct( TopicRoundRepository $topicRoundRepository)
    {
        parent::__construct();
        $this->topicRound = $topicRoundRepository;
        $this->env = new ContestEnvironment();
    }

    public function add(TopicRoundRequest $request)
    {
        $topic_round = new TopicRound();
        $topic_round->display_name = $request->name;
        $topic_round->topic_round_name = str_slug($request->name);
        $topic_round->description = $request->description;
        $topic_round->rule_text = $request->rules;
        $topic_round->order = $request->number;
        $topic_round->topic_id = $request->topic_id;
        $topic_round->status = '1';
        $topic_round->total_question = $request->total_question;
        $topic_round->total_point = $request->total_point;
        $topic_round->total_time_limit = $request->total_time_limit;
        $topic_round->point_minus_no_answer = !empty($request->point_minus_no_answer)?true:false;
        $topic_round->show_true_answer = !empty($request->show_true_answer)?true:false;
        $luckystar = $request->luckystar;
        if(!empty($luckystar['status'])){
            $luckystar['status'] = true;
        }
        else{
            $luckystar['status'] = false;
        }
        $luckystar = json_encode($luckystar);
        $topic_round->lucky_star = $luckystar;
        try{
            $topic_round->save();
            if(!empty($request->environment)){
                $config_arr = [];
                foreach ( $request->environment as $key=>$value){
                    $config_arr[] = [
                        'environment' => $value,
                        'config_id' => $request->config_id[$key],
                        'topic_round_id' => $topic_round->topic_round_id,
                        'status' => '1'
                    ];
                }
                TopicRoundConfig::insert($config_arr);
            }
            activity('topic_round')
                ->performedOn($topic_round)
                ->withProperties($request->all())
                ->log('User: :causer.email - Add topic_round - name: :properties.name, topic_round_id: ' . $topic_round->topic_round_id);

            return redirect()->route('contest.contestmanage.topic_round.manage')->with('success', trans('card-cardmanage::language.messages.success.create'));
        }
        catch(\Exception $e) {
            return redirect()->route('contest.contestmanage.topic_round.manage')->with('error', trans('card-cardmanage::language.messages.error.create'));
        }

    }

    public function create()
    {
        $data_view = [
            'type' => $this->type,
            'environment' => $this->env->getEnvironment()
        ];
        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.topic_round.create', $data_view);
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

            return redirect()->route('contest.contestmanage.topic_round.manage')->with('success', trans('card-cardmanage::language.messages.success.delete'));
        } else {
            return redirect()->route('contest.contestmanage.topic_round.manage')->with('error', trans('card-cardmanage::language.messages.error.delete'));
        }
    }

    public function manage()
    {
        $data_view = [
            'topic' => ContestTopic::all()->pluck('display_name','topic_id')
        ];
        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.topic_round.manage', $data_view);
    }

    public function show(Request $request)
    {
        $product_id = $request->input('product_id');
        $card_product = $this->contestRound->find($product_id);
        $data = [
            'card_product' => $card_product,
        ];

        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.topic_round.edit', $data);
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

            return redirect()->route('contest.contestmanage.topic_round.manage')->with('success', trans('card-cardmanage::language.messages.success.update'));
        } else {
            return redirect()->route('contest.contestmanage.topic_round.show', ['product_id' => $request->input('product_id')])->with('error', trans('card-cardmanage::language.messages.error.update'));
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
                $confirm_route = route('contest.contestmanage.topic_round.delete', ['product_id' => $request->input('product_id')]);
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
        return Datatables::of($this->topicRound->findAll())
            ->addColumn('actions', function ($topic_round) {
                $actions = '<a href=' . route('contest.contestmanage.topic_round.log', ['type' => 'topic_round', 'id' => $topic_round->topic_round_id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log cardProduct"></i></a>';
//                        <a href=' . route('contest.contestmanage.topic_round.confirm-delete', ['product_id' => $card_product->product_id]) . ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete cardProduct"></i></a>';

                return $actions;
            })
            ->rawColumns(['actions'])
            ->make();
    }


}