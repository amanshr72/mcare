<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{   
    protected $roles;
    protected $states;

    public function __construct(){
        $this->roles = ['superadmin', 'admin', 'user'];
        $this->states = ['Andaman and Nicobar Islands', 'Andhra Pradesh', 'Arunachal Pradesh', 'Assam', 'Bihar', 'Chandigarh', 'Chhattisgarh', 'Dadra and Nagar Haveli and Daman and Diu', 'Delhi', 'Goa', 'Gujarat', 'Haryana', 'Himachal Pradesh', 'Jharkhand', 'Karnataka', 'Kerala', 'Lakshadweep', 'Madhya Pradesh', 'Maharashtra', 'Manipur', 'Meghalaya', 'Mizoram', 'Nagaland', 'Odisha', 'Puducherry', 'Punjab', 'Rajasthan', 'Sikkim', 'Tamil Nadu', 'Telangana', 'Tripura', 'Uttar Pradesh', 'Uttarakhand', 'West Bengal'];
    }

    public function index(){
        $users = User::latest()->paginate(10);
        return view('user.index', compact('users'));
    }

    public function create(){
        $roles = $this->roles; $states = $this->states; $user = '';
        return view('user.create', compact('roles', 'states'));
    }

    public function store(Request $request){
        try{
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email|max:255',
                'role' => 'required',
                'state' => 'required',
                'password' => 'required|string|min:8',
                'confirm_password' => 'required|string|min:8|same:password'
            ]);
    
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'state' => $request->state,
                'role' => $request->role,
                'password' => bcrypt($request->password),
            ]);
    
            return redirect()->route('user.index')->with('success', 'User added successfully');
        }catch(Exception $e){
            return redirect()->route('user.index')->with('danger', 'Whoops! an error occurred: ' . $e->getMessage());
        }
    }

    public function edit(User $user){
        $roles = $this->roles; $states = $this->states;
        return view('user.create', compact('roles', 'states', 'user'));
    }

    public function update(Request $request, User $user){
        try{
            $request->validate([
                'password' => 'required|string|min:8',
                'confirm_password' => 'required|string|min:8|same:password'
            ]);
    
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'state' => $request->state,
                'role' => $request->role,
                'password' => bcrypt($request->password),
            ]);
    
            return redirect()->route('user.index')->with('success', 'User updated successfully');
        }catch(Exception $e){
            return redirect()->route('user.index')->with('danger', 'Whoops! an error occurred: ' . $e->getMessage());
        }
    }

    public function destroy(User $user){
        try{
            $user->delete();
            return redirect()->route('user.index')->with('danger', 'User deleted successfully');
        }catch(Exception $e){
            return redirect()->route('user.index')->with('danger', 'Whoops! an error occurred: ' . $e->getMessage());
        }
    }
}
