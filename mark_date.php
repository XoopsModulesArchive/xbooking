<?php
//  ------------------------------------------------------------------------ //
// 本模組由 kimozi 製作
// 製作日期：2009-07-14
// $Id:$
// ------------------------------------------------------------------------- //

/*-----------引入檔案區--------------*/
include "header.php";
$xoopsOption['template_main'] = "index_tpl.html";
/*-----------function區--------------*/

	//判斷是否有管理權限
	$dirname=$xoopsModule->getVar('dirname');
	$moduleperm_handler = & xoops_gethandler( 'groupperm' );
	if ( $xoopsUser) {
		if ($moduleperm_handler->checkRight( 'module_admin', $xoopsModule->getVar( 'mid' ), $xoopsUser->getGroups() ) ) {
			$admin_tools="<a href='".XOOPS_URL."/modules/{$dirname}/admin/index.php'>"._TO_ADMIN_PAGE."</a>";
		}
	}else{
		redirect_header( XOOPS_URL."/user.php",3, _MA_MARK_DATE_ADMIN_ATTION );
	}
	
	//判斷是否有管理權限END

//k_jacana_date編輯表單
function k_jacana_date_form($date_sn=""){
	global $xoopsDB,$xoopsModule,$xoopsUser;
	include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
	//include_once(XOOPS_ROOT_PATH."/class/xoopseditor/xoopseditor.php");
	
	//判斷是否有管理權限
	$dirname=$xoopsModule->getVar('dirname');
	$moduleperm_handler = & xoops_gethandler( 'groupperm' );
	if ( $xoopsUser) {
		if ($moduleperm_handler->checkRight( 'module_admin', $xoopsModule->getVar( 'mid' ), $xoopsUser->getGroups() ) ) {
			$admin_tools="<a href='".XOOPS_URL."/modules/{$dirname}/admin/index.php'>"._TO_ADMIN_PAGE."</a>";
		}
	}

	//抓取預設值
	if(!empty($date_sn)){
		$DBV=get_k_jacana_date($date_sn);
	}else{
		$DBV=array();
	}

	//預設值設定
	
	
	//設定「date_sn」欄位預設值
	$date_sn=(!isset($DBV['date_sn']))?"":$DBV['date_sn'];
	
	//設定「date_mark」欄位預設值
	$date_mark=(!isset($DBV['date_mark']))?"":$DBV['date_mark'];

	$op=(empty($date_sn))?"insert_k_jacana_date":"update_k_jacana_date";
	//$op="replace_k_jacana_date";
	
	$main="
	<link type='text/css' rel='stylesheet' href='".XOOPS_URL."/modules/kimozi_jacana/class/formValidator/style/validator.css'>
	<script src='".XOOPS_URL."/modules/kimozi_jacana/class/formValidator/jquery_last.js' type='text/javascript'></script>
	<script src='".XOOPS_URL."/modules/kimozi_jacana/class/formValidator/formValidator.js' type='text/javascript' charset='UTF-8'></script>
	<script src='".XOOPS_URL."/modules/kimozi_jacana/class/formValidator/formValidatorRegex.js' type='text/javascript' charset='UTF-8'></script>
	<script src='".XOOPS_URL."/modules/kimozi_jacana/class/formValidator/DateTimeMask.js' language='javascript' type='text/javascript'></script>
	<script type='text/javascript'>
	$(document).ready(function(){
	$.formValidator.initConfig({formid:'myForm',onerror:function(msg){alert(msg)}});
	
  

	//「休假日」欄位檢查
	$('#date_mark').focus(function(){
		WdatePicker({
			skin:'whyGreen',
			oncleared:function(){\$(this).blur();},
			onpicked:function(){\$(this).blur();}
		})
	}).formValidator({
		onshow:'".sprintf(_MD_INPUT_VALIDATOR,_MA_KIMOZIJACANA_DATE_MARK)."',
		onfocus:'"._MD_INPUT_VALIDATOR_NEED_NORMAL."',
		oncorrect:'OK!'
	}).inputValidator({
		min:'0000-00-00',
		type:'value',
		onerror:'".sprintf(_MD_INPUT_VALIDATOR_ERROR,_MA_KIMOZIJACANA_DATE_MARK)."'
	});
	});
	</script>
	<script defer='defer' src='".XOOPS_URL."/modules/kimozi_jacana/class/formValidator/datepicker/WdatePicker.js' type='text/javascript'></script>
	
	<form action='{$_SERVER['PHP_SELF']}' method='post' id='myForm' enctype='multipart/form-data'>
	<table class='form_tbl'>
  

	<!--休假日SN-->
	<input type='hidden' name='date_sn' value='{$date_sn}'>

	<!--休假日-->
	<tr><td class='title' nowrap>"._MA_KIMOZIJACANA_DATE_MARK."</td>
	<td class='col'><input type='text' name='date_mark' size='10' value='{$date_mark}' id='date_mark'></td><td class='col'><div id='date_markTip'></div></td></tr>
	<tr><td class='bar' colspan='3'>
	<input type='hidden' name='op' value='{$op}'>
	<input type='submit' value='"._MA_SAVE."'></td></tr>
	</table>
	</form>";

	//raised,corners,inset
	$main=div_3d(_MA_KIMOZIJACANA_DATE_MARK,$main,"raised");
  
	return $main;
}

//新增資料到k_jacana_date中
function insert_k_jacana_date(){
	global $xoopsDB,$xoopsUser;
	

	$sql = "insert into ".$xoopsDB->prefix("k_jacana_date")."
	(`date_mark`)
	values('{$_POST['date_mark']}')";
	$xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	
	//取得最後新增資料的流水編號
	$date_sn=$xoopsDB->getInsertId();
	return $date_sn;
}

//列出所有k_jacana_date資料
function list_k_jacana_date($show_function=1){
	global $xoopsDB,$xoopsModule,$xoopsUser;	
	$MDIR=$xoopsModule->getVar('dirname');
	$sql = "select * from ".$xoopsDB->prefix("k_jacana_date")." ORDER BY `date_mark` DESC";
	//PageBar(資料數, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
	$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	$total=$xoopsDB->getRowsNum($result);
	$navbar = new PageBar($total, 20, 10);
	$mybar = $navbar->makeBar();
	$bar= sprintf(_BP_TOOLBAR,$mybar['total'],$mybar['current'])."{$mybar['left']}{$mybar['center']}{$mybar['right']}";
	$sql.=$mybar['sql'];

	$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	
	$function_title=($show_function)?"<th>"._BP_FUNCTION."</th>":"";
	
	//刪除確認的JS
	$data="
	<script>
	function delete_k_jacana_date_func(date_sn){
		var sure = window.confirm('"._BP_DEL_CHK."');
		if (!sure)	return;
		location.href=\"{$_SERVER['PHP_SELF']}?op=delete_k_jacana_date&date_sn=\" + date_sn;
	}
	</script>
	
	<table summary='list_table' id='tbl' style='width:100%;'>
	<tr>
	<th>"._MA_KIMOZIJACANA_DATE_MARK."</th>
	$function_title</tr>
	<tbody>";
	
	while($all=$xoopsDB->fetchArray($result)){
	  //以下會產生這些變數： $date_sn , $date_mark
    foreach($all as $k=>$v){
      $$k=$v;
    }
    
		$fun=($show_function)?"
		<td>
		<a href='{$_SERVER['PHP_SELF']}?op=k_jacana_date_form&date_sn=$date_sn'><img src='".XOOPS_URL."/modules/{$MDIR}/images/edit.gif' alt='"._BP_EDIT."'></a>
		<a href=\"javascript:delete_k_jacana_date_func($date_sn);\"><img src='".XOOPS_URL."/modules/{$MDIR}/images/del.gif' alt='"._BP_DEL."'></a>
		</td>":"";
		
		$data.="<tr>
		<td>{$date_mark}</td>
		$fun
		</tr>";
	}
	
	$data.="
	<tr>
	<td colspan=2 class='bar'>
	<a href='{$_SERVER['PHP_SELF']}?op=k_jacana_date_form'><img src='".XOOPS_URL."/modules/{$MDIR}/images/add.gif' alt='"._BP_ADD."' align='right'></a>
	{$bar}</td></tr>
	</tbody>
	</table>";
	
	//raised,corners,inset
	$main=div_3d("",$data,"corners");
	
	return $main;
}


//以流水號取得某筆k_jacana_date資料
function get_k_jacana_date($date_sn=""){
	global $xoopsDB;
	if(empty($date_sn))return;
	$sql = "select * from ".$xoopsDB->prefix("k_jacana_date")." where date_sn='$date_sn'";
	$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	$data=$xoopsDB->fetchArray($result);
	return $data;
}

//更新k_jacana_date某一筆資料
function update_k_jacana_date($date_sn=""){
	global $xoopsDB,$xoopsUser;
	
	
	$sql = "update ".$xoopsDB->prefix("k_jacana_date")." set 
	 `date_mark` = '{$_POST['date_mark']}'
	where date_sn='$date_sn'";
	$xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	return $date_sn;
}

//刪除k_jacana_date某筆資料資料
function delete_k_jacana_date($date_sn=""){
	global $xoopsDB;
	$sql = "delete from ".$xoopsDB->prefix("k_jacana_date")." where date_sn='$date_sn'";
	$xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
}

//以流水號秀出某筆k_jacana_date資料內容
function show_one_k_jacana_date($date_sn=""){
	global $xoopsDB,$xoopsModule;
	if(empty($date_sn)){
		return;
	}else{
		$date_sn=intval($date_sn);
	}
	$sql = "select * from ".$xoopsDB->prefix("k_jacana_date")." where date_sn='{$date_sn}'";
	$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	$all=$xoopsDB->fetchArray($result);
	
	//以下會產生這些變數： $date_sn , $date_mark
	foreach($all as $k=>$v){
		$$k=$v;
	}
  
	$data="
	<table summary='list_table' id='tbl'>
	<tr><th>"._MA_KIMOZIJACANA_DATE_SN."</th><td>{$date_sn}</td></tr>
	<tr><th>"._MA_KIMOZIJACANA_DATE_MARK."</th><td>{$date_mark}</td></tr>
	</table>";
	
	//raised,corners,inset
	$main=div_3d("",$data,"corners");
	
	return $main;
}




/*-----------執行動作判斷區----------*/
$op=(empty($_REQUEST['op']))?"":$_REQUEST['op'];
switch($op){
	
	//更新資料
	case "update_k_jacana_date":
	update_k_jacana_date($_POST['date_sn']);
	header("location: {$_SERVER['PHP_SELF']}");
	break;
	
	//新增資料
	case "insert_k_jacana_date":
	insert_k_jacana_date();
	header("location: {$_SERVER['PHP_SELF']}");
	break;
	
	//輸入表格
	case "k_jacana_date_form":
	$main=k_jacana_date_form($_GET['date_sn']);
	break;
	
	//刪除資料
	case "delete_k_jacana_date":
	delete_k_jacana_date($_GET['date_sn']);
	header("location: {$_SERVER['PHP_SELF']}");
	break;
	
	//預設動作
	default:
	if(empty($_GET['date_sn'])){
		$main=list_k_jacana_date();
		//$main.=k_jacana_date_form($_GET['date_sn']);
	}else{
		$main=show_one_k_jacana_date($_GET['date_sn']);
	}
	break;
}

/*-----------秀出結果區--------------*/
include XOOPS_ROOT_PATH."/header.php";
$xoopsTpl->assign( "css" , "<link rel='stylesheet' type='text/css' media='screen' href='".XOOPS_URL."/modules/kimozi_jacana/module.css' />") ;
$xoopsTpl->assign( "toolbar" , toolbar($interface_menu)) ;
$xoopsTpl->assign( "content" , $main) ;
include_once XOOPS_ROOT_PATH.'/footer.php';

?>