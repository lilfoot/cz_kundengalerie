<?php
	global $smarty, $oPlugin;
	
	require_once(PFAD_ROOT . PFAD_INCLUDES . "tools.Global.php");

	$stepPlugin = "cz_kundengalerie_donate";
	
	$smarty->assign('cAdminmenuPfadURL', $oPlugin->cAdminmenuPfadURL);
	$smarty->assign("URL_SHOP", URL_SHOP);
	$smarty->assign("URL_ADMINMENU", URL_SHOP . "/" . PFAD_PLUGIN . $oPlugin->cVerzeichnis . "/" . PFAD_PLUGIN_VERSION . $oPlugin->nVersion . "/" . PFAD_PLUGIN_ADMINMENU);
	$smarty->assign("stepPlugin", $stepPlugin);
	print($smarty->fetch($oPlugin->cAdminmenuPfad . "template/cz_kundengalerieadmin.tpl"));


	