<?php
// Load composer
require __DIR__ . '/vendor/autoload.php';

$bot_api_key  = '252926927:AAEO2sCissM_BB-FOll_X2mmIsheGTu7OCs';
$hook_url = 'https://krakenbfp.heroku.com/';

try {
    // Create Telegram API object
    $telegram = new Zelenin\TelegramBot\Telegram($bot_api_key);

    // Set webhook
    $result = $telegram->setWebhook($hook_url);
    if ($result->isOk()) {
        echo $result->getDescription();
    }
}