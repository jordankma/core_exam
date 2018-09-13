<?php

namespace Vne\Contactfrontend\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\MController as Controller;

use Vne\Contact\App\Models\Contact;

use Vne\Contact\App\Repositories\ContactRepository;

use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator;

class ContactfrontendController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );

    public function __construct(ContactRepository $contactRepository)
    {
        parent::__construct();
        $this->contact = $contactRepository;
    }

    public function contact()
    {
        return view('VNE-CONTACTFRONTEND::modules.contactfrontend.detail');
    }

    public function addContact(Request $request)
    {  
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'content' => 'required'
        ], $this->messages);
        if (!$validator->fails()) {
            $contact = new Contact();
            $contact->name = $request->input('name');       
            $contact->email = $request->input('email');       
            $contact->content = $request->input('content');   
            if($contact->save()){
                return view('VNE-CONTACTFRONTEND::modules.contactfrontend.detail')->with('success', trans('vne-contactfrontend::language.messages.success.create'));    
            } else{
                return view('VNE-CONTACTFRONTEND::modules.contactfrontend.detail')->with('error', trans('vne-contactfrontend::language.messages.error.create'));      
            }
        } else {
            return view('VNE-CONTACTFRONTEND::modules.contactfrontend.detail')->with('error', trans('vne-contactfrontend::language.messages.error.create'));
        }
    }
}
