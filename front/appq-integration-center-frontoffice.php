<?php $admin = new AppQ_Integration_Center_Admin('appq-integration-center',APPQ_INTEGRATION_CENTERVERSION); ?>
<?php get_header(); ?>
<div id="base">
	<div id="content">
		<section>
			<?php $admin->bugs_page(); ?>
		</section>
	</div>
</div>
