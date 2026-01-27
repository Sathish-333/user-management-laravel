<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::with('addresses')->latest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'user_name' => ['required','regex:/^[a-zA-Z\s]+$/'],
        'mobile' => ['required','digits:10'],
        'dob' => ['required','date'],
        'gender' => 'required|in:Male,Female',
        'primary_address' => 'required|in:Home,Office',

        'home.door_street' => 'required|string',
        'home.city' => ['required','regex:/^[a-zA-Z\s]+$/'],
        'home.state' => ['required','regex:/^[a-zA-Z\s]+$/'],
        'home.country' => ['required','regex:/^[a-zA-Z\s]+$/'],

        'office.door_street' => 'required|string',
        'office.city' => ['required','regex:/^[a-zA-Z\s]+$/'],
        'office.state' => ['required','regex:/^[a-zA-Z\s]+$/'],
        'office.country' => ['required','regex:/^[a-zA-Z\s]+$/'],
    ], [
        'user_name.regex' => 'Name should contain only letters',
        'mobile.digits' => 'Mobile number must be 10 digits',
        'home.city.regex' => 'Home city should contain only letters',
        'home.state.regex' => 'Home state should contain only letters',
        'home.country.regex' => 'Home country should contain only letters',
        'office.city.regex' => 'Office city should contain only letters',
        'office.state.regex' => 'Office state should contain only letters',
        'office.country.regex' => 'Office country should contain only letters',
    ]);

    $primary = $request->primary_address;
    
    $user = User::create($request->only('user_name', 'mobile', 'dob', 'gender'));

    $user->addresses()->create([
        'address_type' => 'Home',
        'door_street' => $request->home['door_street'],
        'landmark' => $request->home['landmark'] ?? null,
        'city' => $request->home['city'],
        'state' => $request->home['state'],
        'country' => $request->home['country'],
        'primary' => $primary === 'Home' ? 'Yes' : 'No'
    ]);

    $user->addresses()->create([
        'address_type' => 'Office',
        'door_street' => $request->office['door_street'],
        'landmark' => $request->office['landmark'] ?? null,
        'city' => $request->office['city'],
        'state' => $request->office['state'],
        'country' => $request->office['country'],
        'primary' => $primary === 'Office' ? 'Yes' : 'No'
    ]);

    return redirect('/admin/users')->with('success', 'User created successfully');
}
public function edit($id)
{
    $user = User::with('addresses')->findOrFail($id);
    return view('admin.users.edit', compact('user'));
}
public function update(Request $request, $id)
{
    $request->validate([
        'user_name' => ['required','regex:/^[a-zA-Z\s]+$/'],
        'mobile' => ['required','digits:10'],
        'dob' => ['required','date'],
        'gender' => 'required|in:Male,Female',
        'primary_address' => 'required|in:Home,Office',

        'home.door_street' => 'required|string',
        'home.city' => ['required','regex:/^[a-zA-Z\s]+$/'],
        'home.state' => ['required','regex:/^[a-zA-Z\s]+$/'],
        'home.country' => ['required','regex:/^[a-zA-Z\s]+$/'],

        'office.door_street' => 'required|string',
        'office.city' => ['required','regex:/^[a-zA-Z\s]+$/'],
        'office.state' => ['required','regex:/^[a-zA-Z\s]+$/'],
        'office.country' => ['required','regex:/^[a-zA-Z\s]+$/'],
    ], [
        'user_name.regex' => 'Name should contain only letters',
        'mobile.digits' => 'Mobile number must be 10 digits',
        'home.city.regex' => 'Home city should contain only letters',
        'home.state.regex' => 'Home state should contain only letters',
        'home.country.regex' => 'Home country should contain only letters',
        'office.city.regex' => 'Office city should contain only letters',
        'office.state.regex' => 'Office state should contain only letters',
        'office.country.regex' => 'Office country should contain only letters',
    ]);

    $primary = $request->primary_address;

    $user = User::findOrFail($id);

    $user->update($request->only('user_name', 'mobile', 'dob', 'gender'));

    $homeAddress = $user->addresses()->where('address_type', 'Home')->first();
    if ($homeAddress) {
        $homeAddress->update([
            'door_street' => $request->home['door_street'],
            'landmark' => $request->home['landmark'] ?? null,
            'city' => $request->home['city'],
            'state' => $request->home['state'],
            'country' => $request->home['country'],
            'primary' => $primary === 'Home' ? 'Yes' : 'No',
        ]);
    }

    $officeAddress = $user->addresses()->where('address_type', 'Office')->first();
    if ($officeAddress) {
        $officeAddress->update([
            'door_street' => $request->office['door_street'],
            'landmark' => $request->office['landmark'] ?? null,
            'city' => $request->office['city'],
            'state' => $request->office['state'],
            'country' => $request->office['country'],
            'primary' => $primary === 'Office' ? 'Yes' : 'No',
        ]);
    }

    return redirect('/admin/users')->with('success', 'User updated successfully');
}
public function destroy($id)
{
    $user = User::findOrFail($id);

    $user->addresses()->delete();

    $user->delete();

    return redirect('/admin/users')->with('success', 'User deleted successfully');
}


}

