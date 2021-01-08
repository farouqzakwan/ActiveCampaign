<?php
namespace farouqzakwan\ActiveCampaign\ContactList;

use Illuminate\Support\Facades\Http;

class ContactList
{
    static function getList()
    {
        $response =  Http::withHeaders([
            'Api-Token' => config('activecampaign.activecampaign_key')
         ])
        ->get(config('activecampaign.activecampaign_url').'/api/3/lists/');
        return self::return($response);
    }

    static function getAList($ListID)
    {
        $response =  Http::withHeaders([
            'Api-Token' => config('activecampaign.activecampaign_key')
         ])
        ->get(config('activecampaign.activecampaign_url').'/api/3/lists/'.$ListID);
        return self::return($response);
    }

    static function getUsers($ListID)
    {
        $response =  Http::withHeaders([
            'Api-Token' => config('activecampaign.activecampaign_key')
         ])
        ->get(config('activecampaign.activecampaign_url').'/api/3/lists/'.$ListID.'/user');
        return self::return($response);
    }

    private static function return($response)
    {
        if($response->successful())
        {
            return $response->json();
        }else{
            return array_merge(array('status' => 'failed'),$response->json());
        }
    }
}