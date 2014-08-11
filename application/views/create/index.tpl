{extends file='_public/base_nosidebar.tpl'}
{block name="headercss"}
<link rel="stylesheet" type="text/css" href="assets/plugins/bootstrap-switch/static/stylesheets/bootstrap-switch-metro.css"/>
{/block} 
{block name="footerplugin"}
<script src="assets/plugins/bootstrap-switch/static/js/bootstrap-switch.min.js" type="text/javascript" ></script>
{/block} 
{block name="footerjs"}
<script src="assets/scripts/create-index.js" type="text/javascript" ></script>
<script type="text/javascript">
	CreateIndex.init();
</script>
{/block} 
{block name="title"}创建活动{/block}
{block name="subtitle"}这里随便写点儿什么吧{/block}
{block name="body"}
<div class="row">
	<div class="col-md-12">
		<div class="note note-info">
			<h4 class="block">新加功能</h4>
			<p>随便写点什么功能不好么，拉啦啦啦</p>
		</div>
	</div>
</div>
<div class="clearfix"></div>
<div class="row">
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<div class="dashboard-stat blue">
			<div class="visual">
				<i class="fa fa-calendar"></i>
			</div>
			<div class="details">
				<div class="number">
					1349
				</div>
				<div class="desc">                           
					今日活动
				</div>
			</div>
			<a class="more" href="#">
			View more <i class="m-icon-swapright m-icon-white"></i>
			</a>                 
		</div>
	</div>
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<div class="dashboard-stat green">
			<div class="visual">
				<i class="fa fa-check"></i>
			</div>
			<div class="details">
				<div class="number">549</div>
				<div class="desc">进行中</div>
			</div>
			<a class="more" href="#">
			View more <i class="m-icon-swapright m-icon-white"></i>
			</a>                 
		</div>
	</div>
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<div class="dashboard-stat purple">
			<div class="visual">
				<i class="fa fa-flag-checkered"></i>
			</div>
			<div class="details">
				<div class="number">8000</div>
				<div class="desc">共用活动</div>
			</div>
			<a class="more" href="#">
			View more <i class="m-icon-swapright m-icon-white"></i>
			</a>                 
		</div>
	</div>
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<div class="dashboard-stat yellow">
			<div class="visual">
				<i class="fa fa-group"></i>
			</div>
			<div class="details">
				<div class="number">10023</div>
				<div class="desc">参与人次</div>
			</div>
			<a class="more" href="#">
			View more <i class="m-icon-swapright m-icon-white"></i>
			</a>                 
		</div>
	</div>
</div>
<div class="clearfix"></div>
<div class="row">
	<div class="col-md-12">
		<div class="portlet box blue ">
			<div class="portlet-title">
				<div class="caption"><i class="fa fa-reorder"></i>活动信息</div>
			</div>
			<div class="portlet-body form">
				<!-- BEGIN FORM-->
				<form action="{site_url target='create/handle'}" class="form-horizontal form-bordered form-row-stripped" method="post">
					<div class="form-body">
						<div class="form-group">
							<label class="control-label col-md-3">活动名称</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="name"/>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">活动主页</label>
							<div class="col-md-6">
								<div class="input-group">
									<span class="input-group-btn">
									<p class="btn btn-text green" type="button">{$activity_url}</p>
									</span>
									<input type="text" class="form-control" name="link" />
								</div>
								<!-- /input-group -->
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">时间表</label>
							<div class="col-md-9">
								<div class="make-switch" data-on="primary" data-off="info">
									<input type="checkbox" class="toggle" name="timetable" />
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">聊天室</label>
							<div class="col-md-9">
								<div class="make-switch" data-on="primary" data-off="info">
									<input type="checkbox" class="toggle" name="chat" />
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">位置共享</label>
							<div class="col-md-9">
								<div class="make-switch" data-on="primary" data-off="info">
									<input type="checkbox" class="toggle" name="location" />
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">管理密码</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="pw" />
							</div>
						</div>
						<div class="form-group last">
							<label class="control-label col-md-3">重复密码</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="pwconfirm" />
							</div>
						</div>
					</div>
					<div class="form-actions fluid">
						<div class="row">
							<div class="col-md-12">
								<div class="col-md-offset-3 col-md-9">
									<button type="submit" class="btn blue col-md-2"><i class="fa fa-check"></i> 提交</button>                          
								</div>
							</div>
						</div>
					</div>
				</form>
				<!-- END FORM-->  
			</div>
		</div>
	</div>
</div>
{/block}