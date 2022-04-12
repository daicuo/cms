{extend name="apps/common/view/admin.tpl" /}
<!-- -->
{block name="header_meta"}
<title>{:lang("cms/admin/create")}－{:lang('appName')}</title>
{/block}
<!-- -->
{block name="header_addon"}
<link href="{$path_root}{$path_addon}view/theme.css" rel="stylesheet">
<script src="{$path_root}{$path_addon}view/theme.js"></script>
{/block}
<!-- -->
{block name="main"}
<h6 class="border-bottom pb-2 mb-0 text-purple">
  {:lang("cms/admin/create")}
</h6>
<!-- -->
{:DcBuildForm([
    'name'     => 'cms/admin/create',
    'class'    => 'bg-white form-create py-2',
    'action'   => DcUrlAddon(['module'=>'cms','controll'=>'admin','action'=>'save']),
    'method'   => 'post',
    'submit'   => lang('submit'),
    'reset'    => lang('reset'),
    'close'    => false,
    'disabled' => false,
    'callback' => '',
    'ajax'     => true,
    'data'     => '',
    'items'    => $fields,
    'class_button' => 'form-group text-center pt-3 mb-0',
])}
{/block}