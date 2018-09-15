<?php

namespace Vne\News\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Illuminate\Support\Collection;
use Vne\News\App\Http\Requests\NewsCatRequest;

use Vne\News\App\Repositories\NewsRepository;
use Vne\News\App\Repositories\NewsCatRepository;
use Vne\News\App\Repositories\NewsTagRepository;
use Vne\News\App\Repositories\NewsHasTagRepository;
use Vne\News\App\Repositories\NewsHasCatRepository;

use Vne\News\App\Models\News;
use Vne\News\App\Models\NewsCat;
use Vne\News\App\Models\NewsTag;
use Vne\News\App\Models\NewsHasTag;
use Vne\News\App\Models\NewsHasCat;

use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator;
use Auth;
use DateTime,Cache;
class NewsCatController extends Controller
{	
    protected $_newsCatList;
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );
	public function __construct( NewsCatRepository $newsCatRepository)
    {
        parent::__construct();
        $this->news_cat = $newsCatRepository;
        $this->_user = Auth::user();
    }
	public function manager(){
		return view('VNE-NEWS::modules.news.news_cat.manager');
	}
	/**
     * @return view add news cat 
     * @author: tuanlv
     * @params: 
     * Chức năng : get view add news cat
     */
	public function create(){
        self::getCate();
        $list_news_cat = $this->_newsCatList;
		return view('VNE-NEWS::modules.news.news_cat.create',compact('list_news_cat'));
	}
	/**
     * @return view add list cat
     * @author: tuanlv
     * @params: 
     * Chức năng : thêm 1 chuyên mục tin tức
     */
	public function add(NewsCatRequest $request){
        $name = $request->name;
        $news_cat = new NewsCat();
        $news_cat->name = $name;
        $news_cat->alias = self::to_slug($name);
        $news_cat->created_at = new DateTime();
        $news_cat->updated_at = new DateTime();
        $news_cat->status = 1;
        $news_cat->parent = $request->parent_id;
		$news_cat->save();
		if ($news_cat->news_cat_id) {
            activity('news_cat')
                ->performedOn($news_cat)
                ->withProperties($request->all())
                ->log('User: :causer.email - Add NewsCat - name: :properties.name, news_cat_id: ' . $news_cat->news_cat_id);

            return redirect()->route('vne.news.cat.manager')->with('success', trans('vne-news::language.messages.success.create'));
        } else {
            return redirect()->route('vne.news.cat.manager')->with('error', trans('vne-news::language.messages.error.create'));
        }
	}
	/**
     * @return true,false
     * @author: tuanlv
     * @params: 
     * Chức năng : kiểm tra chuyên mục tồn tại hay chưa
     */
    public function checkNameExists(Request $request) {
        $data['valid'] = true;
        if ($request->ajax()) {
            $news_cat =  NewsCat::where(['name' => $request->name])->first();
            if ($news_cat) {
                $data['valid'] = false; // true là có user
            }
        }
        echo json_encode($data);
    }
    /**
     * @return view add edit cat
     * @author: tuanlv
     * @params: 
     * Chức năng : get view sửa chuyên đề
     */
	public function show(Request $request){
        $news_cat_id = $request->news_cat_id;
		$news_cat = $this->news_cat->find($news_cat_id);
        self::getCate();
        $list_news_cat = $this->_newsCatList;
		return view('VNE-NEWS::modules.news.news_cat.edit',compact('news_cat','list_news_cat'));
	}	
	public function update(NewsCatRequest $request){
		$news_cat = $this->news_cat->find($request->news_cat_id);
		$news_cat->name = $request->name;
        $news_cat->alias = self::to_slug($request->name);
        $news_cat->parent = $request->parent_id;
		if ($news_cat->save()) {
            activity('news_cat')
                ->performedOn($news_cat)
                ->withProperties($request->all())
                ->log('User: :causer.email - Update News Cat - news_cat_id: :properties.news_cat_id, name: :properties.name');

            return redirect()->route('vne.news.cat.manager')->with('success', trans('VNE-NEWS::language.messages.success.update'));
        } else {
            return redirect()->route('vne.news.cat.manager')->with('error', trans('VNE-NEWS::language.messages.error.update'));
        }
	}
    public function delete(Request $request)
    {
        $news_cat_id = $request->input('news_cat_id');
        $news_cat = $this->news_cat->find($news_cat_id);
        if (null != $news_cat) {
            // if($news_cat->news_cat_id==0){
            //     DB::table('vne_news_cat')->where('parent_news_cat_id',$news_cat_id)->update(array(
            //         'parent_news_cat_id'=>0,
            //     ));
            // }
            $news_cat->delete($news_cat_id);
            activity('news_cat')
                ->performedOn($news_cat)
                ->withProperties($request->all())
                ->log('User: :causer.email - Delete News Cat - news_cat_id: :properties.news_cat_id, name: ' . $news_cat->name);
            return redirect()->route('vne.news.cat.manager')->with('success', trans('VNE-NEWS::language.messages.success.delete'));
        } else {
            return redirect()->route('vne.news.cat.manager')->with('error', trans('VNE-NEWS::language.messages.error.delete'));
        }
    }
    public function getModalDelete(Request $request)
    {
        $model = 'news_cat';
        $type = 'delete';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'news_cat_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            $new_cat_id = $request->input('news_cat_id');
            $count = NewsHasCat::where('news_cat_id','=',$new_cat_id)->count();
            if($count>0){
                $error = "Chuyên đề này đang có tin tức không thể xóa!";
                return view('VNE-NEWS::modules.news.modal.modal_confirmation', compact('type','error', 'model', 'confirm_route')); 
            }
            try {
                $confirm_route = route('vne.news.cat.delete', ['news_cat_id' => $new_cat_id]);
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
        $model = 'news_cat';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'news_cat_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $logs = Activity::where([
                    ['log_name', $model],
                    ['subject_id', $request->input('news_cat_id')]
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
        // $list_news_cat = NewsCat::where('visible',1)->get();
        $newsCatData = array(
            'items' => array(),
            'parents' => array()
        );
        self::getCate();
        $list_news_cat = Collection::make($this->_newsCatList);
        return Datatables::of($list_news_cat)
            ->addIndexColumn()
            ->editColumn('name', function ($list_news_cat) {
                $name = str_repeat('---', $list_news_cat->level) . $list_news_cat->name;
                return $name;
            })
            ->addColumn('actions', function ($list_news_cat) {
                $actions = '';
                if ($this->user->canAccess('vne.news.cat.log')) {
                    $actions .= '<a href=' . route('vne.news.cat.log', ['type' => 'news', 'news_cat_id' => $list_news_cat->news_cat_id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log news cat"></i></a>';
                }
                if ($this->user->canAccess('vne.news.cat.show')) {
                    $actions .= '<a href=' . route('vne.news.cat.show', ['news_cat_id' => $list_news_cat->news_cat_id]) . '><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="update news cat"></i></a>';
                }
                if ($this->user->canAccess('vne.news.cat.confirm-delete')) {
                    $actions .='<a href=' . route('vne.news.cat.confirm-delete', ['news_cat_id' => $list_news_cat->news_cat_id]) . ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete news cat"></i></a>';
                }
                return $actions;
            })
            ->rawColumns(['actions'])
            ->make();
    }

    function getCate() {
        $news_cats = NewsCat::orderBy('parent')->get();
        if (count($news_cats) > 0) {
            foreach ($news_cats as $news_cat) {

                $parent_id = $news_cat->parent;
                $news_cat_id = $news_cat->news_cat_id;

                $newsCatData['items'][$news_cat_id] = $news_cat;
                $newsCatData['parents'][$parent_id][] = $news_cat_id;
            }
            $this->_newsCatList = new Collection();
            self::buildMenu(0, $newsCatData);
        }
    }

    function buildMenu($parentId, $newsCatData)
    {
        if (isset($newsCatData['parents'][$parentId]))
        {
            foreach ($newsCatData['parents'][$parentId] as $itemId)
            {
                $item = $newsCatData['items'][$itemId];
                $item->level = 1;
                if ($parentId == 0)
                    $item->level = 0;
                else
                    $item->level = $newsCatData['items'][$parentId]->level + 1;
                $this->_newsCatList->push($item);

                // find childitems recursively
                $more = self::buildMenu($itemId, $newsCatData);
                if (!empty($more))
                    $this->_newsCatList->push($more);
            }
        }
    }

    function getCateApi() {
        $this->_newsCatList = new Collection();
        $news_cats = NewsCat::orderBy('parent')->get();
        if (count($news_cats) > 0) {
            foreach ($news_cats as $news_cat) {

                $parent_id = $news_cat->parent;
                $news_cat_id = $news_cat->news_cat_id;

                $newsCatData['items'][$news_cat_id] = $news_cat;
                $newsCatData['parents'][$parent_id][] = $news_cat_id;
            }
            self::buildMenu(0, $newsCatData);
        }
        return $this->_newsCatList;
    }
}