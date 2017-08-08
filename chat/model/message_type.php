<?php
/**
 * Created by PhpStorm.
 * User: glrh11
 * Date: 17-8-8
 * Time: 上午11:31
 * 这里边存储消息类型, 以及相关处理函数
 */

namespace chat\message;


class MessageType
{
    // 心跳消息
    CONST PING = 1001;
    CONST PONG = 1002;

    // 一般的文本消息
    CONST TEXT_MESSAGE = 2001;

    // 确认消息
    CONST CONFIRM_TEXT_MESSAGE = 3001;

}

class ErrorCode
{

}