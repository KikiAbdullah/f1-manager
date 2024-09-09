<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use DB;

class AppController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:edit_roles', ['only' => ['menuoptionroles']]);
    }

    public function index(Request $request)
    {
        $data['title'] = "Dashboard";
        $data['subtitle'] = "Hi, " . auth()->user()->name;
        return view('home')->with($data);
    }

    public function toggletheme()
    {
        $value = Cookie::get('nhTheme');
        if (empty($value)) {
            $lifetime = time() + 60 * 60 * 24 * 365;
            Cookie::queue('nhTheme', '1', $lifetime);
        } else {
            Cookie::queue(Cookie::forget('nhTheme'));
        }
        return back();
    }

    public function changepassword(Request $request)
    {
        if ($request->newpass <> "") {
            $model = User::where('id', auth()->user()->id)->where('password', md5($request->current))->get();
            if ($model->isNotEmpty()) {
                User::where('id', auth()->user()->id)->update(['password' => md5($request->newpass)]);
                return response()->json([
                    'status' => true,
                    'msg' => 'Password Saved Successfully',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'msg' => 'Current User & Password didn\'t match',
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'msg' => 'New Password can\'t empty.',
            ]);
        }
    }
}
