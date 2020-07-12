<?php
//  ------------------------------------------------------------------------ //
// 本模組由 kimozi 製作
// 製作日期：2009-07-14
// $Id:$
// ------------------------------------------------------------------------- //

/*-----------引入檔案區--------------*/
include "../../../include/cp_header.php";
include "../function.php";

/*-----------function區--------------*/
//


//k_jacana_order編輯表單
function k_jacana_order_form($order_sn=""){
	global $xoopsDB,$xoopsUser;
	include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
	//include_once(XOOPS_ROOT_PATH."/class/xoopseditor/xoopseditor.php");

	//抓取預設值
	if(!empty($order_sn)){
		$DBV=get_k_jacana_order($order_sn);
	}else{
		$DBV=array();
	}

	//預設值設定
	
	
	//設定「order_sn」欄位預設值
	$order_sn=(!isset($DBV['order_sn']))?"":$DBV['order_sn'];
	
	//設定「o_date」欄位預設值
	$o_date=(!isset($DBV['o_date']))?date("Y-m-d H:i:s"):$DBV['o_date'];
	
	//設定「o_booking_date」欄位預設值
	$o_booking_date=(!isset($DBV['o_booking_date']))?"":$DBV['o_booking_date'];
	
	//設定「o_period」欄位預設值
	$o_period=(!isset($DBV['o_period']))?"":$DBV['o_period'];
	
	//設定「o_booking_num」欄位預設值
	$o_booking_num=(!isset($DBV['o_booking_num']))?"":$DBV['o_booking_num'];
	
	//設定「o_organization」欄位預設值
	$o_organization=(!isset($DBV['o_organization']))?"":$DBV['o_organization'];
	
	//設定「o_contact」欄位預設值
	$o_contact=(!isset($DBV['o_contact']))?"":$DBV['o_contact'];
	
	//設定「o_tel」欄位預設值
	$o_tel=(!isset($DBV['o_tel']))?"":$DBV['o_tel'];
	
	//設定「o_fax」欄位預設值
	$o_fax=(!isset($DBV['o_fax']))?"":$DBV['o_fax'];
	
	//設定「o_cellphone」欄位預設值
	$o_cellphone=(!isset($DBV['o_cellphone']))?"":$DBV['o_cellphone'];
	
	//設定「o_email」欄位預設值
	$o_email=(!isset($DBV['o_email']))?"":$DBV['o_email'];
	
	//設定「o_mark」欄位預設值
	$o_mark=(!isset($DBV['o_mark']))?"":$DBV['o_mark'];
	
	//設定「o_ok」欄位預設值
	$o_ok=(!isset($DBV['o_ok']))?"":$DBV['o_ok'];

	$op=(empty($order_sn))?"insert_k_jacana_order":"update_k_jacana_order";
	//$op="replace_k_jacana_order";
	$options=get_k_jacana_default_menu_options($o_period);
	$main="
	<link type='text/css' rel='stylesheet' href='".XOOPS_URL."/modules/kimozi_jacana/class/formValidator/style/validator.css'>
	<script src='".XOOPS_URL."/modules/kimozi_jacana/class/formValidator/jquery_last.js' type='text/javascript'></script>
	<script src='".XOOPS_URL."/modules/kimozi_jacana/class/formValidator/formValidator.js' type='text/javascript' charset='UTF-8'></script>
	<script src='".XOOPS_URL."/modules/kimozi_jacana/class/formValidator/formValidatorRegex.js' type='text/javascript' charset='UTF-8'></script>
	<script src='".XOOPS_URL."/modules/kimozi_jacana/class/formValidator/DateTimeMask.js' language='javascript' type='text/javascript'></script>
	<script type='text/javascript'>
	$(document).ready(function(){
	$.formValidator.initConfig({formid:'myForm',onerror:function(msg){alert(msg)}});  

	//「預定日期」欄位檢查
	$('#o_booking_date').focus(function(){
		WdatePicker({
			skin:'whyGreen',
			oncleared:function(){\$(this).blur();},
			onpicked:function(){\$(this).blur();}
		})
	}).formValidator({
		onshow:'".sprintf(_MD_INPUT_VALIDATOR,_MA_KIMOZIJACANA_O_BOOKING_DATE)."',
		onfocus:'"._MD_INPUT_VALIDATOR_NEED."',
		oncorrect:'OK!'
	}).inputValidator({
		min:'0000-00-00',
		type:'value',
		onerror:'".sprintf(_MD_INPUT_VALIDATOR_ERROR,_MA_KIMOZIJACANA_O_BOOKING_DATE)."'
	});

	//「預定人數」欄位檢查
	$('#o_booking_num').formValidator({
		onshow:'".sprintf(_MD_INPUT_VALIDATOR,_MA_KIMOZIJACANA_O_BOOKING_NUM)."',
		onfocus:'".sprintf(_MD_INPUT_VALIDATOR_CHK,'1','3')."',
		oncorrect:'OK!'
	}).inputValidator({
		min:1,
		max:3,
		onerror:'".sprintf(_MD_INPUT_VALIDATOR_ERROR,_MA_KIMOZIJACANA_O_BOOKING_NUM)."'
	});

	//「聯絡人」欄位檢查
	$('#o_contact').formValidator({
		onshow:'".sprintf(_MD_INPUT_VALIDATOR,_MA_KIMOZIJACANA_O_CONTACT)."',
		onfocus:'".sprintf(_MD_INPUT_VALIDATOR_MIN,'1')."',
		oncorrect:'OK!'
	}).inputValidator({
		min:1,
		onerror:'".sprintf(_MD_INPUT_VALIDATOR_ERROR,_MA_KIMOZIJACANA_O_CONTACT)."'
	});

	//「手機」欄位檢查
	$('#o_cellphone').formValidator({
		onshow:'".sprintf(_MD_INPUT_VALIDATOR,_MA_KIMOZIJACANA_O_CELLPHONE)."',
		onfocus:'".sprintf(_MD_INPUT_VALIDATOR_MIN,'1')."',
		oncorrect:'OK!'
	}).inputValidator({
		min:1,
		onerror:'".sprintf(_MD_INPUT_VALIDATOR_ERROR,_MA_KIMOZIJACANA_O_CELLPHONE)."'
	});

	//「Email」欄位檢查
	$('#o_email').formValidator({
		onshow:'".sprintf(_MD_INPUT_VALIDATOR,_MA_KIMOZIJACANA_O_EMAIL)."',
		onfocus:'".sprintf(_MD_INPUT_VALIDATOR_MIN,'1')."',
		oncorrect:'OK!'
	}).inputValidator({
		min:1,
		onerror:'".sprintf(_MD_INPUT_VALIDATOR_ERROR,_MA_KIMOZIJACANA_O_EMAIL)."'
	});
	});
	</script>
	<script defer='defer' src='".XOOPS_URL."/modules/kimozi_jacana/class/formValidator/datepicker/WdatePicker.js' type='text/javascript'></script>
	
	<form action='{$_SERVER['PHP_SELF']}' method='post' id='myForm' enctype='multipart/form-data'>
	<table class='form_tbl'>
  

	<!--預訂單ID-->
	<input type='hidden' name='order_sn' value='{$order_sn}'>

	<!--預定日期-->
	<tr><td class='title' nowrap>"._MA_KIMOZIJACANA_O_BOOKING_DATE."</td>
	<td class='col'><input type='text' name='o_booking_date' size='20' value='{$o_booking_date}' id='o_booking_date'></td><td class='col'><div id='o_booking_dateTip'></div></td></tr>

	<!--預定時段-->
	<tr><td class='title' nowrap>"._MA_KIMOZIJACANA_O_PERIOD."</td>
	<td class='col'><select name='o_period' size=1>
		<!--option value='' ".chk($o_period,$options,'1','selected')."></option-->
		{$options}
	</select></td><td class='col'><div id='o_periodTip'></div></td></tr>

	<!--預定人數-->
	<tr><td class='title' nowrap>"._MA_KIMOZIJACANA_O_BOOKING_NUM."</td>
	<td class='col'><input type='text' name='o_booking_num' size='3' value='{$o_booking_num}' id='o_booking_num'></td><td class='col'><div id='o_booking_numTip'></div></td></tr>

	<!--單位名稱-->
	<tr><td class='title' nowrap>"._MA_KIMOZIJACANA_O_ORGANIZATION."</td>
	<td class='col'><input type='text' name='o_organization' size='20' value='{$o_organization}' id='o_organization'></td><td class='col'><div id='o_organizationTip'></div></td></tr>

	<!--聯絡人-->
	<tr><td class='title' nowrap>"._MA_KIMOZIJACANA_O_CONTACT."</td>
	<td class='col'><input type='text' name='o_contact' size='10' value='{$o_contact}' id='o_contact'></td><td class='col'><div id='o_contactTip'></div></td></tr>

	<!--電話-->
	<tr><td class='title' nowrap>"._MA_KIMOZIJACANA_O_TEL."</td>
	<td class='col'><input type='text' name='o_tel' size='20' value='{$o_tel}' id='o_tel'></td><td class='col'><div id='o_telTip'></div></td></tr>

	<!--傳真-->
	<tr><td class='title' nowrap>"._MA_KIMOZIJACANA_O_FAX."</td>
	<td class='col'><input type='text' name='o_fax' size='20' value='{$o_fax}' id='o_fax'></td><td class='col'><div id='o_faxTip'></div></td></tr>

	<!--手機-->
	<tr><td class='title' nowrap>"._MA_KIMOZIJACANA_O_CELLPHONE."</td>
	<td class='col'><input type='text' name='o_cellphone' size='20' value='{$o_cellphone}' id='o_cellphone'></td><td class='col'><div id='o_cellphoneTip'></div></td></tr>

	<!--Email-->
	<tr><td class='title' nowrap>"._MA_KIMOZIJACANA_O_EMAIL."</td>
	<td class='col'><input type='text' name='o_email' size='20' value='{$o_email}' id='o_email'></td><td class='col'><div id='o_emailTip'></div></td></tr>

	<!--其他事項-->
	<tr><td class='title' nowrap>"._MA_KIMOZIJACANA_O_MARK."</td>
	<td class='col'><textarea name='o_mark' cols='50' rows=8 id='o_mark'>{$o_mark}</textarea></td><td class='col'><div id='o_markTip'></div></td></tr>

	<!--接受預約-->
	<tr><td class='title' nowrap>"._MA_KIMOZIJACANA_O_OK."</td>
	<td class='col'>
	<input type='radio' name='o_ok' id='o_ok' value='0' ".chk($o_ok,'0').">"._MA_KIMOZIJACANA_O_OK_NO."
	<input type='radio' name='o_ok' id='o_ok' value='1' ".chk($o_ok,'1').">"._MA_KIMOZIJACANA_O_OK_YES."</td><td class='col'><div id='o_okTip'></div></td></tr>
	<tr><td class='bar' colspan='3'>
	<input type='hidden' name='op' value='{$op}'>
	<input type='submit' value='"._MA_SAVE."'></td></tr>
	</table>
	</form>";

	//raised,corners,inset
	$main=div_3d(_MA_INPUT_FORM,$main,"raised");  
	return $main;
}

//取得k_jacana_default分類選單的選項（單層選單）
function get_k_jacana_default_menu_options($default_kinds_sn="0"){
	global $xoopsDB,$xoopsModule;
	$sql = "select * from ".$xoopsDB->prefix("k_jacana_default")." 
	WHERE `d_switch` = '1'
	order by `d_period_start`
	";
	$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	$option=""; 
   	while(list($d_period_sn,$d_period_start,$d_period_end)=$xoopsDB->fetchRow($result)){
 		$selected=($d_period_sn==$default_kinds_sn)?"selected=selected":"";
		$option.="<option value=$d_period_sn $selected>{$d_period_start}~{$d_period_end}</option>";
	}
	return $option;
}


//列出所有k_jacana_order資料
function list_k_jacana_order($show_function=1){
	global $xoopsDB,$xoopsModule;
	$MDIR=$xoopsModule->getVar('dirname');
	
	//接收是否有查詢的要求
	$post_where="";
	if(!empty($_POST['o_booking_date']) or !empty($_POST['o_period']) or !empty($_POST['o_organization']) or !empty($_POST['o_contact']) or !empty($_POST['o_cellphone'])){
		if(!empty($_POST['o_booking_date'])){$array_where[o_booking_date]=$_POST['o_booking_date'];}
		if(!empty($_POST['o_period'])){$array_where[o_period]=$_POST['o_period'];}
		if(!empty($_POST['o_organization'])){$array_where[o_organization]=$_POST['o_organization'];}
		if(!empty($_POST['o_contact'])){$array_where[o_contact]=$_POST['o_contact'];}
		if(!empty($_POST['o_cellphone'])){$array_where[o_cellphone]=$_POST['o_cellphone'];}
		$count=count($array_where);
		$i=1;		
		foreach($array_where as $k => $v){
			if($i==1){
				$post_where.=" WHERE `{$k}` like '%{$v}%'";				
				$i++;
			}elseif($i<=$count){
				$post_where.=" AND `{$k}` like '%{$v}%'";				
				$i++;
			}
		}
	}
	$sql = "select * from ".$xoopsDB->prefix("k_jacana_order")."
	{$post_where}
	ORDER BY `o_booking_date` DESC , `o_period` ASC
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
	$options=get_k_jacana_default_menu_options();
	
	$data="
	<script src='".XOOPS_URL."/modules/kimozi_jacana/class/formValidator/jquery_last.js' type='text/javascript'></script>
	<script src='".XOOPS_URL."/modules/kimozi_jacana/class/formValidator/formValidator.js' type='text/javascript' charset='UTF-8'></script>
	<script type='text/javascript'>
	$(document).ready(function(){
		
	//隱藏進階說明
	$('#show_admin_attention').hide();
	$('#show_admin_attention_worker').click(function(){
		if ($('#show_admin_attention').is(':visible')) {
			$('#show_admin_attention').slideUp();
			} else{
				$('#show_admin_attention').slideDown();}
				});
		
	//「預定日期」月曆物件
	$('#o_booking_date').focus(function(){
		WdatePicker({
			skin:'whyGreen',
			oncleared:function(){\$(this).blur();},
			onpicked:function(){\$(this).blur();}
		})
	});
	});
	</script>
	<script defer='defer' src='".XOOPS_URL."/modules/kimozi_jacana/class/formValidator/datepicker/WdatePicker.js' type='text/javascript'></script>
	";	
	//搜尋特定團體
	$data.="
	<form action='{$_SERVER['PHP_SELF']}' method='post' id='myForm' enctype='multipart/form-data'>
		<p>"._MA_KIMOZIJACANA_O_BOOKING_DATE."：
		<input name=\"o_booking_date\" type=\"text\" id=\"o_booking_date\" size=\"10\" maxlength=\"10\" />
		　　"._MA_KIMOZIJACANA_O_PERIOD."：
		<select name=\"o_period\" id=\"o_period\">
		<option value=\"\"></option>
		{$options}
		</select>
		　　"._MA_KIMOZIJACANA_O_ORGANIZATION."：
		<input name=\"o_organization\" type=\"text\" id=\"o_organization\" />
		　　"._MA_KIMOZIJACANA_O_CONTACT."：
		<input name=\"o_contact\" type=\"text\" id=\"o_contact\" size=\"10\" maxlength=\"20\" />
		　　"._MA_KIMOZIJACANA_O_CELLPHONE."：
		<input name=\"o_cellphone\" type=\"text\" id=\"o_cellphone\" size=\"10\" maxlength=\"15\" />
		<input type='hidden' name='op' value='list_k_jacana_order'>
		　　<input type=\"submit\" name=\"Submit\" value=\""._MA_ADMIN_BOOKING_SUBMIT."\" />
		</p>
	</form>
	";
	
	//刪除確認的JS
	$data.="
	<script>
	function delete_k_jacana_order_func(order_sn){
		var sure = window.confirm('"._BP_DEL_CHK."');
		if (!sure)	return;
		location.href=\"{$_SERVER['PHP_SELF']}?op=delete_k_jacana_order&order_sn=\" + order_sn;
	}
	</script>
	
	<table summary='list_table' id='tbl' style='width:100%;'>
	<tr>
	<th>"._MA_KIMOZIJACANA_O_BOOKING_DATE."</th>
	<th>"._MA_KIMOZIJACANA_O_PERIOD."</th>
	<th>"._MA_KIMOZIJACANA_O_BOOKING_NUM."</th>
	<th>"._MA_KIMOZIJACANA_O_ORGANIZATION."</th>
	<th>"._MA_KIMOZIJACANA_O_CONTACT."</th>
	<th>"._MA_KIMOZIJACANA_O_CELLPHONE."</th>
	<th>"._MA_KIMOZIJACANA_O_EMAIL."</th>
	$function_title</tr>
	<tbody>";
	$o_period_array=get_k_jacana_default_all();
	while($all=$xoopsDB->fetchArray($result)){
	  //以下會產生這些變數： $order_sn , $o_date , $o_booking_date , $o_period , $o_booking_num , $o_organization , $o_contact , $o_tel , $o_fax , $o_cellphone , $o_email , $o_mark , $o_ok
    foreach($all as $k=>$v){
      $$k=$v;
    }    
		$fun=($show_function)?"
		<td>
		<a href='{$_SERVER['PHP_SELF']}?op=k_jacana_order_form&order_sn=$order_sn'><img src='".XOOPS_URL."/modules/{$MDIR}/images/edit.gif' alt='"._BP_EDIT."'></a>
		<a href=\"javascript:delete_k_jacana_order_func($order_sn);\"><img src='".XOOPS_URL."/modules/{$MDIR}/images/del.gif' alt='"._BP_DEL."'></a>
		</td>":"";
		
		$data.="<tr>
		<td>{$o_booking_date}</td>
		<td>{$o_period_array[$o_period]['d_period_start']}~{$o_period_array[$o_period]['d_period_end']}</td>
		<td>{$o_booking_num}</td>
		<td>{$o_organization}</td>
		<td>{$o_contact}</td>
		<td>{$o_cellphone}</td>
		<td>{$o_email}</td>
		$fun
		</tr>";
	}
	
	$data.="
	<tr>
	<td class='bar'>
	<input type=\"button\" value=\""._MA_SHOW_ADMIN_ATTENTION_WORKER."\" id=\"show_admin_attention_worker\" />
	</td>	
	<td colspan=7 class='bar'>
	<a href='{$_SERVER['PHP_SELF']}?op=k_jacana_order_form'><img src='".XOOPS_URL."/modules/{$MDIR}/images/add.gif' alt='"._BP_ADD."' align='right'></a>
	{$bar}</td>
	</tr>
	<tr>
	<td colspan=8 class='bar' style='text-align: left;font-size: 14px;'>
	<div id=\"show_admin_attention\">	
	"._MA_ADMIN_BOOKING_ATTENTION."	
	</div>
	</td>
	</tr>	
	</tbody>
	</table>";
	
	//raised,corners,inset
	$main=div_3d("",$data,"corners");
	
	return $main;
}


//以流水號取得某筆k_jacana_order資料
function get_k_jacana_order($order_sn=""){
	global $xoopsDB;
	if(empty($order_sn))return;
	$sql = "select * from ".$xoopsDB->prefix("k_jacana_order")." where order_sn='$order_sn'";
	$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	$data=$xoopsDB->fetchArray($result);
	return $data;
}

//更新k_jacana_order某一筆資料
function update_k_jacana_order($order_sn=""){
	global $xoopsDB,$xoopsUser;
	
	
	$sql = "update ".$xoopsDB->prefix("k_jacana_order")." set 
	 `o_date` = now() , 
	 `o_booking_date` = '{$_POST['o_booking_date']}' , 
	 `o_period` = '{$_POST['o_period']}' , 
	 `o_booking_num` = '{$_POST['o_booking_num']}' , 
	 `o_organization` = '{$_POST['o_organization']}' , 
	 `o_contact` = '{$_POST['o_contact']}' , 
	 `o_tel` = '{$_POST['o_tel']}' , 
	 `o_fax` = '{$_POST['o_fax']}' , 
	 `o_cellphone` = '{$_POST['o_cellphone']}' , 
	 `o_email` = '{$_POST['o_email']}' , 
	 `o_mark` = '{$_POST['o_mark']}' , 
	 `o_ok` = '{$_POST['o_ok']}'
	where order_sn='$order_sn'";
	$xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	return $order_sn;
}

//刪除k_jacana_order某筆資料資料
function delete_k_jacana_order($order_sn=""){
	global $xoopsDB;
	$sql = "delete from ".$xoopsDB->prefix("k_jacana_order")." where order_sn='$order_sn'";
	$xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
}

//以流水號秀出某筆k_jacana_order資料內容
function show_one_k_jacana_order($order_sn=""){
	global $xoopsDB,$xoopsModule;
	if(empty($order_sn)){
		return;
	}else{
		$order_sn=intval($order_sn);
	}
	$sql = "select * from ".$xoopsDB->prefix("k_jacana_order")." where order_sn='{$order_sn}'";
	$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	$all=$xoopsDB->fetchArray($result);
	
	//以下會產生這些變數： $order_sn , $o_date , $o_booking_date , $o_period , $o_booking_num , $o_organization , $o_contact , $o_tel , $o_fax , $o_cellphone , $o_email , $o_mark , $o_ok
	foreach($all as $k=>$v){
		$$k=$v;
	}
  
	$data="
	<table summary='list_table' id='tbl'>
	<tr><th>"._MA_KIMOZIJACANA_ORDER_SN."</th><td>{$order_sn}</td></tr>
	<tr><th>"._MA_KIMOZIJACANA_O_DATE."</th><td>{$o_date}</td></tr>
	<tr><th>"._MA_KIMOZIJACANA_O_BOOKING_DATE."</th><td>{$o_booking_date}</td></tr>
	<tr><th>"._MA_KIMOZIJACANA_O_PERIOD."</th><td>{$o_period}</td></tr>
	<tr><th>"._MA_KIMOZIJACANA_O_BOOKING_NUM."</th><td>{$o_booking_num}</td></tr>
	<tr><th>"._MA_KIMOZIJACANA_O_ORGANIZATION."</th><td>{$o_organization}</td></tr>
	<tr><th>"._MA_KIMOZIJACANA_O_CONTACT."</th><td>{$o_contact}</td></tr>
	<tr><th>"._MA_KIMOZIJACANA_O_TEL."</th><td>{$o_tel}</td></tr>
	<tr><th>"._MA_KIMOZIJACANA_O_FAX."</th><td>{$o_fax}</td></tr>
	<tr><th>"._MA_KIMOZIJACANA_O_CELLPHONE."</th><td>{$o_cellphone}</td></tr>
	<tr><th>"._MA_KIMOZIJACANA_O_EMAIL."</th><td>{$o_email}</td></tr>
	<tr><th>"._MA_KIMOZIJACANA_O_MARK."</th><td>{$o_mark}</td></tr>
	<tr><th>"._MA_KIMOZIJACANA_O_OK."</th><td>{$o_ok}</td></tr>
	</table>";
	
	//raised,corners,inset
	$main=div_3d("",$data,"corners");
	
	return $main;
}


//自動取得k_jacana_order的最新排序
function k_jacana_order_max_sort(){
	global $xoopsDB;
	$sql = "select max(`o_booking_date`) from ".$xoopsDB->prefix("k_jacana_order");
	$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	list($sort)=$xoopsDB->fetchRow($result);
	return ++$sort;
}

//k_jacana_order禁止時段表單
function k_jacana_order_interdiction_form(){
	global $xoopsDB,$xoopsUser;
	include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
	$options=get_k_jacana_default_menu_options($o_period);
	$uname=$xoopsUser->getVar('uname');
	$main="
	<link type='text/css' rel='stylesheet' href='".XOOPS_URL."/modules/kimozi_jacana/class/formValidator/style/validator.css'>
	<script src='".XOOPS_URL."/modules/kimozi_jacana/class/formValidator/jquery_last.js' type='text/javascript'></script>
	<script src='".XOOPS_URL."/modules/kimozi_jacana/class/formValidator/formValidator.js' type='text/javascript' charset='UTF-8'></script>
	<script src='".XOOPS_URL."/modules/kimozi_jacana/class/formValidator/formValidatorRegex.js' type='text/javascript' charset='UTF-8'></script>
	<script src='".XOOPS_URL."/modules/kimozi_jacana/class/formValidator/DateTimeMask.js' language='javascript' type='text/javascript'></script>
	<script type='text/javascript'>
	$(document).ready(function(){
	$.formValidator.initConfig({formid:'myForm',onerror:function(msg){alert(msg)}});  

	//「預定日期」欄位檢查
	$('#o_booking_date').focus(function(){
		WdatePicker({
			skin:'whyGreen',
			oncleared:function(){\$(this).blur();},
			onpicked:function(){\$(this).blur();}
		})
	}).formValidator({
		onshow:'".sprintf(_MD_INPUT_VALIDATOR,_MA_KIMOZIJACANA_O_BOOKING_DATE)."',
		onfocus:'"._MD_INPUT_VALIDATOR_NEED."',
		oncorrect:'OK!'
	}).inputValidator({
		min:'0000-00-00',
		type:'value',
		onerror:'".sprintf(_MD_INPUT_VALIDATOR_ERROR,_MA_KIMOZIJACANA_O_BOOKING_DATE)."'
	});
	});
	</script>
	<script defer='defer' src='".XOOPS_URL."/modules/kimozi_jacana/class/formValidator/datepicker/WdatePicker.js' type='text/javascript'></script>
	
	<form action='{$_SERVER['PHP_SELF']}' method='post' id='myForm' enctype='multipart/form-data'>
	<table class='form_tbl'>
  
	<!--預定日期-->
	<tr><td class='title' nowrap>"._MA_KIMOZIJACANA_O_BOOKING_DATE."</td>
	<td class='col'><input type='text' name='o_booking_date' size='20' value='{$o_booking_date}' id='o_booking_date'></td><td class='col'><div id='o_booking_dateTip'></div></td></tr>

	<!--預定時段-->
	<tr><td class='title' nowrap>"._MA_KIMOZIJACANA_O_PERIOD."</td>
	<td class='col'><select name='o_period' size=1>
		{$options}
	</select></td><td class='col'><div id='o_periodTip'></div></td></tr>

	<!--單位名稱-->
	<input type='hidden' name='o_organization' value='"._MA_ORGANIZATION_TITLE."'>

	<!--聯絡人-->
	<input type='hidden' name='o_contact' value='"._MA_ORGANIZATION_ADMIN."({$uname})'>

	<!--接受預約-->
	<input type='hidden' name='o_ok' value='1'>	
	
	<tr><td class='bar' colspan='3'>
	<input type='hidden' name='op' value='insert_k_jacana_order'>
	<input type='hidden' name='action' value='interdiction_form'>
	<input type='submit' value='"._MA_SAVE."'></td></tr>
	</table>
	</form>";

	//raised,corners,inset
	$main=div_3d(_MA_ORGANIZATION_DIV_TITLE,$main,"raised");
  
	return $main;
}


/*-----------執行動作判斷區----------*/
$op = (!isset($_REQUEST['op']))? "":$_REQUEST['op'];

switch($op){
	
	//禁止預約（時段）
	case "k_jacana_order_interdiction_form":
	$main=k_jacana_order_interdiction_form();
	break;
	
	//取得選單內容
	case "get_k_jacana_default_menu_options":
	get_k_jacana_default_menu_options();
	break;
		
	//更新資料
	case "update_k_jacana_order":
	update_k_jacana_order($_POST['order_sn']);
	header("location: {$_SERVER['PHP_SELF']}");
	break;
	
	//新增資料
	case "insert_k_jacana_order"://@function.php
	insert_k_jacana_order();
	header("location: {$_SERVER['PHP_SELF']}");
	break;

	//輸入表格
	case "k_jacana_order_form":
	$main=k_jacana_order_form($_GET['order_sn']);
	break;
	
	//刪除資料
	case "delete_k_jacana_order":
	delete_k_jacana_order($_GET['order_sn']);
	header("location: {$_SERVER['PHP_SELF']}");
	break;
	
	//預設動作
	default:
	if(empty($_GET['order_sn'])){
		$main=list_k_jacana_order();
		//$main.=k_jacana_order_form($_GET['order_sn']);
	}else{
		$main=show_one_k_jacana_order($_GET['order_sn']);
	}
	break;

}

/*-----------秀出結果區--------------*/
xoops_cp_header();
echo "<link rel='stylesheet' type='text/css' media='screen' href='../module.css' />";
echo menu_interface();
echo $main;
xoops_cp_footer();

?>