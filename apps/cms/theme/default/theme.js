window.daicuo.cms = {
    init: function(){
        this.imageFluid();
        this.videoFluid();
        this.infoUpClick();
    },
    imageFluid: function(){
        $('.content img').addClass('d-block img-fluid mx-auto');
    },
    videoFluid: function(){
        $('.dc-player').addClass('embed-responsive embed-responsive-16by9');
    },
    infoUpClick: function(){
        $(document).on("click", '[data-toggle="infoUp"]', function() {
            $(this).addClass('disabled');
            var btn = $(this).find('.infoUpValue');
            daicuo.ajax.get($(this).attr('href'), function($data, $status, $xhr) {
                if($data.code == 1){
                    btn.text($data.value);
                }
                
            });
            //daicuo.bootstrap.dialog('<span class="fa fa-spinner fa-spin"></span> Loading...');
            return false;
        });
    },
    dropdownEvent: function(){
        //$('#searchDropdown').dropdown('show');
        $('#searchDropdown').on('show.bs.dropdown', function () {
            //alert(123);
        })
    }
};
//主题JS
$(document).ready(function() { 
    //框架脚本初始化
    window.daicuo.init();
    //主题脚本初始化
    window.daicuo.cms.init();
});