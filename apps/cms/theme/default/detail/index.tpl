{extend name="apps/common/view/front.tpl" /}
<!-- -->
{block name="header_meta"}
<title>{$seoTitle}－{:config('common.site_name')}</title>
<meta name="keywords" content="{$seoKeywords}" />
<meta name="description" content="{$seoDescription}"  />
<meta name="referrer" content="never">
{/block}
{block name="header"}{include file="widget/header" /}{/block}
<!--main -->
{block name="main"}
<div class="container">
  <div class="row">
    <div class="col-12 col-md-9">
      <ol class="breadcrumb bg-white mb-2">
        <li class="breadcrumb-item"><a href="{:cmsUrl('cms/index/index')}">首页</a></li>
        <li class="breadcrumb-item active">{$info_name|DcHtml}</li>
      </ol>
      <div class="bg-white border-bottom px-0 px-md-5 mb-2">
        <div class="card-body">
          <h2 class="py-2">{$info_name|DcHtml}</h2>
          <p>{$info_create_time}
            {foreach name="category" item="item"}
            <a class="ml-1" href="{:cmsUrlCategory($item)}">{$item.term_name}</a>
            {/foreach}
            {foreach name="tag" item="item"}
            <a class="ml-1" href="{:cmsUrlTag($item)}">{$item.term_name}</a>
            {/foreach}
          </p>
          {if $cms_cover}
          <p><img class="d-block img-fluid mx-auto rounded" src="{$cms_cover}" alt="{$info_name|DcHtml}"/></p>
          {/if}
          <section class="lead content mb-2">{$info_content|cmsEditor}</section>
          <p class="lead text-center">
            <a class="btn btn-lg btn-info px-4" href="{:cmsUrl('cms/value/up',['id'=>$info_id])}" data-toggle="infoUp">
              <i class="fa fa-thumbs-o-up"></i>
              <small class="infoUpValue">{$cms_up|number_format}</small>
            </a>
          </p>
          <p class="lead">作者：{$user_name}</p>
          <p class="lead text-truncate">链接：{$info_share_url}</p>
          <p class="lead">来源：{:config('common.site_name')}</p>
          <p class="lead">著作权归作者所有。商业转载请联系作者获得授权，非商业转载请注明出处。</p>
        </div>
        <div class="d-inline d-md-flex justify-content-md-between">
          <p class="px-3 px-md-0">{volist name=":cmsPrev($info_id)" id="cms"}上一篇：<a href="{:cmsUrlDetail($cms)}" title="{$cms.info_name}">{$cms.info_name|cmsSubstr=0,18}</a>{/volist}</p>
          <p class="px-3 px-md-0">{volist name=":cmsNext($info_id)" id="cms"}下一篇：<a href="{:cmsUrlDetail($cms)}" title="{$cms.info_name}">{$cms.info_name|cmsSubstr=0,18}</a>{/volist}</p>
        </div>
      </div>
      <!---->
      <div class="card rounded-0 mb-2">
        <div class="card-header bg-light h5">热门文章</div>
        <ul class="list-unstyled card-body px-5 mb-0">
          {volist name=":cmsSelect(['status'=>'normal','limit'=>10,'term_id'=>['in',$category_id],'sort'=>'info_views','order'=>'desc'])" id="cms"}
          <li class="py-2"><a href="{:cmsUrlDetail($cms)}">{$cms.info_name|DcHtml}</a></li>
          {/volist}
        </ul>
      </div>
    </div>
    <div class="col-12 col-md-3">{include file="widget/sitebar" /}</div>
  </div>
</div>
{/block}
<!-- -->
{block name="footer"}{include file="widget/footer" /}{/block}