# GetResponse lightweight PHP API library

## Simple usage
```php
<?php
    require_once 'MailerClass.php';
    $getApi = new GetResponse('YOUR_API_AUTH_KEY');
    $getApi->getCampaign(); // returns all campaigns
  	$getApi->getCampaign('my_campaign_id'); // returns data specific to the campaign with the ID specified
  	$getApi->createCampaign('my_new_campaign'); // creates a new campaign, and returns the campaigns info (like in getCampaign)
  	$getApi->getContacts('my_campaign_id'); // shows the contacts (people subscribed to campaign)
  	$getApi->getContacts('my_campaign_id', 'j.doe@example.com'); // search a campaign for a users info by email
  	$getApi->subscribe('my_campaign_id', 'Joe Smith', 'j.doe@example.com', 'MY_IP'); // subscribes user to a campaign, all fields required
    $getApi->unsubscribe('my_campaign_id', 'j.doe@example.com'); // will unsubscribe a user from a list, returns either true or false
?>
```
