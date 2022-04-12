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
      <ol class="breadcrumb bg-white mb-2">
        <li class="breadcrumb-item"><a href="{:cmsUrl('cms/index/index','')}">首页</a></li>
        <li class="breadcrumb-item active">{:config('common.site_name')}为您找到相关结果约{$total|number_format}个</li>
      </ol>
      <form class="w-100 mb-2 p-3 bg-white" id="search" action="{:cmsUrlSearch()}" method="post">
        <div class="input-group">
          <input class="form-control" type="text" name="searchText" id="searchText" value="{$searchText|DcHtml}" placeholder="搜索..." autocomplete="off" required>
          <div class="input-group-append">
            <button class="btn btn-info" type="submit"><i class="fa fa-search"></i></button>
          </div>
        </div>
        {if $search_list}<div class="w-100 mb-3"></div>{/if}
        <ul class="nav nav-pills">
          {volist name="search_list" id="searchUrl"}
          {if $i eq 1}
            <li class="nav-item"><a class="nav-link active" href="{$searchUrl}">{:lang('cms_search_'.$key)}</a></li>
          {else/}
            <li class="nav-item"><a class="nav-link" href="{$searchUrl}" target="_blank">{:lang('cms_search_'.$key)}</a></li>
          {/if}
          {/volist}
        </ul>
      </form>
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
      <div class="w-100 mb-2"></div>
      <!---->
      {gt name="last_page" value="1"}
        <div class="border bg-white pagesmall py-2 mb-2 d-md-none">{:DcPageSimple($current_page, $last_page, $pagePath)}</div>
        <div class="border bg-white page py-2 mb-2 d-none d-md-block">{:DcPage($page, $per_page, $total, $pagePath)}</div>
      {/gt}
      <div class="card rounded-0 mb-2">
        <div class="card-header bg-light h5"><a class="text-dark" href="{:cmsUrl('cms/index/views','')}">热门文章</a></div>
        <ul class="list-unstyled card-body px-5 mb-0">
          {volist name=":cmsSelect(['status'=>'normal','limit'=>10,'term_id'=>$term_id,'sort'=>'info_views','order'=>'desc'])" id="cms"}
          <li class="py-2"><a href="{:cmsUrlDetail($cms)}">{$cms.info_name|DcHtml}</a></li>
          {/volist}
        </ul>
      </div>
    </div>
    <div class="col-12 col-md-3">
      <h5><a class="text-dark" href="{:cmsUrl('cms/index/categorys','')}">网站分类</a></h5>
      <ul class="list-unstyled row">
      {volist name=":cmsCategorySelect(['status'=>'normal',limit=>999,'sort'=>'term_id','order'=>'desc','module'=>['in','cms,common']])" id="category"}
      <li class="py-2 col-6"><a href="{:cmsUrlCategory($category)}">{$category.term_name}</a></li>
      {/volist}
      </ul>
      <h5><a class="text-dark" href="{:cmsUrl('cms/index/tags','')}">热门标签</a></h5>
      <ul class="list-unstyled row">
      {volist name=":cmsTagSelect(['status'=>'normal',limit=>20,'sort'=>'term_count','order'=>'desc'])" id="tag"}
      <li class="py-2 col-6"><a href="{:cmsUrlTag($tag)}">{$tag.term_name}</a></li>
      {/volist}
      </ul>
    </div>
  </div>
</div>
{/block}
<!-- -->
{block name="footer"}{include file="widget/footer" /}{/block}