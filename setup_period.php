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

//k_jacana_default編輯表單
function k_jacana_default_form($d_period_sn=""){
	global $xoopsDB,$xoopsUser;
	include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
	//include_once(XOOPS_ROOT_PATH."/class/xoopseditor/xoopseditor.php");

	//抓取預設值
	if(!empty($d_period_sn)){
		$DBV=get_k_jacana_default($d_period_sn);
	}else{
		$DBV=array();
	}

	//預設值設定	
	//設定「d_period_sn」欄位預設值
	$d_period_sn=(!isset($DBV['d_period_sn']))?"":$DBV['d_period_sn'];	
	//設定「d_period_start」欄位預設值
	$d_period_start=(!isset($DBV['d_period_start']))?"":$DBV['d_period_start'];	
	//設定「d_period_end」欄位預設值
	$d_period_end=(!isset($DBV['d_period_end']))?"":$DBV['d_period_end'];	
	//設定「d_total_num」欄位預設值
	$d_total_num=(!isset($DBV['d_total_num']))?"":$DBV['d_total_num'];	
	//設定「d_switch」欄位預設值
	$d_switch=(!isset($DBV['d_switch']))?"1":$DBV['d_switch'];
	$op=(empty($d_period_sn))?"insert_k_jacana_default":"update_k_jacana_default";
	//$op="replace_k_jacana_default";
	
	$main="
	<link type='text/css' rel='stylesheet' href='".XOOPS_URL."/modules/kimozi_jacana/class/formValidator/style/validator.css'>
	<script src='".XOOPS_URL."/modules/kimozi_jacana/class/formValidator/jquery_last.js' type='text/javascript'></script>
	<script src='".XOOPS_URL."/modules/kimozi_jacana/class/formValidator/formValidator.js' type='text/javascript' charset='UTF-8'></script>
	<script src='".XOOPS_URL."/modules/kimozi_jacana/class/formValidator/formValidatorRegex.js' type='text/javascript' charset='UTF-8'></script>
	<script src='".XOOPS_URL."/modules/kimozi_jacana/class/formValidator/DateTimeMask.js' language='javascript' type='text/javascript'></script>
	<script type='text/javascript'>
	$(document).ready(function(){
	$.formValidator.initConfig({formid:'myForm',onerror:function(msg){alert(msg)}});	
  

	//「時段起點」欄位檢查
	$('#d_period_start').formValidator({
		onshow:'".sprintf(_MD_INPUT_VALIDATOR,_MA_KIMOZIJACANA_D_PERIOD_START)."',
		onfocus:'".sprintf(_MD_INPUT_VALIDATOR_EQUAL,'4')."',
		oncorrect:'OK!'
	}).inputValidator({
		min:4,
		max:4,
		onerror:'".sprintf(_MD_INPUT_VALIDATOR_ERROR,_MA_KIMOZIJACANA_D_PERIOD_START)."'
	});

	//「時段結束」欄位檢查
	$('#d_period_end').formValidator({
		onshow:'".sprintf(_MD_INPUT_VALIDATOR,_MA_KIMOZIJACANA_D_PERIOD_END)."',
		onfocus:'".sprintf(_MD_INPUT_VALIDATOR_EQUAL,'5')."',
		oncorrect:'OK!'
	}).inputValidator({
		min:4,
		max:5,
		onerror:'".sprintf(_MD_INPUT_VALIDATOR_ERROR,_MA_KIMOZIJACANA_D_PERIOD_END)."'
	});

	//「限量人數」欄位檢查
	$('#d_total_num').formValidator({
		onshow:'".sprintf(_MD_INPUT_VALIDATOR,_MA_KIMOZIJACANA_D_TOTAL_NUM)."',
		onfocus:'".sprintf(_MD_INPUT_VALIDATOR_CHK,'1','3')."',
		oncorrect:'OK!'
	}).inputValidator({
		min:1,
		max:3,
		onerror:'".sprintf(_MD_INPUT_VALIDATOR_ERROR,_MA_KIMOZIJACANA_D_TOTAL_NUM)."'
	});
	});
	</script>
	<script defer='defer' src='".XOOPS_URL."/modules/kimozi_jacana/class/formValidator/datepicker/WdatePicker.js' type='text/javascript'></script>
	
	<form action='{$_SERVER['PHP_SELF']}' method='post' id='myForm' enctype='multipart/form-data'>
	<table class='form_tbl'>
  

	<!--時段設定ID-->
	<input type='hidden' name='d_period_sn' value='{$d_period_sn}'>

	<!--時段起點-->
	<tr><td class='title' nowrap>"._MA_KIMOZIJACANA_D_PERIOD_START."</td>
	<td class='col'><input type='text' name='d_period_start' size='4' value='{$d_period_start}' id='d_period_start'></td><td class='col'><div id='d_period_startTip'></div></td></tr>

	<!--時段結束-->
	<tr><td class='title' nowrap>"._MA_KIMOZIJACANA_D_PERIOD_END."</td>
	<td class='col'><input type='text' name='d_period_end' size='4' value='{$d_period_end}' id='d_period_end'></td><td class='col'><div id='d_period_endTip'></div></td></tr>

	<!--限量人數-->
	<tr><td class='title' nowrap>"._MA_KIMOZIJACANA_D_TOTAL_NUM."</td>
	<td class='col'><input type='text' name='d_total_num' size='3' value='{$d_total_num}' id='d_total_num'></td><td class='col'><div id='d_total_numTip'></div></td></tr>

	<!--關閉作用-->
	<tr><td class='title' nowrap>"._MA_KIMOZIJACANA_D_SWITCH."</td>
	<td class='col'>
	<input type='radio' name='d_switch' id='d_switch' value='0' ".chk($d_switch,'0').">"._MA_CLOSE."
	<input type='radio' name='d_switch' id='d_switch' value='1' ".chk($d_switch,'1','1').">"._MA_ACTIVE."</td><td class='col'><div id='d_switchTip'></div></td></tr>
	<tr><td class='bar' colspan='3'>
	<input type='hidden' name='op' value='{$op}'>
	<input type='submit' value='"._MA_SAVE."'></td></tr>
	</table>
	</form>";

	//raised,corners,inset
	$main=div_3d(_MA_SETUP_PERIOD_FORM,$main,"raised");
  
	return $main;
}



//新增資料到k_jacana_default中
function insert_k_jacana_default(){
	global $xoopsDB,$xoopsUser;
	$sql = "insert into ".$xoopsDB->prefix("k_jacana_default")."
	(`d_period_start` , `d_period_end` , `d_total_num` , `d_switch`)
	values('{$_POST['d_period_start']}' , '{$_POST['d_period_end']}' , '{$_POST['d_total_num']}' , '{$_POST['d_switch']}')";
	$xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());

	//取得最後新增資料的流水編號
	$d_period_sn=$xoopsDB->getInsertId();
	return $d_period_sn;
}

//列出所有k_jacana_default資料
function list_k_jacana_default($show_function=1){
	global $xoopsDB,$xoopsModule;
	$MDIR=$xoopsModule->getVar('dirname');
	$sql = "select * from ".$xoopsDB->prefix("k_jacana_default")."
	ORDER BY `d_period_start` ASC
	";

	//PageBar(資料數, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
	$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	$total=$xoopsDB->getRowsNum($result);

	$navbar = new PageBar($total, 20, 10);
	$mybar = $navbar->makeBar();
	$bar= sprintf(_BP_TOOLBAR,$mybar['total'],$mybar['current'])."{$mybar['left']}{$mybar['center']}{$mybar['right']}";
	$sql.=$mybar['sql'];

	$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());

	$function_title=($show_function)?"<th>"._BP_FUNCTION."</th>":"";

	$data="
	<table summary='list_table' id='tbl' style='width:100%;'>
	<tr>
	<th>"._MA_KIMOZIJACANA_D_PERIOD_START."</th>
	<th>"._MA_KIMOZIJACANA_D_PERIOD_END."</th>
	<th>"._MA_KIMOZIJACANA_D_TOTAL_NUM."</th>
	<th>"._MA_KIMOZIJACANA_D_SWITCH."</th>
	$function_title</tr>
	<tbody>";
	while($all=$xoopsDB->fetchArray($result)){
	  //以下會產生這些變數： $d_period_sn , $d_period_start , $d_period_end , $d_total_num , $d_switch
    foreach($all as $k=>$v){
      $$k=$v;
    }
		$d_switch=($d_switch==0)?"<span style=\"color: #808080;\">"._MA_SAVE."</span>":"<span style=\"color: #FF0000;\">"._MA_ACTIVE."</span>";
		$fun=($show_function)?"
		<td>
		<a href='{$_SERVER['PHP_SELF']}?op=k_jacana_default_form&d_period_sn=$d_period_sn'><img src='".XOOPS_URL."/modules/{$MDIR}/images/edit.gif' title='"._BP_EDIT."' alt='"._BP_EDIT."'></a>
		<a href='{$_SERVER['PHP_SELF']}?op=switch_k_jacana_default&d_period_sn=$d_period_sn'><img src='".XOOPS_URL."/modules/{$MDIR}/images/unable.gif' title='"._BP_SWITCH."' alt='"._BP_SWITCH."'></a>
		</td>":"";

		$data.="<tr>
		<td>{$d_period_start}</td>
		<td>{$d_period_end}</td>
		<td>{$d_total_num}</td>
		<td>{$d_switch}</td>
		$fun
		</tr>";
	}

	$data.="
	<tr>
	<td colspan=5 class='bar'>
	<a href='{$_SERVER['PHP_SELF']}?op=k_jacana_default_form'><img src='".XOOPS_URL."/modules/{$MDIR}/images/add.gif' alt='"._BP_ADD."' align='right'></a>
	{$bar}</td></tr>
	</tbody>
	</table>";

	//raised,corners,inset
	$main=div_3d(_MA_SETUP_PERIOD_FORM,$data,"corners");

	return $main;
}


//以流水號取得某筆k_jacana_default資料
function get_k_jacana_default($d_period_sn=""){
	global $xoopsDB;
	if(empty($d_period_sn))return;
	$sql = "select * from ".$xoopsDB->prefix("k_jacana_default")." where d_period_sn='$d_period_sn'";
	$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	$data=$xoopsDB->fetchArray($result);
	return $data;
}

//更新k_jacana_default某一筆資料
function update_k_jacana_default($d_period_sn=""){
	global $xoopsDB,$xoopsUser;


	$sql = "update ".$xoopsDB->prefix("k_jacana_default")." set
	 `d_period_start` = '{$_POST['d_period_start']}' ,
	 `d_period_end` = '{$_POST['d_period_end']}' ,
	 `d_total_num` = '{$_POST['d_total_num']}' ,
	 `d_switch` = '{$_POST['d_switch']}'
	where d_period_sn='$d_period_sn'";
	$xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	return $d_period_sn;
}

//取得k_jacana_default所有資料陣列
function get_k_jacana_default_ture_all(){
	global $xoopsDB;
	$sql = "select * from ".$xoopsDB->prefix("k_jacana_default");
	$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	while($data=$xoopsDB->fetchArray($result)){
		$d_period_sn=$data['d_period_sn'];
		$data_arr[$d_period_sn]=$data;
	}
	return $data_arr;
}


//關閉或開啟時段的作用k_jacana_default
function switch_k_jacana_default($d_period_sn=""){
	global $xoopsDB,$xoopsUser;
	//判斷原始的狀況與以更改
	$k_jacana=get_k_jacana_default_ture_all();
	if($k_jacana[$d_period_sn]['d_switch']== 0 ){
		$d_switch='1';
	}else{
		$d_switch='0';
	}
	$sql = "update ".$xoopsDB->prefix("k_jacana_default")." set
	 `d_switch` = '{$d_switch}'
	where d_period_sn='$d_period_sn'";
	$xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	return $d_period_sn;
}


//刪除k_jacana_default某筆資料資料
function delete_k_jacana_default($d_period_sn=""){
	global $xoopsDB;
	$sql = "delete from ".$xoopsDB->prefix("k_jacana_default")." where d_period_sn='$d_period_sn'";
	$xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
}

//以流水號秀出某筆k_jacana_default資料內容
function show_one_k_jacana_default($d_period_sn=""){
	global $xoopsDB,$xoopsModule;
	if(empty($d_period_sn)){
		return;
	}else{
		$d_period_sn=intval($d_period_sn);
	}
	$sql = "select * from ".$xoopsDB->prefix("k_jacana_default")." where d_period_sn='{$d_period_sn}'";
	$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	$all=$xoopsDB->fetchArray($result);

	//以下會產生這些變數： $d_period_sn , $d_period_start , $d_period_end , $d_total_num , $d_switch
	foreach($all as $k=>$v){
		$$k=$v;
	}

	$data="
	<table summary='list_table' id='tbl'>
	<tr><th>"._MA_KIMOZIJACANA_D_PERIOD_SN."</th><td>{$d_period_sn}</td></tr>
	<tr><th>"._MA_KIMOZIJACANA_D_PERIOD_START."</th><td>{$d_period_start}</td></tr>
	<tr><th>"._MA_KIMOZIJACANA_D_PERIOD_END."</th><td>{$d_period_end}</td></tr>
	<tr><th>"._MA_KIMOZIJACANA_D_TOTAL_NUM."</th><td>{$d_total_num}</td></tr>
	<tr><th>"._MA_KIMOZIJACANA_D_SWITCH."</th><td>{$d_switch}</td></tr>
	</table>";

	//raised,corners,inset
	$main=div_3d("",$data,"corners");

	return $main;
}

/*-----------執行動作判斷區----------*/
$op=(empty($_REQUEST['op']))?"":$_REQUEST['op'];

switch($op){
	
	//更新資料
	case "update_k_jacana_default":
	update_k_jacana_default($_POST['d_period_sn']);
	header("location: {$_SERVER['PHP_SELF']}");
	break;
	
	//更新資料
	case "switch_k_jacana_default":
	switch_k_jacana_default(intval($_GET['d_period_sn']));
	header("location: {$_SERVER['PHP_SELF']}");
	break;
	
	//新增資料
	case "insert_k_jacana_default":
	insert_k_jacana_default();
	header("location: {$_SERVER['PHP_SELF']}");
	break;
	
	//輸入表格
	case "k_jacana_default_form":
	$main=k_jacana_default_form($_GET['d_period_sn']);
	break;
	
	//刪除資料
	case "delete_k_jacana_default":
	delete_k_jacana_default($_GET['d_period_sn']);
	header("location: {$_SERVER['PHP_SELF']}");
	break;
	
	//預設動作
	default:
	if(empty($_GET['d_period_sn'])){
		$main=list_k_jacana_default();
		//$main.=k_jacana_default_form($_GET['d_period_sn']);
	}else{
		$main=show_one_k_jacana_default($_GET['d_period_sn']);
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