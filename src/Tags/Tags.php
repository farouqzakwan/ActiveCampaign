<?php
namespace farouqzakwan\ActiveCampaign\Tags;

use Illuminate\Support\Facades\Http;

class Tags 
{
    protected static $sideloading;
    protected static $limit = 20;
    protected static $offset = 0;
    protected static $orders;
    
    static function sideloading($sideloading)
    {
       foreach ($sideloading as $key => $sideload) 
       {
           if ($key != 0) 
           {
                self::$sideloading .= ',';
           }
           self::$sideloading .= $sideload;
           return __CLASS__;
       }
    }

    static function limit($limit)
    {
        self::$limit = $limit;
        return __CLASS__;
    }

    static function offset($offset)
    {
        self::$offset = $offset;  
        return __CLASS__;  
    }

    static function page($page)
    {
        self::$offset = ($page*self::$limit)-self::$limit;
        return __CLASS__;
    }

    static function ordering($orders)
    {
        $counter = 0;
        foreach ($orders as $key => $order) 
        {
            if($counter != 0)
            {
                self::$orders .= '&';
            }
            $counter++;
            self::$orders .= 'orders['.$key.']='.$order;
        }
        return __CLASS__;
    }   

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
        $url = config('activecampaign.activecampaign_url').'/api/3/tags?limit='.self::$limit.'&offset='.self::$offset;
        if (!empty(self::$sideloading)) 
        {
            $url .= '&include='.self::$sideloading;
        }

        $response =  Http::withHeaders([
            'Api-Token' => config('activecampaign.activecampaign_key')
         ])
        ->get($url);
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
