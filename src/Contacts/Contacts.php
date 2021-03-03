<?php

namespace farouqzakwan\ActiveCampaign\Contacts;

use Illuminate\Support\Facades\Http;

class Contacts
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

    static function createOrUpdate($contact,$field_values = array())
    {
        if (!empty($field_values)) 
        {
            $body = json_encode(array('contact' => $contact,'fieldValues' => $field_values));
        }else{
            $body = json_encode(array('contact' => $contact));
        }
        
        $response =  Http::withBody($body,'json')->withHeaders([
                        'Api-Token' => config('activecampaign.activecampaign_key')
                     ])
                    ->post(config('activecampaign.activecampaign_url').'/api/3/contacts');
        return self::return($response);
    }

    static function listAllContact()
    {
        $url = config('activecampaign.activecampaign_url').'/api/3/contacts?limit='.self::$limit.'&offset='.self::$offset;

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

    static function listContact($contactID)
    {
        $url = config('activecampaign.activecampaign_url').'/api/3/contacts/'.$contactID;
        $response =  Http::withHeaders([
            'Api-Token' => config('activecampaign.activecampaign_key')
         ])
        ->get($url);   
        return self::return($response);
    }

    static function bounceLogs($contactID)
    {
        $response =  Http::withHeaders([
            'Api-Token' => config('activecampaign.activecampaign_key')
         ])
        ->get(config('activecampaign.activecampaign_url').'/api/3/contacts/'.$contactID.'bounceLogs');   
        return self::return($response);
    }

    static function automations($contactID,$limit = 1000)
    {
        $response =  Http::withHeaders([
            'Api-Token' => config('activecampaign.activecampaign_key')
         ])
        ->get(config('activecampaign.activecampaign_url').'/api/3/contacts/'.$contactID.'/contactAutomations');   
        return self::return($response);
    }

    static function getTags($contactID)
    {
        $response =  Http::withHeaders([
            'Api-Token' => config('activecampaign.activecampaign_key')
         ])
        ->get(config('activecampaign.activecampaign_url').'/api/3/contacts/'.$contactID.'/contactTags');   
        return self::return($response);
    }

    static function removeTag($contagTagID)
    {
        $response =  Http::withHeaders([
            'Api-Token' => config('activecampaign.activecampaign_key')
         ])
        ->delete(config('activecampaign.activecampaign_url').'/api/3/contactTags/'.$contagTagID);   
        return self::return($response);
    }

    static function subsContactList($listID,$contactID,$statusID)
    {
        $body = json_encode(array(
            'contactList'   => array(
                'list'      => $listID,
                'contact'   => $contactID,
                'status'    => $statusID
            )
        ));
        $response =  Http::withBody($body,'json')->withHeaders([
            'Api-Token' => config('activecampaign.activecampaign_key')
         ])
        ->post(config('activecampaign.activecampaign_url').'/api/3/contactLists');
        return self::return($response);
    }

    static function updateContact($contact,$field_values = array(),$contactID)
    {
        if (!empty($field_values)) 
        {
            $body = json_encode(array('contact' => $contact,'fieldValues' => $field_values));
        }else{
            $body = json_encode(array('contact' => $contact));
        }
        
        $response =  Http::withBody($body,'json')->withHeaders([
                        'Api-Token' => config('activecampaign.activecampaign_key')
                     ])
                    ->post(config('activecampaign.activecampaign_url').'/api/3/contacts/'.$contactID);
        return self::return($response);
    }

    static function deleteContact($contactID)
    {
        $response =  Http::withHeaders([
            'Api-Token' => config('activecampaign.activecampaign_key')
         ])
        ->delete(config('activecampaign.activecampaign_url').'/api/3/contacts/'.$contactID);
        return self::return($response);
    }

    static function contactScore($contactID)
    {
        $response =  Http::withHeaders([
            'Api-Token' => config('activecampaign.activecampaign_key')
         ])
        ->get(config('activecampaign.activecampaign_url').'/api/3/contacts/'.$contactID.'/scoreValues');   
        return self::return($response);
    }

    static function bulkImportContact($contacts,$callback = array())
    {
        if (!empty($callback)) 
        {
            $body = json_encode(array('contacts' => $contacts,'callback' => $callback));
        }else{
            $body = json_encode(array('contacts' => $contacts));
        }

        $response =  Http::withBody($body,'json')->withHeaders([
                    'Api-Token' => config('activecampaign.activecampaign_key')
                ])
                ->post(config('activecampaign.activecampaign_url').'/api/3/import/bulk_import');
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