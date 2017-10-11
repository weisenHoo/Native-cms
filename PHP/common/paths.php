<?php
//配置框架的目录结构
define("CACHE_DIR", "cache");//缓存目录
define("LOG_DIR", "log");//日志目录
define("TPL_DIR", "tpl");//模板编译目录
define("CONFIG_DIR", "config");//配置目录
define("TEMPLETE_DIR", "templete");//视图目录
define("MODULE_DIR", "module");//模块目录
define("UPLOAD_DIR", "upload");//上传目录

define("CACHE_PATH", TEMP_PATH.'/'.CACHE_DIR);
define("LOG_PATH", TEMP_PATH.'/'.LOG_DIR);
define("TPL_PATH", TEMP_PATH.'/'.TPL_DIR);
define("TEMPLETE_PATH", APP_PATH.'/'.TEMPLETE_DIR);
if(!defined("MODULE_PATH")) define("MODULE_PATH", APP_PATH.'/'.MODULE_DIR);
define("CONFIG_PATH", MODULE_PATH.'/'.CONFIG_DIR);
define("UPLOAD_PATH", APP_PATH.'/'.UPLOAD_DIR);

























?>