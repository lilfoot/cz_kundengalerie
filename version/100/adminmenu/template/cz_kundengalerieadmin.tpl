{*
-------------------------------------------------------------------------------
    JTL-Shop 3
    
    page for JTL-Shop 3
    Admin
    
    Author: marcel.besancon@jtl-software.de, JTL-Software
    http://www.jtl-software.de
    
    Copyright (c) 2010 JTL-Software
-------------------------------------------------------------------------------
*}

{if $stepPlugin == "cz_kundengalerie_aktive"}
    {assign var=cTPLPfad value="`$oPlugin->cAdminmenuPfad`template/tpl_inc/kundengalerie_aktive.tpl"}
    {include file="$cTPLPfad"}
{elseif $stepPlugin == "cz_kundengalerie_inaktive"}
    {assign var=cTPLPfad value="`$oPlugin->cAdminmenuPfad`template/tpl_inc/kundengalerie_inaktive.tpl"}
    {include file="$cTPLPfad"}
{/if}