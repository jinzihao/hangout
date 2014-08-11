<?php
/*
活动显示页，为一静态页面，可通过activities模块post数据加入活动
*/
	$this->load->helper('form');
?>
<div class="page-header">
  <h1><?php echo $title; ?></h1>
</div>

<div class="container">
	<div class="jumbotron">
	  <p><?php echo $description ?></p>
	</div>
</div>
<a name="join"></a>
<?php
	echo form_open('',array('id' => 'createActivity', 'class' => 'form-horizontal', 'method' => 'post'));
?>
<input type="hidden" id="id" value="<?php echo $id ?>" />
<div class="container">
	<div class="form-group">
	  <div id="username_group">
		<label for="username" class="col-sm-3 control-label">姓名</label>
		<div class="input-group col-sm-6">
		  <span class="input-group-addon input-lg"></span>
			<input type="text" class="form-control input-lg" id="username" name="username" placeholder="" >
		</div>
	  </div>
  </div>
  
  <div class="form-group">
	  <div id="userPassword_group">
		<label for="userPassword" class="col-sm-3 control-label">密码</label>
		<div class="input-group col-sm-6">
		  <span class="input-group-addon input-lg"></span>
		  <input class="form-control input-lg" type="password" id="userPassword" name="slug" placeholder="">
		</div>
	  </div>
  </div>

  <div class="form-group">
          <div id="userPasswordAgain_group">
                <label for="userPasswordAgain" class="col-sm-3 control-label">密码(重复)</label>
                <div class="input-group col-sm-6">
                  <span class="input-group-addon input-lg"></span>
		  <input class="form-control input-lg" type="password" id="userPasswordAgain" name="slug" placeholder="">
                </div>
          </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-3 col-sm-6">
      <button type="button" class="btn btn-default input-lg" onclick="joinActivity();">加入活动</button>
    </div>
  </div>
</form>
</div>
