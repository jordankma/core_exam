<?php

namespace Vne\Newsfrontend\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\MController as Controller;

use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Vne\News\App\Models\News;
use Vne\News\App\Models\NewsBox;

use Vne\News\App\Repositories\NewsRepository;

use Validator,Auth,Config;

class NewsfrontendController extends Controller
{
    public function __construct( NewsRepository $newsRepository)
    {
        parent::__construct();
        $this->news = $newsRepository;
        $this->_user = Auth::user();
    }

    public function list(Request $request,$alias  = null){
        if($alias==null){
            $list_news = News::orderBy('news_id', 'desc')->paginate(10);  
        } else {
            $list_news = $this->news->getNewsByCate($alias,10);    
        }
        $data = [
            'list_news' => $list_news     
        ];
        return view('VNE-NEWSFRONTEND::modules.newsfrontend.list',$data);                  
    }

    public function listBox(Request $request,$alias  = null){
        $list_news = $this->news->getNewsByBox($alias,10);
        $news_box = NewsBox::where('alias',$alias)->first();
        $data = [
            'list_news' => $list_news,
            'title'=> $news_box->name     
        ];
        return view('VNE-NEWSFRONTEND::modules.newsfrontend.list',$data);                  
    }

    public function detail(Request $request,$alias){
        $news = News::where('title_alias',$alias)->first();  
        $data = [
            'news' => $news     
        ];
        return view('VNE-NEWSFRONTEND::modules.newsfrontend.detail',$data);                  
    }
    
}
