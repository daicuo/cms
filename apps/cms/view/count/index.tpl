<div class="card-deck mb-2">
  <div class="card">
    <div class="card-body d-flex flex-row justify-content-between align-items-center">
      <div>
        <p class="card-title mb-1">{:lang('cms/count/detail')}</p>
        <h5 class="card-text" id="count-detail">0</h5>
      </div>
      <i class="fa fa-2x fa-file-text text-danger"></i>
    </div>
  </div>
  <div class="card">
    <div class="card-body d-flex flex-row justify-content-between align-items-center">
      <div>
        <p class="card-title mb-1">{:lang('cms/count/category')}</p>
        <h5 class="card-text" id="count-category">0</h5>
      </div>
      <i class="fa fa-2x fa-folder-o text-muted"></i>
    </div>
  </div>
  <div class="card">
    <div class="card-body d-flex flex-row justify-content-between align-items-center">
      <div>
        <p class="card-title mb-1">{:lang('cms/count/tag')}</p>
        <h5 class="card-text" id="count-tag">0</h5>
      </div>
      <i class="fa fa-2x fa-tags text-purple"></i> 
    </div>
  </div>
</div>
<script>
$(document).ready(function () {
    daicuo.ajax.get("{:DcUrlAddon( ['module'=>'cms','controll'=>'count','action'=>'index'] )}", function(data, status, xhr){
        $('#count-category').text(data.category);
        $('#count-tag').text(data.tag);
        $('#count-detail').text(data.detail);
    });
});
</script>