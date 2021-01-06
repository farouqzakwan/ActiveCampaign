<?php

namespace farouqzakwan\ActiveCampaign\Contacts;

use Illuminate\Support\Facades\Http;

class Automations
{
    static function addContact($contactAutomation)
    {
        $response =  Http::withBody(json_encode($contactAutomation),'json')->withHeaders([
            'Api-Token' => config('activecampaign.activecampaign_key')
         ])
        ->post(config('activecampaign.activecampaign_url').'/api/3/contactAutomations');
        return self::return($response);
    }

    static function getContacts($contactAutomationID)
    {
        $response =  Http::withHeaders([
            'Api-Token' => config('activecampaign.activecampaign_key')
         ])
        ->get(config('activecampaign.activecampaign_url').'/api/3/contactAutomations/'.$contactAutomationID);
        return self::return($response);
    }
    
    static function listContactAutomations()
    {
        $response =  Http::withHeaders([
            'Api-Token' => config('activecampaign.activecampaign_key')
         ])
        ->get(config('activecampaign.activecampaign_url').'/api/3/contactAutomations');
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