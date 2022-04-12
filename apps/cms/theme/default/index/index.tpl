{extend name="apps/common/view/front.tpl" /}
<!-- -->
{block name="header_meta"}
<title>{$seoTitle}－{:config('common.site_name')}</title>
<meta name="keywords" content="{$seoKeywords}" />
<meta name="description" content="{$seoDescription}"  />
{/block}
{block name="header"}{include file="widget/header" /}{/block}
<!--main -->
{block name="main"}
<div class="container">
  <div class="row">
    <div class="col-12 col-md-9">
      {volist name="data" id="cms"}
      <div class="px-0 px-md-5 bg-white border-bottom">
        <div class="card-body">
          <h2 class="py-2">
            <a class="{$cms.cms_color|cmsColor}" href="{:cmsUrlDetail($cms)}">{$cms.info_name|DcHtml}</a>
          </h2>
          <p>
            {$cms.info_create_time}
            {foreach name="cms.category" item="category"}
              <a class="ml-1" href="{:cmsUrlCategory($category)}">{$category.term_name}</a>
            {/foreach}
          </p>
          <p class="card-text">{$cms.info_excerpt|DcHtml}</p>
          <p><a href="{:cmsUrlDetail($cms)}">查看全文<i class="fa fa-angle-double-right mx-1"></i></a></p>
        </div>
      </div>
      {/volist}
      <!---->
      {gt name="last_page" value="1"}
      <div class="w-100 mb-2"></div>
      <div class="border bg-white pagesmall py-2 mb-2 d-md-none">{:DcPageSimple($current_page, $last_page, $pagePath)}</div>
      <div class="border bg-white page py-2 mb-2 d-none d-md-block">{:DcPage($current_page, $per_page, $total, $pagePath)}</div>
      {/gt}
    </div>
    <div class="col-12 col-md-3">
      {include file="widget/sitebar" /}
      {include file="widget/friend" /}
    </div>
  </div>
</div>
{/block}
<!-- -->
{block name="footer"}{include file="widget/footer" /}{/block}