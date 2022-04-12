{extend name="apps/common/view/front.tpl" /}
<!-- -->
{block name="header_meta"}
<title>富文本编辑器CKEditor演示－{:config('common.site_name')}</title>
<meta name="keywords" content="CKEditor,呆错编辑器插件" />
<meta name="description" content="CKEditor是全球最优秀的网页在线文字编辑器之一，因其惊人的性能与可扩展性被运用于呆错后台管理框架。"  />
{/block}
{block name="header"}{include file="public/widget/header.tpl" /}{/block}
<!--main -->
{block name="main"}
<div class="container pt-3">
  <h2 class="text-center mb-3">富文本编辑器（CKEditor）</h2>
  <p class="lead text-center text-muted">CKEditor是全球最优秀的网页在线文字编辑器之一，因其惊人的性能与可扩展性被运用于呆错后台管理框架。</p>
  {:DcBuildForm([
    'name'     => 'ckeditor_index_index',
    'class'    => 'bg-white',
    'action'   => DcUrl('ckeditor/index/index', '', ''),
    'method'   => 'post',
    'ajax'     => true,
    'submit'   => lang('submit'),
    'reset'    => lang('reset'),
    'close'    => '',
    'disabled' => false,
    'callback' => '',
    'data'     => '',
    'items'    => [
        [
            'type'        => 'editor',
            'name'        => 'editor',
            'id'          => 'editor',
            'value'       => '呆错（DaiCuo）是一款基于ThinkPHP、Bootstrap、Jquery的极速后台开发框架'.DcHtml('<p>dsfdsfdas</p>'),
            'width'       => '100%',
            'height'      => '600px',
            'autofocus'   => false,
            'readonly'    => false,
            'disabled'    => false,
            'required'    => true,
            'class'       => 'row form-group',
            'class_left'  => 'col-12',
            'class_right' => 'col-12',
        ],
    ]
  ])}
  <div class="card mb-3">
    <div class="card-header">Ckeditor模板调用示例</div>
    <div class="card-body pb-0">
      <pre class="code">{literal}
      {:DcBuildForm([
        'name'     => 'ckeditor_index_index',
        'class'    => 'bg-white py-3',
        'action'   => DcUrl('ckeditor/index/index', '', ''),
        'method'   => 'post',
        'submit'   => lang('submit'),
        'reset'    => lang('reset'),
        'close'    => '',
        'disabled' => false,
        'ajax'     => false,
        'callback' => '',
        'data'     => '',
        'items'    => [
            [
                'type'        => 'editor',
                'name'        => 'editor',
                'id'          => 'editor',
                'value'       => '呆错（DaiCuo）是一款基于ThinkPHP、Bootstrap、Jquery的极速后台开发框架'),
                'widget'      => '100%',
                'height'      => '400px',
                'autofocus'   => false,
                'readonly'    => false,
                'disabled'    => false,
                'required'    => true,
                'class'       => 'row form-group',
                'class_left'  => 'col-12',
                'class_right' => 'col-12',
            ]
        ]
      ])}
    {/literal}</pre> 
    </div>
  </div>
  <div class="card mb-3">
    <div class="card-header">Ckeditor安全输出</div>
    <div class="card-body pb-0">
      <pre class="code">{literal}{:DcEditor($string)}{/literal}</pre>
      <pre class="code">{literal}{:DcHtml($string)}{/literal}</pre>
      <pre class="code">{literal}{:DcStrip($string)}{/literal}</pre> 
    </div>
    <div class="text-center">{:DcEditor('<strong>呆错（DaiCuo）</strong>是一款基于ThinkPHP、Bootstrap、Jquery的极速后台开发框架')}</div>
  </div>
</div>
{/block}
{block name="footer"}{include file="public/widget/footer.tpl" /}{/block}