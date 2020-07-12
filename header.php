<?php
//  ------------------------------------------------------------------------ //
// 本模組由 kimozi 製作
// 製作日期：2009-07-14
// $Id:$
// ------------------------------------------------------------------------- //

include "../../mainfile.php";
include "function.php";

//判斷是否對該模組有管理權限
$isAdmin=false;
if ($xoopsUser) {
    $module_id = $xoopsModule->getVar('mid');
    $isAdmin=$xoopsUser->isAdmin($module_id);
}

$interface_menu[_MD_KIMOZIJACANA_SMNAME1]="index.php";
//$interface_menu[_MD_KIMOZIJACANA_SMNAME2]="search.php";


?>