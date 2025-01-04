<?php

namespace App\Http\Controllers\Client\Billing;

use App\Http\Controllers\Controller;
use App\Models\Payments\PaymentsModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Salla\ZATCA\GenerateQrCode;
use Salla\ZATCA\Tags\InvoiceDate;
use Salla\ZATCA\Tags\InvoiceTaxAmount;
use Salla\ZATCA\Tags\InvoiceTotalAmount;
use Salla\ZATCA\Tags\Seller;
use Salla\ZATCA\Tags\TaxNumber;

class PaymentsController extends Controller
{
    
    public function payments(Request $request)
    {
        
        $query      = PaymentsModel::where(['user_id' => $request->user()->id , 'status' => 'paid']);
        $sum        = $query->count('id');
        $contacts   = $query->paginate(100);
        
        return view('client.payments.list', compact('contacts', 'sum'));
    }


    // find more info at
    // https://github.com/SallaApp/ZATCA
    public function invoice(Request $request)
    {
        $payment_data = PaymentsModel::where(['user_id' =>  $request->user()->id , 'id' => $request->id ])->first();

        if( $payment_data == NULL)
        {
            return abort(Response::HTTP_NOT_FOUND);
        }
        
        $dateString     = $payment_data->created_at;// '2024-11-26 22:35:31';
        $formattedDate  = Carbon::parse($dateString)->format('F j, Y');
        $isoDataFormat  = Carbon::parse($dateString)->format('Y-m-d\TH:i:s\Z');
        
        // Render A QR Code Image
        // data:image/png;base64, .........
        $displayQRCodeAsBase64 = GenerateQrCode::fromArray([
            new Seller(env('COMPANY_NAME')), // seller name        
            new TaxNumber(env('COMPANY_TaxNumber')), // seller tax number
            new InvoiceDate($isoDataFormat), // invoice date as Zulu ISO8601 @see https://en.wikipedia.org/wiki/ISO_8601
            new InvoiceTotalAmount($payment_data->amount ), // invoice total amount
            new InvoiceTaxAmount($payment_data->amount * 0.15) // invoice tax amount
            // .......
        ])->render();

        // now you can inject the output to src of html img tag :)
        // <img src="$displayQRCodeAsBase64" alt="QR Code" />

        return view('client.payments.invoice' , compact('formattedDate' , 'payment_data' , 'displayQRCodeAsBase64'));
    }

}
