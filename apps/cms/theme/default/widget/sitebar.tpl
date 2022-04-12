<form class="w-100 mb-3" id="search" action="{:cmsUrlSearch('','index')}" method="post">
  <div class="input-group">
    <input class="form-control" type="text" name="searchText" id="searchText" placeholder="搜索..." autocomplete="off" required>
    <div class="input-group-append">
      <button class="btn btn-info" type="submit"><i class="fa fa-search"></i></button>
    </div>
  </div>
</form>
{if function_exists('adsenseShow')}
<p class="text-center">{:adsenseShow("image300")}</p>
{/if}
{if in_array($controll, ['index','category','tag'])}
<h5><a class="text-dark" href="{:cmsUrl('cms/index/views','')}">人气排行</a></h5>
<ul class="list-unstyled">
  {volist name=":cmsSelect(['status'=>'normal','limit'=>10,'sort'=>'info_views','order'=>'desc'])" id="cms"}
  <li class="py-2"><a href="{:cmsUrlDetail($cms)}">{$cms.info_name|DcHtml}</a></li>
  {/volist}
</ul>
{else/}
<h5><a class="text-dark" href="{:cmsUrl('cms/index/news','')}">近期文章</a></h5>
<ul class="list-unstyled">
  {volist name=":cmsSelect(['status'=>'normal','limit'=>10,'sort'=>'info_id','order'=>'desc'])" id="cms"}
  <li class="py-2"><a href="{:cmsUrlDetail($cms)}">{$cms.info_name|DcHtml}</a></li>
  {/volist}
</ul>
{/if}
<h5><a class="text-dark" href="{:cmsUrl('cms/category/all','')}">网站分类</a></h5>
<ul class="list-unstyled row">
  {volist name=":cmsCategorySelect(['status'=>'normal','limit'=>60,'sort'=>'term_id','order'=>'desc'])" id="category"}
  <li class="py-2 col-4"><a href="{:cmsUrlCategory($category)}" title="{$category.term_name}">{$category.term_name|cmsSubstr=0,4,false}</a></li>
  {/volist}
</ul>
<h5><a class="text-dark" href="{:cmsUrl('cms/tag/all','')}">热门标签</a></h5>
<ul class="list-unstyled row">
  {volist name=":cmsTagSelect(['status'=>'normal','limit'=>30,'sort'=>'term_count','order'=>'desc'])" id="tag"}
  <li class="py-2 col-6 col-md-4"><a href="{:cmsUrlTag($tag)}" title="{$tag.term_name}">{$tag.term_name|cmsSubstr=0,4,false}</a></li>
  {/volist}
</ul>