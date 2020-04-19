<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Http\Resources\ContactResource;
use Illuminate\Http\Request;

class BirthdaysController extends Controller
{
    public function index(){

        $contacts = request()->user()->contacts()->birthdays()->get();
        return ContactResource::collection($contacts) ;
    }
}
