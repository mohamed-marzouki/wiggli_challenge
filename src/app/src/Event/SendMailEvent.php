<?php
namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

class SendMailEvent extends Event
{
    public function __construct()
    {
        echo 'Send Mail Evnet ';
    }
}