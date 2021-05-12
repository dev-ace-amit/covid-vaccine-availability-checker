<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Emails;

use Mail;

class SendEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify users when slot available';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $fetchrecord = Emails::where('email_sent',0)->distinct('pincode')->get();
        
        if($fetchrecord != '')
        {
            foreach ($fetchrecord as $k => $v) {
                $res = $this->checkAvailability($v->pincode,$v->date);
                $this->info($res);
                if($res == 1)
                {
                    //slots available for this pincode
                    $emailData = Emails::where('pincode',$v->pincode)->get();
                    foreach ($emailData as $a => $b) {
                        $user = [];
                        $user['email'] = $b->email;
                        $user['msg'] = 'Amit Prithyani';
                        $user['subject'] = 'Vaccine Slot Available For '.$b->pincode;
                        Mail::send('mails.email', ['user' => $user], function ($m) use ($user) {
                            $m->from('amit@acetechventures.in', $user['msg']);

                            $m->to($user['email'])->subject($user['subject']);
                        });
                        $updateEmailSent = Emails::where('id',$b->id)->update(['email_sent' => 1]);
                        $this->info('email sent to '.$b->email);
                    }
                }
            }
        }
    }

    public function checkAvailability($pincode,$date){
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://cdn-api.co-vin.in/api/v2/appointment/sessions/public/calendarByPin?pincode=".$pincode."&date=".$date,
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
            return 0;
        } else {
            $isAvailable = 0;
            if($response && json_decode($response)->centers != '')
            {
                foreach (json_decode($response)->centers as $key => $value) {
                    $this->info($value->sessions[0]->available_capacity);exit();
                    if($value->sessions[0]->available_capacity != 0)
                    {
                        $isAvailable = 1;
                    }
                }
            }

            return $isAvailable;
        }
    }
}
