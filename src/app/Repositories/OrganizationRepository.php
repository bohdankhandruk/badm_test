<?php

namespace App\Repositories;

use App\Models\Organization;
use App\Interfaces\OrganizationRepositoryInterface;

class OrganizationRepository implements OrganizationRepositoryInterface
{
    public function getAllOrganizations() 
    {
        return Organization::all();
    }

    public function getSubbedOrganizations() 
    {
        return Organization::all()->where('subscribed', '=', 1);
    }

    public function getTrialOrganizations() 
    {
        return Organization::all()->where('trial_end', '>', date('Y-m-d H:i:s'));
    }

    public function createOrganization(array $data) 
    {
        return Organization::create($data);
    }
}
