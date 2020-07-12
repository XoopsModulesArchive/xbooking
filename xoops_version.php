<?php
//  ------------------------------------------------------------------------ //
// 本模組由 kimozi 製作
// 製作日期：2009-07-25
// $Id:$
// ------------------------------------------------------------------------- //

//---基本設定---//
//模組名稱
$modversion['name'] = _MI_KIMOZIJACANA_NAME;
//模組版次
$modversion['version']	= '1.02';
//模組作者
$modversion['author'] = _MI_KIMOZIJACANA_AUTHOR;
//模組說明
$modversion['description'] = _MI_KIMOZIJACANA_DESC;
//模組授權者
$modversion['credits']	= _MI_KIMOZIJACANA_CREDITS;
//模組版權
$modversion['license']		= "GPL";
//模組是否為官方發佈1，非官方2
$modversion['official']		= 2;
//模組圖示
$modversion['image']		= "images/logo.png";
//模組目錄名稱
$modversion['dirname']		= "xbooking";
//---資料表架構---//
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";
$modversion['tables'][1] = "xbooking_default";
$modversion['tables'][2] = "xbooking_order";
$modversion['tables'][3] = "xbooking_date";

//---管理介面設定---//
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

//---使用者主選單設定---//
$modversion['hasMain'] = 1;

//---樣板設定---//
$modversion['templates'][1]['file'] = 'index_tpl.html';
$modversion['templates'][1]['description'] = _MI_KIMOZIJACANA_TEMPLATE_DESC1;
//---區塊設定---//
$modversion['blocks'][1]['file'] = "kimozi_jacana_show.php";
$modversion['blocks'][1]['name'] = _MI_KIMOZIJACANA_BNAME2;
$modversion['blocks'][1]['description'] = _MI_KIMOZIJACANA_BDESC2;
$modversion['blocks'][1]['show_func'] = "kimozi_jacana_show";
$modversion['blocks'][1]['template'] = "kimozi_jacana_show.html";
$modversion['blocks'][1]['edit_func'] = "kimozi_jacana_show_edit";
$modversion['blocks'][1]['options'] = "5";

//---偏好設定---//
$modversion['config'][1]['name'] = 'day_for_bokking';
$modversion['config'][1]['title'] = '_MI_KIMOZIJACANA_KIMOZI_JACANA_BASIC_EDIT_DAY';
$modversion['config'][1]['description'] = '_MI_KIMOZIJACANA_KIMOZI_JACANA_BASIC_EDIT_DAY_CONTENT';
$modversion['config'][1]['formtype'] = 'textbox';
$modversion['config'][1]['valuetype'] = 'int';
$modversion['config'][1]['default'] = '6';
$modversion['config'][2]['name'] = 'mon_for_bokking';
$modversion['config'][2]['title'] = '_MI_KIMOZIJACANA_KIMOZI_JACANA_BASIC_EDIT_MON';
$modversion['config'][2]['description'] = '_MI_KIMOZIJACANA_KIMOZI_JACANA_BASIC_EDIT_MON_CONTENT';
$modversion['config'][2]['formtype'] = 'select';
$modversion['config'][2]['valuetype'] = 'int';
$modversion['config'][2]['default'] = '2';
$modversion['config'][2]['options'] = array(1=>1,2=>2,3=>3,4=>4,5=>5,6=>6,7=>7,8=>8,9=>9,10=>10,11=>11,12=>12);
?>