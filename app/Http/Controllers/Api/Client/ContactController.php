<?php

namespace App\Http\Controllers\Api\Client;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    //create contact 
    public function createContactFromCustomer(Request $request){
        $data = $request->validate([
            'name' => 'required|max:1000',
            'email' => 'required|email|string',
            'phone' => 'nullable|string|max:1000',
            'website' => 'nullable|string|max:1000',
            'description' => 'required|string'
        ]);
        Contact::create($data);
        return "Thank you for contact me!";
    }
}
