<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\CandidateRegisterRequest;
use App\Models\Profile;
use App\Models\User;
use App\Traits\ActivationTrait;
use App\Traits\CandidateTrait;
use App\Traits\CaptureIpTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class CandidateAuthController extends Controller
{
    use CandidateTrait, ActivationTrait;


    public function loginView()
    {
//        return view('auth.candidate.login-register');
        return view('auth.candidate.login');
    }


    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->to( $request->state);
        }


        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput();
    }


    public function registerView()
    {
        return view('auth.candidate.register');
    }


    public function register(CandidateRegisterRequest $request, User $user)
    {
        DB::beginTransaction();
        try {
            $user = $this->createUser($request, 0);
//            $user = $this->attachRole($user, 'Candidate');
            $candidate = $this->registerCandidate($user, $request);

            $this->initiateEmailActivation($user);

            if (!config('settings.activation')) {
                /*
                 * Assign Candidate Role When Email Verification is Set to False
                 */
                $this->disabledActivationRoleAssign($user);
            }

            Auth::login($user, true);

            DB::commit();
            toastr()->success(__('Registration Successful!'));
            return redirect()->to( $request->state);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage(), [$e->getCode(), $e->getLine()]);
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }


}
