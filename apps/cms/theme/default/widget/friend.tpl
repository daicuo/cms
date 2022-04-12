{if function_exists('friendSelect')}
<h5>友情链接</h5>
<ul class="list-unstyled row">
  {volist name=":friendSelect(['status'=>'normal','limit'=>60,'sort'=>'info_order','order'=>'desc'])" id="friend"}
  <li class="py-2 col-6"><a href="{$friend.friend_referer|default='javascript:;'}" target="_blank" title="{$firend.info_name|DcHtml}" data-id="{$friend.info_id}" data-type="links">{$friend.info_name|cmsSubstr=0,6,false}</a></li>
  {/volist}
</ul>
{/if}