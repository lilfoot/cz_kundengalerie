{if $cSuccessInaktiv}
<div class="box_success">{$cSuccessInaktiv}</div>
{/if}
{if $cErrorInaktiv}
<div class="box_error">{$cErrorInaktiv}</div>
{/if}
{if $oBilderInaktive_arr && $oBilderInaktive_arr|@count>0}
<div style="padding:4px;float:none;width:770px;padding-left:50px;border-bottom:1px solid #c0c0c0; margin-top:3px; margin-bottom:3px;">
	<table border="0" cellspacing="0" cellpadding="4" width="100%">
	<tr>
		<th align="center" width="140">Bildvorschau</th>
		<th align="left">Kundenkommentar</th>
		<th colspan="4">Aktionen</th>
	</tr>
{foreach from=$oBilderInaktive_arr item=oBildAktiv name=bilderInaktiv}
	<tr valign="middle">
	<td align="center"><img src="{$URL_SHOP}/bilder/kundengalerie/mini/{$oBildAktiv->cFilename}" border="0"></td>
	<td width="300">{$oBildAktiv->cKundenkommentar}</td>
	<td align="center">
	<form method="POST">
	<input type="hidden" name="kPlugin" value="{$oPlugin->kPlugin}">
	<input type="hidden" name="cAction" value="kundengalerie_freischalten">
	<input type="hidden" value="{$cz_kundengalerieInaktive_tab}" name="kPluginAdminMenu">
	<input type="hidden" name="kKundenbild" value="{$oBildAktiv->kKundenbild}">
	<input type="hidden" name="kKunde" value="{$oBildAktiv->kKunde}"> 
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
	<input type="submit" name="btnKundengalerieAktivieren" value="Bild freischalten">
	</form>
	</td>
	<td align="right" valign="bottom">
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