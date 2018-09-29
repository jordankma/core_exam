<?php

namespace Contest\Contestmanage\App\Http\Controllers;

use Adtech\Application\Cms\Controllers\Controller as Controller;
use Contest\Contestmanage\App\ContestEnvironment;
use Contest\Contestmanage\App\Http\Requests\SeasonRequest;
use Contest\Contestmanage\App\Models\ContestSeason;
use Contest\Contestmanage\App\Models\SeasonConfig;
use Contest\Contestmanage\App\Repositories\ContestSeasonRepository;
use Dhcd\Contest\App\Repositories\ContestRepository;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Validator;
use Yajra\Datatables\Datatables;

class ContestSeasonController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );
    public function __construct(ContestRepository $contestRepository, ContestSeasonRepository $contestSeasonRepository)
    {
        parent::__construct();
        $this->contest = $contestRepository;
        $this->contestSeason = $contestSeasonRepository;
        $this->env = new ContestEnvironment();
    }


    public function add(SeasonRequest $request)
    {
        $season = new ContestSeason();
        $season->name = $request->name;
        $season->alias = str_slug($request->name);
        $season->description = $request->description;
        $season->rule = $request->rules;
        $season->before_start_notify = $request->before_start_notify;
        $season->after_end_notify = $request->after_end_notify;
        $start_date = date_create_from_format('d-m-Y H:m',$request->start_date);
        $end_date = date_create_from_format('d-m-Y H:m',$request->end_date);
        $season->start_date = $start_date;
        $season->end_date = $end_date;
        $season->number = $request->number;
        try{
            $season->save();
            if(!empty($request->environment)){
                $config_arr = [];
                foreach ( $request->environment as $key=>$value){
                    $config_arr[] = [
                        'environment' => $value,
                        'config_id' => $request->config_id[$key],
                        'season_id' => $season->season_id,
                        'status' => '1'
                    ];
                }
                SeasonConfig::insert($config_arr);
            }
            activity('contest_season')
                ->performedOn($season)
                ->withProperties($request->all())
                ->log('User: :causer.email - Add season - name: :properties.name, season_id: ' . $season->season_id);

            return redirect()->route('contest.contestmanage.contest_season.manage')->with('success', trans('card-cardmanage::language.messages.success.create'));
        }
        catch(\Exception $e) {
            return redirect()->route('contest.contestmanage.contest_season.manage')->with('error', trans('card-cardmanage::language.messages.error.create'));
        }
    }

    public function create()
    {
        $data_view = [
            'environment' => $this->env->getEnvironment()
        ];
        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.contest_season.create', $data_view);
    }

    public function delete(Request $request)
    {
        $product_id = $request->input('product_id');
        $card_product = $this->contestSeason->find($product_id);

        if (null != $card_product) {
            $this->contestSeason->delete($product_id);

            activity('cardProduct')
                ->performedOn($card_product)
                ->withProperties($request->all())
                ->log('User: :causer.email - Delete cardProduct - product_id: :properties.product_id, name: ' . $card_product->product_name);

            return redirect()->route('contest.contestmanage.contest_season.manage')->with('success', trans('card-cardmanage::language.messages.success.delete'));
        } else {
            return redirect()->route('contest.contestmanage.contest_season.manage')->with('error', trans('card-cardmanage::language.messages.error.delete'));
        }
    }

    public function manage()
    {
        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.contest_season.manage');
    }

    public function show(Request $request)
    {
        $product_id = $request->input('product_id');
        $card_product = $this->contestSeason->find($product_id);
        $data = [
            'card_product' => $card_product,
        ];

        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.contest_season.edit', $data);
    }

    public function update(CardProductRequest $request)
    {
        $product_id = $request->input('product_id');
        $card_product = $this->contestSeason->find($product_id);
        $card_product->product_name =$request->input('name');
        $card_product->product_code=strtoupper($request->input('code'));
        $card_product->description=$request->input('description');
        if ($card_product->save()) {

            activity('cardProduct')
                ->performedOn($card_product)
                ->withProperties($request->all())
                ->log('User: :causer.email - Update cardProduct - product_id: :properties.product_id, name: :properties.product_name');

            return redirect()->route('contest.contestmanage.contest_season.manage')->with('success', trans('card-cardmanage::language.messages.success.update'));
        } else {
            return redirect()->route('contest.contestmanage.contest_season.show', ['product_id' => $request->input('product_id')])->with('error', trans('card-cardmanage::language.messages.error.update'));
        }
    }

    public function getModalDelete(Request $request)
    {
        $model = 'cardProduct';
        $tittle = 'Xác nhận xóa';
        $type = $this->contestSeason->find($request->input('product_id'));
        $content = 'Bạn có chắc chắn muốn xóa loại: '.$type->product_name.'?';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $confirm_route = route('contest.contestmanage.contest_season.delete', ['product_id' => $request->input('product_id')]);
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
    public function data(Request $request)
    {
        return Datatables::of($this->contestSeason->findAll())
            ->addColumn('actions', function ($card_product) {
                $actions = '<a href=' . route('contest.contestmanage.contest_season.log', ['type' => 'cardProduct', 'id' => $card_product->product_id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log cardProduct"></i></a>';
//                        <a href=' . route('contest.contestmanage.contest_season.confirm-delete', ['product_id' => $card_product->product_id]) . ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete cardProduct"></i></a>';

                return $actions;
            })
            ->rawColumns(['actions'])
            ->make();
    }



}