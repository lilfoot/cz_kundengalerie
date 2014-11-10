{if $cSuccessAktiv}
<div class="box_success">{$cSuccessAktiv}</div>
{/if}
{if $cErrorAktiv}
<div class="box_error">{$cErrorAktiv}</div>
{/if}
{if $oBilderAktive_arr && $oBilderAktive_arr|@count>0}
<div style="padding:4px;float:none;width:770px;padding-left:50px;border-bottom:1px solid #c0c0c0; margin-top:3px; margin-bottom:3px;">
	<table border="0" cellspacing="0" cellpadding="4" width="100%">
	<tr>
		<th align="center" width="140">Bildvorschau</th>
		<th align="left">Kundenkommentar</th>
		<th colspan="4">Aktionen</th>
	</tr>
{foreach from=$oBilderAktive_arr item=oBildAktiv name=bilderAktiv}
	<tr valign="middle">
	<td align="center"><img src="{$URL_SHOP}/bilder/kundengalerie/mini/{$oBildAktiv->cFilename}" border="0"></td>
	<td width="300">{$oBildAktiv->cKundenkommentar}</td>
	<td align="center" valign="middle">
	<form method="POST">
	<input type="hidden" name="kPlugin" value="{$oPlugin->kPlugin}">
	<input type="hidden" name="cAction" value="deleteAktiv">
	<input type="hidden" value="{$cz_kundengalerieAktive_tab}" name="kPluginAdminMenu">
	<input type="hidden" name="kKundenbild" value="{$oBildAktiv->kKundenbild}"> 
	<input type="submit" name="btnKundengalerieLoeschen" value="Bild löschen">
	</form>
	</td>
	</tr>
{/foreach}
</table>
</div>

{if $seitenanzahlAktiv>1}
<div class="paging" style="padding-left:50px;">
{if $nAktSeiteAktiv>1}
<a href="plugin.php?kPlugin={$oPlugin->kPlugin}&kPluginAdminMenu={$cz_kundengalerieAktive_tab}&sAktiv={math equation="x - y" x=$nAktSeiteAktiv y=1}">&laquo;&nbsp;Vorherige</a>&nbsp;
{else}
Vorherige&nbsp;-&nbsp;
{/if}
Seite {$nAktSeiteAktiv} von {$seitenanzahlAktiv}
{if $nAktSeiteAktiv<$seitenanzahlAktiv}
<a href="plugin.php?kPlugin={$oPlugin->kPlugin}&kPluginAdminMenu={$cz_kundengalerieAktive_tab}&sAktiv={math equation="x + y" x=$nAktSeiteAktiv y=1}">&nbsp;-&nbsp;N&auml;chste&nbsp;&raquo;</a>&nbsp;
{else}
&nbsp;-&nbsp;N&auml;chste&nbsp;&raquo;
{/if}
</div>
{/if}

{else}
<table border="0" cellpadding="4" cellspacing="0" width="100%">
<tr>
	<td align="center">- Nichts vorhanden -</td>
</tr>
</table>
{/if}