<?php

function bauePaging($nAktuelleSeite, $nAnzahl, $nAnzahlProSeite)
{		
	unset($oBlaetterNavi);	
	$oBlaetterNavi->nAktiv = 0;
	
	if($nAnzahl > $nAnzahlProSeite)
	{
		$nBlaetterAnzahl_arr = array();
		
		$nSeiten = ceil($nAnzahl / $nAnzahlProSeite);
		$nMaxAnzeige = 5;					// Zeige in der Navigation nur maximal X Seiten an
		$nAnfang = 0;						// Wenn die aktuelle Seite - $nMaxAnzeige gr��er 0 ist, wird nAnfang gesetzt
		$nEnde = 0;							// Wenn die aktuelle Seite + $nMaxAnzeige <= $nSeitenist, wird nEnde gesetzt	
		$nVon = 0;							// Diese Variablen ermitteln die aktuellen Seiten in der Navigation, die angezeigt werden sollen.
		$nBis = 0;							// Begrenzt durch $nMaxAnzeige.
		$nVoherige = $nAktuelleSeite - 1;	// Zum zur�ck bl�ttern in der Navigation
		if($nVoherige <= 0)
			$nVoherige = 1;
		$nNaechste = $nAktuelleSeite + 1;	// Zum vorw�rts bl�ttern in der Navigation
		if($nNaechste >= $nSeiten)
			$nNaechste = $nSeiten;
			
		if($nSeiten > $nMaxAnzeige)
		{			
			// Ist die aktuelle Seite nach dem abzug der Begrenzung gr��er oder gleich 1?
			if(($nAktuelleSeite - $nMaxAnzeige) >= 1)
			{
				$nAnfang = 1;
				$nVon = ($nAktuelleSeite - $nMaxAnzeige) + 1;
			}
			else 
			{
				$nAnfang = 0;
				$nVon = 1;
			}
			
			// Ist die aktuelle Seite nach dem addieren der Begrenzung kleiner als die maximale Anzahl der Seiten
			if(($nAktuelleSeite + $nMaxAnzeige) < $nSeiten)
			{
				$nEnde = $nSeiten;
				$nBis = ($nAktuelleSeite + $nMaxAnzeige) - 1;
			}
			else 
			{
				$nEnde = 0;
				$nBis = $nSeiten;
			}
			
			// Baue die Seiten f�r die Navigation
			for($i=$nVon; $i<=$nBis; $i++)
			{
				array_push($nBlaetterAnzahl_arr, $i);
			}
		}
		else
		{			
			// Baue die Seiten f�r die Navigation	
			for($i=1; $i<=$nSeiten; $i++)
			{
				array_push($nBlaetterAnzahl_arr, $i);
			}
		}
		
		// Blaetter Objekt um sp�ter in Smarty damit zu arbeiten
		$oBlaetterNavi->nSeiten = $nSeiten;
		$oBlaetterNavi->nVoherige = $nVoherige;
		$oBlaetterNavi->nNaechste = $nNaechste;
		$oBlaetterNavi->nAnfang = $nAnfang;
		$oBlaetterNavi->nEnde = $nEnde;
		$oBlaetterNavi->nBlaetterAnzahl_arr = $nBlaetterAnzahl_arr;
		$oBlaetterNavi->nAktiv = 1;
		$oBlaetterNavi->nAnzahl = $nAnzahl;
	}
	
	$oBlaetterNavi->nAktuelleSeite = $nAktuelleSeite;
	$oBlaetterNavi->nVon = (($oBlaetterNavi->nAktuelleSeite - 1) * $nAnzahlProSeite) + 1;
	$oBlaetterNavi->nBis = $oBlaetterNavi->nAktuelleSeite * $nAnzahlProSeite;
	if($oBlaetterNavi->nBis > $nAnzahl)
		$oBlaetterNavi->nBis = $nAnzahl;
	
	//if($oBlaetterNavi->nBis > $nAnzahl)
		//$oBlaetterNavi->nBis -= 1;
	
	return $oBlaetterNavi;
}

function pagingGetterSetter($nAnzahl, $nAnzahlProSeite)
{    
    $nAnzahl            = intval($nAnzahl);
    $nAnzahlProSeite    = intval($nAnzahlProSeite);
    $oBlaetterNaviConf  = new stdClass();
    
    if($nAnzahl > 0 && $nAnzahlProSeite > 0)
    {   
        // Baue Getter
        for($i = 1; $i <= $nAnzahl; $i++)
        {
            $cSQL = "cSQL" . $i;
            $nAktuelleSeite = "nAktuelleSeite" . $i;
            
            $oBlaetterNaviConf->$cSQL = " LIMIT " . $nAnzahlProSeite;
            $oBlaetterNaviConf->$nAktuelleSeite = 1;
            
            // GET || POST
            if(intval(verifyGPCDataInteger("p" . $i)) > 0)
            {
                $nSeite                             = verifyGPCDataInteger("p" . $i);
                $oBlaetterNaviConf->$cSQL           = " LIMIT " . (($nSeite - 1) * $nAnzahlProSeite) . ", " . $nAnzahlProSeite;
                $oBlaetterNaviConf->$nAktuelleSeite = $nSeite;
            }
        }
        
        return $oBlaetterNaviConf;
    }   
    
    return false;
}
?>