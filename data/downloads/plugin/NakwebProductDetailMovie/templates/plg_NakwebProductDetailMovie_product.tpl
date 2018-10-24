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
    <!--▼youtube埋め込みタグ-->
    <h2>youtube埋め込み動画タグ</h2>
    <table class="form">
        <!--{section name=cnt loop=$arrIncludeMovieStatus.how_movie}-->
        <tr>
            <!--{assign var=count value=0}-->
            <!--{if $arrIncludeMovieStatus.other_movie_flg == 0}-->
                <!--{assign var=count value=$count+1}-->
            <!--{/if}-->
            <!--{if $arrIncludeMovieStatus.loop_flg == 0}-->
                <!--{assign var=count value=$count+1}-->
            <!--{/if}-->
            <!--{if $arrIncludeMovieStatus.fullscreen_flg == 0}-->
                <!--{assign var=count value=$count+1}-->
            <!--{/if}-->
            <!--{if $count == 3}-->
                <th rowspan="6">埋め込むyoutubeタグ(<!--{$smarty.section.cnt.iteration}-->)</th>
            <!--{elseif $count == 2}-->
                <th rowspan="5">埋め込むyoutubeタグ(<!--{$smarty.section.cnt.iteration}-->)</th>
            <!--{elseif $count == 1}-->
                <th rowspan="4">埋め込むyoutubeタグ(<!--{$smarty.section.cnt.iteration}-->)</th>
            <!--{elseif $count == 0}-->
                <th rowspan="3">埋め込むyoutubeタグ(<!--{$smarty.section.cnt.iteration}-->)</th>
            <!--{/if}-->
                <th>youtubeコード</th>
                <td colspan="3" style="width:70%">
                    <!--{assign var=key value="youtube_tag_base`$smarty.section.cnt.iteration`"}-->
                    <input type="text" size="60" name="<!--{$key}-->" value="<!--{$arrForm[$key]|h|nl2br}-->" />
                </td>
            <tr>
                <th>横幅</th>
                <td style="width:25%">
                    <!--{assign var=key value="width`$smarty.section.cnt.iteration`"}-->
                    <span class="attention"><!--{$arrErrM[$key]}--></span>
                    <input type="text" size="6" name="<!--{$key}-->" value="<!--{$arrForm[$key]|h}-->" style="<!--{if $arrErrM[$key] != ""}-->background-color: <!--{$smarty.const.ERR_COLOR}-->;<!--{/if}-->"/>
                    <span class="attention">(半角数字で入力)</span>
                </td>
                <th>縦幅</th>
                <td style="width:25%">
                    <!--{assign var=key value="height`$smarty.section.cnt.iteration`"}-->
                    <span class="attention"><!--{$arrErrM[$key]}--></span>
                    <input type="text" size="6" name="<!--{$key}-->" value="<!--{$arrForm[$key]|h}-->" style="<!--{if $arrErrM[$key] != ""}-->background-color: <!--{$smarty.const.ERR_COLOR}-->;<!--{/if}-->"/>
                     <span class="attention">(半角数字で入力)</span>
                </td>
            </tr>
            <!--{if $arrIncludeMovieStatus.other_movie_flg == 0}-->
            <tr>
                <th>関連動画の表示</th>
                <td colspan="3">
                    <!--{assign var=key value="other_movie_flg`$smarty.section.cnt.iteration`"}-->
                    <!--{assign var=1key value="other_movie_flg`$smarty.section.cnt.iteration`-1"}-->
                    <!--{assign var=2key value="other_movie_flg`$smarty.section.cnt.iteration`-2"}-->
                    <label for="<!--{$1key}-->">
                        <input id="<!--{$1key}-->" type="radio" name="<!--{$key}-->" value="0" <!--{if $arrForm[$key] == 0}-->checked="checked"<!--{/if}--> />許可する
                    </label>
                    <label for="<!--{$2key}-->">
                        <input id="<!--{$2key}-->" type="radio" name="<!--{$key}-->" value="1" <!--{if $arrForm[$key] == 1}-->checked="checked"<!--{/if}--> />許可しない
                    </label>
                    <!--{if $arrIncludeMovieStatus.other_movie_flg == 0 && $arrIncludeMovieStatus.loop_flg == 0}-->
                    <span class="attention">　　※関連動画はループ再生時には表示されません。 </span>
                    <!--{/if}-->
                </td>
            </tr>
            <!--{/if}-->
            <!--{if $arrIncludeMovieStatus.loop_flg == 0}-->
            <tr>
                <th>ループ再生</th>
                <td colspan="3">
                    <!--{assign var=key value="loop_flg`$smarty.section.cnt.iteration`"}-->
                    <!--{assign var=1key value="loop_flg`$smarty.section.cnt.iteration`-1"}-->
                    <!--{assign var=2key value="loop_flg`$smarty.section.cnt.iteration`-2"}-->
                    <label for="<!--{$1key}-->">
                        <input id="<!--{$1key}-->" type="radio" name="<!--{$key}-->" value="0" <!--{if $arrForm[$key] == 0}-->checked="checked"<!--{/if}--> />許可する
                    </label>
                    <label for="<!--{$2key}-->">
                        <input id="<!--{$2key}-->" type="radio" name="<!--{$key}-->" value="1" <!--{if $arrForm[$key] == 1}-->checked="checked"<!--{/if}--> />許可しない
                    </label>
                </td>
            </tr>
            <!--{/if}-->
            <!--{if $arrIncludeMovieStatus.fullscreen_flg == 0}-->
            <tr>
                <th>フルスクリーン再生許可</th>
                <td colspan="3">
                    <!--{assign var=key value="fullscreen_flg`$smarty.section.cnt.iteration`"}-->
                    <!--{assign var=1key value="fullscreen_flg`$smarty.section.cnt.iteration`-1"}-->
                    <!--{assign var=2key value="fullscreen_flg`$smarty.section.cnt.iteration`-2"}-->
                    <label for="<!--{$1key}-->">
                        <input id="<!--{$1key}-->" type="radio" name="<!--{$key}-->" value="0" <!--{if $arrForm[$key] == 0}-->checked="checked"<!--{/if}--> />許可する
                    </label>
                    <label for="<!--{$2key}-->">
                        <input id="<!--{$2key}-->" type="radio" name="<!--{$key}-->" value="1" <!--{if $arrForm[$key] == 1}-->checked="checked"<!--{/if}--> />許可しない
                    </label>
                </td>
            </tr>
            <!--{/if}-->
            <tr>
                <th>動画表示</th>
                <td colspan="3">
                    <!--{assign var=key value="show_flg`$smarty.section.cnt.iteration`"}-->
                    <!--{assign var=1key value="show_flg`$smarty.section.cnt.iteration`-1"}-->
                    <!--{assign var=2key value="show_flg`$smarty.section.cnt.iteration`-2"}-->
                    <label for="<!--{$1key}-->">
                        <input id="<!--{$1key}-->" type="radio" name="<!--{$key}-->" value="0" <!--{if $arrForm[$key] == 0}-->checked="checked"<!--{/if}--> />表示する
                    </label>
                    <label for="<!--{$2key}-->">
                        <input id="<!--{$2key}-->" type="radio" name="<!--{$key}-->" value="1" <!--{if $arrForm[$key] == 1}-->checked="checked"<!--{/if}--> />表示しない
                    </label>
                    <span class="attention">　　※【表示しない】を選択すると、タグを書き込んでも表示されなくなります。</span>
                </td>
            </tr>
        </tr>
        <!--{assign var=key value="product_id_seq`$smarty.section.cnt.iteration`"}-->
        <input type="hidden" name ="<!--{$key}-->" value="<!--{$arrForm[$key]}-->" />
        <!--{/section}-->
        <input type="hidden" name ="data_id" value="<!--{$arrForm.data_id}-->" />
    </table>
    <!--▲youtube埋め込みタグ-->
<!-- end   NakwebProductDetailMovie -->

