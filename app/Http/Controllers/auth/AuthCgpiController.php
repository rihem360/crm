<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cgpi;
use App\Http\Resources\CgpiResource;
use Illuminate\Support\Facades\Hash;
use App\Notifications\PasswordReset;
use Illuminate\Support\Facades\Notification;

class AuthCgpiController extends Controller
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
            $cgpi = Cgpi::find(Auth::cgpi()->id);
            $hashedPassword = $cgpi->password;
            if (!\Hash::check($request->newPassword , $hashedPassword)) {
                    $cgpi->password = bcrypt($request->newPassword);
                    staff::where( 'id' , Auth::staff()->id)->update(array( 'password' =>  $cgpi->password));
                    return response()->json([
                    'status' => 200,
                    'staff' => $cgpi,
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
            $cgpi = staff::where('id', $id)->first(); 
            $cgpi->password = bcrypt($request->newPassword);
            Cgpi::where( 'id' , $cgpi->id)->update( array( 'password' =>  $cgpi->password));
            return response()->json([
                'status' => 200,
                'message' => 'Password changed !'
            ]);
        }
    }

}
