<!--{*
/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) 2000-2011 LOCKON CO.,LTD. All Rights Reserved.
 *
 * http://www.lockon.co.jp/
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */
*}-->
<form name="form1" id="form1" method="post" action="">
<input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
<input type="hidden" name="mode" value="">
<input type="hidden" name="recommend_banner_id" value="">
<input type="hidden" name="search_pageno" value="<!--{$tpl_pageno}-->">
<div id="system" class="contents-main">
    <!--▼バナー一覧ここから-->
    <table class="list">
        <colgroup width="5%">
        <colgroup width="10%"><!--対象商品-->
        <colgroup width="10%"><!--バナー-->
        <colgroup width="10%"><!--バナー-->
        <colgroup width="10%"><!--バナー-->
        <colgroup width="10%">
        <colgroup width="5%">
        <colgroup width="10%">
        <colgroup width="5%">
        <colgroup width="5%">
        <colgroup width="5%">
        <colgroup width="5%">
        <div class="btn">
          <a class="btn-action" href="#" onclick="location.href='./plg_Recommend_recommend_input.php'"><span class="btn-next">新規登録</span></a>
          <br /><br />
          <span class="attention"><!--{$message}--></span>
          <!--▼ページ送り-->
          <!--{if $tpl_linemax}-->
              <span class="attention"><!--{$tpl_linemax}-->件</span>&nbsp;が該当しました。
          <!--{/if}-->
          <!--{if count($list_data) > 0}-->
            <!--{include file=$tpl_pager}-->
          <!--{/if}-->
          <!--▲ページ送り-->
        </div>
        <tr>
            <th>No.</th>
            <th>対象商品</th>
            <th>バナー(PC)</th>
            <th>バナー(SP)</th>
            <th>バナー(mobile)</th>
            <th>表示箇所</th>
            <th>表示状態</th>
            <th>表示期間</th>
            <th>編集</th>
            <th>削除</th>
        </tr>
        <!--{foreach name=loop from=$list_data item=data}-->
        <!--▼バナー<!--{$smarty.section.data.iteration}-->-->
        <!--{assign var=enable_flg value=$data.enable_flg|escape}-->
        <tr bgcolor="<!--{$tr_color}-->">
            <td><!--{$data.recommend_banner_id|escape}--></td>
            <td>商品ID：<!--{$data.product_id|escape}--><br><!--{$data.name|escape}--></td>
            <td>
                ■購入確認ページ<br>
                <!--{if $data.file_img_pc}-->
                    <a href="<!--{$data.link_url_pc}-->" target="_blank"><img src="<!--{$smarty.const.IMAGE_SAVE_URLPATH}--><!--{$data.file_img_pc|escape}-->" style="max-width:150px;"></a><br>
                    <a href="<!--{$data.link_url_pc}-->" target="_blank"><!--{$data.link_url_pc}--></a>
                <!--{else}-->
                    未登録
                <!--{/if}-->
                <br><br>
                ■購入完了ページ<br>
                <!--{if $data.file_img_pc2}-->
                    <a href="<!--{$data.link_url_pc2}-->" target="_blank"><img src="<!--{$smarty.const.IMAGE_SAVE_URLPATH}--><!--{$data.file_img_pc2|escape}-->" style="max-width:150px;"></a><br>
                    <a href="<!--{$data.link_url_pc2}-->" target="_blank"><!--{$data.link_url_pc2}--></a>
                <!--{else}-->
                    未登録
                <!--{/if}-->
            </td>
            <td>
                ■購入確認ページ<br>
                <!--{if $data.file_img_sp}-->
                    <a href="<!--{$data.link_url_sp}-->" target="_blank"><img src="<!--{$smarty.const.IMAGE_SAVE_URLPATH}--><!--{$data.file_img_sp|escape}-->" style="max-width:150px;"></a><br>
                    <a href="<!--{$data.link_url_sp}-->" target="_blank"><!--{$data.link_url_sp}--></a>
                <!--{else}-->
                    未登録
                <!--{/if}-->
                <br><br>
                ■購入完了ページ<br>
                <!--{if $data.file_img_sp2}-->
                    <a href="<!--{$data.link_url_sp2}-->" target="_blank"><img src="<!--{$smarty.const.IMAGE_SAVE_URLPATH}--><!--{$data.file_img_sp2|escape}-->" style="max-width:150px;"></a><br>
                    <a href="<!--{$data.link_url_sp2}-->" target="_blank"><!--{$data.link_url_sp2}--></a>
                <!--{else}-->
                    未登録
                <!--{/if}-->
            </td>
            <td>
                ■購入確認ページ<br>
                <!--{if $data.file_img_mb}-->
                    <a href="<!--{$data.link_url_mb}-->" target="_blank"><img src="<!--{$smarty.const.IMAGE_SAVE_URLPATH}--><!--{$data.file_img_mb|escape}-->" style="max-width:150px;"></a><br>
                    <a href="<!--{$data.link_url_mb}-->" target="_blank"><!--{$data.link_url_mb}--></a>
                <!--{else}-->
                    未登録
                <!--{/if}-->
                <br><br>
                ■購入完了ページ<br>
                <!--{if $data.file_img_mb2}-->
                    <a href="<!--{$data.link_url_mb2}-->" target="_blank"><img src="<!--{$smarty.const.IMAGE_SAVE_URLPATH}--><!--{$data.file_img_mb2|escape}-->" style="max-width:150px;"></a><br>
                    <a href="<!--{$data.link_url_mb2}-->" target="_blank"><!--{$data.link_url_mb2}--></a>
                <!--{else}-->
                    未登録
                <!--{/if}-->
            </td>
            <td align="center">
                <!--{if $data.view_type==1}-->
                    購入確認ページ
                <!--{elseif $data.view_type==2}-->
                    購入完了ページ
                <!--{else}-->
                    購入確認ページ<br>購入完了ページ
                <!--{/if}-->
            </td>
            <td align="center">
                <!--{if $data.show_flg==1}-->
                    公開
                <!--{else}-->
                    非公開
                <!--{/if}-->
            </td>
            <td align="center"><!--{$data.start_time|sfDispDBDate:false|escape}-->～<!--{$data.end_time|sfDispDBDate:false|escape}--></td>
            <td align="center"><a href="" onclick="eccube.changeAction('plg_Recommend_recommend_input.php', 'form1'); eccube.fnFormModeSubmit('form1', 'edit', 'recommend_banner_id', <!--{$data.recommend_banner_id}-->); return false;">編集</a></td>
            <td align="center"><a href="" onclick="eccube.fnFormModeSubmit('form1', 'delete', 'recommend_banner_id', <!--{$data.recommend_banner_id}-->); return false;">削除</a></td>
        </tr>
        <!--▲バナー<!--{$smarty.section.data.iteration}-->-->
        <!--{foreachelse}-->
        <tr bgcolor="#ffffff"><td colspan="10" align="center"> まだバナーが登録されていません </td></tr>
        <!--{/foreach}-->
    </table>

    <div class="paging">
        <!--▼ページ送り-->
        <!--{$tpl_strnavi}-->
        <!--▲ページ送り-->
    </div>
</div>
</form>
