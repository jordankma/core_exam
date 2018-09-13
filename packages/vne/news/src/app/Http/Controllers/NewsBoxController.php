<?php

namespace Vne\News\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Illuminate\Support\Collection;

use Vne\News\App\Repositories\NewsBoxRepository;

use Vne\News\App\Models\NewsBox;
use Vne\News\App\Models\NewsHasBox;

use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator,DB;
use Auth;
use DateTime,Cache;
class NewsBoxController extends Controller
{	
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );
	public function __construct(NewsBoxRepository $newsBoxRepository)
    {
        parent::__construct();
        $this->news_box = $newsBoxRepository;
        $this->_user = Auth::user();
    }
	public function manager(){
		return view('VNE-NEWS::modules.news.news_box.manager');
	}
	/**
     * @return view add news cat 
     * @author: tuanlv
     * @params: 
     * Chức năng : get view add news cat
     */
	public function create(){
		return view('VNE-NEWS::modules.news.news_box.create');
	}
	/**
     * @return view add list cat
     * @author: tuanlv
     * @params: 
     * Chức năng : thêm 1 chuyên mục tin tức
     */
	public function add(Request $request){
        $name = $request->name;
        $news_box = new NewsBox();
        $news_box->name = $name;
        $news_box->alias = self::to_slug($name);
        $news_box->created_at = new DateTime();
        $news_box->updated_at = new DateTime();
		$news_box->save();
		if ($news_box->news_box_id) {
            activity('news_box')
                ->performedOn($news_box)
                ->withProperties($request->all())
                ->log('User: :causer.email - Add NewsCat - name: :properties.name, news_box_id: ' . $news_box->news_cat_id);

            return redirect()->route('vne.news.box.manager')->with('success', trans('vne-news::language.messages.success.create'));
        } else {
            return redirect()->route('vne.news.box.manager')->with('error', trans('vne-news::language.messages.error.create'));
        }
	}
    /**
     * @return view add edit cat
     * @author: tuanlv
     * @params: 
     * Chức năng : get view sửa chuyên đề
     */
	public function show(Request $request){
        $news_box_id = $request->news_box_id;
		$news_box = $this->news_box->find($news_box_id);
		return view('VNE-NEWS::modules.news.news_box.edit',compact('news_box'));
	}	
	public function update(Request $request){
        $news_box = $this->news_box->find($request->news_box_id);
        $news_box->name = $request->name;
		$news_box->name = $request->alias;
		if ($news_box->save()) {
            activity('news_box')
                ->performedOn($news_box)
                ->withProperties($request->all())
                ->log('User: :causer.email - Update News box - news_box_id: :properties.news_box_id, name: :properties.name');

            return redirect()->route('vne.news.box.manager')->with('success', trans('VNE-NEWS::language.messages.success.update'));
        } else {
            return redirect()->route('vne.news.box.manager')->with('error', trans('VNE-NEWS::language.messages.error.update'));
        }
	}
    public function delete(Request $request)
    {
        $news_box_id = $request->news_box_id;
        $news_box = $this->news_box->find($news_box_id);
        if (null != $news_box) {
            $this->news_box->delete($news_box_id);
            DB::table('vne_news_has_box')->where('news_box_id',$news_box_id)->delete();
            activity('news_box')
                ->performedOn($news_box)
                ->withProperties($request->all())
                ->log('User: :causer.email - Delete News box - news_box_id: :properties.news_box_id, name: ' . $news_box->name);
            return redirect()->route('vne.news.box.manager')->with('success', trans('VNE-NEWS::language.messages.success.delete'));
        } else {
            return redirect()->route('vne.news.box.manager')->with('error', trans('VNE-NEWS::language.messages.error.delete'));
        }
    }
    public function getModalDelete(Request $request)
    {
        $model = 'news_box';
        $type = 'delete';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'news_box_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            $count = NewsHasBox::where('news_box_id','=',$request->input('news_box_id'))->count();
            if($count>0){
                $error = "Box này đang có tin tức không thể xóa!";
                return view('VNE-NEWS::modules.news.modal.modal_confirmation', compact('type','error', 'model', 'confirm_route')); 
            }
            try {
                $confirm_route = route('vne.news.box.delete', ['news_box_id' => $request->input('news_box_id')]);
                return view('VNE-NEWS::modules.news.modal.modal_confirmation', compact('type','error', 'model', 'confirm_route'));
            } catch (GroupNotFoundException $e) {
                return view('VNE-NEWS::modules.news.modal.modal_confirmation', compact('type','error', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }
    public function log(Request $request)
    {
        $model = 'news_box';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'news_box_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $logs = Activity::where([
                    ['log_name', $model],
                    ['subject_id', $request->input('news_box_id')]
                ])->get();
                return view('VNE-NEWS::modules.news.modal.modal_table', compact('error', 'model', 'confirm_route', 'logs'));
            } catch (GroupNotFoundException $e) {
                return view('VNE-NEWS::modules.news.modal.modal_table', compact('error', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }
	//Table Data to index page
    public function data()
    {
        $list_news_box = $this->news_box->findAll();
        return Datatables::of($list_news_box)
            ->addIndexColumn()
            ->addColumn('actions', function ($list_news_box) {
                $actions = '';
                if ($this->user->canAccess('vne.news.box.log')) {
                    $actions .= '<a href=' . route('vne.news.box.log', ['type' => 'news', 'news_box_id' => $list_news_box->news_box_id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log news box"></i></a>';
                }
                if ($this->user->canAccess('vne.news.box.show')) {
                    $actions .= '<a href=' . route('vne.news.box.show', ['news_box_id' => $list_news_box->news_box_id]) . '><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="update news box"></i></a>';
                }
                if ($this->user->canAccess('vne.news.box.confirm-delete')) {
                    $actions .='<a href=' . route('vne.news.box.confirm-delete', ['news_box_id' => $list_news_box->news_box_id]) . ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete news box"></i></a>';
                }
                return $actions;
            })
            ->rawColumns(['actions'])
            ->make();
    }

}