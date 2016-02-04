<?php

use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;

class FacebookConnect {
    const APP_ID = '785123928176736';
    const APP_SECRET = '22ea9bddaa3cb5a7f2b1ce14e2595772';

    public function __construct()
    {
        FacebookSession::setDefaultApplication(self::APP_ID, self::APP_SECRET);
       // ...your code goes here...
    }

}
?>
