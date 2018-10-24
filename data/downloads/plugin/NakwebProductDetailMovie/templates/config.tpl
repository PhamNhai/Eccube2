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
<!--{include file="`$smarty.const.TEMPLATE_ADMIN_REALDIR`admin_popup_header.tpl"}-->
<script type="text/javascript">
</script>

<h2><!--{$tpl_subtitle}--></h2>
<form name="plg_form" id="plg_form" method="post" action="<!--{$smarty.server.REQUEST_URI|h}-->">
<input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
<input type="hidden" name="mode" value="edit">
<p><!--{$tpl_note}--><br/>
    <br/>
</p>

<table border="0" cellspacing="1" cellpadding="8" summary=" ">
    <!-- 詳細タイトル -->
    <tr>
        <td colspan="2" bgcolor="#f3f3f3">▼<!--{$tpl_subtitle}--> 詳細</td>
    </tr>
    <tr>
        <td bgcolor="#f3f3f3">表示動画数</td>
        <td>
            <span class="attention"><!--{$arrErr.how_movie}--></span>
            <input type="text" name="how_movie" value="<!--{$arrForm.how_movie|h|nl2br}-->" style="<!--{if $arrErr.how_movie != ""}-->background-color: <!--{$smarty.const.ERR_COLOR}-->;<!--{/if}-->"/><span class="attention">(半角数字で入力)</span><br />
        </td>
    </tr>
   <!--{assign var=key value="other_movie_flg"}-->
   <!--{assign var=1key value="other_movie_flg-1"}-->
   <!--{assign var=2key value="other_movie_flg-2"}-->
    <tr>
        <td bgcolor="#f3f3f3">関連動画表示許可</td>
        <td>
            <label for="<!--{$1key}-->">
                <input type="radio" id="<!--{$1key}-->" name="<!--{$key}-->" value="0" <!--{if $arrForm[$key] == 0}-->checked="checked"<!--{/if}--> />許可する　
            </label>
            <label for="<!--{$2key}-->">
                <input type="radio" id="<!--{$2key}-->" name="<!--{$key}-->" value="1" <!--{if $arrForm[$key] == 1}-->checked="checked"<!--{/if}--> />許可しない　<br />
            </label>
        </td>
    </tr>
    <!--{assign var=key value="loop_flg"}-->
    <!--{assign var=1key value="loop_flg-1"}-->
    <!--{assign var=2key value="loop_flg-2"}-->
    <tr>
        <td bgcolor="#f3f3f3">ループ再生許可</td>
        <td>
            <label for="<!--{$1key}-->">
                <input type="radio" id="<!--{$1key}-->" name="<!--{$key}-->" value="0" <!--{if $arrForm[$key] == 0}-->checked="checked"<!--{/if}--> />許可する　
            </label>
            <label for="<!--{$2key}-->">
                <input type="radio" id="<!--{$2key}-->" name="<!--{$key}-->" value="1" <!--{if $arrForm[$key] == 1}-->checked="checked"<!--{/if}--> />許可しない　<br />
            </label>
        </td>
    </tr>
    <!--{assign var=key value="fullscreen_flg"}-->
    <!--{assign var=1key value="fullscreen_flg-1"}-->
    <!--{assign var=2key value="fullscreen_flg-2"}-->
    <tr>
        <td bgcolor="#f3f3f3">全体画面再生許可</td>
        <td>
            <label for="<!--{$1key}-->">
                <input type="radio" id="<!--{$1key}-->" name="<!--{$key}-->" value="0" <!--{if $arrForm[$key] == 0}-->checked="checked"<!--{/if}--> />許可する　
            </label>
            <label for="<!--{$2key}-->">
                <input type="radio" id="<!--{$2key}-->" name="<!--{$key}-->" value="1" <!--{if $arrForm[$key] == 1}-->checked="checked"<!--{/if}--> />許可しない　<br />
            </label>
        </td>
    </tr>
</table>

<div class="btn-area">
    <ul>
        <li>
            <a class="btn-action" href="javascript:;" onclick="document.plg_form.submit();return false;"><span class="btn-next">この内容で登録する</span></a>
        </li>
    </ul>
</div>

</form>
<!--{include file="`$smarty.const.TEMPLATE_ADMIN_REALDIR`admin_popup_footer.tpl"}-->
<!-- end   NakwebProductDetailMovie -->
