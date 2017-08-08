<?php
/**
 * Created by PhpStorm.
 * User: glrh11
 * Date: 17-8-8
 * Time: 上午11:38
 * 连接pgsql的
 * 参考http://php.net/manual/en/function.pg-connect.php
 *
 */


class DB
{

    private static $sqlconn = null;

    function __construct($host=null, $port=null, $timeout=10){
    }

    // 获取数据库连接; 如果已经连接过, 返回已经有的连接
    public static function getConnection ()
    {

        if (self::$sqlconn==null) {
            self::$sqlconn = pg_connect("host=172.17.0.2 port=5432 dbname=read_in_life user=read_in_life password=wocao");
        }
        return self::$sqlconn;
    }

    function __destruct()
    {
        if(self::$sqlconn){
            pg_close([self::$sqlconn]);
            self::$sqlconn = null;
        }
    }
}