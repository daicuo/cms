<div class="{$form.class|default='row form-group'}">
  <label class="{$form.class_left|default='col-md-2'}" for="{$form.name}">
    <strong>{$form.title}</strong>
  </label>
  <div class="{$form.class_right|default='col-md-6'}" data-toggle="script">
    <textarea {if $form['readonly']}readonly{/if} {if $form['disabled']}disabled{/if} {if $form['required']}required{/if} {if $form['autofocus']}autofocus{/if} class="dc-editor {$form.class_right_control|default='form-control form-control-sm'}" id="{:DcEmpty($form['id'],$form['name'])}" name="{$form.name}" rows="{$form.rows|default='12'}" placeholder="{$form.placeholder}" data-upload-url="{$path_upload}">{$form.value|DcHtml}</textarea>
    {if $form['tips']}
    <small class="{$form.class_tips|default='form-text text-muted'}">{$form.tips}</small>
    {/if}
    <div id="dc-editor-upload"></div>
  </div>
</div>
<script>
$(document).ready(function () {
    window.CKEDITOR_BASEPATH = window.daicuo.config.root+'apps/ckeditor/4.16.2/';
    window.daicuo.ajax.script(CKEDITOR_BASEPATH+'ckeditor.js', function(){
        CKEDITOR.replace('{$form.name}',{
            width : '{$form.width|default='100%'}',
            height : '{$form.height|default='300px'}',
            language: '{:config("default_lang")}'
        });
    });
});
</script>