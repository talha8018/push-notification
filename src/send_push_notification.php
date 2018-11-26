<?php
require __DIR__ . '/../vendor/autoload.php';
use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\VAPID;

// here I'll get the subscription endpoint in the POST parameters
// but in reality, you'll get this information in your database
// because you already stored it (cf. push_subscription.php)
$subscription = Subscription::create(json_decode(file_get_contents('php://input'), true));
var_dump(VAPID::createVapidKeys());
$auth = array(
    'VAPID' => array(
        'subject' => 'https://github.com/Minishlink/web-push-php-example/',
        'publicKey' => 'BCmti7ScwxxVAlB7WAyxoOXtV7J8vVCXwEDIFXjKvD-ma-yJx_eHJLdADyyzzTKRGb395bSAtxlh4wuDycO3Ih4',
        'privateKey' => 'HJweeF64L35gw5YLECa-K7hwp3LLfcKtpdRNK8C_fPQ', // in the real world, this would be in a secret file
    ),
);

$webPush = new WebPush($auth);

$res = $webPush->sendNotification(
    $subscription,
    json_encode(['url'=>'https://www.youtube.com/','title'=>'0406789456321','body'=>'Hello this is new World','icon'=>'https://scontent.fkhi10-1.fna.fbcdn.net/v/t1.0-9/29543132_1679576338767918_5622404301358770163_n.jpg?_nc_cat=109&_nc_ht=scontent.fkhi10-1.fna&oh=5c033f23b5287266f20827cfc888c273&oe=5C7729A7']),
    true
);
 
// handle eventual errors here, and remove the subscription from your server if it is expired
