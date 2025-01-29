<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRequest;
use App\Models\Admin;
use App\Models\ShopOwner;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function showRegisterForm()
    {
        return view('admin.admin-register');
    }

    public function register(AdminRequest $request)
    {
        Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.login')->with('success', '管理者が登録されました。');
    }

    public function showLoginForm()
    {
        return view('admin.admin-login');
    }

    public function login(AdminRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'メールアドレスまたはパスワードが一致しません。')->withInput($request->only('email'));
    }

    public function dashboard()
    {
        return view('admin.admin');
    }

    public function adminShop()
    {
        $owners = ShopOwner::paginate(5); // ページネーションで5人ずつ表示
        return view('admin.admin-shop', compact('owners'));
    }

    public function deleteOwner($id)
    {
        $owner = ShopOwner::findOrFail($id);
        $owner->delete();

        return redirect()->route('admin.shop')->with('success', 'オーナー情報が削除されました。');
    }

    public function createShopOwner(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:owners',
            'password' => 'required|string|min:8',
        ]);

        ShopOwner::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'オーナーが登録されました。');
    }
}
