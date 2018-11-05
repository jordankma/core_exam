<?php

namespace Vne\Essay\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\MController as Controller;

use Vne\Essay\App\Repositories\EssayRepository;
use Vne\Essay\App\Models\Essay;

use Vne\Essay\App\Models\EssayTopic;

use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator,Storage;

class EssayFrontendController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );

    public function __construct(EssayRepository $essayRepository)
    {
        parent::__construct();
        $this->essay = $essayRepository;
    }

    public function show()
    {
        $essay_topic = EssayTopic::all();
        $data = [
            'essay_topic' => $essay_topic
        ];
        return view('VNE-ESSAY::modules.essay.frontend.show',$data);
    }
}
