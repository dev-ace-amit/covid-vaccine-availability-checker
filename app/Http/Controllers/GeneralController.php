<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Emails;

use Mail;

class GeneralController extends Controller
{
    public function sendEmail(Request $request){

    	$fetchrecord = Emails::where('email_sent',0)->get();

    	if($fetchrecord != '')
    	{
    		foreach ($fetchrecord as $k => $v) {
    			$user = [];
		    	$user['email'] = $v->email;
		    	$user['msg'] = 'Amit Prithyani';
		    	$user['subject'] = 'Vaccine Slot Available For '.$v->pincode;
		    	Mail::send('mails.email', ['user' => $user], function ($m) use ($user) {
		            $m->from('amit@acetechventures.in', $user['msg']);

		            $m->to($user['email'])->subject($user['subject']);
		        });

		        $updateEmailSent = Emails::where('id',$v->id)->update(['email_sent' => 1]);
    		}
    	}
        
        return response()->json(
                [
                    'status' => 'success'
                ], 200);
    }

    public function makeRequest(Request $request) 
    {
    	
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://cdn-api.co-vin.in/api/v2/appointment/sessions/public/calendarByPin?pincode=".$request->data['pincode']."&date=".$request->data['date'],
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_HTTPHEADER => array(
		    "cache-control: no-cache",
		    "postman-token: 00d3a4c7-1285-f961-706e-c46cb0d32bc6"
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
		  echo $response;
		}
    }

    public function saveEmailToNotify(Request $request){
    	$checkIfExists = Emails::where(['email' => $request->data['email'], 'pincode' => $request->data['pincode']])->first();

    	if(empty($checkIfExists))
    	{
    		$addRecord = new Emails();
	        $addRecord->email = $request->data['email'];
	        $addRecord->pincode = $request->data['pincode'];
	        $addRecord->date = $request->data['date'];
	        $addRecord->save();
	        return response()->json(
                [
                    'status' => 'success'
                ], 200);
    	}
    	else
    	{
    		return response()->json(
                [
                    'status' => 'already_exists'
                ], 200);
    	}
	 	

        
    }
}
