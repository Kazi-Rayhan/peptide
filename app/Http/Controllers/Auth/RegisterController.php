<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'customer_type' => ['required', 'string', 'in:retailer,wholesaler'],
        ];

        // Add validation rules for wholesaler fields if customer type is wholesaler
        if (isset($data['customer_type']) && $data['customer_type'] === 'wholesaler') {
            $wholesalerRules = [
                'company_name' => ['required', 'string', 'max:255'],
                'company_registration' => ['nullable', 'string', 'max:255'],
                'company_address' => ['required', 'string', 'max:500'],
                'company_phone' => ['required', 'string', 'max:20'],
                'company_website' => ['nullable', 'url', 'max:255'],
                'business_type' => ['required', 'string', 'in:pharmaceutical,biotechnology,research_institute,university,hospital,laboratory,distributor,other'],
                'industry' => ['required', 'string', 'in:healthcare,life_sciences,academic,clinical_research,drug_development,biomedical,other'],
                'expected_volume' => ['required', 'string', 'in:small,medium,large,enterprise'],
            ];

            $rules = array_merge($rules, $wholesalerRules);
        }

        return Validator::make($data, $rules, [
            'customer_type.required' => 'Please select a customer type.',
            'customer_type.in' => 'Invalid customer type selected.',
            'company_name.required' => 'Company name is required for wholesaler accounts.',
            'company_address.required' => 'Company address is required for wholesaler accounts.',
            'company_phone.required' => 'Company phone is required for wholesaler accounts.',
            'business_type.required' => 'Business type is required for wholesaler accounts.',
            'industry.required' => 'Industry is required for wholesaler accounts.',
            'expected_volume.required' => 'Expected order volume is required for wholesaler accounts.',
            'company_website.url' => 'Please enter a valid website URL.',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $isWholesaler = ($data['customer_type'] === 'wholesaler');
        $details = null;
        if ($isWholesaler) {
            $details = [
                'company_name' => $data['company_name'],
                'company_registration' => $data['company_registration'] ?? null,
                'company_address' => $data['company_address'],
                'company_phone' => $data['company_phone'],
                'company_website' => $data['company_website'] ?? null,
                'business_type' => $data['business_type'],
                'industry' => $data['industry'],
                'expected_volume' => $data['expected_volume'],
            ];
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role_id' => 2,
            'password' => Hash::make($data['password']),
            'is_wholesaler' => 0,
            'details' => $details ? json_encode($details) : null,
        ]);

        // Send welcome email
        Mail::to($user->email)->send(new WelcomeEmail($user));

        return $user;
    }
}
