<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TenantsController extends Controller
{
    public function index()
    {
        $tenants = User::where('role', User::ROLE_TENANT)->orderBy('name')->paginate(15);
        return view('admin.tenants.index', compact('tenants'));
    }

    public function create()
    {
        return view('admin.tenants.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
        ]);
        $user = new User();
        $user->fill([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => User::ROLE_TENANT,
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'] ?? null,
        ]);
        $user->save();
        return redirect()->route('admin.tenants.index')->with('status', 'Tenant created');
    }

    public function edit(User $tenant)
    {
        return view('admin.tenants.edit', ['tenant' => $tenant]);
    }

    public function update(Request $request, User $tenant)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$tenant->id,
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
        ]);
        $tenant->name = $data['name'];
        $tenant->email = $data['email'];
        if (!empty($data['password'])) {
            $tenant->password = Hash::make($data['password']);
        }
        $tenant->phone = $data['phone'] ?? null;
        $tenant->address = $data['address'] ?? null;
        $tenant->save();
        return redirect()->route('admin.tenants.index')->with('status', 'Tenant updated');
    }

    public function destroy(User $tenant)
    {
        $tenant->delete();
        return redirect()->route('admin.tenants.index')->with('status', 'Tenant deleted');
    }
}
