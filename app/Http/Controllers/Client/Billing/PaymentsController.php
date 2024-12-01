<?php

namespace App\Http\Controllers\Client\Billing;

use App\Http\Controllers\Controller;
use App\Models\Payments\PaymentsModel;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    
    public function payments(Request $request)
    {
        
        $query      = PaymentsModel::where('user_id', $request->user()->id);
        $sum        = $query->count('id');
        $contacts   = $query->paginate(100);

        return view('client.payments.list', compact('contacts', 'sum'));
    }

}
