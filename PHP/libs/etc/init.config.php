<?php
/*
 * 常规配置文件
 * 
 * */

return array(
	//系统配置
	"SHOW_TIME"=>1,//显示运行时间
	"FONT"=>PHP_PATH.'/data/font/yahei.ttf',//字体
	"DEBUG"=>0,//是否开启调试模式
	"NOTICE_SHOW"=>1,//是否开启提示性错误
	"DEBUG_TPL"=>PHP_PATH.'./tpl/debug.tpl.php',//错误异常处理模板
	"ERROR_MESSAGE"=>"页面出错",//关闭调试模式显示内容
	"DEFAULT_TIMEZOBE_SET"=>"PRC",//默认时区
	//文件上传
	"UPLOAD_EXT_SIZE"=>array("jpg"=>"","jpeg"=>"","gif"=>"","bmp"=>"","txt"=>"","doc"=>"","rar"=>""),//文件上传类型及大小
	"UPLOAD_PATH"=>UPLOAD_PATH."/user/".date("Ymd"),//文件保存目录
	"UPLOAD_PATH_IMG"=>UPLOAD_PATH.'/img/'.date("Ymd"),//图片保存目录
	//"UPLOAD_THUMB_ON"=>1,//是否对上传文件开启缩略图
	//"UPLOAD_WATERMARK_ON"=>1,//是否对上传文件加水印
	//图像水印处理
	"WATER_ON"=>1,//水印是否开启
	"WATER_TYPE"=>1,//水印类型  1 为图片水印  0 为文字水印
	"WATER_IMG"=>PHP_PATH.'/data/water/water.png',//水印图片
	"WATER_POS"=>9,//水印位置
	"WATER_PCT"=>60,//水印透明度
	"WATER_QUALITY"=>80,//水印压缩比
	"WATER_TEXT"=>"后盾网PHP框架学习视频",//水印文字
	"WATER_TEXT_COLOR"=>"#000000",//水印文字颜色
	"WATER_TEXT_SIZE"=>13,//水印文字大小
	//缩略图处理
	"THUMB_ON"=>1,//是否开启缩略图
	"THUMB_PREFIX"=>"",//缩略图前缀
	"THUMB_ENDFIX"=>"_thumb",//缩略图后缀
	"THUMB_TYPE"=>1,//生成缩略图的方式  1固定宽度 高度自增  2固定高度 宽度自增  3固定宽度 高度裁切  4固定高度 宽度裁切  5缩放最大边
	"THUMB_WIDTH"=>250,//缩略图宽度
	"THUMB_HEIGHT"=>250,//缩略图高度
	"THUMB_PATH"=>UPLOAD_PATH.'/img/'.date("Ymd"),//缩略图保存目录
	//SESSION
	
	//验证码
	"CODE_STR"=>"0123456789abcdefghijklmnopqrstuvwxyz",//验证码字符串
	"CODE_WIDTH"=>80,//验证码宽度
	"CODE_HEIGHT"=>25,//验证码宽度
	"CODE_BG_COLOR"=>"#DCDCDC",//背景颜色
	"CODE_LEN"=>4,//长度
	"CODE_FONT_SIZE"=>18,//字体大小
	"CODE_FONT_COLOR"=>"#000000",//文字颜色
	"CODE"=>"code",//session变量
	//PATH_INFO
	"PATHINFO_DLI"=>"/",//PATHINFO分隔符
	"PATHINFO_VAR"=>"q",//兼容模式GET变量
	"PATHINFO_HTML"=>"html",//伪静态扩展名
	//日志处理
	"LOG_START"=>1,//日志是否开启
	"LOG_TYPE"=>array("SQL","NOTICE","ERROR"),//日志处理类型
	"LOG_SIZE"=>2000000,//日志文件大小
	//项目配置项
	"DEFAULT_MODULE"=>"index",
	"DEFAULT_CONTROL"=>"index",
	"DEFAULT_ACTION"=>"index",
	"CONTROL_FIX"=>"Control",
	"CLASS_FIX"=>".class",
	//全局变量
	"VAR_MODULE"=>"m",//模块变量
	"VAR_CONTROL"=>"c",//控制器变量
	"VAR_ACTION"=>"a",//动作变量
);




















?>