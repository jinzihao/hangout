//SUNCHAT 格式化输出日期
Date.prototype.format = function(format) {
    var o = {
        "M+": this.getMonth() + 1,
        //month 
        "d+": this.getDate(),
        //day 
        "h+": this.getHours(),
        //hour 
        "m+": this.getMinutes(),
        //minute 
        "s+": this.getSeconds(),
        //second 
        "q+": Math.floor((this.getMonth() + 3) / 3),
        //quarter 
        "S": this.getMilliseconds() //millisecond 
    }
    if (/(y+)/.test(format)) format = format.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
    for (var k in o) if (new RegExp("(" + k + ")").test(format)) format = format.replace(RegExp.$1, RegExp.$1.length == 1 ? o[k] : ("00" + o[k]).substr(("" + o[k]).length));
    return format;
}


bootbox.setDefaults({
  /**
   * @optional String
   * @default: en
   * which locale settings to use to translate the three
   * standard button labels: OK, CONFIRM, CANCEL
   */
  locale: "zh_CN"
});

jQuery.extend(jQuery.validator.messages, {
	required: "必填字段",
	remote: "请修正该字段",
	email: "请输入正确格式的电子邮件",
	url: "请输入合法的网址",
	date: "请输入合法的日期或时间，类似2000-01-01 12:00:00",
	dateISO: "请输入合法的日期 (ISO).",
	number: "请输入合法的数字",
	digits: "只能输入整数",
	creditcard: "请输入合法的信用卡号",
	equalTo: "请再次输入相同的值",
	accept: "请输入拥有合法后缀名的字符串",
	maxlength: jQuery.validator.format("请输入一个长度最多是 {0} 的字符串"),
	minlength: jQuery.validator.format("请输入一个长度最少是 {0} 的字符串"),
	rangelength: jQuery.validator.format("请输入一个长度介于 {0} 和 {1} 之间的字符串"),
	range: jQuery.validator.format("请输入一个介于 {0} 和 {1} 之间的值"),
	max: jQuery.validator.format("请输入一个最大为 {0} 的值"),
	min: jQuery.validator.format("请输入一个最小为 {0} 的值")
});

jQuery.validator.addMethod("oldtotime", function(value, element, param) {
	var time = Date.parse(value);
	return time > param;
}, jQuery.validator.format("请输入未来的时间"));

jQuery.validator.addMethod("oldtoedit", function(value, element, param) {
	if (SC_EDIT == true) return true;
	var time = Date.parse(value);
	return time > param;
}, jQuery.validator.format("请输入未来的时间"));

jQuery.validator.addMethod("oldto", function(value, element, param) {
	var before = Date.parse(jQuery(param).val());
	var time = Date.parse(value);
	return time > before;
}, jQuery.validator.format("请输入未来的时间"));

jQuery.validator.addMethod("youngto", function(value, element, param) {
	var before = Date.parse(jQuery(param).val());
	var time = Date.parse(value);
	return time < before;
}, jQuery.validator.format("请输入过去的时间"));

jQuery.validator.addMethod("smallto", function(value, element, param) {
	var big = parseInt(jQuery(param).val());
	var small = parseInt(value);
	return small < big;
}, jQuery.validator.format("数字范围不正确"));


var FormInfo = function () {

	return {
        //main function to initiate the module
        alert: function () {
          bootbox.dialog({
              message: '您填写的信息有误，请返回修改一下^_^！',
              title: '提示',
              closeButton: false,
              buttons: {
                button: {
                  label: "好的",
                  className: 'red',
                }
              }
          });
        }

    };

}();

jQuery('button[data-dismiss="hide"]').click(function(){
    jQuery(this).parent().hide();
});
