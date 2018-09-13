<?php

namespace Vne\News\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Illuminate\Support\Collection;

use Vne\News\App\Http\Requests\NewsRequest;

use Vne\News\App\Repositories\NewsRepository;

use Vne\News\App\Models\News;

use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator;
use Auth;
use DateTime;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class PageController extends Controller
{	
	protected $_newsCatList;
	private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );

	public function __construct(NewsRepository $newsRepository)
    {
        parent::__construct();
        $this->news = $newsRepository;
        $this->_user = Auth::user();
    }
	/**
     * @return view list news
     * @author: tuanlv
     * @params: 
     * Chức năng : get list news
     */
	public function manager(Request $request){
		return view('VNE-NEWS::modules.news.page.manage');
	}
	public function create(){
		return view('VNE-NEWS::modules.news.page.create');
	}
	public function add(NewsRequest $request){
		$create_by = $this->user->email;
		$title = $request->input('title');
		$content = $request->input('content');
		$type_page = 'page';

		$news = new News();
		$news->create_by = $create_by;
		$news->title = $title;
		$news->title_alias = strtolower(preg_replace('([^a-zA-Z0-9])', '', self::stripUnicode($title)));

		$news->type_page = $type_page;
		$news->content = $content;
		$news->created_at = new DateTime();
		$news->updated_at = new DateTime();
		
		if ($news->save()) {
            Cache::forget('cache_api_news');
            Cache::forget('cache_news');
            activity('news')
                ->performedOn($news)
                ->withProperties($request->all())
                ->log('User: :causer.email - Add page - name: :properties.name, news_id: ' . $news->news_id);
            return redirect()->route('vne.news.page.manager')->with('success', trans('VNE-NEWS::language.messages.success.create'));
        } else {
            return redirect()->route('vne.news.page.manager')->with('error', trans('VNE-NEWS::language.messages.error.create'));
        }
	}

	public function show(Request $request){
		$news_id = $request->news_id;
		$news = $this->news->find($news_id);

		$data = [
			'news' => $news     
        ];
		return view('VNE-NEWS::modules.news.page.edit',$data);
	}	
	public function update(Request $request){
		$news_id = $request->input('news_id');
		$title = $request->input('title');
		$content = $request->input('content');
        $type_page = 'page';

		$news = $this->news->find($news_id);
		$news->title = $title;
		$news->title_alias = strtolower(preg_replace('([^a-zA-Z0-9])', '', self::stripUnicode($title)));
		$news->type_page = $type_page;
		$news->content = $content;

		if ($news->save()) {
            Cache::forget('cache_api_news');
            Cache::forget('cache_news');
            activity('news')
                ->performedOn($news)
                ->withProperties($request->all())
                ->log('User: :causer.email - Edit page - name: :properties.name, news_id: ' . $news->news_id);
            return redirect()->route('vne.news.page.manager')->with('success', trans('VNE-NEWS::language.messages.success.update'));
        } else {
            return redirect()->route('vne.news.page.manager')->with('error', trans('VNE-NEWS::language.messages.error.update'));
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
		$list_news = News::where('type_page','page')->get();	
        return Datatables::of($list_news)
        	->addIndexColumn()
            ->addColumn('actions', function ($list_news) {
                $actions = '';
                if ($this->user->canAccess('vne.news.page.log')) {
                    $actions .= '<a href=' . route('vne.news.page.log', ['type' => 'page', 'news_id' => $list_news->news_id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log page"></i></a>';
                }
                if ($this->user->canAccess('vne.news.page.show')) {
                    $actions .= '<a href=' . route('vne.news.page.show', ['news_id' => $list_news->news_id]) . '><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="update page"></i></a>';
                }
                if ($this->user->canAccess('vne.news.page.confirm-delete')) {
                    $actions .=  '<a href=' . route('vne.news.page.confirm-delete', ['news_id' => $list_news->news_id]) . ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete page"></i></a>';
                }
                return $actions;
            })
            ->rawColumns(['actions'])
            ->make();
    }

}