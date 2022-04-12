$(function() {
    $.getUrlParam = function(name){
        var reg = new RegExp("(^|&)"+name +"=([^&]*)(&|$)");
        var r = window.location.search.substr(1).match(reg);
        if (r!=null) {
            return unescape(r[2]);
        }
        return null;
    };
    $.extend(daicuo.admin, {
        cms : {
            formatter : function(value, row, index, field){
                var $url = daicuo.config.file + '/addon/index?module='+$.getUrlParam('module')+'&controll='+$.getUrlParam('controll')+'&action=index&'+ field +'='+value;
                return '<a class="text-purple" href="'+$url+'">'+value+'</a>';
            },
            events : {
                'click [data-toggle="edit"]': function (event, value, row, index) {
                    $(event.currentTarget).removeAttr('data-toggle');
                }
            },
            eventsDialog : {
                'click [data-toggle="edit"]': function (event, value, row, index) {
                    $(event.currentTarget).attr('data-callback','window.daicuo.admin.cms.dialog');
                }
            },
            dialog: function($data, $status, $xhr) {
                window.daicuo.bootstrap.dialogForm($data);
                window.daicuo.upload.init();
            }
        }
    });
});