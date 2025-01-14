<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client\ContactRequestsModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use PhpParser\Node\Expr\FuncCall;

class ContactRequestController extends Controller
{
    public function home(Request $request)
    {

        $query      = ContactRequestsModel::query();
        $sum        = $query->count('id');
        $contacts   = $query->paginate(100);

        return view('admin.contacts.list', compact('contacts'));
    }

    public function details(Request $request)
    {
        $data = ContactRequestsModel::where('id' , $request->id)->first();

        if($data === null)
        {
            return abort(Response::HTTP_NOT_FOUND);
        }
        return view('admin.contacts.details', compact('data'));
    }
        
}
