<?php
/*
 * ���������ļ�
 * 
 * */

return array(
	//ϵͳ����
	"SHOW_TIME"=>1,//��ʾ����ʱ��
	"FONT"=>PHP_PATH.'/data/font/yahei.ttf',//����
	"DEBUG"=>0,//�Ƿ�������ģʽ
	"NOTICE_SHOW"=>1,//�Ƿ�����ʾ�Դ���
	"DEBUG_TPL"=>PHP_PATH.'./tpl/debug.tpl.php',//�����쳣����ģ��
	"ERROR_MESSAGE"=>"ҳ�����",//�رյ���ģʽ��ʾ����
	"DEFAULT_TIMEZOBE_SET"=>"PRC",//Ĭ��ʱ��
	//�ļ��ϴ�
	"UPLOAD_EXT_SIZE"=>array("jpg"=>"","jpeg"=>"","gif"=>"","bmp"=>"","txt"=>"","doc"=>"","rar"=>""),//�ļ��ϴ����ͼ���С
	"UPLOAD_PATH"=>UPLOAD_PATH."/user/".date("Ymd"),//�ļ�����Ŀ¼
	"UPLOAD_PATH_IMG"=>UPLOAD_PATH.'/img/'.date("Ymd"),//ͼƬ����Ŀ¼
	//"UPLOAD_THUMB_ON"=>1,//�Ƿ���ϴ��ļ���������ͼ
	//"UPLOAD_WATERMARK_ON"=>1,//�Ƿ���ϴ��ļ���ˮӡ
	//ͼ��ˮӡ����
	"WATER_ON"=>1,//ˮӡ�Ƿ���
	"WATER_TYPE"=>1,//ˮӡ����  1 ΪͼƬˮӡ  0 Ϊ����ˮӡ
	"WATER_IMG"=>PHP_PATH.'/data/water/water.png',//ˮӡͼƬ
	"WATER_POS"=>9,//ˮӡλ��
	"WATER_PCT"=>60,//ˮӡ͸����
	"WATER_QUALITY"=>80,//ˮӡѹ����
	"WATER_TEXT"=>"�����PHP���ѧϰ��Ƶ",//ˮӡ����
	"WATER_TEXT_COLOR"=>"#000000",//ˮӡ������ɫ
	"WATER_TEXT_SIZE"=>13,//ˮӡ���ִ�С
	//����ͼ����
	"THUMB_ON"=>1,//�Ƿ�������ͼ
	"THUMB_PREFIX"=>"",//����ͼǰ׺
	"THUMB_ENDFIX"=>"_thumb",//����ͼ��׺
	"THUMB_TYPE"=>1,//��������ͼ�ķ�ʽ  1�̶���� �߶�����  2�̶��߶� �������  3�̶���� �߶Ȳ���  4�̶��߶� ��Ȳ���  5��������
	"THUMB_WIDTH"=>250,//����ͼ���
	"THUMB_HEIGHT"=>250,//����ͼ�߶�
	"THUMB_PATH"=>UPLOAD_PATH.'/img/'.date("Ymd"),//����ͼ����Ŀ¼
	//SESSION
	
	//��֤��
	"CODE_STR"=>"0123456789abcdefghijklmnopqrstuvwxyz",//��֤���ַ���
	"CODE_WIDTH"=>80,//��֤����
	"CODE_HEIGHT"=>25,//��֤����
	"CODE_BG_COLOR"=>"#DCDCDC",//������ɫ
	"CODE_LEN"=>4,//����
	"CODE_FONT_SIZE"=>18,//�����С
	"CODE_FONT_COLOR"=>"#000000",//������ɫ
	"CODE"=>"code",//session����
	//PATH_INFO
	"PATHINFO_DLI"=>"/",//PATHINFO�ָ���
	"PATHINFO_VAR"=>"q",//����ģʽGET����
	"PATHINFO_HTML"=>"html",//α��̬��չ��
	//��־����
	"LOG_START"=>1,//��־�Ƿ���
	"LOG_TYPE"=>array("SQL","NOTICE","ERROR"),//��־��������
	"LOG_SIZE"=>2000000,//��־�ļ���С
	//��Ŀ������
	"DEFAULT_MODULE"=>"index",
	"DEFAULT_CONTROL"=>"index",
	"DEFAULT_ACTION"=>"index",
	"CONTROL_FIX"=>"Control",
	"CLASS_FIX"=>".class",
	//ȫ�ֱ���
	"VAR_MODULE"=>"m",//ģ�����
	"VAR_CONTROL"=>"c",//����������
	"VAR_ACTION"=>"a",//��������
);




















?>