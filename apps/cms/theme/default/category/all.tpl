{extend name="apps/common/view/front.tpl" /}
<!-- -->
{block name="header_meta"}
<title>{$seoTitle}－{:config('common.site_name')}</title>
<meta name="keywords" content="{$seoKeywords}" />
<meta name="description" content="{$seoDescription}" />
{/block}
{block name="header"}{include file="widget/header" /}{/block}
<!--main -->
{block name="main"}
<div class="container">
  <ol class="breadcrumb bg-white mb-3">
    <li class="breadcrumb-item"><a href="{:cmsUrl('cms/index/index')}">首页</a></li>
    <li class="breadcrumb-item active">网站分类</li>
  </ol>
  <div class="row">
  {volist name=":cmsCategorySelect(['cache'=>true,'module'=>['in',['cms','common']],'status'=>'normal','sort'=>'term_count','order'=>'desc'])" id="category"}
    <div class="col-4 col-md-2 mb-3">
      <a class="btn btn-block btn-light py-4 border" href="{:cmsUrlCategory($category)}">{$category.term_name} <sup class="text-muted">{$category.term_count}</sup></a>
    </div>
  {/volist}
  </div>
  <!---->
</div>
{/block}
<!-- -->
{block name="footer"}{include file="widget/footer" /}{/block}