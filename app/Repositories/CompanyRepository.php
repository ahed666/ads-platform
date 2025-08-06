<?php

namespace App\Repositories;

use App\Models\Company;

class CompanyRepository
{
    public function findById(int $id): ?Company
    {
        return Company::find($id);
    }

    public function findByOwnerId(int $ownerId): ?Company
    {
        return Company::where('owner_id', $ownerId)->first();
    }

    public function update(Company $company, array $data): Company
    {
        $company->fill($data);
        $company->save();
        return $company;
    }

    public function create(array $data): Company
    {
        return Company::create($data);
    }
}
