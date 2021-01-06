<?php
namespace farouqzakwan\ActiveCampaign\Automations;

use Illuminate\Support\Facades\Http;

class Automations
{
    static function listAllAutomations()
    {
        $response =  Http::withHeaders([
            'Api-Token' => config('activecampaign.activecampaign_key')
         ])
        ->get(config('activecampaign.activecampaign_url').'/api/3/automations/');
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
