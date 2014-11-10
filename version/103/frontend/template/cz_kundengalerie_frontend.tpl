<script type="text/javascript" src="{$currentTemplateDir}js/jquery.fancybox-1.3.3.js"></script>
<script type="text/javascript">
$(document).ready(function() {ldelim}
	$("a.fancy-gallery").fancybox({ldelim}          
            'titleShow': false, 
            'hideOnContentClick': true, 
            'transitionIn': 'elastic', 
            'transitionOut': 'elastic',
            'overlayShow' : true,
            'overlayColor' : '#000',
            'overlayOpacity' : 0.15,
            'autoScale' : true,
            'centerOnScroll' : true,
            'autoDimensions' : false
          {rdelim});
	{rdelim});
</script>

{if $oBilderFrontend_arr|@count >0}
	{foreach from=$oBilderFrontend_arr item=oBild name=frontendBilder}
	<div style="float:left; width: 180px; min-height:250px; border:1px solid #000000; padding:5px; margin:5px; text-align:center;">
		{*<a href="{$URL_SHOP}bilder/kundengalerie/big/{$oBild->cFilename}" target="_blank">*}
		<a class="fancy-gallery" rel="adjustX: 10, adjustY: 0, smoothMove:5" href="{$URL_SHOP}bilder/kundengalerie/big/{$oBild->cFilename}" style="position: relative; display: block;">
		<img src="{$SHOP_URL}bilder/kundengalerie/medium/{$oBild->cFilename}" border="0">
		</a>
		<br />
		<span style="font-size:8pt; font-style:italic;">{if $oBild->cKundenkommentar}"{/if}{$oBild->cKundenkommentar}{if $oBild->cKundenkommentar}"{/if}</span>
		<br />
		<br />
		<a href="index.php?a={$oBild->kArtikel}">Zum Artikel</a>
	</div>
	{/foreach}
	<div style="float:none; clear:both; width:100%; text-align:center;">&nbsp;</div>
	{if $seitenanzahlFrontend>1}
	<div class="paging" style="text-align:center;">
	{if $nAktSeiteFrontend>1}
	<a href="navi.php?s={$nFrontlinkID}&sK={math equation="x - y" x=$nAktSeiteFrontend y=1}">&laquo;&nbsp;Vorherige</a>&nbsp;
	{else}
	Vorherige&nbsp;-&nbsp;
	{/if}
	Seite {$nAktSeiteFrontend} von {$seitenanzahlFrontend}
	{if $nAktSeiteFrontend<$seitenanzahlFrontend}
	<a href="navi.php?s={$nFrontlinkID}&sK={math equation="x + y" x=$nAktSeiteFrontend y=1}">&nbsp;-&nbsp;N&auml;chste&nbsp;&raquo;</a>&nbsp;
	{else}
	&nbsp;-&nbsp;N&auml;chste&nbsp;&raquo;
	{/if}
	</div>
	{/if}
{else}
	<div style="border:1px solid #000000;">
	Leider noch keine Bilder vorhanden...
	</div>
{/if}