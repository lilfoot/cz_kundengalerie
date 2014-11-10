<?php
  
    class cz_kundengalerie 
    {
    	private static $DB;
    	public $nAnzahlProSeite = 25;
    	
        public function __construct()
        {
            
        }
            
        /**
         * Überprüfen ob der Artikel bereits gekauft wurde
         * 
         * @param int $kKunde
         * @param int $kArtikel
         * 
         * @return bool
         */
        public function hatGekauft($kKunde,$kArtikel)
        {
        	$oGekauft = $this->db()->executeQuery("SELECT * FROM tbestellung 
														JOIN twarenkorb ON twarenkorb.kWarenkorb=tbestellung.kWarenkorb
														JOIN twarenkorbpos ON twarenkorb.kWarenkorb=twarenkorbpos.kWarenkorb
														WHERE
														tbestellung.kKunde=" . $kKunde . "
														AND
														twarenkorbpos.kArtikel IN (" . $kArtikel . ")",2);
        	if ($oGekauft)
        		return true;
        	
        	return false;
        }
    
        /**
         * Alle Kunden-Bilder zu einem Artikel aus der DB holen
         * 
         * @param int $kArtikel
         * 
         * @return array
         */
        public function holeArtikelKundenbilder($kArtikel)
        {
        	$oKundenbilder_arr = $this->db()->executeQuery("SELECT * FROM xplugin_cz_kundengalerie_bilder 
        														WHERE 
        															kArtikel=" . $kArtikel . "
        														AND 
        															bAktiv='y'",2);
        	
        	if ($oKundenbilder_arr)
        		return $oKundenbilder_arr;
        		
        	return false;
        }
    
    	/**
    	 * Zeige alle aktiven Bilder
    	 * 
    	 * @param int $nSeite
    	 * @param bool $bAktiv
    	 * @param int $kArtikel
    	 * 
    	 * return false|array
    	 */
        public function zeigeBilder($bAktiv=false,$kArtikel=0,$nSeite=1)
        {
        	if ($nSeite>$this->gibSeitenAnzahl($bAktiv) || !$nSeite)
        		$nSeite = 1;
        	
        	$cSql = "SELECT * FROM xplugin_cz_kundengalerie_bilder 
        				WHERE
        					bAktiv=";
        	$cSql .= ($bAktiv)?"'y' ":"'n' ";
			if ($kArtikel>0)
				$cSql .= " AND kArtikel=" . $kArtikel . " ";
			
			$cSql .= " LIMIT " . (($nSeite-1)*$this->nAnzahlProSeite) . "," . $this->nAnzahlProSeite;
        	
        	$oBilder_arr = $this->db()->executeQuery($cSql, 2);
        	
        	return $oBilder_arr;
        }
        
        public function gibSeitenAnzahl($bAktiv=false)
        {
        	$cSql = "SELECT COUNT(*) AS anz FROM xplugin_cz_kundengalerie_bilder where bAktiv=";
        	$cSql .= ($bAktiv)?"'y'":"'n'";
        	$oTmp = $this->db()->executeQuery($cSql, 1);
        	
        	return (floor($oTmp->anz/$this->nAnzahlProSeite)>0)?floor($oTmp->anz/$this->nAnzahlProSeite):1;
        }
        
        /**
         * Kupon als Belohnung erstellen
         * 
         * @param int $kKunde
         * @param float $fWert
         * 
         * 
         * @return true|false
         */
        public function speicherKupon($kKunde,$fWert,$oKuponNameLocalized_arr,$fMindestbestellwert='0.00')
        {
        	// Kuponcode erstellen
        	$cKuponCode = strtoupper(substr(time()/1000+rand(123,9999999),0,7));

        	$Kupon = new stdClass();
	        $Kupon->cName="Upload-Kupon";
			$Kupon->fWert=str_replace(",",".",$fWert);
			$Kupon->dGueltigAb=date('Y-m-d H:i:s',mktime(0,0,0,date('m'),date('d'),date('Y')));
			// Kupon ist 12 Monate gÃ¼ltig
			//$Kupon->dGueltigBis=date('Y-m-d H:i:s',mktime(0,0,0,date('m')+12,date('d'),date('Y')));
			$Kupon->dGueltigBis="";
			$Kupon->kKundengruppe=-1;
			$Kupon->cWertTyp="festpreis";
			$Kupon->fMindestbestellwert=$fMindestbestellwert;
			$Kupon->cCode=$cKuponCode;
			$Kupon->nVerwendungen=1;
			$Kupon->nVerwendungenProKunde=1;
			$Kupon->kSteuerklasse = 1;
			$Kupon->cArtikel="";
			$Kupon->cLieferlaender="";
			$Kupon->cZusatzgebuehren="N";
			
			/*if ($_POST['cZusatzgebuehren']=="Y")
				$Kupon->cZusatzgebuehren="Y";*/
			
			$Kupon->cAktiv="Y";
			$Kupon->dErstellt="now()";
			$Kupon->cKuponTyp="standard";
			$Kupon->cKategorien="-1";
			$Kupon->cKunden = $kKunde;
			
			// Ganzen WK rabattieren
			$Kupon->nGanzenWKRabattieren = 0;
		
			// Kupon in DB schreiben
			$kKupon = $this->db()->insertRow('tkupon',$Kupon);
			
			//Sprachwerte einfÃ¼gen
			$sprachen = gibAlleSprachen();
			$kuponSprache = new stdClass();
			$kuponSprache->kKupon = $kKupon;
			foreach ($sprachen as $sprache)
			{
				$kuponSprache->cISOSprache = $sprache->cISO;
				$kuponSprache->cName = $Kupon->cName;
				if (isset($oKuponNameLocalized_arr['cName_'.$sprache->cISO]))
					$kuponSprache->cName = $oKuponNameLocalized_arr['cName_'.$sprache->cISO];
	
				$this->db()->executeQuery("delete from tkuponsprache where kKupon=".$kKupon." and cISOSprache=\"".$sprache->cISO."\"",4);
				$this->db()->insertRow('tkuponsprache',$kuponSprache);
			}
			
			return $Kupon;
        }
                
        /**
         * Schreibberechtigungen überprüfen
         * @param string $cFolder
         * 
         * @return bool
         */
        public function pruefeSchreibrechte($cFolder)
        {
        	// Existiert das Verzeichnis
        	if (!file_exists($cFolder))
        	{
        		echo $cFolder;
        		return false;
        	}
        	else
        	{
        		if (!file_exists($cFolder."/micro"))
        			return false;
        		
        		if (!file_exists($cFolder."/mini"))
        			return false;
        		
        		if (!file_exists($cFolder."/medium"))
        			return false;
        		
        		if (!file_exists($cFolder."/normal"))
        			return false;
        		
        		if (!file_exists($cFolder."/big"))
        			return false;
        		
        		if (!file_exists($cFolder."/original"))
        			return false;
        	}
        	
        	return true;
        }
              
        /**
         * Bild löschen
         * 
         * @param int $kKundenbild
         * 
         * @return true|false
         */
        public function bildLoeschen($kKundenbild)
        {
        	$oBild = $this->db()->executeQuery("SELECT * FROM xplugin_cz_kundengalerie_bilder WHERE kKundenbild=" . $kKundenbild, 1);
        	
        	if ($oBild)
        	{
        		@unlink(PFAD_ROOT."bilder/kundengalerie/micro/".$oBild->cFilename);
        		@unlink(PFAD_ROOT."bilder/kundengalerie/mini/".$oBild->cFilename);
        		@unlink(PFAD_ROOT."bilder/kundengalerie/medium/".$oBild->cFilename);
        		@unlink(PFAD_ROOT."bilder/kundengalerie/normal/".$oBild->cFilename);
        		@unlink(PFAD_ROOT."bilder/kundengalerie/big/".$oBild->cFilename);
        		@unlink(PFAD_ROOT."bilder/kundengalerie/original/".$oBild->cFilename);
        		
        		$this->db()->executeExQuery("DELETE FROM xplugin_cz_kundengalerie_bilder WHERE kKundenbild=" . $kKundenbild);
        		
        		return true;
        	}
        	
        	return false;
        }
        
        /**
         * Gib die Anzahl der möglichen Seiten zurück
         * 
         * @param int $kArtikel
         * @param bool $bAktiv
         * 
         * @return int
         */
        public function gibAnzahl($bAktiv=false,$kArtikel=0)
        {
        	$cSql = "SELECT COUNT(*) AS nAnz FROM xplugin_cz_kundengalerie_bilder
        				WHERE
        					bAktiv=";
        	$cSql .= ($bAktiv)?"'y' ":"'n' ";
        	
        	if ($kArtikel>0)
        	$cSql .= " AND
        					kArtikel=" . $kArtikel;
        	
        	$oTmpObject = $this->db()->executeQuery($cSql,1);
        	
        	if ($oTmpObject)
        	{
        		return $oTmpObject->nAnz;
        	}
        	
        	return 0;
        }
        
	    public function db()
	    {
	        if (!self::$DB)
	            self::$DB = new NiceDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	            
	        return self::$DB;
	    }
	    
	    /**
	     *
	     * Lizenzschlüsel dekodieren um Timestamo zu erhalten
	     * @param string $cCode
	     */
		private function baueTimestamp($cCode)
		{
			$cString = "";
			$cCode = strtolower($cCode);
			$cZahlenSchluessel_arr = array('x','z','a','p','m','r','y','d','u','t');
			    
			for($i=0;$i<strlen($cCode);$i++)
			{
				unset($keys);
				if (preg_match('([a-zA-Z])', $cCode[$i]))
				{
					$keys = array_keys($cZahlenSchluessel_arr, $cCode[$i]);
					$cString .= $keys[0];
				}
				else
					echo $cCode[$i];
			}
			
			return $cString;
		}
	}
?>
