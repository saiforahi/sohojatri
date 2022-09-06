<?php

namespace App\Http\Controllers;

use App\Models\Validation;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Mail;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function phone_number($number)
    {
        if(preg_match("/^(?:\+88|01)?(?:\d{11}|\d{13})$/", $number)) {
            $length = strlen($number);
            if ($length === 11 && stripos($number, "+88") == false) return "+88" . $number;
            elseif ($length === 14 && stripos($number, "88") && preg_match('/^\+?\d+$/', $number)) return $number;
            else return false;
        }
        else return false;
    }

    public function sendOTP($destination, $destination_type, $verification_code, $user){
        try {
            if ($destination_type === 'email') {
            $subject = "Verify your email address.";
            $name = $user->first_name . ' ' . $user->last_name;
            Mail::send('email.verify', ['name' => $name, 'verification_code' => $verification_code],
                function ($mail) use ($destination, $subject) {
                    $mail->from("finecourier@gmail.com", "Durpalla");
                    $mail->to($destination)->subject($subject);
                });
            }

            if ($destination_type === 'phone') {
                $message = 'Please enter the following code ' . $verification_code . ' to verify your account.';
                $post_url = 'https://api.mobireach.com.bd/SendTextMessage';
                $post_values = array(
                    'Username' => config('mobireach.MOBIREACH_USER'),
                    'Password' => config('mobireach.MOBIREACH_PASS'),
                    'From' => config('mobireach.MOBIREACH_FROM'),
                    'To' => $destination,
                    'Message' => $message
                );

                $post_string = "";
                foreach ($post_values as $key => $value) {
                    $post_string .= "$key=" . urlencode($value) . "&";
                }
                $post_string = rtrim($post_string, "& ");

                $request = curl_init($post_url);
                curl_setopt($request, CURLOPT_HEADER, 0);
                curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($request, CURLOPT_POSTFIELDS, $post_string);
                curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE);
                $post_response = curl_exec($request);
                curl_close($request);
            }
        }catch (\Exception $e) {
            return redirect()->back()->withErrors([$e->getMessage()]);
        }
    }

    public function saveVerify($destination, $destination_type, $verification_code, $user)
    {
        $search = Validation::where('destination', $destination)->first();
        if ($search) $search->delete();

        $insert = new Validation();
        $insert->fk_user_id = $user->user_id;
        $insert->destination = $destination;
        $insert->code = $verification_code;
        $insert->validation_type = $destination_type;
        $insert->save();
    }

    public function checkOtpSent($account_details)
    {
        $response = 0;
        $nowDate = date('Y-m-d');
        $data = Validation::whereDate('updated_at', '=', $nowDate)
            ->where('destination', $account_details)->first();
        if (!empty($data)) {
            $nowDate = date('Y-m-d H:i:s');
            $date1 = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data->updated_at)->timestamp;
            $date2 = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $nowDate)->timestamp;
            $diff = $date2 - $date1;
            if ($diff < 3000) {
                $response = 1;
            }
        }
        return $response;
    }
}
