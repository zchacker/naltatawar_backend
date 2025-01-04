<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Client\ContactRequestsModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ContactRequestController extends Controller
{
    
    public function home(Request $request)
    {

        $query      = ContactRequestsModel::whereIn('user_id' , [ $request->user()->id , $request->user()->parent()->id ] );
        $sum        = $query->count('id');
        $contacts   = $query->paginate(100);

        return view('agent.contacts.list', compact('contacts'));
    }

    public function details(Request $request)
    {
        $data = ContactRequestsModel::where('id' , $request->id)->first();

        if($data === null)
        {
            return abort(Response::HTTP_NOT_FOUND);
        }
        return view('agent.contacts.details', compact('data'));
    }

}
