{extend name="apps/common/view/admin.tpl" /}
<!-- -->
{block name="header_meta"}
<title>{:lang("cms/seo/index")}－{:lang('appName')}</title>
{/block}
{block name="header_addon"}
<link href="{$path_root}{$path_addon}view/theme.css">
<script src="{$path_root}{$path_addon}view/theme.js"></script>
{/block}
<!-- -->
{block name="main"}
<h6 class="border-bottom pb-2 text-purple">
  {:lang("cms/seo/index")}
</h6>
{:DcBuildForm([
    'name'     => 'cms/seo/index',
    'class'    => 'bg-white py-2',
    'action'   => DcUrlAddon(['module'=>'cms','controll'=>'seo','action'=>'update']),
    'method'   => 'post',
    'ajax'     => true,
    'submit'   => lang('submit'),
    'reset'    => lang('reset'),
    'close'    => false,
    'disabled' => false,
    'callback' => '',
    'items'    => $items,
])}
{/block}