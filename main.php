<?php
/**
 * run with command
 * php start.php start
 */
ini_set('display_errors', 'on');
use Workerman\Worker;
require_once __DIR__ . '/chat/model/db.php';
require_once __DIR__ . '/chat/model/text_message.php';

// 初始化id对应关系列表
require_once __DIR__ . '/chat/controller/user.php';

// 检查扩展
if(!extension_loaded('pcntl'))
{
    exit("Please install pcntl extension. See http://doc3.workerman.net/appendices/install-extension.html\n");
}
if(!extension_loaded('posix'))
{
    exit("Please install posix extension. See http://doc3.workerman.net/appendices/install-extension.html\n");
}

//// 检查数据库链接
//DB::getConnection();
//TextMessage::markReadMessage([1,2,3]);

// 标记是全局启动
define('GLOBAL_START', 1);
require_once __DIR__ . '/vendor/autoload.php';

// 加载所有Applications/*/start.php，以便启动所有服务
foreach(glob(__DIR__.'/chat/start*.php') as $start_file)
{
    require_once $start_file;
}
// 运行所有服务
Worker::runAll();