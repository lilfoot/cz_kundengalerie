<?php
	require_once $oPlugin->cFrontendPfad . 'includes/class.cz_kundengalerie.php';
	
	$oKundengalerieFrontend = new cz_kundengalerie();
	if (preg_match("([0-9]+)", $oPlugin->oPluginEinstellungAssoc_arr['kundengalerie_anzahl_bilder']))
		$oKundengalerieFrontend->nAnzahlProSeite = $oPlugin->oPluginEinstellungAssoc_arr['kundengalerie_anzahl_bilder'];
	else 
		$oKundengalerieFrontend->nAnzahlProSeite = 16;
	
	if (verifyGPCDataInteger("sK")>$oKundengalerieFrontend->gibSeitenAnzahl(true) || !verifyGPCDataInteger("sK"))
		$oBilderFrontend_arr = $oKundengalerieFrontend->zeigeGalerie(true,"",1);
	else
		$oBilderFrontend_arr = $oKundengalerieFrontend->zeigeGalerie(true,"",verifyGPCDataInteger("sK"));
	
	$smarty->assign('seitenanzahlFrontend', $oKundengalerieFrontend->gibSeitenAnzahl(true));
	
	//var_dump($oBilderFrontend_arr);
	$smarty->assign('oBilderFrontend_arr', $oBilderFrontend_arr);
	
	if (verifyGPCDataInteger("sK")>$oKundengalerieFrontend->gibSeitenAnzahl(true) || !verifyGPCDataInteger("sK"))
		$smarty->assign('nAktSeiteFrontend', 1);
	else
		$smarty->assign('nAktSeiteFrontend', verifyGPCDataInteger("sK"));
	
	$smarty->assign('nFrontlinkID', $oPlugin->oPluginFrontendLink_arr[0]->kLink);