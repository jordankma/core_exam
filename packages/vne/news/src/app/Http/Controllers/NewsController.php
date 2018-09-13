<?php

namespace Vne\News\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Illuminate\Support\Collection;
use Vne\News\App\Http\Requests\NewsCatRequest;
use Vne\News\App\Http\Requests\NewsRequest;

use Vne\News\App\Repositories\NewsRepository;
use Vne\News\App\Repositories\NewsCatRepository;
use Vne\News\App\Repositories\NewsTagRepository;
use Vne\News\App\Repositories\NewsBoxRepository;
use Vne\News\App\Repositories\NewsHasTagRepository;
use Vne\News\App\Repositories\NewsHasCatRepository;

use Vne\News\App\Models\News;
use Vne\News\App\Models\NewsCat;
use Vne\News\App\Models\NewsTag;
use Vne\News\App\Models\NewsBox;
use Vne\News\App\Models\NewsHasTag;
use Vne\News\App\Models\NewsHasCat;
use Vne\News\App\Models\NewsHasBox;

use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator;
use Auth;
use DateTime;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class NewsController extends Controller
{	
	protected $_newsCatList;
	private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );

	public function __construct(NewsRepository $newsRepository, NewsCatRepository $newsCatRepository,NewsTagRepository $newsTagRepository,NewsHasTagRepository $newsHasTagRepository,NewsHasCatRepository $newsHasCatRepository,NewsBoxRepository $newsBoxRepository)
    {
        parent::__construct();
        $this->news = $newsRepository;
        $this->news_cat = $newsCatRepository;
        $this->news_tag = $newsTagRepository;
        $this->news_has_tag = $newsHasTagRepository;
        $this->news_has_cat = $newsHasCatRepository;
        $this->news_box = $newsBoxRepository;
        $this->_user = Auth::user();
    }
	/**
     * @return view list news
     * @author: tuanlv
     * @params: 
     * Chức năng : get list news
     */
	public function manager(Request $request){
		$list_news_cat = $this->news_cat->all();
		$params =[
    		'name'=>$request->name,
    		'news_time'=>$request->news_time,
    		'news_cat'=>$request->news_cat,
    		'is_hot'=> $request->is_hot
    	];
		return view('VNE-NEWS::modules.news.news.manager',compact('list_news_cat','params'));
	}
	public function create(){
		// $list_news_cat = $this->news_cat->all();
		self::getCate();
        $list_news_cat = $this->_newsCatList;
        $list_news_tag = $this->news_tag->all();
		$list_news_box = $this->news_box->all();
		$data = [
			'list_news_cat' => $list_news_cat,
			'list_news_tag' => $list_news_tag,
            'list_news_box' => $list_news_box
		];
		return view('VNE-NEWS::modules.news.news.create',$data);
	}
	public function add(NewsRequest $request){
		$create_by = $this->user->email;
		$title = $request->input('title');
		$news_cat = $request->input('news_cat');
        $news_tag = $request->input('news_tag');
		$news_box = $request->input('news_box');
		$desc = $request->input('desc');
		$content = $request->input('content');
        $is_hot = $request->input('is_hot');
		$type = $request->input('type');
		$priority = $request->input('priority');
		$desc_seo = !empty($request->input('desc_seo')) ? $request->input('desc_seo') : '';
		$image = $request->input('image') !='' ? $request->input('image') : asset('test.png');
		$key_word_seo = explode(",",$request->input('key_word_seo')[0]);
        $gallery = [];
        if($type == 2){  
            $file_names = $request->input('file_names');
            $file_types = $request->input('file_types');
            $file_links = $request->input('file_links');
            if(!empty($file_names)){
                foreach($file_names as $i => $name){
                    $gallery[] = [
                        'name' => $name,
                        'type' => $file_types[$i],
                        'link' => $file_links[$i]
                    ];
                }
            }
        }
		$news = new News();
		$news->create_by = $create_by;
        $news->title = $title;
		$news->type_page = 'news';
		$news->news_cat = json_encode($news_cat);
		$news->news_tag = json_encode($news_tag);
		$news->title_alias = self::to_slug($title);
		$news->desc = $desc;
		$news->image = $image;
		$news->content = $content;
        $news->is_hot = $is_hot;

		$news->type = $type;
		$news->gallery = json_encode($gallery);  

        $news->priority = $priority;
		$news->key_word_seo = json_encode($key_word_seo);
		$news->desc_seo = $desc_seo;
		$news->created_at = new DateTime();
		$news->updated_at = new DateTime();
		$news->save();

		if(!empty($news_tag)){
			foreach ($news_tag as $key => $tag) {
				$data_insert_news_has_tag[] =[
					'news_id'=> $news->news_id,
					'news_tag_id'=> $tag
				];
				$list_tag_id[] = $tag;
			}
			if(!empty($data_insert_news_has_tag)){
				DB::table('vne_news_has_tag')->insert($data_insert_news_has_tag);
				$news_tag_list = NewsTag::whereIn('news_tag_id', $list_tag_id)->select('news_tag_id', 'name')->get()->toJson();
	            $news->news_tag = $news_tag_list;
	            $news->save();
			}
		}
        if(!empty($news_box)){
            foreach ($news_box as $key => $box) {

                $data_insert_news_has_box[] =[
                    'news_id'=> $news->news_id,
                    'news_box_id'=> $box
                ];
                $list_box_id[] = $box;
            }
            if(!empty($data_insert_news_has_box)){
                DB::table('vne_news_has_box')->insert($data_insert_news_has_box);
                $news_box_list = NewsBox::whereIn('news_box_id', $list_box_id)->select('news_box_id', 'name')->get()->toJson();
                $news->news_box = $news_box_list;
                $news->save();
            }
        }
		if (!empty($news_cat)) {
            $news_has_tag = [];
            foreach ($news_cat as $cat) {
                $news_has_tag[] = [
                    'news_id' => $news->news_id,
                    'news_cat_id' => $cat
                ];
            }
            if (!empty($news_has_tag)) {
                DB::table('vne_news_has_cat')->insert($news_has_tag);
            }
            $news_cat_list = NewsCat::whereIn('news_cat_id', $news_cat)->select('news_cat_id', 'name')->get()->toJson();
            $news->news_cat = $news_cat_list;
            $news->save();
        }
		if ($news->news_id) {
            Cache::forget('cache_api_news');
            Cache::forget('cache_news');
            activity('news')
                ->performedOn($news)
                ->withProperties($request->all())
                ->log('User: :causer.email - Add news - name: :properties.name, news_id: ' . $news->news_id);
            return redirect()->route('vne.news.news.manager')->with('success', trans('VNE-NEWS::language.messages.success.create'));
        } else {
            return redirect()->route('vne.news.news.manager')->with('error', trans('VNE-NEWS::language.messages.error.create'));
        }
	}

	public function show($news_id){

		self::getCate();
        $list_news_cat = $this->_newsCatList;
        $list_news_tag = $this->news_tag->all();
		$list_news_box = $this->news_box->all();
		$news = $this->news->find($news_id);
		$list_id_cat = array();
        $list_id_tag = array();
        $list_id_box= array();
		$list_tag = array();
		if(!empty($news->news_cat)){
			$news_cat = json_decode($news->news_cat,true);
            if(!empty($news_cat)){
                foreach ($news_cat as $key => $value) {
                    $list_id_cat[] = $value['news_cat_id'];
                } 
            }
		}
		if(!empty($news->news_tag)){
			$news_tag = json_decode($news->news_tag,true);
            if(!empty($news_tag)){
    			foreach ($news_tag as $key => $value) {
    				$list_id_tag[] = $value['news_tag_id'];
    			}
            }	
		}
        if(!empty($news->news_box)){
            $news_box = json_decode($news->news_box,true);
            if(!empty($news_box)){
                foreach ($news_box as $key => $value) {
                    $list_id_box[] = $value['news_box_id'];
                }
            }   
        }
		$list_key_word_seo_string = implode(',', json_decode($news->key_word_seo,true));
        $list_gallery = json_decode($news->gallery,true);
		$data = [
			'news' => $news,
			'list_news_cat' => $list_news_cat,
            'list_news_tag' => $list_news_tag,
			'list_news_box' => $list_news_box,
			'list_id_cat' => $list_id_cat,
            'list_id_tag' => $list_id_tag,
			'list_id_box' => $list_id_box,
			'list_key_word_seo_string' => $list_key_word_seo_string,
		    'list_gallery' => $list_gallery        
        ];
		return view('VNE-NEWS::modules.news.news.edit',$data);
	}	
	public function update($news_id,NewsRequest $request){
        
        DB::table('vne_news_has_tag')->where('news_id',$news_id)->delete();
		DB::table('vne_news_has_box')->where('news_id',$news_id)->delete();
		DB::table('vne_news_has_cat')->where('news_id',$news_id)->delete();

		$title = $request->input('title');
		$news_cat = $request->input('news_cat');
		$news_tag = $request->input('news_tag');
        $news_box = $request->input('news_box');
		$desc = $request->input('desc');
		$content = $request->input('content');
		$image = $request->input('image') !='' ? $request->input('image') : asset('test.png');
		$is_hot = $request->input('is_hot');
        $type = $request->input('type');
		$priority = $request->input('priority');
		$desc_seo = !empty($request->input('desc_seo')) ? $request->input('desc_seo') : '';
		$key_word_seo = explode(",",$request->input('key_word_seo')[0]);
        
        $gallery = [];
        if($type == 2){ 
            $file_names = $request->input('file_names');
            $file_types = $request->input('file_types');
            $file_links = $request->input('file_links');
            if(!empty($file_names)){
                foreach($file_names as $i => $name){
                    $gallery[] = [
                        'name' => $name,
                        'type' => $file_types[$i],
                        'link' => $file_links[$i]
                    ];
                }
            }
        }
        
		$news = $this->news->find($news_id);
		$news->title = $title;
        $news->type_page = 'news';
		$news->news_cat = json_encode($news_cat);
		$news->news_tag = json_encode($news_tag);
		$news->title_alias = self::to_slug($title);
		$news->desc = $desc;
		$news->content = $content;
		$news->image = $image;
		$news->is_hot = $is_hot;

        $news->type = $type;
        $news->gallery = json_encode($gallery);

		$news->priority = $priority;
		$news->is_hot = $is_hot;
		$news->key_word_seo = json_encode($key_word_seo);
		$news->desc_seo = $desc_seo;
		$news->updated_at = new DateTime();
		$news->save();

		if(!empty($news_tag)){
			foreach ($news_tag as $key => $tag) {
				$data_insert_news_has_tag[] =[
					'news_id'=> $news->news_id,
					'news_tag_id'=> $tag
				];
				$list_tag_id[] = $tag;
			}
			if(!empty($data_insert_news_has_tag)){
				DB::table('vne_news_has_tag')->insert($data_insert_news_has_tag);
				$news_tag_list = NewsTag::whereIn('news_tag_id', $list_tag_id)->select('news_tag_id', 'name')->get()->toJson();
	            $news->news_tag = $news_tag_list;
	            $news->save();
			}
		}
        if(!empty($news_box)){
            foreach ($news_box as $key => $box) {
                $data_insert_news_has_box[] =[
                    'news_id'=> $news->news_id,
                    'news_box_id'=> $box
                ];
                $list_box_id[] = $box;
            }
            if(!empty($data_insert_news_has_box)){
                DB::table('vne_news_has_box')->insert($data_insert_news_has_box);
                $news_box_list = NewsBox::whereIn('news_box_id', $list_box_id)->select('news_box_id', 'name')->get()->toJson();
                $news->news_box = $news_box_list;
                $news->save();
            }
        }
		if (!empty($news_cat)) {
            $news_has_tag = [];
            foreach ($news_cat as $cat) {
                $news_has_tag[] = [
                    'news_id' => $news->news_id,
                    'news_cat_id' => $cat
                ];
            }
            if (!empty($news_has_tag)) {
                DB::table('vne_news_has_cat')->insert($news_has_tag);
            }
            $news_cat_list = NewsCat::whereIn('news_cat_id', $news_cat)->select('news_cat_id', 'name')->get()->toJson();
            $news->news_cat = $news_cat_list;
            $news->save();
        }
		if ($news->news_id) {
            Cache::forget('cache_api_news');
            Cache::forget('cache_news');
            activity('news')
                ->performedOn($news)
                ->withProperties($request->all())
                ->log('User: :causer.email - Edit news - name: :properties.name, news_id: ' . $news->news_id);
            return redirect()->route('vne.news.news.manager')->with('success', trans('VNE-NEWS::language.messages.success.update'));
        } else {
            return redirect()->route('vne.news.news.manager')->with('error', trans('VNE-NEWS::language.messages.error.update'));
        }		
	}

	public function log(Request $request)
    {
        $model = 'news';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'news_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $logs = Activity::where([
                    ['log_name', $model],
                    ['subject_id', $request->input('news_id')]
                ])->get();
                return view('VNE-NEWS::modules.news.modal.modal_table', compact('error', 'model', 'confirm_route', 'logs'));
            } catch (GroupNotFoundException $e) {
                return view('VNE-NEWS::modules.news.modal.modal_table', compact('error', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }
    public function delete(Request $request)
    {
        $news_id = $request->news_id;
        $news = $this->news->find($news_id);
        if (null != $news) {
            $this->news->delete($news_id);
            Cache::forget('cache_api_news');
            Cache::forget('cache_news');

            NewsHasTagRepository::where('news_id', $news_id)->delete();
            NewsHasCatRepository::where('news_id', $news_id)->delete();
            NewsHasBoxRepository::where('news_id', $news_id)->delete();

            activity('news')
                ->performedOn($news)
                ->withProperties($request->all())
                ->log('User: :causer.email - Delete News Cat - news_id: :properties.news_id, name: ' . $news->name);
            return redirect()->route('vne.news.news.manager')->with('success', trans('VNE-NEWS::language.messages.success.delete'));
        } else {
            return redirect()->route('vne.news.news.manager')->with('error', trans('VNE-NEWS::language.messages.error.delete'));
        }
    }
    public function getModalDelete(Request $request)
    {
        $model = 'news';
        $type = 'delete';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'news_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $confirm_route = route('vne.news.news.delete', ['news_id' => $request->news_id]);
                return view('VNE-NEWS::modules.news.modal.modal_confirmation', compact('type','error', 'model', 'confirm_route'));
            } catch (GroupNotFoundException $e) {
                return view('VNE-NEWS::modules.news.modal.modal_confirmation', compact('type','error', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }
	//Table Data to index page
    public function data(Request $request)
    {
    	$params =[
    		'name'=>$request->name,
    		'news_time'=>$request->news_time,
    		'news_cat'=>$request->news_cat,
    		'is_hot'=> $request->is_hot
    	];
    	if($request->name!=null || $request->news_time!=null || $request->news_cat!=null || $request->is_hot!=null){
    		$list_news = $this->news->getListNews($params);
    	}
    	else{
    		$list_news = News::where('type_page','news')->get();	
    	}
        return Datatables::of($list_news)
            ->addIndexColumn()
            ->addColumn('actions', function ($list_news) {
                $actions = '';
                if ($this->user->canAccess('vne.news.news.log')) {
                    $actions .= '<a href=' . route('vne.news.news.log', ['type' => 'news', 'news_id' => $list_news->news_id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log news cat"></i></a>';
                }
                if ($this->user->canAccess('vne.news.news.show')) {
                    $actions .= '<a href=' . route('vne.news.news.show', ['news_id' => $list_news->news_id]) . '><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="update news cat"></i></a>';
                }
                if ($this->user->canAccess('vne.news.news.confirm-delete')) {
                    $actions .=  '<a href=' . route('vne.news.news.confirm-delete', ['news_id' => $list_news->news_id]) . ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete news cat"></i></a>';
                }
                return $actions;
            })
            ->addColumn('title', function ($list_news) {
            	if($list_news->is_hot==1){
            		$title = $list_news->title . '  (Tin hot)';
            	}
            	else{
            		$title = $list_news->title;	
            	}
            	return $title;
            })
            ->addColumn('image', function ($list_news) {
            	$image = '<img src="'.$list_news->image.'"  height="80" width="100">';
            	return $image;
            })
            ->addColumn('news_cat', function ($list_news) {
            	$list_cat_json = json_decode($list_news->news_cat,true);
            	$list_cat_array = array();
                if(!empty($list_cat_json)){
                    foreach ($list_cat_json as $key => $cat) {
                        $list_cat_array[] = $cat['name'];   
                    }
                	$news_cat = implode(",",$list_cat_array);
                }
            	return $news_cat;
            })
            ->rawColumns(['actions','is_hot','image'])
            ->make();
    }
    public function searchNews(){
    	$list_news_cat = $this->news_cat->all();
		return view('VNE-NEWS::modules.news.news.manager_search',compact('list_news_cat'));
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

    public function listNewsApi(Request $request) {
        $params = [
            'keyword' => $request->input('keyword'),
            'news_cat_id' => $request->input('news_cat_id'),
            'news_tag_id' => $request->input('news_tag_id')
        ];
        $list_news = $this->news->getListNewsApi($params);
        return $list_news;
    }


}