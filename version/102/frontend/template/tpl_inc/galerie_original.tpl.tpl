{*Nur angemeldete Kunden dürfen ein Bild hochladen*}
{if $bKundengalerieError}
<div class="cz_galerie_error">
{$oKundengaleriePlugin->oPluginSprachvariableAssoc_arr.cz_kundengalerie_upload_error} {if $bKundengalerieFormatError}{$oKundengaleriePlugin->oPluginSprachvariableAssoc_arr.cz_kundengalerie_upload_error_format}{/if}
</div>
{/if}
{if $bKundengalerieSuccess}
<div class="cz_galerie_success">
{$oKundengaleriePlugin->oPluginSprachvariableAssoc_arr.cz_kundengalerie_upload_success} {if $oKundengaleriePlugin->oPluginEinstellungAssoc_arr.kundengalerie_moderation == 'y'}{$oKundengaleriePlugin->oPluginSprachvariableAssoc_arr.cz_kundengalerie_upload_moderation_warten}{/if}
</div>
{/if}
{if $smarty.session.Kunde->kKunde>0}
{if ($oKundengaleriePlugin->oPluginEinstellungAssoc_arr.kundengalerie_gekauft eq 'y' && bGekauft>0) || ($oKundengaleriePlugin->oPluginEinstellungAssoc_arr.kundengalerie_gekauft eq 'n')}
{if $bKundengalerieRechteGesetzt > 0 && not $bKundengalerieSuccess}
<div class="cz_kundengalerie_uploadform">
<form method="POST" enctype="multipart/form-data">
<input type="hidden" name="kArtikel" value="{$Artikel->kArtikel}">
<div class="cz_galerie_formrow">
<label for="cz_kundengalerie_uploadpic">{$oKundengaleriePlugin->oPluginSprachvariableAssoc_arr.cz_kundengalerie_bild}&nbsp;(max. {$nMaxFileSize} | .jpg):&nbsp;</label>
<br />
<input type="file" name="cz_kundengalerie_uploadpic" id="cz_kundengalerie_uploadpic">
</div>
<div class="cz_galerie_formrow">
<label for="cKundenkommentar">{$oKundengaleriePlugin->oPluginSprachvariableAssoc_arr.cz_kundengalerie_kommentar}:&nbsp;</label>
<br />
<textarea class="cz_kundengalerie_textarea" name="cKundenkommentar" id="cKundenkommentar"></textarea>
</div>
<br />
<input type="submit" name="btn_cz_kundengalerie_upload" value="{$oKundengaleriePlugin->oPluginSprachvariableAssoc_arr.cz_kundengalerie_upload_button}">
</form>
</div>
{else}
{if not $bKundengalerieSuccess}<strong>{$oKundengaleriePlugin->oPluginSprachvariableAssoc_arr.cz_kundengalerie_konfigfehler}Das Plugin wurde nicht korrekt konfiguriert!</strong>{/if}
{/if}
{else}
<strong>{$oKundengaleriePlugin->oPluginSprachvariableAssoc_arr.cz_kundengalerie_kaufen}</strong>
{/if}
{else}
{* Hinweis das Kunden nach Anmeldung Bilder hochladen können*}
<strong>{$oKundengaleriePlugin->oPluginSprachvariableAssoc_arr.cz_kundengalerie_anmelden}</strong>
{/if}
<br />
<hr noshade>
<br />
{if $oBilder_arr && $oBilder_arr|@count>0}
<div style="padding-left:45px;">
	{foreach from=$oBilder_arr item=oBild}
	<div class="kundengalerieBildContainer">
	<a id="cz_kundengalerie" class="fancy-gallery" rel="adjustX: 10, adjustY: 0, smoothMove:5, showNavArrows:false" href="{$URL_SHOP}bilder/kundengalerie/big/{$oBild->cFilename}" style="position: relative; display: block;">
	<img src="{$URL_SHOP}bilder/kundengalerie/medium/{$oBild->cFilename}" border="0">
	</a>
	</div>
	{/foreach}
</div>
{else}
{$oKundengaleriePlugin->oPluginSprachvariableAssoc_arr.cz_kundengalerie_keine_bilder}
{/if}