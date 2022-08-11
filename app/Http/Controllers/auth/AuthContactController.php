<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Contact;
use App\Http\Resources\ContactResource;
use Illuminate\Support\Facades\Hash;
use App\Notifications\PasswordReset;
use Illuminate\Support\Facades\Notification;

class AuthContactController extends Controller
{
    public function changePassword(Request $request) {
        $this->validate($request,[
            'newPassword' => 'required',
            'confirmPassword' => 'required'
            ]);
        if($request->newPassword != $request->confirmPassword) {
            return response()->json([
                'status' => 406,
                'message' => 'Passwords do not match!'
            ]);   
        }   
        else { 
            $contact = Contact::find(Auth::contact()->id);
            $hashedPassword = $contact->password;
            if (!\Hash::check($request->newPassword , $hashedPassword)) {
                    $contact->password = bcrypt($request->newPassword);
                    Contact::where( 'id' , Auth::contact()->id)->update(array( 'password' =>  $contact->password));
                    return response()->json([
                    'status' => 200,
                    'contact' => new ContactResource($contact),
                    'message' => 'Password changed !'
                    ]);
            }
            else {
                return response()->json([
                    'status' => 406,
                    'message' => 'Same password, please enter a new password !'
                ]);
            }   
        }
    }

    public function reset(Request $request, $id) {
        $request->validate([
            'newPassword' => 'required',
            'confirmPassword' => 'required'
        ]);
        if ($request->newPassword != $request->confirmPassword) {
            return response()->json([
                'status' => 406,
                'message' => 'Same password, please enter a new password !'
            ]);
        }
        else {
            $contact = Contact::where('id', $id)->first(); 
            $contact->password = bcrypt($request->newPassword);
            Contact::where( 'id' , $contact->id)->update( array( 'password' =>  $contact->password));
            return response()->json([
                'status' => 200,
                'message' => 'Password changed !'
            ]);
        }
    }
}
