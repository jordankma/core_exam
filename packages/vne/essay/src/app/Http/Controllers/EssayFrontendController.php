<?php

namespace Vne\Essay\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\MController as Controller;

use Vne\Essay\App\Repositories\EssayRepository;
use Vne\Essay\App\Models\Essay;

use Vne\Essay\App\Models\EssayTopic;

use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator,Storage,Auth;

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
        $this->_guard = Auth::guard('member');
    }

    public function show(Request $request)
    {
        $data_file = file_get_contents('https://drive.google.com/file/d/1B8AwYmZQFw_Xl6YW5eFaV-s9SR_QOy0c/preview');

        // dd($data);
        $member_id = $this->_guard->user()->member_id;
        if(self::checkOnlySubmitEssay($member_id)){
            return redirect()->route('index');
        }

        $name = $note = $flag = $message = '' ;
        $data = [
            'name' => !empty($request->input('name')) ? $request->input('name') : '',
            'note' => !empty($request->input('note')) ? $request->input('note') : '',
            'flag' => $flag,
            'message' => $message,
            'data_file' => $data_file
        ];
        return view('VNE-ESSAY::modules.essay.frontend.show',$data);
    }
    public function save(Request $request)
    {
        $member_id = $this->_guard->user()->member_id;

        if(self::checkOnlySubmitEssay($member_id)){
            return redirect()->route('index');
        }

        $flag = '';
        $name = $request->input('name');
        $alias_name = self::to_slug($name) .'-'. $member_id .'-'. time();
        $note = $request->input('note');
        $image = $path_local = '';
        $messages = "File không đúng định dạng";
        $folder_upload_essay = "uploads/essay/essay";
        $folder_upload_essay_icon = "uploads/essay/icon";
        //file upload
        $file_to_upload = $request->file('fileToUpload');
        $file_name = $file_to_upload->getClientOriginalName();
        $file_tmp = explode('.', $file_name);
        $file_extension = end($file_tmp);
        $file_name_full = $alias_name .'.'. $file_extension;
        if($file_extension != 'pdf' && $file_extension != 'docx' && $file_extension != 'pptx' && $file_extension != 'txt'){
            return redirect()->route('vne.essay.essay.create',$data)->with('error', 'Sai định dạng file tải lên');   
        }
        $path_local = $folder_upload_essay . '/' . $file_name_full;
        //icon upload
        if($request->has('image')){
            $icon_to_upload = $request->file('image');
            $icon_name = $icon_to_upload->getClientOriginalName();
            $icon_tmp = explode('.', $icon_name);
            $icon_extension = end($icon_tmp);
            $icon_name_full = $alias_name .'.'. $icon_extension;
            if($icon_extension != 'png' && $icon_extension != 'jpg'){
                return redirect()->route('vne.essay.essay.create',$data)->with('error', 'Sai định dạng file ảnh tải lên');   
            }
            $image = $folder_upload_essay_icon . '/' . $icon_name_full;
        }
        
        if(Storage::disk('google')->put($alias_name .'.'. $file_extension, file_get_contents($file_to_upload))){
            $file_to_upload->move($folder_upload_essay, $file_name_full);
            if($request->has('image')){
                $icon_to_upload->move($folder_upload_essay_icon, $icon_name_full);
            }
            //get info file from gg drive 
            $dir = '/';
            $recursive = false;
            $contents = collect(Storage::disk('google')->listContents($dir, $recursive));
            $file = $contents
                ->where('type', '=', 'file')
                ->where('filename', '=', pathinfo($file_name_full, PATHINFO_FILENAME))
                ->where('extension', '=', pathinfo($file_name_full, PATHINFO_EXTENSION))
                ->first();
            $essay = new Essay();
            $essay->name = $name;
            //info from gg drive
            $essay->type = $file['type'];
            $essay->path = $file['path'];
            $essay->filename = $file['filename'];
            $essay->extension = $file['extension'];
            $essay->timestamp = $file['timestamp'];
            $essay->mimetype = $file['mimetype'];
            $essay->dirname = $file['dirname'];
            $essay->basename = $file['basename'];
            //
            $essay->member_id = $member_id;
            $essay->note = $note;
            $essay->path_local = $path_local;
            $essay->image = $image;
            if ($essay->save()) {
                $flag = 1;
                $message = 'Gửi bài thi thành công';
            } else {
                $flag = 2;
                $message = 'Gửi bài thất bại mời bạn kiểm tra thông tin bên dưới';
            }
        } else{
            $flag = 2;
            $message = 'Gửi bài thất bại mời bạn kiểm tra thông tin bên dưới';
        }
        $data = [
            'flag' => $flag,
            'name' => $name,
            'note' => $note,
            'message' => $message
        ];
        return view('VNE-ESSAY::modules.essay.frontend.show',$data);
    }

    public function list(Request $request){
        $params = [
            'u_name' => $request->has('u_name') ? $request->input('u_name') : '',
            'member_name' => $request->has('member_name') ? $request->input('member_name') : '',
            'name' => $request->has('name') ? $request->input('name') : '',
            'table_id' => $request->has('table_id') ? $request->input('table_id') : '',
        ];
        $list_essay = $this->essay->search($params);
        $data = [
            'list_essay' => $list_essay,
            'params' => $params
        ];
        return view('VNE-ESSAY::modules.essay.frontend.list',$data);
    }
    public function detail(Request $request){

        $essay = Essay::find($request->input('essay_id'));
        $file = $essay->path_local;
        $file_content = file_get_contents($file);
        $data = [
            'essay' => $essay,
            'file' => $file,
            'file_content' => $file_content
        ];
        return view('VNE-ESSAY::modules.essay.frontend.detail',$data);
    }
    function checkOnlySubmitEssay($member_id){
        $essay = Essay::where('member_id', $member_id)->first();
        if($essay){
            return false;
        }
    }

}
