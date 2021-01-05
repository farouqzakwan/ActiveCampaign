<?php
define('ACTIVECAMPAIGN_CONTACT_SUBSCRIBE_LIST',1);
define('ACTIVECAMPAIGN_CONTACT_UNSUBSCRIBE_LIST',2);
define('ACTIVECAMPAIGN_CONTACT_RESUBSCRIBE_LIST',4);

return [
    'activecampaign_url'    => env('ACTIVECAMPAIGN_URL') ?? false,
    'activecampaign_key'    => env('ACTIVECAMPAIGN_KEY') ?? false,
];