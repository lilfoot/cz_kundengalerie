<?php
	global $smarty, $oPlugin;
	
	require_once(PFAD_ROOT . PFAD_INCLUDES . "tools.Global.php");
	require_once $oPlugin->cFrontendPfad .'includes/class.cz_kundengalerie.php';
	require_once(PFAD_ROOT . PFAD_INCLUDES . "mailTools.php");
	
	$stepPlugin = 'cz_kundengalerie_inaktive';
	$oTab = $GLOBALS["DB"]->executeQuery("SELECT * FROM tpluginadminmenu WHERE kPlugin=" . $oPlugin->kPlugin . " AND cDateiname='admin_kundengalerie_freischalten.php'",1);
	$smarty->assign('cz_kundengalerieInaktive_tab', $oTab->kPluginAdminMenu);
	
	$oKundengalerie = new cz_kundengalerie();
	$oKundengalerie->nAnzahlProSeite = 25;
	$smarty->assign('seitenanzahlInaktiv', $oKundengalerie->gibSeitenAnzahl(false));
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cAction']) && $_POST['cAction'] == 'kundengalerie_freischalten')
	{
		$oUpdate = new stdClass();
		$oUpdate->bAktiv = "y";
		
		$bOk = $GLOBALS['DB']->updateRow('xplugin_cz_kundengalerie_bilder','kKundenbild', $_POST['kKundenbild'], $oUpdate);
		
		if ($bOk)
		{
			// Kupon versenden
			if ($_POST['selKupon'] == 1)
			{
				$oKundengalerieSprache_arr = gibSprachVariablen($oPlugin->kPlugin);
				
				foreach ($oKundengalerieSprache_arr as $oKundengalerieSprache)
				{
					// Wenn es die richtige Sprachvariable fÃ¼r den Kupon-Namen ist
					if ($oKundengalerieSprache->cName == 'cz_kundengalerie_kuponname')
					{
						$oKuponNameLocalized_arr = array();
				
						// Lokalisierte Kupon-Namen in Array speichern
						foreach ($oKundengalerieSprache->oPluginSprachvariableSprache_arr as $key => $value)
						{
							$oKuponNameLocalized_arr['cName_' . strtolower($key)] = $value;
						}
					}
				}
				
				$oKupon = $oKundengalerie->speicherKupon($_POST['kKunde'], str_replace(',', '.', $_POST['fKuponWert']), $oKuponNameLocalized_arr, str_replace(',','.',$_POST['fMindestbestellwert']));
				
				if (is_object($oKupon))
				{
					$oObj = new stdClass();
					$oObj->tkunde = new Kunde($_POST['kKunde']);
					$oObj->Kupon = $oKupon;
					sendeMail("kPlugin_" . $oPlugin->kPlugin . "_czkundengalerie", $oObj);
				}
			}
			
			$smarty->assign("cSuccessInaktiv", "Das Bild wurde erfolgreich freigeschaltet!");
		}
		else
			$smarty->assign("cErrorInaktiv", "Es ist ein Fehler aufgetreten!");
	}	
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cAction']) && $_POST['cAction'] == 'deleteInaktiv')
	{
		if ($oKundengalerie->bildLoeschen($_POST['kKundenbild']))
			$smarty->assign("cSuccessInaktiv", "Das Bild wurde erfolgreich gelöscht!");
		else
			$smarty->assign("cErrorInaktiv", "Es ist ein Fehler aufgetreten!");
	}

	$oBilderInaktive_arr = $oKundengalerie->zeigeBilder(false,0,verifyGPCDataInteger("sInaktiv"));
	
	if (verifyGPCDataInteger("sAktiv")>$oKundengalerie->gibSeitenAnzahl(false) || !verifyGPCDataInteger("sInaktiv"))
		$smarty->assign('nAktSeiteInaktiv', 1);
	else
		$smarty->assign('nAktSeiteInaktiv', verifyGPCDataInteger("sInaktiv"));
		
	$smarty->assign('oBilderInaktive_arr',$oBilderInaktive_arr);
	
	$smarty->assign('cAdminmenuPfadURL', $oPlugin->cAdminmenuPfadURL);
	$smarty->assign("URL_SHOP", URL_SHOP);
	$smarty->assign("URL_ADMINMENU", URL_SHOP . "/" . PFAD_PLUGIN . $oPlugin->cVerzeichnis . "/" . PFAD_PLUGIN_VERSION . $oPlugin->nVersion . "/" . PFAD_PLUGIN_ADMINMENU);
	$smarty->assign("stepPlugin", $stepPlugin);
	print($smarty->fetch($oPlugin->cAdminmenuPfad . "template/cz_kundengalerieadmin.tpl"));


	