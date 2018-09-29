<?php

namespace Contest\Contestmanage\App\Http\Controllers;

use Contest\Contestmanage\App\ContestEnvironment;
use Contest\Contestmanage\App\Http\Requests\ConfigRequest;
use Contest\Contestmanage\App\Models\ContestConfig;
use Contest\Contestmanage\App\Repositories\ContestConfigRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Illuminate\Support\Facades\Schema;
use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator;

class ContestConfigController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );

    public function __construct(ContestConfigRepository $configRepository)
    {
        parent::__construct();
        $this->contestConfig = $configRepository;
        $this->env = new ContestEnvironment();
    }

    public function add(ConfigRequest $request)
    {
        $config = new ContestConfig();
        $config->environment = $request->environment;
        $config->name = $request->name;
        $config->config_type = $request->type;
        $config->status = !empty($request->status)?'1':'0';
        $config->description = $request->description;
        $config->config_option = $request->option;
        if($request->option == 'special'){
            $config->start_date = date_create_from_format('d-m-Y H:m',$request->start_date);
            $config->end_date = date_create_from_format('d-m-Y H:m',$request->end_date);
        }
        $config_arr = [];
        if(!empty($request->config)){
            foreach ($request->config as $key=>$conf){
                $config_arr[$key] = [];
                if(!empty($conf['varible'])){
                    foreach ($conf['varible'] as $key1=>$value1){
                        $config_arr[$key][$value1] = [
                            'type' => $conf['type'][$key1],
                            'value' => $conf['value'][$key1]
                        ];
                    }
                }
            }
        }
        $config->config = !empty($config_arr)?json_encode($config_arr):$config_arr;
        try{
            $config->save();
            activity('contest_config')
                ->performedOn($config)
                ->withProperties($request->all())
                ->log('User: :causer.email - Add config - name: :properties.name, config_id: ' . $config->config_id);

            return redirect()->route('contest.contestmanage.contest_config.manage')->with('success', trans('card-cardmanage::language.messages.success.create'));
        }
        catch(\Exception $e){
            return redirect()->route('contest.contestmanage.contest_config.manage')->with('error', trans('card-cardmanage::language.messages.error.create'));
        }

    }

    public function create()
    {
        $data_view = [
            'type' => $this->env->getType(),
            'environment' => $this->env->getEnvironment(),
            'option' => $this->env->getOption()
        ];
        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.contest_config.create',$data_view);
    }

    public function delete(Request $request)
    {
        $product_id = $request->input('product_id');
        $card_product = $this->contestConfig->find($product_id);

        if (null != $card_product) {
            $this->contestConfig->delete($product_id);

            activity('cardProduct')
                ->performedOn($card_product)
                ->withProperties($request->all())
                ->log('User: :causer.email - Delete cardProduct - product_id: :properties.product_id, name: ' . $card_product->product_name);

            return redirect()->route('contest.contestmanage.contest_config.manage')->with('success', trans('card-cardmanage::language.messages.success.delete'));
        } else {
            return redirect()->route('contest.contestmanage.contest_config.manage')->with('error', trans('card-cardmanage::language.messages.error.delete'));
        }
    }

    public function manage()
    {
        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.contest_config.manage');
    }

    public function show(Request $request)
    {
        $product_id = $request->input('product_id');
        $card_product = $this->contestConfig->find($product_id);
        $data = [
            'card_product' => $card_product,
        ];

        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.contest_config.edit', $data);
    }

    public function update(Request $request)
    {
        $product_id = $request->input('product_id');
        $card_product = $this->contestConfig->find($product_id);
        $card_product->product_name=$request->input('name');
        $card_product->product_code=strtoupper($request->input('code'));
        $card_product->description=$request->input('description');
        if ($card_product->save()) {

            activity('cardProduct')
                ->performedOn($card_product)
                ->withProperties($request->all())
                ->log('User: :causer.email - Update cardProduct - product_id: :properties.product_id, name: :properties.product_name');

            return redirect()->route('contest.contestmanage.contest_config.manage')->with('success', trans('card-cardmanage::language.messages.success.update'));
        } else {
            return redirect()->route('contest.contestmanage.contest_config.show', ['product_id' => $request->input('product_id')])->with('error', trans('card-cardmanage::language.messages.error.update'));
        }
    }

    public function getModalDelete(Request $request)
    {
        $model = 'cardProduct';
        $tittle='Xác nhận xóa';
        $type=$this->contestConfig->find($request->input('product_id'));
        $content='Bạn có chắc chắn muốn xóa loại: '.$type->product_name.'?';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $confirm_route = route('contest.contestmanage.contest_config.delete', ['product_id' => $request->input('product_id')]);
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
        if(!empty($request->type)){
            return Datatables::of($this->contestConfig->findByType($request->type))
                ->addColumn('actions', function ($config) {
                    $actions = '<a href="javascript:void(0)" c-data="'. $config->config_id .'" d-data="' . $config->name . '" class="choose"><i class="livicon" data-name="plus" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="choose"></i></a>';
                    return $actions;
                })
                ->rawColumns(['actions'])
                ->make();
        }
        else{
            return Datatables::of($this->contestConfig->findAll())
                ->addColumn('actions', function ($config) {
                    $actions = '<a href=' . route('contest.contestmanage.contest_config.log', ['type' => 'contest_config', 'id' => $config->config_id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log config"></i></a>
                        <a href=' . route('contest.contestmanage.contest_config.show', ['config_id' => $config->config_id]) . '><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="update config"></i></a>
                        <a href=' . route('contest.contestmanage.contest_config.confirm-delete', ['config_id' => $config->config_id]) . ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete config"></i></a>';

                    return $actions;
                })
                ->rawColumns(['actions'])
                ->make();
        }

    }

    public function listData(Request $request){
        $data_view = [
            'type' => $request->type,
            'title' => 'cấu hình',
            'type_list' => $this->env->getType(),
            'environment' => $this->env->getEnvironment(),
            'option' => $this->env->getOption()
        ];
        $html = view('CONTEST-CONTESTMANAGE::modules.contestmanage.includes.get_list_config', $data_view)->render();
        return response()->json($html);
    }

    public function listTargetID(Request $request){
        if(!empty($request->type)){
            switch ($request->type){
                case 'season':
                    return [
                        1 => 'Mùa 1',
                        2 => 'Mùa 2',
                        3 => 'Mùa 3',
                    ];
                    break;
                    case 'round':
                    return [
                        1 => 'Vòng loại',
                        2 => 'Vòng trường',
                        3 => 'Vòng tỉnh/ tp',
                        4 => 'Vòng chung kết toàn quốc',
                    ];
                    break;
                    case 'topic':
                    return [
                        1 => 'Vòng loại - Tuần 1',
                        2 => 'Vòng loại - Tuần 2',
                        3 => 'Vòng trường - Tuần 1',
                    ];
                    break;
                    case 'topic_round':
                    return [
                        1 => 'Mùa 1',
                        2 => 'Mùa 2',
                        3 => 'Mùa 3',
                    ];
                    break;
            }
        }
    }
}