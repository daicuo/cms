<hr class="bg-muted mb-3" style="height:2px">
<div class="container">
  <p class="text-md-center">
    <a class="text-muted" href="{:cmsUrl('cms/index/index')}">返回首页</a>
    {volist name=":cmsAttrOption()" id="attr"}
    <a class="text-muted" href="{:cmsUrl('cms/index/'.$key)}">{$attr}文章</a>
    {/volist}
    {volist name=":cmsNavsSelect(['module'=>'cms','action'=>'links','status'=>'normal'])" id="link"}
    <a class="text-muted" href="{$link.navs_link}">{$link.navs_name|DcSubstr=0,6,false}</a>
    {/volist}
  </p>
  <p class="text-md-center">
    Copyright © 2020-2022 {:config('common.site_domain')} All rights reserved
    {if config('common.site_icp')}
    <a href="https://beian.miit.gov.cn" target="_blank">{:config('common.site_icp')}</a>
    {/if}
  </p>
  {if config('common.site_email')}
    <p class="text-md-center">联系我们：{:config('common.site_email')}</p>
  {/if}
</div>