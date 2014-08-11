{include file="_public/header.tpl" nosidebar="true"}
<!-- BEGIN PAGE -->
<div class="page-content  page-content-nosidemenu">
	<!-- BEGIN PAGE HEADER-->
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN PAGE TITLE & BREADCRUMB-->
			<h3 class="page-title">
				{block name="title"}默认页面标题{/block} <small>{block name="subtitle"}默认页面副标题{/block}</small>
			</h3>
			{include file="_public/breadcrumb.tpl"}
			<!-- END PAGE TITLE & BREADCRUMB-->
		</div>
	</div>
	<!-- END PAGE HEADER-->
	{block name="body"}默认的页面内容{/block}
	
</div>
<!-- END PAGE -->
{include file="_public/footer.tpl"}