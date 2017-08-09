<?php
/**
 * Created by PhpStorm.
 * User: glrh11
 * Date: 17-8-8
 * Time: 上午11:31
 * 这里边存储消息类型, 以及相关处理函数
 */

namespace chat\message;


class MessageTypeModel
{
    // 心跳消息
    CONST PING = 1001;  // 服务端发出的ping消息
    CONST PONG = 1002;  // 客户端回应的pong消息

    // 一般的文本消息
    CONST CLIENT_TO_CLIENT = 2001; // c 2 c
    CONST CLIENT_TO_ALL = 2002;    // c 2 all
    CONST IM_TO_CLIENT_EVER = 2003; // 历史消息

    // 确认消息: 客户端发送给im的
    CONST CONFIRM_TEXT_MESSAGE = 3001;

    // 上线, 下线消息
    CONST CLIENT_ONLINE = 4001;
    CONST CLIENT_OFFLINE = 4002;
}

class ErrorCodeModel
{

}