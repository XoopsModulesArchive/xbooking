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

//k_jacana_order編輯表單
function k_jacana_order_form($order_sn=""){
	global $xoopsDB,$xoopsUser;
	include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
	//include_once(XOOPS_ROOT_PATH."/class/xoopseditor/xoopseditor.php");
	if(!empty($_POST['can_order_period'])){
		if($_POST['booking_num'] > $_POST['can_order_period']){
			echo "<script>alert('"._MA_ALERT_1.$_POST['can_order_period']._MA_ALERT_2."');history.go(-1);</script>";
		}elseif(empty($_POST['booking_num']) or $_POST['booking_num']== 0 ){
			echo "<script>alert('"._MA_ALERT_3."');history.go(-1);</script>";
		}
	}
	//取得預約時段資料
	$booking_period=get_k_jacana_default_all();//@function.php
	$d_period_sn=$_POST['d_period_sn'];
	$main="
	<link type='text/css' rel='stylesheet' href='".XOOPS_URL."/modules/kimozi_jacana/class/formValidator/style/validator.css'>
	<script src='".XOOPS_URL."/modules/kimozi_jacana/class/formValidator/jquery_last.js' type='text/javascript'></script>
	<script src='".XOOPS_URL."/modules/kimozi_jacana/class/formValidator/formValidator.js' type='text/javascript' charset='UTF-8'></script>
	<script src='".XOOPS_URL."/modules/kimozi_jacana/class/formValidator/formValidatorRegex.js' type='text/javascript' charset='UTF-8'></script>
	<script src='".XOOPS_URL."/modules/kimozi_jacana/class/formValidator/DateTimeMask.js' language='javascript' type='text/javascript'></script>
	<script type='text/javascript'>
	$(document).ready(function(){
	$.formValidator.initConfig({formid:'myForm',onerror:function(msg){alert(msg)}});


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
	
	$('#agree').formValidator({
		onshow: '"._MA_FORM_ONSHOW."',
		onfocus:'"._MA_FORM_ONSHOW."',
		oncorrect:'"._MA_FORM_ONSHOW."'
	}).inputValidator({
		min:1,
		onerror:'"._MA_FORM_ONSHOW."'
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
	<td class='col' colspan='2'>{$_POST['order_date']}
	</td></tr>

	<!--預定時段-->
	<tr><td class='title' nowrap>"._MA_KIMOZIJACANA_O_PERIOD."</td>
	<td class='col' colspan='2'>{$booking_period[$d_period_sn]['d_period_start']}～{$booking_period[$d_period_sn]['d_period_end']}</td></tr>

	<!--預定人數-->
	<tr><td class='title' nowrap>"._MA_KIMOZIJACANA_O_BOOKING_NUM."</td>
	<td class='col' colspan='2'>{$_POST['booking_num']}</td></tr>

	<!--單位名稱-->
	<tr><td class='title' nowrap>"._MA_KIMOZIJACANA_O_ORGANIZATION."</td>
	<td class='col'><input type='text' name='o_organization' size='20' value='{$o_organization}' id='o_organization'></td><td class='col'><div id='o_organizationTip'></div></td></tr>

	<!--聯絡人-->
	<tr><td class='title' nowrap>"._MA_KIMOZIJACANA_O_CONTACT."</td>
	<td class='col'><input type='text' name='o_contact' size='10' value='{$o_contact}' id='o_contact'></td><td class='col'><div id='o_contactTip'></div></td></tr>

	<!--電話-->
	<tr><td class='title' nowrap>"._MA_KIMOZIJACANA_O_TEL."</td>
	<td class='col'><input type='text' name='o_tel' size='20' value='{$o_tel}' id='o_tel'></td><td class='col'></td></tr>

	<!--傳真-->
	<tr><td class='title' nowrap>"._MA_KIMOZIJACANA_O_FAX."</td>
	<td class='col'><input type='text' name='o_fax' size='20' value='{$o_fax}' id='o_fax'></td><td class='col'></td></tr>

	<!--手機-->
	<tr><td class='title' nowrap>"._MA_KIMOZIJACANA_O_CELLPHONE."</td>
	<td class='col'><input type='text' name='o_cellphone' size='20' value='{$o_cellphone}' id='o_cellphone'></td><td class='col'><div id='o_cellphoneTip'></div></td></tr>

	<!--Email-->
	<tr><td class='title' nowrap>"._MA_KIMOZIJACANA_O_EMAIL."</td>
	<td class='col'><input type='text' name='o_email' size='20' value='{$o_email}' id='o_email'></td><td class='col'><div id='o_emailTip'></div></td></tr>

	<!--其他事項-->
	<tr><td class='title' nowrap>"._MA_KIMOZIJACANA_O_MARK."</td>
	<td class='col' colspan='2'><textarea name='o_mark' cols='50' rows=8 id='o_mark'>{$o_mark}</textarea></td></tr>

	<!--接受預約-->
	<input type='hidden' name='o_ok' value='{$o_ok}'>
	
	<!--同意保有接受預約的權力-->		
	<tr>
	<td class='col'colspan='2'>
	<input type='checkbox' name='agree' value='agree' id='agree'>"._MA_FORM_AGREE."
	</td>
	<td class='col'><div id='agreeTip'></div></td>
	</tr>
	
	<tr><td class='bar' colspan='3'>
	<input type='hidden' name='op' value='insert_k_jacana_order'>
	<input type='hidden' name='o_booking_date' value='{$_POST['order_date']}'>
	<input type='hidden' name='o_period' value='{$d_period_sn}'>
	<input type='hidden' name='o_booking_num' value='{$_POST['booking_num']}'>
	<input type='submit' value='"._MA_SEND."'></td></tr>
	</table>
	</form>";

	//raised,corners,inset
	$main=div_3d(_MA_KIMOZIJACANA_ORDER_INPUT,$main,"raised");
  
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

function count_booking_num(){
	global $xoopsDB;
	$sql = "select SUM(d_total_num) as totle from ".$xoopsDB->prefix("k_jacana_default")." 
	WHERE `d_switch` = '1'";
	$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	while($all=$xoopsDB->fetchArray($result)){
    foreach($all as $k=>$v){
      $$k=$v;
    }
	}
	return $totle;    
}

//取得k_jacana_date所有資料陣列
function get_k_jacana_date_mark(){
	global $xoopsDB,$xoopsModuleConfig;
	$min_day=date('Y-m-d',mktime(0, 0, 0, date('m') , date('d')+$xoopsModuleConfig['day_for_bokking'], date('Y')));//計算最初開放預約日
	$sql = "select * from ".$xoopsDB->prefix("k_jacana_date")." WHERE `date_mark` > '$min_day'";
	$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	while($data=$xoopsDB->fetchArray($result)){
		//$date_sn=$data['date_sn'];
		//$data_arr[$date_sn]=$data;
		$data_arr[]=$data['date_mark'];
	}
	return $data_arr;
}

//查詢所有k_jacana_order資料
function step_k_jacana_order_calendar(){
	global $xoopsDB,$xoopsModuleConfig;
	$num=count_booking_num();//抓取每天可接受預約人數	
	
	$min_day=date('Y-m-d',mktime(0, 0, 0, date('m') , date('d')+$xoopsModuleConfig['day_for_bokking'], date('Y')));//計算最初開放預約日
	
	$max_day=date('Y-m-d',mktime(0, 0, 0, date('m')+$xoopsModuleConfig['mon_for_bokking'] , date('d')+$xoopsModuleConfig['day_for_bokking'], date('Y')));//取得最末開放預約日	
	
	$mark_day=get_k_jacana_date_mark();//抓取設定休園日期
	
	
	// Array ( [0] => 2009-08-15 [1] => 2009-08-30 ) 	
	$sql = "select A.`o_booking_date` , 
	SUM(A.`o_booking_num`) as totle 
	FROM ".$xoopsDB->prefix("k_jacana_order")." AS A
	LEFT JOIN ".$xoopsDB->prefix("k_jacana_default")." AS B
	ON A.o_period=B.d_period_sn
	WHERE B.`d_switch`= '1'
	AND A.`o_booking_date` >= '".$min_day."' 
	AND A.`o_booking_date` <= '".$max_day."'
	GROUP BY A.`o_booking_date`
	ORDER BY A.`o_booking_date` ASC
	";
	
	$show_day=$min_day;
	$order_list="
	<style type='text/css'>
	#calendar {
		width: 600px;
		margin: 0 auto;
		}
	</style>
<link rel='stylesheet' type='text/css' href='".XOOPS_URL."/modules/kimozi_jacana/class/fullcalendar/fullcalendar.css' />
	<script type='text/javascript' src='".XOOPS_URL."/modules/kimozi_jacana/class/jquery/jquery.js'></script>
	<script type='text/javascript' src='".XOOPS_URL."/modules/kimozi_jacana/class/jquery/ui.core.js'></script>
	<script type='text/javascript' src='".XOOPS_URL."/modules/kimozi_jacana/class/jquery/ui.draggable.js'></script>
	<script type='text/javascript' src='".XOOPS_URL."/modules/kimozi_jacana/class/fullcalendar/fullcalendar_us.js'></script>
	
	<script type='text/javascript'>
			$(document).ready(function() {
				var d = new Date();
				var y = d.getFullYear();
				var m = d.getMonth();
				
				$('#calendar').fullCalendar({
					draggable: false,

					events: [";
	$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	$o_booking_date=$min_day;
	while(list($o_booking_date , $totle)=$xoopsDB->fetchRow($result)){
	  /*以下會產生這些變數：$o_booking_date , $totle*/
 		$booking_arr[$o_booking_date]=$totle;
	}
	
	
	$min_day_time=strtotime($min_day);
	$max_day_time=strtotime($max_day);
	$show_day_time=$min_day_time;
	$i=1;
	while($show_day_time <= $max_day_time){
	
	  $show_day=date("Y-m-d",$show_day_time);
	  //預約人數
	  $booking_num=$booking_arr[$show_day];
	  //可預約人數
	  $can_booking_num=$num-$booking_num;
	  
	  //當天有人預約了，計算剩餘人數與如果已經超過可預約的一半人數，則顯示黃色警戒
	  if($can_booking_num <= 0){
      $className='full';
		}elseif($can_booking_num < ($num/2)){
      $className='order_yellow';
		}else{
      $className='order_green';
		}
	  
		if(in_array($show_day,$mark_day)){
			$order_list.="
			 {
				id: {$i},
				title: \""._MA_ALERT_NOOPEN."\",
				start: \"{$show_day}\",
				className: \"full\"},";
		}else{
			$order_list.="
				{
				id: {$i},
				title: \"{$can_booking_num}\",
				start: \"{$show_day}\",
				className: \"{$className}\",
				url: \"{$_SERVER['PHP_SELF']}?op=step2&order_date={$show_day}\"},";
		}
		$sd=explode("-",$show_day);
		$show_day_time=mktime(0,0,0,$sd[1],$sd[2]+1,$sd[0]);
		$i++;
	}

	$order_list=substr($order_list,0,-1);
	$order_list.="
		]
		});
		});
		</script>
		<br>
		"._MA_DATA_PERIOD."：{$min_day}～{$max_day}
		<div id='calendar'></div>
		<div style='margin-left: 20px;'>
		<br><br>
		<table width=\"0\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
			<tr>
				<td>"._MA_TD_STAR."</td>
				<td>"._MA_ATTION_1."</td>
			</tr>
			<tr><td>　</td><td></td></tr>			
			<tr>
				<td width=\"30\" bgcolor=\"#00ff7f\">&nbsp;</td>
				<td>&nbsp;&nbsp;"._MA_ATTION_OK."</td>
			</tr>
			<tr><td>　</td><td></td></tr>
			<tr>
				<td bgcolor=\"Yellow\"></td>
				<td>&nbsp;&nbsp;"._MA_ATTION_HALF."</td>
			</tr>
			<tr><td>　</td><td></td></tr>
			<tr>
				<td bgcolor=\"Red\">&nbsp;</td>
				<td>&nbsp;&nbsp;"._MA_ATTION_FULL."</td>
			</tr>			
		</table>
		</div>
	";
	return $order_list;
}

//顯示每時段可預約人數
function step_k_jacana_order_period() {
	global $xoopsDB,$xoopsModule;
	$order_date=$_GET['order_date'];	
	$data="<p>"._MA_PERIOD_DATE."：{$order_date}</p>";
	$period_num=find_k_jacana_o_date($order_date);//取得各時段人數總計，@function.php
	$sql = "select * from ".$xoopsDB->prefix("k_jacana_default")." 
	WHERE `d_switch` = '1'
	ORDER BY `d_period_start` ASC ";
	$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	$data.="
	<table summary='list_table' id='tbl' style='width:100%;'>
	<tr>
		<th>"._MA_KIMOZIJACANA_D_PERIOD_START."</th>
		<th>"._MA_KIMOZIJACANA_D_PERIOD_END."</th>
		<th>"._MA_PERIOD_REMAIN_MUN."</th>
		<th>"._MA_PERIOD_BOOKING_NUM."</th>
		<th>"._MA_PERIOD_SEND."</th>
	</tr>
	<tbody>";	
	while($all=$xoopsDB->fetchArray($result)){
	  //以下會產生這些變數： $d_period_sn , $d_period_start , $d_period_end , $d_total_num
    foreach($all as $k=>$v){
      $$k=$v;
    }
    $can_order_period=$d_total_num-$period_num[$d_period_sn];
    if($can_order_period <= 0 ){
    		$can_order_period=_MA_PERIOD_NO;
    		$booking_num="<td></td>
			<td>
			</td>";
		}else{
			$booking_num="
				<td>
				<div>
				<form action='{$_SERVER['PHP_SELF']}' method='post' enctype='multipart/form-data'>
				<input type=\"text\" size=\"3\" maxlength=\"3\" name=\"booking_num\" id=\"booking_num\"/>
				<input type='hidden' name='op' value='k_jacana_order_form'>
				<input type='hidden' name='order_date' value='$order_date'>
				<input type='hidden' name='d_period_sn' value='$d_period_sn'>
				<input type='hidden' name='can_order_period' value='$can_order_period'>
				</td>
				<td>
				<input type='submit' value='"._MA_SUBMIT."'>
				</td>
				</form>
				</div>								
				";
		}
		$data.="		
			<tr>
				<td>{$d_period_start}</td>
				<td>{$d_period_end}</td>
				<td>{$can_order_period}</td>
				{$booking_num}
			</tr>
		";
	}
	
	$data.="
	<tr>
		<td colspan=5 class='bar' style='text-align: left;'>
		"._MA_PERIOD_ATTION_1."<br>
		"._MA_PERIOD_ATTION_2."		
		</td>
	</tr>	
	</tbody>
	</table>";
	
	//raised,corners,inset
	$main=div_3d(_MA_PERIOD_TIME ,$data,"corners");
	
	return $main;
}


/*-----------執行動作判斷區----------*/
$op=(empty($_REQUEST['op']))?"":$_REQUEST['op'];

switch($op){
	
	//更新資料
	case "update_k_jacana_order":
	update_k_jacana_order($_POST['order_sn']);
	header("location: {$_SERVER['PHP_SELF']}");
	break;
	
	//新增資料
	case "insert_k_jacana_order": //@function.php
	insert_k_jacana_order();
	redirect_header( XOOPS_URL ,5,_MA_SWITCH_OK);
	break;

	//秀出預約單
	case "k_jacana_order_form":
	$main=k_jacana_order_form($_GET['order_sn']);
	break;
	
	//預約時段
	case "step2":
	//$main=show_step(2);
	$main=step_k_jacana_order_period();
	break;
	
	//預設動作，預約一覽表（月曆）
	default:
	//$main=show_step(1);
	$main=step_k_jacana_order_calendar();
	break;	
	

}

/*-----------秀出結果區--------------*/
include XOOPS_ROOT_PATH."/header.php";
$xoopsTpl->assign( "css" , "<link rel='stylesheet' type='text/css' media='screen' href='".XOOPS_URL."/modules/kimozi_jacana/module.css' />") ;
$xoopsTpl->assign( "toolbar" , toolbar($interface_menu)) ;
$xoopsTpl->assign( "content" , $main) ;
include_once XOOPS_ROOT_PATH.'/footer.php';

?>
