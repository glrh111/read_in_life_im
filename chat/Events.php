<?php

use \GatewayWorker\Lib\Gateway;
use \chat\message;
require_once __DIR__ . "/controller/text_message.php";
require_once __DIR__ . "/lib/helper.php";

class Events
{
    /**
     * 当客户端连接时触发
     * 如果业务不需此回调可以删除onConnect
     * @param int $client_id 连接id
     */
    public static function onConnect($client_id)
    {
        // 发送历史消息
        Gateway::sendToClient($client_id,json_encode([
            'message_type'=> message\MessageTypeModel::IM_TO_CLIENT_EVER,
            'message_content' => TextMessageModel::getBigRoomEverMessage()
        ]));

        // 向当前client_id发送数据
        Gateway::sendToClient($client_id, json_encode("Hello $client_id"));
        // 向所有人发送
        Gateway::sendToAll(json_encode("$client_id login"));
    }

    /**
     * 当客户端发来消息时触发
     * @param int $client_id 连接id
     * @param string $message 具体消息
     */
    public static function onMessage($client_id, $message)
    {
        $message_arr = json_decode($message, true);

        // 判断消息类型
        $message_type = $message_arr["message_type"];
        $deliver_message = $message_arr["message_content"];
        switch ($message_type)
        {
            case 1002:
                // 说明客户端在线
//                echo 'in ' . 1002;
                break;
            // 一个客户端发给另一个客户端
            case 2001:
//                echo 2001;
                TextMessageController::sendMessageToOneClient(
                    $deliver_message['from_id'],
                    $deliver_message['to_id'],
                    $deliver_message['content']
                );
                break;
            // 客户端群发
            case 2002:
//                echo 2002;
                // 将消息存储到数据库中
                TextMessageModel::saveMessage([
                    'from_id'=> $deliver_message['from_id'],
                    'content'=> $deliver_message['content'],
                    'message_type'=> 1,
                    'ctime'=> Helper::time13()
                ]);
                TextMessageController::sendMessageToAllClient(
                    $deliver_message['from_id'],
                    $deliver_message['content']
                );
                break;
            // im 给客户端发送的
            case 2003: // 不可能
                break;

            // 已读消息确认
            case 3001:
                TextMessageController::markMessageListRead(
                    $deliver_message["message_id_list"]
                );
                break;

            // 客户端上线
            case 4001:
                UserController::onlineUser(
                    $deliver_message["user_id"],
                    $client_id
                );
                break;
            // 客户端下线
            case 4002:
                UserController::offlineUser(
                    $deliver_message["user_id"],
                    $client_id
                );
                break;

            // default
            default:
                echo $message_type;
                break;
        }

    }

    /**
     * 当用户断开连接时触发
     * @param int $client_id 连接id
     */
    public static function onClose($client_id)
    {
        // 向所有人发送
        GateWay::sendToAll("$client_id logout");
    }
}