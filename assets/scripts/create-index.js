/**
 * 创建活动首页的表单处理
 *
 *
 * @package     CI
 * @author      Daniel Sun
 * @link        http://www.onlyke.com
 */

var CreateIndex = function() {

	var handleCheck = function() {
	    var form = $('form');

	    form.validate({
	        errorElement: 'span', //default input error message container
	        errorClass: 'help-block', // default input error message class
	        focusInvalid: false, // do not focus the last invalid input
	        ignore: "",
	        rules: {
	        	name:{
	        		required: true,
	        		rangelength:[6,25],
	        	},
	        	link:{
	        		required: true,
	        		rangelength:[6,25],
	        	},
	        	pw:{
	        		required: true,
	        		rangelength:[6,25],
	        	},
	        	pwconfirm:{
	        		required: true,
	        		rangelength:[6,25],
	        		equalTo:"input[name='pw']",
	        	},
	        },

	        messages: {
	        	pw:{
	        		required: "请输入管理密码",
	        	},
	        	pwconfirm:{
	        		required: "请确认管理密码",
	        		equalTo:"请输入相同的两次密码",
	        	},
	        },
            
	        errorPlacement:function(error,element) {
	        	if(element.attr("name") == "link"){
	        		error.insertAfter(element.parent());
	        		return;
	        	}
				error.insertAfter(element);
			},

            invalidHandler: function (event, validator) { //display error alert on form submit   
                FormInfo.alert();
            },

            highlight: function (element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            success: function (label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },
            submitHandler: function(form) {
			    //FormAjax.submit();
			    form.submit();
			},

	    });

    }


    return {

        //main function to initiate the module
        init: function() {
        	handleCheck();

        }

    };

} ();