<?php
namespace farouqzakwan\ActiveCampaign\Tags;

use Illuminate\Support\Facades\Http;

class Tags 
{
    static function createTag($tags)
    {
        $response =  Http::withBody(json_encode($tags),'json')->withHeaders([
            'Api-Token' => config('activecampaign.activecampaign_key')
         ])
        ->post(config('activecampaign.activecampaign_url').'/api/3/tags');
        return self::return($response);
    }   

    static function getTag($tagID)
    {
        $response =  Http::withHeaders([
            'Api-Token' => config('activecampaign.activecampaign_key')
         ])
        ->get(config('activecampaign.activecampaign_url').'/api/3/tags/'.$tagID);
        return self::return($response);
    }

    static function updateTag($tag,$tagID)
    {
        $response =  Http::withBody(json_encode($tag),'json')->withHeaders([
            'Api-Token' => config('activecampaign.activecampaign_key')
         ])
        ->put(config('activecampaign.activecampaign_url').'/api/3/tags/'.$tagID);
        return self::return($response);
    }

    static function deleteTag($tagID)
    {
        $response =  Http::withHeaders([
            'Api-Token' => config('activecampaign.activecampaign_key')
         ])
        ->delete(config('activecampaign.activecampaign_url').'/api/3/tags/'.$tagID);
        return self::return($response);
    }

    static function listAllTag()
    {
        $response =  Http::withHeaders([
            'Api-Token' => config('activecampaign.activecampaign_key')
         ])
        ->get(config('activecampaign.activecampaign_url').'/api/3/tags');
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
