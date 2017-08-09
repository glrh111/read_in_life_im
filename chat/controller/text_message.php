<?php

/**
 * Created by PhpStorm.
 * User: glrh11
 * Date: 17-8-8
 * Time: 下午6:05
 */
require_once __DIR__ . "/../model/text_message.php";
require_once __DIR__ . "/user.php";
require_once __DIR__ . "/../model/message_type.php";

use \GatewayWorker\Lib\Gateway;

class TextMessageController
{



    public static function sendMessageToOneClient($from_id, $to_id, $content)
    {
        // 通过 $to_id 找到客户端列表
        $to_client_id_list = UserController::findClient($to_id);

        $message = [
            "message_type" => \chat\message\MessageTypeModel::CLIENT_TO_CLIENT,
            "message_content" => [
                "from_id" => $from_id,
                "to_id" => $to_id,
                "content" => $content
            ]
        ];
        $message_json = json_encode($message);
        foreach ($to_client_id_list as $client_id)
        {
            Gateway::sendToClient($client_id, $message_json);
        }
    }

    public static function sendMessageToAllClient($from_id, $content)
    {
        $message = [
            "message_type" => \chat\message\MessageTypeModel::CLIENT_TO_ALL,
            "message_content" => [
                "from_id" => $from_id,
                "content" => $content
            ]
        ];
        $message_json = json_encode($message);
        Gateway::sendToAll($message_json);
    }

    public static function markMessageListRead($message_id_list)
    {

    }

}