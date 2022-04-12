{extend name="apps/common/view/front.tpl" /}
<!-- -->
{block name="header_meta"}
<title>快审文章－{:config('common.site_name')}</title>
<meta name="keywords" content="{:config('common.site_name')}快审文章" />
<meta name="description" content="{:config('common.site_name')}快审的100条文章！" />
{/block}
{block name="header"}{include file="widget/header" /}{/block}
<!--main -->
{block name="main"}
<div class="container">
  <ol class="breadcrumb bg-white mb-3">
    <li class="breadcrumb-item"><a href="{:cmsUrl('cms/index/index')}">首页</a></li>
    <li class="breadcrumb-item active">快审文章</li>
  </ol>
  <ol class="bg-white mb-3 px-5 py-3">
  {volist name=":cmsSelect(['status'=>'normal','limit'=>100,'sort'=>'info_create_time','order'=>'desc','meta_key'=>'cms_fast','meta_value'=>1])" id="cms"}
    <li class="py-2"><a href="{:cmsUrlDetail($cms)}">{$cms.info_name|DcHtml}</a> {$cms.info_create_time|cmsDate='Y-m-d',###}</li>
  {/volist}
  </ol>
</div>
{/block}
<!-- -->
{block name="footer"}{include file="widget/footer" /}{/block}