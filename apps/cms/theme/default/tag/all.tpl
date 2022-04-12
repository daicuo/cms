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
    <li class="breadcrumb-item active">标签列表</li>
  </ol>
  <div class="row">
  {volist name="data" id="tag"}
    <div class="col-4 col-md-2 mb-3">
      <a class="btn btn-block btn-light py-4 border" href="{:cmsUrlTag($tag)}">{$tag.term_name} <sup class="text-muted">{$tag.term_count}</sup></a>
    </div>
  {/volist}
  </div>
  <!---->
  {gt name="last_page" value="1"}
  <div class="w-100"></div>
  <div class="border bg-white pagesmall py-2 mb-2 d-md-none">{:DcPageSimple($current_page, $last_page, $pagePath)}</div>
  <div class="border bg-white page py-2 mb-2 d-none d-md-block">{:DcPage($current_page, $per_page, $total, $pagePath)}</div>
  {/gt}
</div>
{/block}
<!-- -->
{block name="footer"}{include file="widget/footer" /}{/block}