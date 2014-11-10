<?php
// 	kArtikel > 0 -> in DB eintragen
// 	var_dump($bestellung->Positionen);
	
// 	$_SESSION['Kunde']->kKunde

	if (isset($_SESSION['Warenkorb']->PositionenArr) && count($_SESSION['Warenkorb']->PositionenArr)>0)
	{
		$bGlobalAktiv = false;
		require_once $oPlugin->cFrontendPfad . 'includes/class.cz_kundengalerie.php';
		$oKundengalerie = new cz_kundengalerie();
		
		if ($oPlugin->oPluginEinstellungAssoc_arr['kundengalerie_globalaktiv'] == 'y')
			$bGlobalAktiv = true;
		
		foreach ($_SESSION['Warenkorb']->PositionenArr as $oPosition)
		{
			if ($oPosition->kArtikel > 0)
				$oKundengalerie->einkaufVermerken($_SESSION['Warenkorb']->kKunde, $oPosition->kArtikel, $bGlobalAktiv);
		}
	}