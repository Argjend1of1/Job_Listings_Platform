<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Rules\Password;

class RegisteredUserController extends Controller
{

    public function create()
    {
        return view('auth.register');
    }

    public function store(RegisterRequest $request)
    {
        DB::beginTransaction();
        try {
            $userAttributes = $request->validated();

            $userTableAttributes = [
                'name' => $userAttributes['name'],
                'email' => $userAttributes['email'],
                'password' => bcrypt($userAttributes['password'])
            ];

//            dd($userAttributes);

            // Check if the 'employer' field is provided
            if ($userAttributes['employer'] !== null) {
                // Check if the 'logo' field is provided and is a valid file
                if (!$request->hasFile('logo')) {
                    return response()->json([
                        'message' => 'A company must have a logo!'
                    ], 422);
                }

                if (empty($userAttributes['category'])) {
                    return response()->json([
                        'message' => 'A company must have a category'
                    ], 422);
                }

                $logoPath = $request->file('logo')->store('logos'); // Store the file
                $category = Category::where('name', $userAttributes['category'])->first();
                $userTableAttributes['role'] = 'employer';

                $user = User::create($userTableAttributes);
                // Create the employer record
                $user->employer()->create([
                    'name' => $userAttributes['employer'],
                    'category_id' => $category->id,
                    'logo' => $logoPath
                ]);
            }else {
                $user = User::create($userTableAttributes);
            }

            DB::commit();

            return response()->json([
                'message' => 'Successfully Registered!',
                'user' => $user,
                'employer' => $user->employer ?? null
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'User already exists!',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
