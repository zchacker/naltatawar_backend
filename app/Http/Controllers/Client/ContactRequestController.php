<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client\ContactRequestsModel;
use App\Models\Property\PropertyModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class ContactRequestController extends Controller
{
    public function home(Request $request)
    {

        $query      = ContactRequestsModel::where('user_id' , $request->user()->id);
        $sum        = $query->count('id');
        $contacts   = $query->paginate(100);

        return view('client.contacts.list', compact('contacts'));
    }

    public function details(Request $request)
    {
        $data = ContactRequestsModel::where('id' , $request->id)->first();

        if($data === null)
        {
            return abort(Response::HTTP_NOT_FOUND);
        }
        return view('client.contacts.details', compact('data'));
    }

    public function save_contact(Request $request)
    {
        $json = json_decode($request->getContent());

        // Log the entire request body as JSON
        Log::info('Incoming Request Body: '. $request->getContent());
        
        // find user id from propery id
        $user = PropertyModel::where('property_number' , $request->item_id)->first();

        // save contact data
        if($user != null)
        {
            $user_id = $user->user_id;
            
            $contact                = new ContactRequestsModel();
            $contact->property_no   = $request->item_id;
            $contact->user_id       = $user_id;
            $contact->name          = $request->name;
            $contact->phone         = $request->phone;
            $contact->email         = $request->email;
            $contact->message       = $request->message;
            $contact->save();
        
        }else{

            $user_id = 0;
            
            $contact                = new ContactRequestsModel();
            $contact->property_no   = $request->item_id;
            $contact->user_id       = $user_id;
            $contact->name          = $request->name;
            $contact->phone         = $request->phone;
            $contact->email         = $request->email;
            $contact->message       = $request->message;
            $contact->save();

        }

        // this sample data back from wordpress
        /*
        {
            "name":"ahmed nagem",
            "phone":"053601031",
            "email":"ahmed@gmail.com",
            "message":"hello world",
            "item_id":"334",
            "Date":"13 يناير، 2025",
            "Time":"5:49 م",
            "Page_URL":"https://naltatawar.com/real-estate/%d8%b4%d9%82%d8%a9-%d9%84%d9%84%d8%a8%d9%8a%d8%b9-%d9%81%d9%8a-%d8%b4%d8%a7%d8%b1%d8%b9-%d8%a7%d8%a8%d9%88-%d8%a7%d9%84%d9%85%d8%b7%d8%b1%d9%81-%d8%a7%d9%84%d9%85%d8%ba%d8%b1%d8%a8%d9%8a/",
            "User_Agent":"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36",
            "Remote_IP":"2001:16a2:42a2:d700:ecb2:bbc3:1476:c1c8",
            "Powered_by":"Elementor",
            "form_id":"17ad420",
            "form_name":"contact form"
        } 
        */

        // Proceed with your logic
        return response()->json(['message' => 'Request logged successfully']);
    }

}
