<?php

namespace App\Services;

use App\Models\Company;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Repositories\CompanyRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AccountService
{
    protected UserRepository $userRepo;
    protected CompanyRepository $companyRepo;
    public function __construct(UserRepository $userRepo,CompanyRepository $companyRepo)
    {
        $this->userRepo = $userRepo;
        $this->companyRepo = $companyRepo;
    }

    public function getAccount(): User
    {
        return Auth::user()->load('company');
    }


    public function updateAccount(array $data): User
    {
        $user = Auth::user();

        
        $userValidated = Validator::make($data, [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'account_type' => ['required', 'in:individual,company'],

            // personal info for user only
            'phone' => ['nullable', 'string'],
            'whatsapp' => ['nullable', 'string'],
            'country_id' => ['nullable', 'numeric'],
            'city_id' => ['nullable', 'numeric'],
            'address' => ['nullable', 'string'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'facebook' => ['nullable', 'url'],
            'instagram' => ['nullable', 'url'],
            'linkedin' => ['nullable', 'url'],
            'twitter' => ['nullable', 'url'],
        ])->validate();

        $this->userRepo->update($user, $userValidated);

        // ✅ if comapny account then update the company info
        if ($user->account_type === 'company') {
            $company = $user->company ?? new Company(['owner_id' => $user->id]);

            $companyValidated = Validator::make($data, [
                'name' => ['required', 'string'],
                'slug' => ['nullable', 'string'],
                'description' => ['nullable', 'string'],
                'industry' => ['nullable', 'string'],
                'logo' => ['nullable', 'string'],
                'email' => ['nullable', 'email'],
                'website' => ['nullable', 'url'],
                'tax_id' => ['nullable', 'string'],
                'registration_number' => ['nullable', 'string'],
            ])->validate();

            if ($company->exists) {
                $this->companyRepo->update($company, $companyValidated);
            } else {
                $companyValidated['owner_id'] = $user->id;
                $this->companyRepo->create($companyValidated);
            }
        }

        return $user->fresh()->load('company');
    }


    
}
