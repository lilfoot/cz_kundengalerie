<?php
    // Alle POST-Actions
    if (isset($_POST['btn_cz_kundengalerie_upload']) && $_SESSION['Kunde']->kKunde>0)
    {
    	$_SESSION['cz_kundegalerie_upload'] = true;
    	$smarty->assign('PluginTabAnzeigen','cz_kundengalerie');
    	$smarty->assign('PluginTabName','#cz_kundengalerie');
    	    	
    	if ($_FILES['cz_kundengalerie_uploadpic']['error'])
    			$smarty->assign('bKundengalerieError', true);
    	
    	if (preg_match('(^image/([a-z]{0,1})jp([e]{0,1})g$)', $_FILES['cz_kundengalerie_uploadpic']['type']))
    	{
			require_once $oPlugin->cFrontendPfad . 'includes/class.cz_kundengalerie.php';
			require_once $oPlugin->cFrontendPfad . 'includes/class.thumbnail.php';
			require_once(PFAD_ROOT . PFAD_INCLUDES . "mailTools.php");
		  
			$oKundengalerie = new cz_kundengalerie();
			
			$cFileName = substr(md5(time()+$_POST['kArtikel']),0,12).".jpg";
					
			$oThumbnail = new thumbnail();
			$oThumbnail->create($_FILES['cz_kundengalerie_uploadpic']['tmp_name']);
			$oThumbnail->maxSize(45);
			$oThumbnail->save(PFAD_ROOT."bilder/kundengalerie/micro/".$cFileName);
			$oThumbnail->destroy();
			
			$oThumbnail = new thumbnail();
			$oThumbnail->create($_FILES['cz_kundengalerie_uploadpic']['tmp_name']);
			$oThumbnail->maxSize(90);
			$oThumbnail->save(PFAD_ROOT."bilder/kundengalerie/mini/".$cFileName);
			$oThumbnail->destroy();
			
			$oThumbnail = new thumbnail();
			$oThumbnail->create($_FILES['cz_kundengalerie_uploadpic']['tmp_name']);
			$oThumbnail->maxSize(180);
			$oThumbnail->save(PFAD_ROOT."bilder/kundengalerie/medium/".$cFileName);
			$oThumbnail->destroy();
			
			$oThumbnail = new thumbnail();
			$oThumbnail->create($_FILES['cz_kundengalerie_uploadpic']['tmp_name']);
			$oThumbnail->maxSize(350);
			$oThumbnail->save(PFAD_ROOT."bilder/kundengalerie/normal/".$cFileName);
			$oThumbnail->destroy();
			
			$oThumbnail = new thumbnail();
			$oThumbnail->create($_FILES['cz_kundengalerie_uploadpic']['tmp_name']);
			$oThumbnail->maxSize(600);
			$oThumbnail->save(PFAD_ROOT."bilder/kundengalerie/big/".$cFileName);
			$oThumbnail->destroy();
			
			move_uploaded_file($_FILES['cz_kundengalerie_uploadpic']['tmp_name'], PFAD_ROOT."bilder/kundengalerie/original/".$cFileName);
			
			$smarty->assign('cKundengalerieBildname', $cFileName);
					
			$oBildEintrag = new stdClass();
			$oBildEintrag->kKunde = $_SESSION['Kunde']->kKunde;
			$oBildEintrag->kArtikel = $_POST['kArtikel'];
			$oBildEintrag->cFilename = $cFileName;
			$oBildEintrag->cKundenkommentar = $_POST['cKundenkommentar'];
			$oBildEintrag->bKundenkommentarAnzeigen = ($oPlugin->oPluginEinstellungAssoc_arr['kundengalerie_moderation']=='y')?'n':'y';
			$oBildEintrag->bAktiv = ($oPlugin->oPluginEinstellungAssoc_arr['kundengalerie_moderation']=='y')?'n':'y';
			$oBildEintrag->dEingetragen = "now()";
			
			$GLOBALS["DB"]->insertRow("xplugin_cz_kundengalerie_bilder", $oBildEintrag);
			
			// Wenn keine Moderation erfolgen soll UND ein Kupon als Belohnun erstellt werden soll
			if ($oPlugin->oPluginEinstellungAssoc_arr['kundengalerie_moderation']=='n' && $oPlugin->oPluginEinstellungAssoc_arr['kundengalerie_kupon']=='y')
			{
				$oKundengalerieSprache_arr = gibSprachVariablen($oPlugin->kPlugin);
				
				foreach ($oKundengalerieSprache_arr as $oKundengalerieSprache)
				{
					// Wenn es die richtige Sprachvariable für den Kupon-Namen ist
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
				
				$oKupon = $oKundengalerie->speicherKupon($_SESSION['Kunde']->kKunde, str_replace(',', '.', $oPlugin->oPluginEinstellungAssoc_arr['kundegalerie_kuponwert']),$oKuponNameLocalized_arr,  str_replace(',', '.', $oPlugin->oPluginEinstellungAssoc_arr['kundegalerie_mindestbestellwert']));
				
				if (is_object($oKupon))
				{
					$oObj = new stdClass();
					$oObj->tkunde = new Kunde($_SESSION['Kunde']->kKunde);
					$oObj->Kupon = $oKupon;
					sendeMail("kPlugin_" . $oPlugin->kPlugin . "_czkundengalerie", $oObj);
				}
			}
			
			$smarty->assign('bKundengalerieSuccess', true);
    	}
    	else 
    	{
    		$smarty->assign('bKundengalerieError', true);
    		$smarty->assign('bKundengalerieFormatError', true);
    	}
    }