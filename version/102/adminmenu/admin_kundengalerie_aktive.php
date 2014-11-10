<?php
	global $smarty, $oPlugin;
	
	require_once(PFAD_ROOT . PFAD_INCLUDES . "tools.Global.php");
	require_once $oPlugin->cFrontendPfad .'includes/class.cz_kundengalerie.php';
	require_once 'includes/paging.php';
	
	$stepPlugin = 'cz_kundengalerie_aktive';
	$oTab = $GLOBALS["DB"]->executeQuery("SELECT * FROM tpluginadminmenu WHERE kPlugin=" . $oPlugin->kPlugin . " AND cDateiname='admin_kundengalerie_aktive.php'",1);
	$smarty->assign('cz_kundengalerieAktive_tab', $oTab->kPluginAdminMenu);
	
	$oKundengalerie = new cz_kundengalerie();
	$oKundengalerie->nAnzahlProSeite = 25;
	$smarty->assign('seitenanzahlAktiv', $oKundengalerie->gibSeitenAnzahl('true'));
		
	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cAction']) && $_POST['cAction'] == 'deleteAktiv')
	{
		if ($oKundengalerie->bildLoeschen($_POST['kKundenbild']))
			$smarty->assign("cSuccessAktiv", "Das Bild wurde erfolgreich gelöscht!");
		else
			$smarty->assign("cErrorAktiv", "Es ist ein Fehler aufgetreten!");
	}
	
	$oBilderAktive_arr = $oKundengalerie->zeigeBilder(true,0,verifyGPCDataInteger("sAktiv"));
	
	if (verifyGPCDataInteger("sAktiv")>$oKundengalerie->gibSeitenAnzahl("true") || !verifyGPCDataInteger("sAktiv"))
		$smarty->assign('nAktSeiteAktiv', 1);
	else
		$smarty->assign('nAktSeiteAktiv', verifyGPCDataInteger("sAktiv"));
		
	$smarty->assign('oPaging', $oPaging);
	
	//var_dump($oPaging);
	//var_dump($oBilderAktive_arr);
	$smarty->assign('oBilderAktive_arr',$oBilderAktive_arr);
	
	//$smarty->assign('oBegriffe_arr', $oBegriffe_arr);
	
	$smarty->assign('cAdminmenuPfadURL', $oPlugin->cAdminmenuPfadURL);
	$smarty->assign("URL_SHOP", URL_SHOP);
	$smarty->assign("URL_ADMINMENU", URL_SHOP . "/" . PFAD_PLUGIN . $oPlugin->cVerzeichnis . "/" . PFAD_PLUGIN_VERSION . $oPlugin->nVersion . "/" . PFAD_PLUGIN_ADMINMENU);
	$smarty->assign("stepPlugin", $stepPlugin);
	print($smarty->fetch($oPlugin->cAdminmenuPfad . "template/cz_kundengalerieadmin.tpl"));


	