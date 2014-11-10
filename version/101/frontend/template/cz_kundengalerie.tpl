{*
    /**
        Template zur codezombie.de-Kundengalerie
        Author: Marcel Besancon
        http://www.codezombie.de
    **/
*}
<link rel="stylesheet" type="text/css" href="{$oKundengaleriePlugin->cFrontendPfadURL}template/cz_kundengalerie_frontend.css" media="screen" />
{if $cz_kundengalerie_stepPlugin == "galerie"}
    {assign var=cTPLPfad value="`$oKundengaleriePlugin->cFrontendPfad`template/tpl_inc/galerie.tpl"}
    {include file="$cTPLPfad"}
{/if}