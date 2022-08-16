<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Contact;
use App\Http\Resources\ContactResource;
use App\Models\Staff;
use App\Models\cgpi;
use App\Http\Resources\StaffResource;
use App\Http\Resources\CgpiResource;
use Illuminate\Support\Facades\Hash;
use App\Notifications\PasswordReset;
use Illuminate\Support\Facades\Notification;

class AuthController extends Controller
{
    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $staff = Staff::where('email', $request->email)->first();
        if (!$staff || !Hash::check($request->password, $staff->password)) {
            $contact = Contact::where('email', $request->email)->first();
            if (!$contact || !Hash::check($request->password, $contact->password)) 
            {
                $cgpi= cgpi::where('email', $request->email)->first();
                if(!$cgpi || !Hash::check($request->password, $cgpi->password)){
                    return response()->json([
                        'status' => 401,
                        'message' => 'The provided credentials are incorrect.'
                        
                    ]);

                } 
                else
                {
                    return response()->json([
                        'status' => 200,
                        'cgpi' => new CgpiResource($cgpi),
                        'token' => $cgpi->createToken('Weaplan', ['role:cgpi'])->plainTextToken
                    ]);
                }
                
            }
            else {
                return response()->json([
                    'status' => 200,
                    'contact' => new ContactResource($contact),
                    'token' => $contact->createToken('Weaplan', ['role:contact'])->plainTextToken
                ]);
            }
           
        }
        else {
            if($staff->role == 'admin') {
                return response()->json([
                    'status' => 200,
                    'staff' => new StaffResource($staff),
                    'token' => $staff->createToken('Weaplan', ['role:admin'])->plainTextToken
                ]);
            }
            else {
                return response()->json([
                    'status' => 200,
                    'staff' => new StaffResource($staff),
                    'token' => $staff->createToken('Weaplan', ['role:staff'])->plainTextToken
                ]);
            }
             
        }
    }

    public function resetNotif(Request $request) {
        $request->validate([
            'email' => 'required'
        ]);
        $staff = Staff::where('email', $request->email)->first();
        if (!$staff) {
            $contact = Contact::where('email', $request->email)->first();
            $cgpi = Cgpi::where('email', $request->email)->first();
            if($contact) {
                $details = [
                    'greeting' => 'Hi '.$contact->name,
                    'body' => 'Follow this link to reset your account password !',
                    'url' => 'http://127.0.0.1:8000/clientpassReset/'.$contact->id,
                    'thanks' => 'Thank you for using our CRM !',
                ];
                Notification::send($cgpi, new PasswordReset($details));
                return response()->json([
                    'status' => 200,
                    'message' => 'Email sent !'
                ]);
            }
            else if($cgpi) {
                $details = [
                    'greeting' => 'Hi '.$cgpi->name,
                    'body' => 'Follow this link to reset your account password !',
                    'url' => 'http://127.0.0.1:8000/clientpassReset/'.$cgpi->id,
                    'thanks' => 'Thank you for using our CRM !',
                ];
                Notification::send($cgpi, new PasswordReset($details));
                return response()->json([
                    'status' => 200,
                    'message' => 'Email sent !'
                ]);
            }
            else {
                return response()->json([
                    'status' => 404,
                    'message' => 'user not found !'
                ]);
            }
        }
        else {
            if($staff->role == 'admin') {
                return response()->json([
                    'status' => 403,
                    'message' => 'Admin Privileges'
                ]);
            }
            else {
                $details = [
                    'greeting' => 'Hi '.$staff->name,
                    'body' => 'Follow this link to reset your account password !',
                    'url' => 'http://127.0.0.1:8000/staffpassReset/'.$staff->id,
                    'thanks' => 'Thank you for using our CRM !',
                ];
                Notification::send($staff, new PasswordReset($details));
                return response()->json([
                    'status' => 200,
                    'message' => 'Email sent !'
                ]);
            }   
        }
    }

    public function logout (Request $request) {
        auth()->user()->tokens()->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Logged out !'
        ]);
    }
}
