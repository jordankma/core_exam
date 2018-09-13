<?php

namespace Vne\Newsfrontend\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\MController as Controller;

use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Vne\News\App\Models\News;

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

    public function list(Request $request){
        $list_news = $this->news->paginate(10);   
        $data = [
            'list_news' => $list_news     
        ];
        return view('VNE-NEWSFRONTEND::modules.newsfrontend.list',$data);                  
    }

    public function detail(Request $request,$alias,$news_id){
        $news = $this->news->find($news_id);  
        $data = [
            'news' => $news     
        ];
        return view('VNE-NEWSFRONTEND::modules.newsfrontend.detail',$data);                  
    }
    
}
