<?php

namespace Contest\Contestmanage\App\Http\Controllers;

use Contest\Contestmanage\App\Repositories\ContestRoundRepository;
use Contest\Contestmanage\App\Repositories\ContestSeasonRepository;
use Contest\Contestmanage\App\Repositories\ContestTopicRepository;
use Contest\Contestmanage\App\Repositories\TopicRoundRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Illuminate\Support\Facades\Schema;
use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator;

class ApiController extends Controller
{
    public function __construct(ContestSeasonRepository $seasonRepository, ContestRoundRepository $roundRepository, ContestTopicRepository $topicRepository, TopicRoundRepository $topicRoundRepository)
    {
        parent::__construct();
        $this->season = $seasonRepository;
        $this->round = $roundRepository;
        $this->topic = $topicRepository;
        $this->topic_round = $topicRoundRepository;
    }

    public function getListData(Request $request)
    {
        $data_view = [
            'type' => $request->type,
            'title' => ''
        ];
        $html = view('CONTEST-CONTESTMANAGE::modules.contestmanage.includes.get_list_data', $data_view)->render();
        return response()->json($html);
    }

    //Table Data to index page
    public function data(Request $request)
    {
        if(!empty($request->type)){
            switch ($request->type){
                case 'season':
                    return Datatables::of($this->season->findAll())
                        ->addColumn('actions', function ($season) {
                            $actions = '<a href="javascript:void(0)" c-data="'.$season->name.'" data-value="'.$season->season_id.'" class="season_choose"><i class="livicon" data-name="plus" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="chọn"></i></a>';
                            return $actions;
                        })
                        ->rawColumns(['actions'])
                        ->make();
                    break;
                case 'round':
                    return Datatables::of($this->round->findAll())
                        ->addColumn('actions', function ($round) {
                            $actions = '<a href="javascript:void(0)" c-data="'.$round->display_name.'" data-value="'.$round->round_id.'" class="round_choose"><i class="livicon" data-name="plus" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="chọn"></i></a>';
                            return $actions;
                        })
                        ->rawColumns(['actions'])
                        ->make();
                    break;
                case 'topic':
                    return Datatables::of($this->topic->findAll())
                        ->addColumn('actions', function ($topic) {
                            $actions = '<a href="javascript:void(0)" c-data="'.$topic->display_name.'" data-value="'.$topic->topic_id.'" class="topic_choose"><i class="livicon" data-name="plus" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="chọn"></i></a>';
                            return $actions;
                        })
                        ->rawColumns(['actions'])
                        ->make();
                    break;
                case 'topic_round':
                    return Datatables::of($this->topic_round->findAll())
                        ->addColumn('actions', function ($topic_round) {
                            $actions = '<a href="javascript:void(0)" c-data="'.$topic_round->display_name.'" data-value="'.$topic_round->topic_round_id.'" class="choose"><i class="livicon" data-name="plus" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="chọn"></i></a>';
                            return $actions;
                        })
                        ->rawColumns(['actions'])
                        ->make();
                    break;

            }
        }

    }


}