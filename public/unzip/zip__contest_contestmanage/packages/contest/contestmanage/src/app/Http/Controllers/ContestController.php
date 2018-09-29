<?php

namespace Contest\Contestmanage\App\Http\Controllers;

use Dhcd\Contest\App\Repositories\ContestRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Illuminate\Support\Facades\Schema;
use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator;

class ContestController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );

    public function __construct(ContestRepository $contestRepository)
    {
        parent::__construct();
        $this->contest = $contestRepository;
    }

    public function add(Request $request)
    {

            if ($card_product->product_id) {


//                dd(shell_exec('cd ../ && /egserver/php/bin/php /egserver/php/bin/composer dump-autoload'));
                activity('cardProduct')
                    ->performedOn($card_product)
                    ->withProperties($request->all())
                    ->log('User: :causer.email - Add cardProduct - name: :properties.name, product_id: ' . $card_product->product_id);

                return redirect()->route('card.cardmanage.card_product.manage')->with('success', trans('card-cardmanage::language.messages.success.create'));
            } else {
                return redirect()->route('card.cardmanage.card_product.manage')->with('error', trans('card-cardmanage::language.messages.error.create'));
            }

    }

    public function create()
    {
        return view('CARD-CARDMANAGE::modules.cardmanage.card_product.create');
    }

    public function delete(Request $request)
    {
        $product_id = $request->input('product_id');
        $card_product = $this->cardProduct->find($product_id);

        if (null != $card_product) {
            $this->cardProduct->delete($product_id);

            activity('cardProduct')
                ->performedOn($card_product)
                ->withProperties($request->all())
                ->log('User: :causer.email - Delete cardProduct - product_id: :properties.product_id, name: ' . $card_product->product_name);

            return redirect()->route('card.cardmanage.card_product.manage')->with('success', trans('card-cardmanage::language.messages.success.delete'));
        } else {
            return redirect()->route('card.cardmanage.card_product.manage')->with('error', trans('card-cardmanage::language.messages.error.delete'));
        }
    }

    public function manage()
    {
        return view('CARD-CARDMANAGE::modules.cardmanage.card_product.manage');
    }

    public function show(Request $request)
    {
        $product_id = $request->input('product_id');
        $card_product = $this->cardProduct->find($product_id);
        $data = [
            'card_product' => $card_product,
        ];

        return view('CARD-CARDMANAGE::modules.cardmanage.card_product.edit', $data);
    }

    public function update(CardProductRequest $request)
    {
        $product_id = $request->input('product_id');
        $card_product = $this->cardProduct->find($product_id);
        $card_product->product_name=$request->input('name');
        $card_product->product_code=strtoupper($request->input('code'));
        $card_product->description=$request->input('description');
        if ($card_product->save()) {

            activity('cardProduct')
                ->performedOn($card_product)
                ->withProperties($request->all())
                ->log('User: :causer.email - Update cardProduct - product_id: :properties.product_id, name: :properties.product_name');

            return redirect()->route('card.cardmanage.card_product.manage')->with('success', trans('card-cardmanage::language.messages.success.update'));
        } else {
            return redirect()->route('card.cardmanage.card_product.show', ['product_id' => $request->input('product_id')])->with('error', trans('card-cardmanage::language.messages.error.update'));
        }
    }

    public function getModalDelete(Request $request)
    {
        $model = 'cardProduct';
        $tittle='Xác nhận xóa';
        $type=$this->cardProduct->find($request->input('product_id'));
        $content='Bạn có chắc chắn muốn xóa loại: '.$type->product_name.'?';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $confirm_route = route('card.cardmanage.card_product.delete', ['product_id' => $request->input('product_id')]);
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
        return Datatables::of($this->cardProduct->findAll())
            ->addColumn('actions', function ($card_product) {
                $actions = '<a href=' . route('card.cardmanage.card_product.log', ['type' => 'cardProduct', 'id' => $card_product->product_id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log cardProduct"></i></a>';
//                        <a href=' . route('card.cardmanage.card_product.confirm-delete', ['product_id' => $card_product->product_id]) . ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete cardProduct"></i></a>';

                return $actions;
            })
            ->rawColumns(['actions'])
            ->make();
    }


}