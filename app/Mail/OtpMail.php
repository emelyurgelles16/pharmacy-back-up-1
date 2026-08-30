<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Setting;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $code;
    public $username;
    public $pharmacyName;
    public $pharmacyAddress;
    public $pharmacyContact;
    public $pharmacyEmail;
    public $pharmacyLogo;

    public function __construct($code, $username)
    {
        $this->code = $code;
        $this->username = $username;
        
        $this->pharmacyName = Setting::get('pharmacy_name', 'AER Pharmacy');
        $this->pharmacyAddress = Setting::get('pharmacy_address', '');
        $this->pharmacyContact = Setting::get('pharmacy_contact', '');
        $this->pharmacyEmail = Setting::get('pharmacy_email', env('MAIL_FROM_ADDRESS', 'emelyurgelles16@gmail.com'));
        $this->pharmacyLogo = Setting::get('pharmacy_logo', '');
    }

    public function build()
    {
        return $this->from($this->pharmacyEmail, $this->pharmacyName)
                    ->subject('OTP Verification - ' . $this->pharmacyName)
                    ->view('email.otp')
                    ->with([
                        'code' => $this->code,
                        'username' => $this->username,
                        'pharmacyName' => $this->pharmacyName,
                        'pharmacyAddress' => $this->pharmacyAddress,
                        'pharmacyContact' => $this->pharmacyContact,
                        'pharmacyLogo' => $this->pharmacyLogo,
                    ]);
    }
}