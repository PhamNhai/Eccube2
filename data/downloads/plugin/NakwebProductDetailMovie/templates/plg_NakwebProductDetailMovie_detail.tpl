<!--{*
 * NakwebProductDetailMovie
 * Copyright (C) 2014 NAKWEB CO.,LTD. All Rights Reserved.
 * http://www.nakweb.com/
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*}-->

<!-- start NakwebProductDetailMovie -->
<!--{section name=cnt loop=$arrYoutube}-->
    <!--{assign var=loop value="youtube_tag_remake`$smarty.section.cnt.iteration`"}-->
    <!--{assign var=show value="show_flg`$smarty.section.cnt.iteration`"}-->
    <!--{if $arrYoutube[$loop] != "" && $arrYoutube[$show] != "1"}-->
        <!--{assign var ="Nakweb_plg00005movie`$smarty.section.cnt.iteration`" value=$arrYoutube[$loop]}-->
    <!--{elseif $arrYoutube[$loop] == "" || $arrYoutube[$show] == "1"}-->
        <!--{assign var ="Nakweb_plg00005movie`$smarty.section.cnt.iteration`" value=""}-->
    <!--{/if}-->
    <!--{/section}-->
<!-- end   NakwebProductDetailMovie -->

