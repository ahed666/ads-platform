<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AccountService;
 use Inertia\Inertia;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Country;
use App\Models\City;
class AccountController extends Controller
{
    protected AccountService $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
       
    }

    public function index()
    {
            $user = $this->accountService->getAccount();
            $countries=Country::where('is_active',true)->get();
            $cities = City::whereIn('country_id', $countries->pluck('id'))->get();
          
        return Inertia::render('admin/account/Index', [
            'user' => $user,
            'countries'=>$countries,
            'cities'=>$cities,
        ]);
    }

    public function update(Request $request): User
    {
        $user=$this->accountService->updateAccount($request->all());
        return $user;
    }

}
