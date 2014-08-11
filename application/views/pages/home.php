<?php
/*
首页，目前为一静态页面，提供一个form向activities/create提交数据
*/
	$this->load->helper('form');
?>
<div class="page-header">
  <h1>Hangout<sup><small> α</small></sup></h1>
</div>

<div class="container">
	<div class="jumbotron">
	  <h1>Hangout</h1>
	  <p>
正在开发中...<br />
更新：<br />
2014/08/10 13:00<br />
增加活动用户名查重和提交成功提示
</p>
	  <p><a class="btn btn-primary btn-lg" role="button" onclick="location.href='#create';">立即体验</a></p>
	</div>
</div>

<a name="create"></a>
<?php
	echo form_open('',array('id' => 'createActivity', 'class' => 'form-horizontal', 'method' => 'post'));
?>
  <div class="form-group">
	  <div id="title_group">
		<label for="title" class="col-sm-3 control-label">活动名称</label>
		<div class="input-group col-sm-6">
		  <span class="input-group-addon input-lg"></span>
			<input type="text" class="form-control input-lg" id="title" name="title" placeholder=""  onchange="generateSlug(document.getElementById('title').value);">
		</div>
	  </div>
  </div>
  
  <div class="form-group">
	  <div id="slug_group">
		<label for="slug" class="col-sm-3 control-label">活动主页</label>
		<div class="input-group col-sm-6">
		  <span class="input-group-addon input-lg">http://hangout.jinzihao.info/a/</span>
		  <input class="form-control input-lg" type="text" id="slug" name="slug" placeholder="">
		</div>
	  </div>
  </div>
  
  <div class="form-group">
  	<label for="models" class="col-sm-3 control-label">模块选择</label>
    <div class="btn-group" id="models" data-toggle="buttons">
	  <label id="timetable" class="btn btn-default glyphicon glyphicon-calendar">
		<input type="checkbox" id="model_timetable" name="model_timetable">时间表
	  </label>
	  <label id="chatroom" class="btn btn-default glyphicon glyphicon-comment">
		<input type="checkbox" id="model_chatroom" name="model_chatroom">聊天室
	  </label>
	  <label id="location" class="btn btn-default glyphicon glyphicon-map-marker">
		<input type="checkbox" id="model_location" name="model_location">位置共享
	  </label>
	</div>
  </div>
  
  <div class="form-group">
	  <div id="adminPassword_group">
		<label for="adminPassword" class="col-sm-3 control-label">管理密码</label>
		<div class="input-group col-sm-6">
		  <span class="input-group-addon input-lg"></span>
		  <input type="password" class="form-control input-lg" id="adminPassword" name="adminPassword" placeholder="">
		</div>
	  </div>
  </div>
  
  <div class="form-group">
	  <div id="adminPasswordAgain_group">
		<label for="adminPasswordAgain" class="col-sm-3 control-label">重复管理密码</label>
		<div class="input-group col-sm-6">
		  <span class="input-group-addon input-lg"></span>
		  <input type="password" class="form-control input-lg" id="adminPasswordAgain" name="adminPasswordAgain" placeholder="">
		</div>
	  </div>
  </div>
  
  <div class="form-group">
    <div class="col-sm-offset-3 col-sm-6">
      <button type="button" class="btn btn-default input-lg" onclick="createActivity();">创建活动</button>
    </div>
  </div>
</form>