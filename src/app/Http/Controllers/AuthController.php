<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\ShopOwnerRequest;
use App\Http\Requests\AdminRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ShopOwner;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function create()
    {
        return view('login');
    }

    public function store(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('shop.index'); // お店一覧画面にリダイレクト
        }

        return back()->with('error', 'メールアドレスまたはパスワードが一致しません。')->withInput($request->only('email'));
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function createAdminRegister()
    {
        return view('admin.admin-register');
    }

    public function storeAdminRegister(AdminRequest $request)
    {
        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.login')->with('success', '管理者が登録されました。');
    }

    public function createAdminLogin()
    {
        return view('admin.admin-login');
    }

    public function storeAdminLogin(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard'); // 管理者ダッシュボードにリダイレクト
        }

        return back()->with('error', 'メールアドレスまたはパスワードが一致しません。')->withInput($request->only('email'));
    }

    public function createShopOwnerRegister()
    {
        return view('shopOwner.owner-register');
    }

    public function storeShopOwnerRegister(ShopOwnerRequest $request)
    {
        $shopOwner = ShopOwner::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'shop_id' => $request->shop_id,
        ]);

        return redirect()->route('admin.dashboard')->with('success', '店舗代表者が登録されました。');
    }

    public function createShopOwnerLogin()
    {
        return view('shopOwner.owner-login');
    }

    public function storeShopOwnerLogin(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('shop_owner')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('shopOwner.dashboard'); // 店舗情報管理画面にリダイレクト
        }

        return back()->with('error', 'メールアドレスまたはパスワードが一致しません。')->withInput($request->only('email'));
    }
}
