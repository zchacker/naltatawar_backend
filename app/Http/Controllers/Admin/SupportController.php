<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Support\SupportModel;
use App\Models\Support\SupportReplayModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SupportController extends Controller
{
    
    public function list(Request $request)
    {
        
        $query      = SupportModel::query();
        $sum        = $query->count('id');
        $items      = $query->paginate(100);

        return view('admin.support.list', compact('items', 'sum'));
    }


    public function create(Request $request)
    {
        return view('admin.support.create');
    }

    public function create_action(Request $request)
    {
        $support                = new SupportModel();
        $support->customer_id   = $request->user()->id;
        $support->title         = $request->title;
        $support->message       = $request->message;
        $support->status        = 1;
        $result                 = $support->save();

        if($result)
        {
            
            return back()->with(['success' => __('added_successfuly')]);

        }else{

            return back()
            ->withErrors(['error' => __('faild_to_save')])
            ->withInput($request->all());

        }
    }

    public function update(Request $request)
    {
        $support = SupportModel::where('id' , $request->id)->first();        

        if($support == NULL)
        {
            return abort(Response::HTTP_NOT_FOUND);
        }
        
        return view('admin.support.replay' , compact('support'));
    }

    public function update_action(Request $request)
    {
        $replay                = new SupportReplayModel();
        $replay->ticket_id     = $request->id;
        $replay->sender_id     = $request->user()->id;       
        $replay->message       = $request->message;       
        $result                = $replay->save();

        if($result)
        {
            
            return back()->with(['success' => __('added_successfuly')]);

        }else{

            return back()
            ->withErrors(['error' => __('faild_to_save')])
            ->withInput($request->all());

        }
    }
    
}
