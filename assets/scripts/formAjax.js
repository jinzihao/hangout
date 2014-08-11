/**
 * 统一的表单AJAX提交
 *
 *
 * @package     CI
 * @author      Daniel Sun
 * @link        http://www.onlyke.com
 */

var FormAjax = function () {

    var form = $("form");
    var info;
    var status;
    var url;
    var img;
    var title;
    var className;

    /**
     * 跳转到指定的URL
     * @return {[type]} [description]
     */
    var jumpToUrl = function(){
        if(url != '' && typeof(url) != "undefined" && url != "undefined"){
            if(url == '[#RELOAD#]'){
                location.reload(true);
            }else{
                window.location.href = url;
            }
            return;
        }else{
            if(status){
                if(typeof FormAjaxSuccess !='undefined') FormAjaxSuccess.init();
            }else{
                if(typeof FormAjaxError !='undefined') FormAjaxError.init();
            }
        }
    }

    return {
        //main function to initiate the module
        
        /**
         * 直接HOOK表单的提交动作方法
         * @return {[type]} [description]
         */
        hook: function () {
            form.submit(function(e){
                FormAjax.submit();
                return false;
            });
        },


        /**
         * 手动提交方法
         * @return {[type]} [description]
         */
        submit: function () {

            $.ajax({
                cache: true,
                type: "POST",
                url: form.attr('action'),
                data:form.serialize(),
                async: false,
                dataType: 'json',
                error: function(request) {
                    info = '网络连接失败';
                    title = '错误';
                    className = 'red';
                },
                success: function(data) {
                    info = data.info;
                    url = data.url;
                    if (data.status == 1){
                        status = true;
                        title = '成功';
                        className = 'blue';
                    }else{
                        status = false;
                        title = '错误';
                        className = 'red';
                    }
                }
            });

            //var dialog = '<div class="thumbnail" style="margin-bottom: 0px;"><img src="'+ img +'" alt="100%x200" style="width: auto; height: 80px; display: block;"><div class="caption"><p style="">'+ info +'</p></div></div>';
            if(info == '' || typeof(info) == "undefined" || info == "undefined"){
                jumpToUrl();
                return;
            }

            bootbox.dialog({
                message: info,
                title: title,
                closeButton: false,
                buttons: {
                  button: {
                    label: "好的",
                    className: className,
                    callback: function() {
                       jumpToUrl();
                    }
                  }
                }
            });
        }

        

    };

}();