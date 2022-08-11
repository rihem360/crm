<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Staff;
use App\Http\Resources\StaffResource;
use Illuminate\Support\Facades\Hash;
use App\Notifications\PasswordReset;
use Illuminate\Support\Facades\Notification;

class AuthStaffController extends Controller
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
            $staff = staff::find(Auth::staff()->id);
            $hashedPassword = $staff->password;
            if (!\Hash::check($request->newPassword , $hashedPassword)) {
                    $staff->password = bcrypt($request->newPassword);
                    Staff::where( 'id' , Auth::staff()->id)->update(array( 'password' =>  $staff->password));
                    return response()->json([
                    'status' => 200,
                    'staff' => $staff,
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
            $staff = staff::where('id', $id)->first(); 
            $staff->password = bcrypt($request->newPassword);
            Staff::where( 'id' , $staff->id)->update( array( 'password' =>  $staff->password));
            return response()->json([
                'status' => 200,
                'message' => 'Password changed !'
            ]);
        }
    }

}
