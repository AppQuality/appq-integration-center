<?php $admin = new AppQ_Integration_Center_Admin('appq-integration-center',APPQ_INTEGRATION_CENTERVERSION); ?>
<?php $cp_id = $admin->get_campaign_id() ?>
<?php $available_campaign_ids = $admin->get_available_campaign_ids() ?>
<?php get_header(); ?>
<div id="base">
	<div id="content">
		<section>
			<?php if (in_array($cp_id,$available_campaign_ids)) : ?>
				<?php $admin->bugs_page(); ?>
			<?php else: ?>
				<?php $admin->partial('not-found'); ?>
			<?php endif ?>
		</section>
	</div>
</div>
