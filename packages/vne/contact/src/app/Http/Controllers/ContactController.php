<?php

namespace Vne\Contact\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Vne\Contact\App\Repositories\ContactRepository;
use Vne\Contact\App\Models\Contact;
use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator;

class ContactController extends Controller
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


    public function manage()
    {
        return view('VNE-CONTACT::modules.contact.contact.manage');
    }

    public function getModalDelete(Request $request)
    {
        $model = 'contact';
        $type = 'delete';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'contact_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $confirm_route = route('vne.contact.contact.delete', ['contact_id' => $request->input('contact_id')]);
                return view('VNE-CONTACT::modules.contact.modal.modal_confirmation', compact('error', 'type', 'model', 'confirm_route'));
            } catch (GroupNotFoundException $e) {
                return view('VNE-CONTACT::modules.contact.modal.modal_confirmation', compact('error', 'type', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }
    
    public function delete(Request $request)
    {
        $contact_id = $request->input('contact_id');
        $contact = $this->contact->find($contact_id);

        if (null != $contact) {
            $this->contact->delete($contact_id);

            activity('contact')
                ->performedOn($contact)
                ->withProperties($request->all())
                ->log('User: :causer.email - Delete contact - contact_id: :properties.contact_id, name: ' . $contact->name);

            return redirect()->route('vne.contact.contact.manage')->with('success', trans('vne-contact::language.messages.success.delete'));
        } else {
            return redirect()->route('vne.contact.contact.manage')->with('error', trans('vne-contact::language.messages.error.delete'));
        }
    }

    public function log(Request $request)
    {
        $model = 'contact';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $logs = Activity::where([
                    ['log_name', $model],
                    ['subject_id', $request->input('id')]
                ])->get();
                return view('VNE-CONTACT::modules.contact.modal.modal_table', compact('error', 'model', 'confirm_route', 'logs'));
            } catch (GroupNotFoundException $e) {
                return view('VNE-CONTACT::modules.contact.modal.modal_table', compact('error', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }


    //Table Data to index page
    public function data()
    {
        $contacts = $this->contact->findAll();
        return Datatables::of($contacts)
            ->addColumn('actions', function ($contacts) {
                $actions = '';
                if ($this->user->canAccess('vne.contact.contact.log')) {
                    $actions .= '<a href=' . route('vne.contact.contact.log', ['type' => 'contact', 'id' => $contacts->contact_id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log contact"></i></a>';
                }
                if ($this->user->canAccess('vne.contact.contact.confirm-delete')) {
                    $actions .= '<a href=' . route('vne.contact.contact.confirm-delete', ['contact_id' => $contacts->contact_id]) . ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete contact"></i></a>';
                }
                return $actions;
            })
            ->addIndexColumn()
            ->rawColumns(['actions'])
            ->make();
    }
}
