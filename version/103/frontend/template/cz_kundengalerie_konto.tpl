<br />
<div>
<strong>{$cz_kundengalerie_konto_ueberschrift}</strong>
<br />
{if isset($oArtikelOhneUpload_arr) && $oArtikelOhneUpload_arr|@count > 0}
{foreach from=$oArtikelOhneUpload_arr item=oArtikel name=uploadListe}
	{if $smarty.foreach.uploadListe.first}
	<table border="0" cellspacing="1" cellpadding="0">
	{/if}

	<tr>
		<td>
		{if $bSeoAktiv}
		<a href="{$URL_SHOP}/{$oArtikel->cSeo}">{$oArtikel->cName}</a>
		{else}
		<a href="{$URL_SHOP}?a={$oArtikel->kArtikel}">{$oArtikel->cName}</a>
		{/if}
		</td>
		<td width="10%">
		{if $bSeoAktiv}
		<a href="{$URL_SHOP}/{$oArtikel->cSeo}">
		{else}
		<a href="{$URL_SHOP}?a={$oArtikel->kArtikel}">
		{/if}
		<img src="{$cFrontendPfadUrl}template/images/goto.png" border="0" alt="Zum Artikel" title="Zum Artikel">
		</a>
		</td>
		<td width="10%">
		<form method="POST" action="index.php" id="frmKundengalerieDel">
		<input type="hidden" name="kArtikel" value="{$oArtikel->kArtikel}">
		<input type="hidden" name="kundengalerieAction" value="delete">
		<input type="image" src="{$cFrontendPfadUrl}template/images/button_delete.png" alt="Vormerkung l&ouml;schen" title="Vormerkung l&ouml;schen" id="btnKundengalerieDel" name="btnKundengalerieDel">
		</form>
		</td>
	</tr>
	
	{if $smarty.foreach.uploadListe.first}
	</table>
	{/if}
{/foreach}
{else}
- Keine -
{/if}
</div>