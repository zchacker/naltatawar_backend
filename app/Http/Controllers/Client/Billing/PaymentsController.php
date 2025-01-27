<?php

namespace App\Http\Controllers\Client\Billing;

use App\Http\Controllers\Controller;
use App\Models\Payments\CardsTokensModel;
use App\Models\Payments\PaymentsModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
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

    public function list_cards(Request $request)
    {
        $query      = CardsTokensModel::where(['user_id' => $request->user()->id]);
        $sum        = $query->count('id');
        $cards      = $query->paginate(100);
        
        return view('client.payments.card', compact('cards', 'sum'));
    }


    public function delete(CardsTokensModel $card)
    {
        $card->delete();
        
        return redirect()->route('client.card.list');
    }

    public function add_card(Request $request)
    {
        return view( 'client.payments.save_card' );
    }

    public function save_card_callback(Request $request)
    {
        
        $response = Http::withBasicAuth(env("PAYMENT_SECRET_KEY"), '')
        ->get('https://api.moyasar.com/v1/payments/' . $_GET['id']);
        
        $data = $response->json();

        // Check response status and data
        if ($response->successful()) {
                      
            //dd($data);

            if($data['status'] == 'verified')
            {

                // save card token
                $card_token              = new CardsTokensModel();
                $card_token->user_id     = $request->user()->id;
                $card_token->card_token  = $data['source']['token'];
                $card_token->card_digits = $data['source']['number'];
                $card_token->company     = $data['source']['company'];
                
                $card_token->save(); // save card token
    
                return redirect()
                ->route('client.card.list')
                ->with(['success' => __('card_saved_successfully')]);

            }else{

                return redirect()
                ->route('client.card.add')
                ->withErrors(['error' => __('card_not_saved_error') . ' <br/>' . $data['source']['message'] ]);

            }

        }else{

            return redirect()
            ->route('client.card.add')
            ->withErrors(['error' => __('card_not_saved_error') . ' <br/>' . $data['message'] ]);
            //->withInput($request->all());

        }

    }

}
