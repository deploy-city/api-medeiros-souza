<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailsController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();
        $to = "dev5@cityconnect.com.br";
        $name = $data["name"];
        $from = $data["from"];
        $subject = $data["subject"];
        $text = $data["text"];

        Mail::to($to)->send(new ContactMail($from, $name, $subject, $text));

        return response(null, 202);
    }
}
