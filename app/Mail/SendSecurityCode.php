<?php
declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendSecurityCode extends Mailable
{
    use Queueable, SerializesModels;

    private string $code;

    public function __construct(string $code)
    {
        $this->code = $code;
    }

    public function build()
    {
        return $this->subject('Security code')->view('mail.security-code', [
            'code' => $this->code
        ]);
    }
}
