<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function show($user_id){
    
        $user = User::with('addresses')->find($user_id);
        if (!$user) {
                return response()->json([
                    'status_code' => 404,
                    'message' => 'User not found'
                ], 404);
            }
        $addresses = [];
        foreach ($user->addresses as $address) {
            $addresses[] = [
                'address_type' => $address->address_type,
                'address1' => [
                    'door/street' => $address->door_street,
                    'landmark' => $address->landmark,
                    'city' => $address->city,
                    'state' => $address->state,
                    'country' => $address->country,
                ],
                'primary' => $address->primary
            ];
        }
        return response()->json(['status_code' => 200,
            'message' => 'User details',
            'data' => [
                'user_name' => $user->user_name,
                'mobile' => $user->mobile,
                'dob' => date('d/m/Y', strtotime($user->dob)),
                'gender' => $user->gender,
                'Address' => $addresses
            ]
            ]);
    }
    
}
