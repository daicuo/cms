{extend name="apps/common/view/front.tpl" /}
<!-- -->
{block name="header_meta"}
<title>{$term_name|default='按条件筛选'}第{$page}页－{:config('common.site_name')}</title>
<meta name="keywords" content="{:config('common.site_name')}" />
<meta name="description" content="{:config('common.site_name')}收录的类型有{:implode(',',array_values($termIds))}"  />
{/block}
<!-- -->
{block name="header"}{include file="widget/header" /}{/block}
<!--main -->
{block name="main"}
<div class="container">
<div class="row">
  <!---->
  <div class="col-12">
    <ol class="breadcrumb bg-white mb-2">
      <li class="breadcrumb-item"><a class="text-danger" href="{:DcUrl('daohang/index/index')}">首页</a></li>
      <li class="breadcrumb-item"><a href="{$pageReset}">重置条件</a></li>
      <li class="breadcrumb-item active">{$term_name|default='按条件筛选'}</li>
    </ol>
    <div class="w-100 bg-white rounded px-3 pt-3 pb-1 mb-2">
      <p><strong>栏目分类：</strong>
        <a class="mx-1 badge badge-pill {:DcDefault($termId, 0, 'badge-dark', 'badge-light')}" href="{:cmsUrlFilter(array_merge($pageFilter,['term_id'=>0]))}">全部</a>
        {volist name="termIds" id="filterTermName" offset="0" length="30"}
        <a class="mx-1 badge badge-pill {:DcDefault($key, $termId, 'badge-dark', 'badge-light')}" href="{:cmsUrlFilter(array_merge($pageFilter,['term_id'=>$key]))}">{$filterTermName}</a>{/volist}
      </p>
      <p><strong>文章类型：</strong>
        <a class="mx-1 badge badge-pill {:DcDefault($type, NULL, 'badge-dark', 'badge-light')}" href="{:cmsUrlFilter(array_merge($pageFilter,['info_type'=>'']))}">全部</a>
        {volist name="types" id="filterControll" offset="0" length="10"}
        <a class="mx-1 badge badge-pill {:DcDefault($key, $type, 'badge-dark', 'badge-light')}" href="{:cmsUrlFilter(array_merge($pageFilter,['info_type'=>$key]))}">{$filterControll}</a>
        {/volist}
      </p>
      <p><strong>每页数量：</strong>{volist name="pageSizes" id="filterSize" offset="0" length="10"}
        <a class="mx-1 badge badge-pill {:DcDefault($key, $pageSize, 'badge-dark', 'badge-light')}" href="{:cmsUrlFilter(array_merge($pageFilter,['pageSize'=>$key]))}">{$filterSize}</a>
        {/volist}
      </p>
      <p><strong>排序字段：</strong>{volist name="sortNames" id="filterName" offset="0" length="10"}
        <a class="mx-1 badge badge-pill {:DcDefault($key, $sortName, 'badge-dark', 'badge-light')}" href="{:cmsUrlFilter(array_merge($pageFilter,['sortName'=>$key]))}">{$filterName}</a>
        {/volist}
      </p>
      <p><strong>排序方式：</strong>{volist name="sortOrders" id="filterOrder" offset="0" length="10"}
        <a class="mx-1 badge badge-pill {:DcDefault($key, $sortOrder, 'badge-dark', 'badge-light')}" href="{:cmsUrlFilter(array_merge($pageFilter,['sortOrder'=>$key]))}">{$filterOrder}</a>
        {/volist}
      </p>
    </div>
    {volist name="list.data" id="cms"}
       <div class="px-0 px-md-5 bg-white border-bottom rounded">
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
    {gt name="list.last_page" value="1"}
    <div class="border rounded bg-white py-3 d-flex justify-content-center d-md-none mb-2">
      {:DcPageSimple($list['current_page'], $list['last_page'], $pagePath)}
    </div>
    <div class="d-none border rounded bg-white py-3 d-md-flex justify-content-center mb-2">
      {:DcPage($list['current_page'], $list['per_page'], $list['total'], $pagePath)}
    </div>
    {/gt}
  </div>
  <!---->
</div>
</div>
{/block}
<!-- -->
{block name="footer"}{include file="widget/footer" /}{/block}