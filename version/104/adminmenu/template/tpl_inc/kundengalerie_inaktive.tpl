{if $cSuccessInaktiv}
<div class="box_success">{$cSuccessInaktiv}</div>
{/if}
{if $cErrorInaktiv}
<div class="box_error">{$cErrorInaktiv}</div>
{/if}
{if $oBilderInaktive_arr && $oBilderInaktive_arr|@count>0}
<div style="padding:4px;float:none;padding-left:50px;border-bottom:1px solid #c0c0c0; margin-top:3px; margin-bottom:3px;">
	<table border="0" cellspacing="0" cellpadding="4" width="100%">
	<tr>
		<th align="center" width="140">Bildvorschau</th>
		<th align="left">Kundenkommentar</th>
		<th align="center">Buchungen im akt. Monat</th>
		<th colspan="4">Aktionen</th>
	</tr>
{foreach from=$oBilderInaktive_arr item=oBildAktiv name=bilderInaktiv}
	<tr valign="middle">
	<form method="POST">
	<input type="hidden" name="kPlugin" value="{$oPlugin->kPlugin}">
	<input type="hidden" name="cAction" value="kundengalerie_freischalten">
	<input type="hidden" value="{$cz_kundengalerieInaktive_tab}" name="kPluginAdminMenu">
	<input type="hidden" name="kKundenbild" value="{$oBildAktiv->kKundenbild}">
	<input type="hidden" name="kKunde" value="{$oBildAktiv->kKunde}">
	<td align="center"><img src="{$URL_SHOP}/bilder/kundengalerie/mini/{$oBildAktiv->cFilename}" border="0"><br />
	<a href="{$URL_SHOP}/index.php?a={$oBildAktiv->kArtikel}" target="_blank">Artikel ansehen</a></td>
	<td width="300"><textarea name="cKundenkommentar" cols="50" rows="4">{$oBildAktiv->cKundenkommentar}</textarea></td>
	<td align="center">{$oBildAktiv->nBuchungen}</td>
	<td align="center">
	{if $oPlugin->oPluginEinstellungAssoc_arr.kundengalerie_kupon == 'y'}
	<table border="0" cellspacing="0" cellpadding="4" class="submenue">
	<tr>
		<td>Belohnungs-Kupon?&nbsp;</td>
		<td>
			<select name="selKupon" size="1">
				<option value="1">Ja</option>
				<option value="2">Nein</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>Kupon-Wert:&nbsp;</td>
		<td><input type="text" name="fKuponWert" size="3" value="{$oPlugin->oPluginEinstellungAssoc_arr.kundegalerie_kuponwert}"></td>
	</tr>
	<tr>
		<td>Mindest-Bestellwert:&nbsp;</td>
		<td><input type="text" name="fMindestbestellwert" size="3" value="{$oPlugin->oPluginEinstellungAssoc_arr.kundegalerie_mindestbestellwert}"></td>
	</tr>
	</table>
	<br />
	{elseif $oPlugin->oPluginEinstellungAssoc_arr.kundengalerie_kupon == 'g'}
	<table border="0" cellspacing="0" cellpadding="4" class="submenue">
	<tr>
		<td>Belohnungs-Guthaben?&nbsp;</td>
		<td>
			<select name="selGuthaben" size="1">
				<option value="1">Ja</option>
				<option value="2">Nein</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>Guthaben-Wert:&nbsp;</td>
		<td><input type="text" name="fGuthabenWert" size="3" value="{$oPlugin->oPluginEinstellungAssoc_arr.kundegalerie_kuponwert}"></td>
	</tr>
	</table>
	<br />
	{else}
	&nbsp;
	{/if}
	<input type="submit" name="btnKundengalerieAktivieren" value="Bild freischalten">
	</form>
	</td>
	<td align="center" valign="middle">
	<form method="POST">
	<input type="hidden" name="kPlugin" value="{$oPlugin->kPlugin}">
	<input type="hidden" name="cAction" value="deleteInaktiv">
	<input type="hidden" value="{$cz_kundengalerieInaktive_tab}" name="kPluginAdminMenu">
	<input type="hidden" name="kKundenbild" value="{$oBildAktiv->kKundenbild}"> 
	<input type="submit" name="btnKundengalerieLoeschen" value="Bild löschen">
	</form>
	</td>
	</tr>
{/foreach}
</table>
</div>

{if $seitenanzahlInaktiv>1}
<div class="paging" style="padding-left:50px;">
{if $nAktSeiteInaktiv>1}
<a href="plugin.php?kPlugin={$oPlugin->kPlugin}&kPluginAdminMenu={$cz_kundengalerieInaktive_tab}&sInaktiv={math equation="x - y" x=$nAktSeiteInaktiv y=1}">&laquo;&nbsp;Vorherige</a>&nbsp;
{else}
Vorherige&nbsp;-&nbsp;
{/if}
Seite {$nAktSeiteInaktiv} von {$seitenanzahlInaktiv}
{if $nAktSeiteInaktiv<$seitenanzahlInaktiv}
<a href="plugin.php?kPlugin={$oPlugin->kPlugin}&kPluginAdminMenu={$cz_kundengalerieInaktive_tab}&sInaktiv={math equation="x + y" x=$nAktSeiteInaktiv y=1}">&nbsp;-&nbsp;N&auml;chste&nbsp;&raquo;</a>&nbsp;
{else}
&nbsp;-&nbsp;N&auml;chste&nbsp;&raquo;
{/if}
</div>
{/if}

{else}
<table border="0" cellpadding="4" cellspacing="0" width="100%">
<tr>
	<td align="center">- Nichts freizuschalten -</td>
</tr>
</table>
{/if}