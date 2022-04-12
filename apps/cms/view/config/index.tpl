{extend name="apps/common/view/admin.tpl" /}
<!-- -->
{block name="header_meta"}
<title>{:lang("cms/config/index")}－{:lang('appName')}</title>
{/block}
{block name="header_addon"}
<link href="{$path_root}{$path_addon}view/theme.css">
<script src="{$path_root}{$path_addon}view/theme.js"></script>
{/block}
<!-- -->
{block name="main"}
<h6 class="border-bottom pb-2 mb-0 text-purple">
  {:lang("cms/config/index")}
</h6>
{:DcBuildForm([
    'name'          => 'cms/config/index',
    'class'         => 'bg-white py-2',
    'action'        => DcUrlAddon(['module'=>'cms','controll'=>'config','action'=>'update']),
    'method'        => 'post',
    'submit'        => lang('submit'),
    'reset'         => lang('reset'),
    'close'         => false,
    'disabled'      => false,
    'ajax'          => true,
    'callback'      => '',
    'class_tabs'    => 'mb-2',
    'class_link'    => 'rounded-0',
    'class_content' => 'border p-3',
    'class_button'  => 'form-group text-center mb-0',
    'items'         => $items,
])}
{/block}