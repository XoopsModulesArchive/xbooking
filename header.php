<?php
//  ------------------------------------------------------------------------ //
// ���Ҳե� kimozi �s�@
// �s�@����G2009-07-14
// $Id:$
// ------------------------------------------------------------------------- //

include "../../mainfile.php";
include "function.php";

//�P�_�O�_��ӼҲզ��޲z�v��
$isAdmin=false;
if ($xoopsUser) {
    $module_id = $xoopsModule->getVar('mid');
    $isAdmin=$xoopsUser->isAdmin($module_id);
}

$interface_menu[_MD_KIMOZIJACANA_SMNAME1]="index.php";
//$interface_menu[_MD_KIMOZIJACANA_SMNAME2]="search.php";


?>