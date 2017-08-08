<?php
/**
 * Created by PhpStorm.
 * User: glrh11
 * Date: 17-8-8
 * Time: 下午6:08
 */

class UserController
{
    // user_id: client_id_list
    private static $user_id_to_client_id = [];
    // client_id: user_id
    private static $client_id_to_user_id = [];


    // 找到用户对应的 client_id, 以便发送消息
    // find: return client_id_list
    // else: return null
    public static function findClient($user_id)
    {
        $ifExist = array_key_exists($user_id, self::$user_id_to_client_id);
        if ($ifExist)
        {
            return self::$user_id_to_client_id[$user_id];
        } else {
            return [];
        }
    }

    // delete client_id from client_id_list
    // 从用户的客户端列表里边, 删除
    public static function deleteClient($user_id, $client_id)
    {
        $ifExist = array_key_exists($user_id, self::$user_id_to_client_id);
        if ($ifExist)
        {
            $ever_client_id_list = self::$user_id_to_client_id[$user_id];
            $ever_client_id_list = array_unique($ever_client_id_list);

            if(($key = array_search($client_id, $ever_client_id_list)) !== false) {
                unset($ever_client_id_list[$key]);
            }
            self::$user_id_to_client_id = $ever_client_id_list;
        }
    }

    // 用户上线
    public static function onlineUser($user_id, $client_id)
    {
        // 增加 user_id: client_id_list 关系
        $client_id_list = self::findClient($user_id);
        $client_id_list = array_unique(
            array_push($client_id_list, $client_id)
        );
        self::$user_id_to_client_id= $client_id_list;

        // 增加 client_id: user_id 关系
        self::$client_id_to_user_id[$client_id] = $user_id;
    }

    // 用户下线
    public static function offlineUser($user_id, $client_id)
    {
        // 删除相应 user_id: client_id_list 关系
        self::deleteClient($user_id, $client_id);

        // 删除 client_id: user_id 关系
        if (array_key_exists($client_id, self::$client_id_to_user_id)) {
            unset(self::$client_id_to_user_id[$client_id]);
        }
    }
}