<?php

namespace farouqzakwan\ActiveCampaign\Contacts;

use Illuminate\Support\Facades\Http;

class Tags
{
    static function addTags($tags)
    {
        $response =  Http::withBody(json_encode($tags),'json')->withHeaders([
            'Api-Token' => config('activecampaign.activecampaign_key')
         ])
        ->post(config('activecampaign.activecampaign_url').'/api/3/contactTags');
        return self::return($response);
    }

    static function removeTag($contagTagId)
    {
        $response =  Http::withHeaders([
            'Api-Token' => config('activecampaign.activecampaign_key')
         ])
        ->delete(config('activecampaign.activecampaign_url').'/api/3/contactTags/'.$contagTagId);
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