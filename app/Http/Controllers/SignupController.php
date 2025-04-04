<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Exception;
use App\Models\User;

class SignupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $numA = rand(1, 9);
        $numB = 0;
        while (1) {
            $numB = rand(1, 9);
            if ($numA != $numB) break;
        }

        return view('signup', compact('numA', 'numB'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        //signup  process
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'secret_code' => 'required|numeric',
            'num_a' => 'required|numeric',
            'num_b' => 'required|numeric',
        ]);


        DB::beginTransaction();
        try {

            $randomCode = Str::random(5);
            $numA = $request->num_a;
            $numB = $request->num_b;
            $secretCode = $request->secret_code;

            //    if secret code not matched
            if ($numA + $numB != $secretCode)
                return redirect()->back()->with('warning', 'Registeration rejected!');
            else {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($randomCode),
                ]);

                $user->assignRole('user');

                $user->sales()->create([
                    'coins' => 500,
                    'price' => 0,
                    'expiry_at' => now()->addDays(365),
                    'remarks' => 'Sign up bonus',

                ]);

                // send password to given email for verification
                $email = $request->email;
                Mail::raw('Password sent by exampixel.com : ' . $randomCode, function ($message) use ($email) {
                    $message->to($email);
                    $message->subject('Signup on exampixel');
                });
            }



            DB::commit();

            // go to related dashboard
            return redirect('signup-success');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
