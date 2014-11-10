<?php
	require_once $oPlugin->cFrontendPfad . 'includes/class.cz_kundengalerie.php';
	
	$oKundengalerie = new cz_kundengalerie();
	
	if (!$oKundengalerie->pruefeLizenz($oPlugin->cLizenz))
	{
		aenderPluginStatus(1, $oPlugin->kPlugin);
	}
	else
	{
	    // Nur bei Aufruf eines Artikels
	    if (gibSeitenTyp() == PAGE_ARTIKEL)
	    {
	    	$smarty->assign('bKundengalerieRechteGesetzt',($oKundengalerie->pruefeSchreibrechte(PFAD_ROOT."bilder/kundengalerie"))?1:0);
	
	    	//var_dump($_SESSION);
	    	$oArtikel = $smarty->get_template_vars('Artikel');
	    	
	    	// Beachte die globale Galerie-Einstellung und arbeite entsprechend weiter
	    	if ((!array_key_exists('disable_kundengalerie', $oArtikel->FunktionsAttribute) && $oPlugin->oPluginEinstellungAssoc_arr['kundengalerie_globalaktiv']=='y')
	    			|| (array_key_exists('enable_kundengalerie', $oArtikel->FunktionsAttribute) && $oPlugin->oPluginEinstellungAssoc_arr['kundengalerie_globalaktiv']=='n') )
	    	{
		    	// Kunde ist angemeldet
		    	if ($_SESSION['Kunde']->kKunde>0)
		    		$smarty->assign('bGekauft', ($oKundengalerie->hatGekauft($_SESSION['Kunde']->kKunde, $oArtikel->kArtikel))?1:0);
		    	
		    	$smarty->assign('bLoggedIn', ($_SESSION['kunde']->kKunde>0)?true:false);
		    	$smarty->assign('oKundengaleriePlugin', $oPlugin);
		    	
		    	$smarty->assign('oBilder_arr', $oKundengalerie->holeArtikelKundenbilder($oArtikel->kArtikel));
		    	
		        $smarty->assign('cz_kundengalerie_stepPlugin','galerie');
		        $smarty->assign('nMaxFileSize', ini_get("post_max_size"));
		        
		        $oEinstellungen = $smarty->get_template_vars("Einstellungen");
		        //var_dump($oEinstellungen);
		        if (isset($oPlugin->oPluginEinstellungAssoc_arr['kundengalerie_templatebasis']) && $oPlugin->oPluginEinstellungAssoc_arr['kundengalerie_templatebasis'] == 'modi')
		        	$bModiArt = true;
		        else
		        	$bModiArt = false;
		        
		        if (!$bModiArt)
		        {
			        if ($oEinstellungen['artikeldetails']['artikeldetails_tabs_nutzen'] == 'Y')
			        {
				        define('SemTabsID', '.semtabs');
				        define('TabPanelClass', 'panel');
				        define('TabTitleClass','title');
			        }
			       	else
			       	{       
				        define('SemTabsID', '#mytabset');
				        define('TabPanelClass', 'panel notab');
				        define('TabTitleClass','title');
			       	}
		        }
		        else
		        {
		        	define('SemTabsID', '#semantictabs');
		        	define('TabPanelClass', 'tabPanel');
		        	define('TabTitleClass','tabheadline');
		        }
		        
		        $tab_content = $smarty->fetch($oPlugin->cFrontendPfad . "template/cz_kundengalerie.tpl");
		       	
		        if (!$bModiArt)
		        {
			        $tab = "<div class='" . TabPanelClass . "' id='cz_kundengalerie' title='" . $oPlugin->oPluginSprachvariableAssoc_arr['cz_kundengalerie_tabtitel'] ."'>
			                <h2 class='" . TabTitleClass . "'>" . $oPlugin->oPluginSprachvariableAssoc_arr['cz_kundengalerie_tabtitel'] ."</h2>
			                <div class='custom_content'>" . $tab_content . "</div></div>";
		        }
		        else
		        {
		        	$tab = "<div id='kundengalerie' class='" . TabPanelClass ."'>
		        			<h2 class='" . TabTitleClass . "'>" . $oPlugin->oPluginSprachvariableAssoc_arr['cz_kundengalerie_tabtitel'] . "</h2>
		        			<div id='kundengalerieTab' class='tabContent'>" . $tab_content . "</div>
		        			</div>";
		        }
		
		        pq(SemTabsID)->append($tab);
	    	}
	    }
	}