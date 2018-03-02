<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;

class LoginController extends Controller
{
    //
    public function index(){
        return view('general.login');
    }

    public function login(Request $request){
        $this->validate($request,[
            'username'=>'required',
            'password'=>'required'
        ]);
        $username=$request->input('username');
        $password=$request->input('password');

        if (isset($username) && isset($password)){
            $user=User::where('username',$username)->first();
            if (empty($user)){
                $errors = new MessageBag(['username' => ['Account Not Found']]);
                return redirect()->back()->withErrors($errors);
            }
            if (Auth::attempt(['username'=>$username,'password'=>$password])){
                $user=Auth::user();
                if ($user->is_locked){
                    $suberror=['username' => 'This Account is Locked, contact IT Office'];
                    Auth::logout();
                    return redirect()->back()->withErrors($suberror);
                }else{

                        $user->password_attempt_count=0;
                        $user->password_attempt_date=null;
                        $user->is_login=true;
                        $user->user_ip=$request->getClientIp();
                        $user->save();

                        // role check

                            return redirect()->route('users.index');




                }
            }else{
                $now=strtotime(date(now()));
                $user_time=strtotime($user->password_attempt_date);

//             dd($now,$user_time,strtotime('+6 minutes',$user_time));
                if (session()->get('password_attempt_count')==5){
                    if ($now>=strtotime('+6 minutes',$user_time)){
                        $user->password_attempt_count=0;
                        $user->password_attempt_date=null;
                        $user->save();
                    }
                }


                $user->password_attempt_count++;
                if ($user->password_attempt_count==1){
                    $user->password_attempt_date=date(now());
                }

                if($user->password_attempt_count>=10){
                    $suberror=['username' => 'This Account is Locked, contact IT Office'];
                    $user->is_locked=true;
                }else if ($user->password_attempt_count==5){
                    $counts=$user->password_attempt_count;
                    $user->password_attempt_date=date(now());
                    session()->put('password_attempt_count',$counts);
                    $suberror=['username' => 'Wait For 7 minutes and try again or else after 10 incorrect tries Account will be locked'];
                }else if ($user->password_attempt_count>=6){
                    $user->password_attempt_date=date(now());
                    $suberror=['username' => 'Wait For 7 minutes and try again or else after 10 incorrect tries Account will be locked'];
                }else{
                    $suberror=['username' => 'Invalid Details'];
                }
                $user->save();


                return redirect()->back()
                    ->withInput($request->only('username', 'remember'))
                    ->withErrors($suberror);
            }
        }else{
            $errors = new MessageBag(['password' => ['password required'],'username'=>['Username required.']]);
            return redirect()->back()->withErrors($errors);
        }

    }

    public function logout(){

//        AuditTrails::create([
//            'user_id'=>\auth()->id(),'date_made'=>date(now()),'activity'=>\auth()->user()->email.' logged out of the system'
//        ]);
        $user=Auth::user();
//        dd($user);
        $user->is_login=false;
        $user->user_ip=null;
        $user->save();
        session()->flush();
        Auth::logout();
        return redirect()->route('login');
    }


    public function logout_all(Request $request){
        $this->validate($request,[
            'username'=>'required',
            'password'=>'required'
        ]);
        $username=$request->input('username');
        $password=$request->input('password');

        if (Auth::attempt(['username'=>$username,'password'=>$password])){
            $user=Auth::user();
            $user->is_login=false;
            $user->user_ip=null;
            $user->save();
            session()->flush();
            Auth::logout();
            return redirect()->route('login');
        }else{

        }

    }
}
