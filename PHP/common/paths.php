<?php
//���ÿ�ܵ�Ŀ¼�ṹ
define("CACHE_DIR", "cache");//����Ŀ¼
define("LOG_DIR", "log");//��־Ŀ¼
define("TPL_DIR", "tpl");//ģ�����Ŀ¼
define("CONFIG_DIR", "config");//����Ŀ¼
define("TEMPLETE_DIR", "templete");//��ͼĿ¼
define("MODULE_DIR", "module");//ģ��Ŀ¼
define("UPLOAD_DIR", "upload");//�ϴ�Ŀ¼

define("CACHE_PATH", TEMP_PATH.'/'.CACHE_DIR);
define("LOG_PATH", TEMP_PATH.'/'.LOG_DIR);
define("TPL_PATH", TEMP_PATH.'/'.TPL_DIR);
define("TEMPLETE_PATH", APP_PATH.'/'.TEMPLETE_DIR);
if(!defined("MODULE_PATH")) define("MODULE_PATH", APP_PATH.'/'.MODULE_DIR);
define("CONFIG_PATH", MODULE_PATH.'/'.CONFIG_DIR);
define("UPLOAD_PATH", APP_PATH.'/'.UPLOAD_DIR);

























?>