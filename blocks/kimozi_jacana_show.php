<?php
//  ------------------------------------------------------------------------ //
// 本模組由 kimozi 製作
// 製作日期：2009-07-25
// $Id:$
// ------------------------------------------------------------------------- //

//取得k_jacana_default所有資料陣列
function get_k_jacana_default_all(){
	global $xoopsDB;
	$sql = "select * from ".$xoopsDB->prefix("k_jacana_default");
	$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	while($data=$xoopsDB->fetchArray($result)){
		$d_period_sn=$data['d_period_sn'];
		$data_arr[$d_period_sn]=$data;
	}
	return $data_arr;
}


//區塊主函式 (最新線上預約一覽表(kimozi_jacana_show))
function kimozi_jacana_show($options){
	global $xoopsDB;
	$sql = "select * from ".$xoopsDB->prefix("k_jacana_order")."
	WHERE `o_organization` NOT LIKE '"._MA_ORGANIZATION_TITLE."'
	ORDER BY `o_date` DESC
	LIMIT 0 , {$options[0]}
	";
	$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	$block.="
	<table summary='list_table' id='tbl'  cellspacing='2' style='width:100%';>
	<tr style='text-align: left;background-color:#7FAAFF'>
	<th>"._MA_KIMOZIJACANA_O_BOOKING_DATE."</th>
	<th>"._MA_KIMOZIJACANA_O_PERIOD."</th>
	<th>"._MA_KIMOZIJACANA_O_ORGANIZATION."</th>
	<th>"._MA_KIMOZIJACANA_O_BOOKING_NUM."</th>	
	</tr>
	<tbody>";
	$o_period_array=get_k_jacana_default_all();
	while($all=$xoopsDB->fetchArray($result)){
	  //以下會產生這些變數： $order_sn , $o_date , $o_booking_date , $o_period , $o_booking_num , $o_organization , $o_contact , $o_tel , $o_fax , $o_cellphone , $o_email , $o_mark , $o_ok
    foreach($all as $k=>$v){
      $$k=$v;
    } 
   	$i++;
	$color=($i % 2)?"white":"#D0FF90";
	$block.="<tr style='background-color:{$color}'>
		<td>{$o_booking_date}</td>
		<td>{$o_period_array[$o_period]['d_period_start']}~{$o_period_array[$o_period]['d_period_end']}</td>
		<td>{$o_organization}</td>
		<td>{$o_booking_num}</td>
	</tr>";
	}	
	$block.="
	</tbody>
	</table>";
	
	return $block;
}

//選項
function kimozi_jacana_show_edit($options){

	$form="
	"._MB_KIMOZIJACANA_KIMOZI_JACANA_SHOW_EDIT_BITEM0."
	<INPUT type='text' name='options[0]' size=\"2\" maxlength=\"2\" value='{$options[0]}'>
	";
	return $form;
}

?>