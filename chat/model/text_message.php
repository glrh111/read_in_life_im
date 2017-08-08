<?php

/**
 * Created by PhpStorm.
 * User: glrh11
 * Date: 17-8-8
 * Time: 下午4:43
 * 这里边, 写入操作数据库相关的操作
 *
 * message_id 0
 *
 * from_id 1
 * to_id 2
 * content 3
 *
 * if_read 4
 *
 * ctime 5
 * read_time 6
 *
 */
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/../lib/helper.php';

// 表名 textmessage
class TextMessage
{

    const TABLE_NAME = 'textmessage';

    // 获取某个user_id 的历史消息(含未读消息)
    static function getEverMessage($user_id)
    {
        // 获取数据库连接
        $conn = DB::getConnection();

        // 查询
        $sql = "select * from " . self::TABLE_NAME . " where to_id=$user_id order by ctime";

        $result = pg_query($conn, $sql);

        $resultList = [];

        while ($row = pg_fetch_assoc($result))
        {
            array_push($resultList, $row);
        }
        // print_r($resultList);
        return $resultList;
    }

    // 标记一系列消息已读
    // 一起更新
    // :param: $messageList: [ message_id1, message_id2 ]
    static function markReadMessage($messageList)
    {
        $time13 = Helper::time13();
        $messageListString = join(',',$messageList);
        $sql = "update " . self::TABLE_NAME . " set if_read=true,read_time=$time13 where message_id in ($messageListString)";
        $conn = DB::getConnection();
        pg_query($conn, $sql);
    }

}