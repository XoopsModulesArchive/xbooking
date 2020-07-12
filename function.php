<?php
//  ------------------------------------------------------------------------ //
// 本模組由 kimozi 製作
// 製作日期：2009-07-14
// $Id:$
// ------------------------------------------------------------------------- //

//新增資料到k_jacana_order中
function insert_k_jacana_order(){
	global $xoopsDB,$xoopsUser;
	$o_booking_num=$_POST['o_booking_num'];
	//取得目前報名人數
	$period_num=find_k_jacana_o_date($_POST['o_booking_date'],$_POST['o_period']);
	//取得該時段可預約總數
	$d_total_num=get_k_jacana_default_all();//@function.php
		
	//處理禁止預約時段-開始
	if($_POST['action']=='interdiction_form'){		
		$o_booking_num=$d_total_num[$_POST['o_period']][d_total_num]-$period_num[$_POST['o_period']];	
	}
	//處理禁止預約時段-end
	
	//檢查是否可以寫入
	if($o_booking_num+$period_num[$_POST['o_period']] > $d_total_num[$_POST['o_period']][d_total_num]){
			redirect_header($_SERVER['PHP_SELF'],8, _FUNCTION_MESSAGE_SORRY);
		}
	$sql = "insert into ".$xoopsDB->prefix("k_jacana_order")."
	(`o_date` , `o_booking_date` , `o_period` , `o_booking_num` , `o_organization` , `o_contact` , `o_tel` , `o_fax` , `o_cellphone` , `o_email` , `o_mark` , `o_ok`)
	values(now() , '{$_POST['o_booking_date']}' , '{$_POST['o_period']}' , '{$o_booking_num}' , '{$_POST['o_organization']}' , '{$_POST['o_contact']}' , '{$_POST['o_tel']}' , '{$_POST['o_fax']}' , '{$_POST['o_cellphone']}' , '{$_POST['o_email']}' , '{$_POST['o_mark']}' , '{$_POST['o_ok']}')";
	$xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	
	//取得最後新增資料的流水編號
	$order_sn=$xoopsDB->getInsertId();
	return $order_sn;
}

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


//取得同一天各時段，目前報名資訊，k_jacana_order
function find_k_jacana_o_date($order_date="",$o_period=""){
	global $xoopsDB;
	if(!empty($o_period)){
		$o_period="AND `o_period`='{$o_period}'";
	}
	$sql = "select `o_period`, SUM(o_booking_num) as total_num from ".$xoopsDB->prefix("k_jacana_order")."
	WHERE `o_booking_date`='{$order_date}'
	{$o_period}
	GROUP BY `o_period`
	";
	$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	while($all=$xoopsDB->fetchArray($result)){
	  /*
	  以下會產生這些變數：$o_period , $total_num
	   $order_sn , $o_date , $o_booking_date , $o_period , $o_booking_num , $o_organization , $o_contact , $o_tel , $o_fax , $o_cellphone , $o_email , $o_mark , $o_ok	  
	  */
	  
    foreach($all as $k=>$v){
      $$k=$v;
    }
    $period_num[$o_period]=$total_num;
	}
	
	return $period_num;
}

/********************* 預設函數 *********************/
//圓角文字框
function div_3d($title="",$main="",$kind="raised",$style=""){
	$main="<table style='width:auto;{$style}'><tr><td>
	<div class='{$kind}'>
	<h1>$title</h1>
	<b class='b1'></b><b class='b2'></b><b class='b3'></b><b class='b4'></b>
	<div class='boxcontent'>
 	$main
	</div>
	<b class='b4b'></b><b class='b3b'></b><b class='b2b'></b><b class='b1b'></b>
	</div>
	</td></tr></table>";
	return $main;
}




//管理介面的選單
function menu_interface($show=1){
//global $xoopsModule,$xoopsModuleConfig;
    global $xoopsModule, $xoopsConfig;

	include XOOPS_ROOT_PATH.'/modules/news/config.php';
	if(empty($show))return;
	$dirname=$xoopsModule->getVar('dirname');
//hack mamba	
if (file_exists(XOOPS_ROOT_PATH . '/modules/{$dirname}/language/' . $xoopsConfig['language'] . '/modinfo.php')) {
		include_once XOOPS_ROOT_PATH. '/modules/{$dirname}/language/' . $xoopsConfig['language'] . '/modinfo.php';
	} else {
        include_once("".XOOPS_ROOT_PATH."/modules/{$dirname}/language/english/modinfo.php");		
	}

//	include_once("".XOOPS_ROOT_PATH."/modules/{$dirname}/language/tchinese/modinfo.php");
//end hack mamba
	include("menu.php");
	$page=explode("/",$_SERVER['PHP_SELF']);
	$n=sizeof($page)-1;
	if(is_array($adminmenu)){
		foreach($adminmenu as $m){
			$td="<a href='".XOOPS_URL."/modules/{$dirname}/{$m['link']}'>{$m['title']}</a>";
		}
	}else{
		$td="<td></td>";
	}
	$main="
	<style type='text/css'>
	#admtool{
		margin-bottom:10px;
	}
	#admtool a:link, #admtool a:visited {
		font-size: 12px;
		background-image: url(".XOOPS_URL."/modules/{$dirname}/images/bbg.jpg);
		margin-right: 0px;
		padding: 3px 10px 2px 10px;
		color: rgb(80,80,80);
		background-color: #FCE6EA;
		text-decoration: none;
		border-top: 1px solid #FFFFFF;
		border-left: 1px solid #FFFFFF;
		border-bottom: 1px solid #717171;
		border-right: 1px solid #717171;
	}
	#admtool a:hover {
		background-image: url(".XOOPS_URL."/modules/{$dirname}/images/bbg2.jpg);
		color: rgb(255,0,128);
		border-top: 1px solid #717171;
		border-left: 1px solid #717171;
		border-bottom: 1px solid #FFFFFF;
		border-right: 1px solid #FFFFFF;
	}
	</style>
	<div id='admtool'>{$td}<a href='".XOOPS_URL."/modules/{$dirname}/'>"._BACK_MODULES_PAGE."</a>
	</div>";
	return $main;
}

//首頁的連結工具
function toolbar($interface_menu=array()){
	global $xoopsModule,$xoopsModuleConfig,$xoopsUser;
	if(empty($interface_menu))return;
	$dirname=$xoopsModule->getVar('dirname');
	$moduleperm_handler = & xoops_gethandler( 'groupperm' );
	//判斷是否有管理權限
	if ( $xoopsUser) {
		if ($moduleperm_handler->checkRight( 'module_admin', $xoopsModule->getVar( 'mid' ), $xoopsUser->getGroups() ) ) {
			$admin_tools="<a href='".XOOPS_URL."/modules/{$dirname}/admin/index.php'>"._TO_ADMIN_PAGE."</a>";
		}
	}
	if(is_array($interface_menu)){
		foreach($interface_menu as $title => $url){
			$td="<a href='".XOOPS_URL."/modules/{$dirname}/{$url}'>{$title}</a>";
		}
	}else{
		return;
	}
	$main="
	<style type='text/css'>
	#toolbar{
		margin-bottom:10px;
	}
	#toolbar a:link, #toolbar a:visited {
		font-size: 11px;
		background-image: url(".XOOPS_URL."/modules/{$dirname}/images/bbg.jpg);
		margin-right: 0px;
		padding: 3px 10px 2px 10px;
		color: rgb(80,80,80);
		background-color: #FCE6EA;
		text-decoration: none;
		border-top: 1px solid #FFFFFF;
		border-left: 1px solid #FFFFFF;
		border-bottom: 1px solid #717171;
		border-right: 1px solid #717171;
	}
	#toolbar a:hover {
		background-image: url(".XOOPS_URL."/modules/{$dirname}/images/bbg2.jpg);
		color: rgb(255,0,128);
		border-top: 1px solid #717171;
		border-left: 1px solid #717171;
		border-bottom: 1px solid #FFFFFF;
		border-right: 1px solid #FFFFFF;
	}
	</style>
	<div id='toolbar'>{$td}{$admin_tools}</div>";
	return $main;
}

//單選回復原始資料函數
function chk($DBV="",$NEED_V="",$default="",$return="checked"){
	if($DBV==$NEED_V){
		return $return;
	}elseif(empty($DBV) && $default=='1'){
		return $return;
	}
	return "";
}

//複選回復原始資料函數
function chk2($default_array="",$NEED_V="",$default=1){
	if(in_array($NEED_V,$default_array)){
		return "checked";
	}elseif($default and empty($NEED_V)){
		return "checked";
	}

	return "";
}


//細部權限判斷
function power_chk($perm_name="",$psn=""){
	global $xoopsUser,$xoopsModule;

	//取得目前使用者的群組編號
	if($xoopsUser) {
		$groups = $xoopsUser->getGroups();
	}else{
		$groups = XOOPS_GROUP_ANONYMOUS;
	}

	//取得模組編號
	$module_id = $xoopsModule->getVar('mid');
	//取得群組權限功能
	$gperm_handler =& xoops_gethandler('groupperm');

	//權限項目編號
	$perm_itemid = intval($psn);
	//依據該群組是否對該權限項目有使用權之判斷 ，做不同之處理
	if($gperm_handler->checkRight($perm_name, $perm_itemid, $groups, $module_id)) {
		return true;
	}
	return false;
}

//單選判斷
function is_checked($v1="",$v2="",$default=""){
	if(isset($v1) and $v1==$v2){
		return "checked";
	}elseif($default=="default"){
		return "checked";
	}
}



//分頁物件
class PageBar{
	// 目前所在頁碼
	var $current;
	// 所有的資料數量 (rows)
	var $total;
	// 每頁顯示幾筆資料
	var $limit;
	// 目前在第幾層的頁數選項？
	var $pCurrent;
	// 總共分成幾頁？
	var $pTotal;
	// 每一層最多有幾個頁數選項可供選擇，如：3 = {[1][2][3]}
	var $pLimit;
	var $prev;
	var $next;
	var $prev_layer = ' ';
	var $next_layer = ' ';
	var $first;
	var $last;
	var $bottons = array();
	// 要使用的 URL 頁數參數名？
	var $url_page = "g2p";
	// 要使用的 URL 讀取時間參數名？
	var $url_loadtime = "loadtime";
	// 會使用到的 URL 變數名，給 process_query() 過濾用的。
	var $used_query = array();
	// 目前頁數顏色
	var $act_color = "#990000";
	var $query_str; // 存放 URL 參數列

	function PageBar($total, $limit, $page_limit){
		$mydirname = basename( dirname( __FILE__ ) ) ;
		$this->prev = "<img src='".XOOPS_URL."/modules/{$mydirname}/images/1leftarrow.gif' alt='"._BP_BACK_PAGE."' align='absmiddle' hspace=3>"._BP_BACK_PAGE;
		$this->next = "<img src='".XOOPS_URL."/modules/{$mydirname}/images/1rightarrow.gif' alt='"._BP_NEXT_PAGE."' align='absmiddle' hspace=3>"._BP_NEXT_PAGE;
		$this->first = "<img src='".XOOPS_URL."/modules/{$mydirname}/images/2leftarrow.gif' alt='"._BP_FIRST_PAGE."' align='absmiddle' hspace=3>"._BP_FIRST_PAGE;
		$this->last = "<img src='".XOOPS_URL."/modules/{$mydirname}/images/2rightarrow.gif' alt='"._BP_LAST_PAGE."' align='absmiddle' hspace=3>"._BP_LAST_PAGE;

		$this->limit = $limit;
		$this->total = $total;
		$this->pLimit = $page_limit;
	}

	function init(){
		$this->used_query = array($this->url_page, $this->url_loadtime);
		$this->query_str = $this->processQuery($this->used_query);
		$this->glue = ($this->query_str == "")?'?':
		'&';
		$this->current = (isset($_GET["$this->url_page"]))? $_GET["$this->url_page"]:
		1;
		$this->pTotal = ceil($this->total / $this->limit);
		$this->pCurrent = ceil($this->current / $this->pLimit);
	}

	//初始設定
	function set($active_color = "none", $buttons = "none"){
		if ($active_color != "none"){
			$this->act_color = $active_color;
		}

		if ($buttons != "none"){
			$this->buttons = $buttons;
			$this->prev = $this->buttons['prev'];
			$this->next = $this->buttons['next'];
			$this->prev_layer = $this->buttons['prev_layer'];
			$this->next_layer = $this->buttons['next_layer'];
			$this->first = $this->buttons['first'];
			$this->last = $this->buttons['last'];
		}
	}

	// 處理 URL 的參數，過濾會使用到的變數名稱
	function processQuery($used_query){
		// 將 URL 字串分離成二維陣列
		$vars = explode("&", $_SERVER['QUERY_STRING']);
		for($i = 0; $i < count($vars); $i++){
			$var[$i] = explode("=", $vars[$i]);
		}

		// 過濾要使用的 URL 變數名稱
		for($i = 0; $i < count($var); $i++){
			for($j = 0; $j < count($used_query); $j++){
				if (isset($var[$i][0]) && $var[$i][0] == $used_query[$j]) $var[$i] = array();
			}
		}

		// 合併變數名與變數值
		for($i = 0; $i < count($var); $i++){
			$vars[$i] = implode("=", $var[$i]);
		}

		// 合併為一完整的 URL 字串
		$processed_query = "";
		for($i = 0; $i < count($vars); $i++){
			$glue = ($processed_query == "")?'?':
			'&';
			// 開頭第一個是 '?' 其餘的才是 '&'
			if ($vars[$i] != "") $processed_query .= $glue.$vars[$i];
		}
		return $processed_query;
	}

	// 製作 sql 的 query 字串 (LIMIT)
	function sqlQuery(){
		$row_start = ($this->current * $this->limit) - $this->limit;
		$sql_query = " LIMIT {$row_start}, {$this->limit}";
		return $sql_query;
	}


	// 製作 bar
	function makeBar($url_page = "none"){
		if ($url_page != "none"){
			$this->url_page = $url_page;
		}
		$this->init();

		// 取得目前時間
		$loadtime = '&loadtime='.time();

		// 取得目前頁框(層)的第一個頁數啟始值，如 6 7 8 9 10 = 6
		$i = ($this->pCurrent * $this->pLimit) - ($this->pLimit - 1);

		$bar_center = "";
		while ($i <= $this->pTotal && $i <= ($this->pCurrent * $this->pLimit)){
			if ($i == $this->current){
				$bar_center = "{$bar_center}<font color='{$this->act_color}'>[{$i}]</font>";
			}else{
				$bar_center .= " <a href='{$_SERVER['PHP_SELF']}{$this->query_str}{$this->glue}{$this->url_page}={$i}{$loadtime}'' title='{$i}'>{$i}</a> ";
			}
			$i++;
		}
		$bar_center = $bar_center . "";

		// 往前跳一頁
		if ($this->current <= 1){
			$bar_left = " {$this->prev} ";
			$bar_first = " {$this->first} ";
		}	else{
			$i = $this->current-1;
			$bar_left = " <a href='{$_SERVER['PHP_SELF']}{$this->query_str}{$this->glue}{$this->url_page}={$i}{$loadtime}' title='"._BP_BACK_PAGE."'>{$this->prev}</a> ";
			$bar_first = " <a href='{$_SERVER['PHP_SELF']}{$this->query_str}{$this->glue}{$this->url_page}=1{$loadtime}' title='"._BP_FIRST_PAGE."'>{$this->first}</a> ";
		}

		// 往後跳一頁
		if ($this->current >= $this->pTotal){
			$bar_right = " {$this->next} ";
			$bar_last = " {$this->last} ";
		}	else{
			$i = $this->current + 1;
			$bar_right = " <a href='{$_SERVER['PHP_SELF']}{$this->query_str}{$this->glue}{$this->url_page}={$i}{$loadtime}' title='"._BP_NEXT_PAGE."'>{$this->next}</a> ";
			$bar_last = " <a href='{$_SERVER['PHP_SELF']}{$this->query_str}{$this->glue}{$this->url_page}={$this->pTotal}{$loadtime}' title='"._BP_LAST_PAGE."'>{$this->last}</a> ";
		}

		// 往前跳一整個頁框(層)
		if (($this->current - $this->pLimit) < 1){
			$bar_l = " {$this->prev_layer} ";
		}	else{
			$i = $this->current - $this->pLimit;
			$bar_l = " <a href='{$_SERVER['PHP_SELF']}{$this->query_str}{$this->glue}{$this->url_page}={$i}{$loadtime}' title='".sprintf($this->pLimit,_BP_GO_BACK_PAGE)."'>{$this->prev_layer}</a> ";
		}

		//往後跳一整個頁框(層)
		if (($this->current + $this->pLimit) > $this->pTotal){
			$bar_r = " {$this->next_layer} ";
		}	else{
			$i = $this->current + $this->pLimit;
			$bar_r = " <a href='{$_SERVER['PHP_SELF']}{$this->query_str}{$this->glue}{$this->url_page}={$i}{$loadtime}' title='".sprintf($this->pLimit,_BP_GO_NEXT_PAGE)."'>{$this->next_layer}</a> ";
		}

		$page_bar['center'] = $bar_center;
		$page_bar['left'] = $bar_first . $bar_l . $bar_left;
		$page_bar['right'] = $bar_right . $bar_r . $bar_last;
		$page_bar['current'] = $this->current;
		$page_bar['total'] = $this->pTotal;
		$page_bar['sql'] = $this->sqlQuery();
		return $page_bar;
	}

}

?>