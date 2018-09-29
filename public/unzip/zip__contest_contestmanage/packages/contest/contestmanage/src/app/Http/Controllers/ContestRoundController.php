<?php

namespace Contest\Contestmanage\App\Http\Controllers;

use Contest\Contestmanage\App\ContestEnvironment;
use Contest\Contestmanage\App\Http\Requests\RoundRequest;
use Contest\Contestmanage\App\Models\ContestRound;
use Contest\Contestmanage\App\Models\RoundConfig;
use Contest\Contestmanage\App\Repositories\ContestRoundRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Illuminate\Support\Facades\Schema;
use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator;

class ContestRoundController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );
    private $type = ['online' => 'Online', 'offline' => 'Offline'];

    public function __construct( ContestRoundRepository $contestRoundRepository)
    {
        parent::__construct();
        $this->contestRound = $contestRoundRepository;
        $this->env = new ContestEnvironment();
    }

    public function add(RoundRequest $request)
    {
        $round = new ContestRound();
        $round->display_name = $request->name;
        $round->round_name = str_slug($request->name);
        $round->description = $request->description;
        $round->rule = $request->rules;
        $round->end_notify = $request->end_notify;
        $start_date = date_create_from_format('d-m-Y H:m',$request->start_date);
        $end_date = date_create_from_format('d-m-Y H:m',$request->end_date);
        $round->start_date = $start_date;
        $round->end_date = $end_date;
        $round->order = $request->order;
        $round->status = '1';
        try{
            $round->save();
            if(!empty($request->environment)){
                $config_arr = [];
                foreach ( $request->environment as $key=>$value){
                    $config_arr[] = [
                        'environment' => $value,
                        'config_id' => $request->config_id[$key],
                        'round_id' => $round->round_id,
                        'status' => '1'
                    ];
                }
                RoundConfig::insert($config_arr);
            }
            activity('contest_round')
                ->performedOn($round)
                ->withProperties($request->all())
                ->log('User: :causer.email - Add round - name: :properties.name, round_id: ' . $round->round_id);

            return redirect()->route('contest.contestmanage.contest_round.manage')->with('success', trans('card-cardmanage::language.messages.success.create'));
        }
        catch(\Exception $e) {
            echo "<pre>";print_r($e->getMessage());echo "</pre>";die;
            return redirect()->route('contest.contestmanage.contest_round.manage')->with('error', trans('card-cardmanage::language.messages.error.create'));
        }
    }

    public function create()
    {
        $data_view = [
            'type' => $this->type,
            'environment' => $this->env->getEnvironment(),
            'option' => $this->env->getOption()
        ];
        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.contest_round.create', $data_view);
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

            return redirect()->route('contest.contestmanage.contest_round.manage')->with('success', trans('card-cardmanage::language.messages.success.delete'));
        } else {
            return redirect()->route('contest.contestmanage.contest_round.manage')->with('error', trans('card-cardmanage::language.messages.error.delete'));
        }
    }

    public function manage()
    {
        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.contest_round.manage');
    }

    public function show(Request $request)
    {
        $product_id = $request->input('product_id');
        $card_product = $this->contestRound->find($product_id);
        $data = [
            'card_product' => $card_product,
        ];

        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.contest_round.edit', $data);
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

            return redirect()->route('contest.contestmanage.contest_round.manage')->with('success', trans('card-cardmanage::language.messages.success.update'));
        } else {
            return redirect()->route('contest.contestmanage.contest_round.show', ['product_id' => $request->input('product_id')])->with('error', trans('card-cardmanage::language.messages.error.update'));
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
                $confirm_route = route('contest.contestmanage.contest_round.delete', ['product_id' => $request->input('product_id')]);
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
        return Datatables::of($this->contestRound->findAll())
            ->addColumn('actions', function ($card_product) {
                $actions = '<a href=' . route('contest.contestmanage.contest_round.log', ['type' => 'cardProduct', 'id' => $card_product->product_id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log cardProduct"></i></a>';
//                        <a href=' . route('contest.contestmanage.contest_round.confirm-delete', ['product_id' => $card_product->product_id]) . ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete cardProduct"></i></a>';

                return $actions;
            })
            ->rawColumns(['actions'])
            ->make();
    }


}