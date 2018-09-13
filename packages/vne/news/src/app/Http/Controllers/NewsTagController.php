<?php

namespace Vne\News\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Illuminate\Support\Collection;

use Vne\News\App\Http\Requests\NewsTagRequest;

use Vne\News\App\Repositories\NewsTagRepository;

use Vne\News\App\Models\NewsTag;

use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator,DB;
use Auth;
use DateTime,Cache;
class NewsTagController extends Controller
{	
    protected $_newsCatList;
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );
	public function __construct(NewsTagRepository $newsTagRepository)
    {
        parent::__construct();
        $this->news_tag = $newsTagRepository;
        $this->_user = Auth::user();
    }
	public function manager(){
		return view('VNE-NEWS::modules.news.news_tag.manager');
	}
	/**
     * @return view add news cat 
     * @author: tuanlv
     * @params: 
     * Chức năng : get view add news cat
     */
	public function create(){
		return view('VNE-NEWS::modules.news.news_tag.create');
	}
	/**
     * @return view add list cat
     * @author: tuanlv
     * @params: 
     * Chức năng : thêm 1 chuyên mục tin tức
     */
	public function add(NewsTagRequest $request){
        $name = $request->name;
        $news_tag = new NewsTag();
        $news_tag->name = $name;
        $news_tag->alias = self::stripUnicode($name);
        $news_tag->created_at = new DateTime();
        $news_tag->updated_at = new DateTime();
        $news_tag->status = 1;
		$news_tag->save();
		if ($news_tag->news_tag_id) {
            activity('news_tag')
                ->performedOn($news_tag)
                ->withProperties($request->all())
                ->log('User: :causer.email - Add NewsCat - name: :properties.name, news_tag_id: ' . $news_tag->news_cat_id);

            return redirect()->route('vne.news.tag.manager')->with('success', trans('vne-news::language.messages.success.create'));
        } else {
            return redirect()->route('vne.news.tag.manager')->with('error', trans('vne-news::language.messages.error.create'));
        }
	}
    /**
     * @return view add edit cat
     * @author: tuanlv
     * @params: 
     * Chức năng : get view sửa chuyên đề
     */
	public function show(NewsTagRequest $request){
        $news_tag_id = $request->news_tag_id;
		$news_tag = $this->news_tag->find($news_tag_id);
		return view('VNE-NEWS::modules.news.news_tag.edit',compact('news_tag'));
	}	
	public function update(NewsTagRequest $request){
        $news_tag = $this->news_tag->find($request->news_tag_id);
		$news_tag->name = $request->name;
		if ($news_tag->save()) {
            activity('news_tag')
                ->performedOn($news_tag)
                ->withProperties($request->all())
                ->log('User: :causer.email - Update News tag - news_tag_id: :properties.news_tag_id, name: :properties.name');

            return redirect()->route('vne.news.tag.manager')->with('success', trans('VNE-NEWS::language.messages.success.update'));
        } else {
            return redirect()->route('vne.news.tag.manager')->with('error', trans('VNE-NEWS::language.messages.error.update'));
        }
	}
    public function delete(NewsTagRequest $request)
    {
        $news_tag_id = $request->news_tag_id;
        $news_tag = $this->news_tag->find($news_tag_id);
        if (null != $news_tag) {
            $this->news_tag->delete($news_tag_id);
            DB::table('VNE_news_has_tag')->where('news_tag_id',$news_tag_id)->delete();
            activity('news_tag')
                ->performedOn($news_tag)
                ->withProperties($request->all())
                ->log('User: :causer.email - Delete News tag - news_tag_id: :properties.news_tag_id, name: ' . $news_tag->name);
            return redirect()->route('vne.news.tag.manager')->with('success', trans('VNE-NEWS::language.messages.success.delete'));
        } else {
            return redirect()->route('vne.news.tag.manager')->with('error', trans('VNE-NEWS::language.messages.error.delete'));
        }
    }
    public function getModalDelete(Request $request)
    {
        $model = 'news_tag';
        $type = 'delete';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'news_tag_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $confirm_route = route('vne.news.tag.delete', ['news_tag_id' => $request->news_tag_id]);
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
        $model = 'news_tag';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'news_tag_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $logs = Activity::where([
                    ['log_name', $model],
                    ['subject_id', $request->input('news_tag_id')]
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
        $list_news_tag = $this->news_tag->findAll();
        return Datatables::of($list_news_tag)
            ->addIndexColumn()
            ->addColumn('actions', function ($list_news_tag) {
                $actions = '';
                if ($this->user->canAccess('vne.news.tag.log')) {
                    $actions .= '<a href=' . route('vne.news.tag.log', ['type' => 'news', 'news_tag_id' => $list_news_tag->news_tag_id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log news tag"></i></a>';
                }
                if ($this->user->canAccess('vne.news.tag.show')) {
                    $actions .= '<a href=' . route('vne.news.tag.show', ['news_tag_id' => $list_news_tag->news_tag_id]) . '><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="update news tag"></i></a>';
                }
                if ($this->user->canAccess('vne.news.tag.confirm-delete')) {
                    $actions .='<a href=' . route('vne.news.tag.confirm-delete', ['news_tag_id' => $list_news_tag->news_tag_id]) . ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete news tag"></i></a>';
                }
                return $actions;
            })
            ->rawColumns(['actions'])
            ->make();
    }

    public function addAjax(Request $request){
        $tags_reponse = array();
        $tags_request = explode(",",$request->list_tag);
        if(!empty($tags_request)){
            foreach ($tags_request as $key => $value) {
                $news_tag = new NewsTag(); 
                $news_tag->name = $value;
                $news_tag->alias = self::stripUnicode($value);
                $news_tag->created_at = new DateTime();
                $news_tag->updated_at = new DateTime();
                $news_tag->status = 1;
                $news_tag->save();
                $tags_reponse[] = [
                    'news_tag_id' => $news_tag->news_tag_id,
                    'name' => $news_tag->name
                ];
            }
        }
        return json_encode($tags_reponse);
    }
}