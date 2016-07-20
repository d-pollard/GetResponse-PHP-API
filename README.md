# GetResponse lightweight PHP API library

## Simple usage
```php
<?php
    require_once 'MailerClass.php';
    $getApi = new GetResponse('YOUR_API_AUTH_KEY');
    
    // returns all campaigns
    $getApi->getCampaign(); 
    
    // returns data specific to the campaign with the ID specified
  	$getApi->getCampaign('my_campaign_id'); 
  	
  	// creates a new campaign, and returns the campaigns info (like in getCampaign)
  	$getApi->createCampaign('my_new_campaign'); 
  	
  	// shows the contacts (people subscribed to campaign)
  	$getApi->getContacts('my_campaign_id'); 
  	
  	// search a campaign for a users info by email
  	$getApi->getContacts('my_campaign_id', 'j.doe@example.com'); 
  	
  	// subscribes user to a campaign, all fields required
  	$getApi->subscribe('my_campaign_id', 'Joe Smith', 'j.doe@example.com', 'MY_IP'); 
  	
  	// will unsubscribe a user from a list, returns either true or false
    $getApi->unsubscribe('my_campaign_id', 'j.doe@example.com'); 
?>
```
