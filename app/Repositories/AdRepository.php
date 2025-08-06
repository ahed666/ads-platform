<?php
namespace App\Repositories;

use App\Models\Ad;

class AdRepository
{
   
    // AdRepository.php

    public function all(?int $userId = null,$withOwner=false)
    {
        $query = Ad::with(['media', 'category', 'brand','model','type'])->latest();

        if ($userId) {
            $query->where('user_id', $userId);
        }

        return $query->get();
    }

    public function paginate(int $perPage = 15, ?int $userId = null,$withOwner=false)
    {
        $query = Ad::with(['media', 'category', 'brand','model','type']);

        if ($withOwner) {
            $with[] = 'company'; 
        }
        
        if ($userId) {
            $query->where('user_id', $userId);
        }

        return $query->latest()->paginate($perPage);
    }

    public function paginateQuery($query, int $perPage = 20, ?int $userId = null,$withOwner=false)
    {

        
        $with = ['media', 'category', 'brand','model','type'];

        if ($withOwner) {
            $with[] = 'user'; 
        }
        if ($userId) {
            $query->where('user_id', $userId);
        }
         
         
        return $query->latest()->with($with)->paginate($perPage);
    }



    public function find($id,$withOwner=false)
    {
       
        if($withOwner)
        {$ad=Ad::with(['media', 'category', 'brand','model','type','user'])->findOrFail($id);
         
        
          return $ad;
        }        
return Ad::with(['media', 'category', 'brand','model','type'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return Ad::create($data);
    }

    public function update(Ad $ad, array $data)
    {
        $ad->update($data);
        return $ad;
    }

    public function delete(Ad $ad)
    {
        return $ad->delete();
    }
}
