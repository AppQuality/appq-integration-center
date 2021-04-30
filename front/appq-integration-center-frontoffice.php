<?php $admin = new AppQ_Integration_Center_Admin('appq-integration-center',APPQ_INTEGRATION_CENTERVERSION); ?>
<?php $cp_id = $admin->get_campaign_id() ?>
<?php $available_campaign_ids = $admin->get_available_campaign_ids() ?>
<?php get_header(); ?>
<div id="base">
    <?php if (in_array($cp_id,$available_campaign_ids)) : ?>
		<div id="content">
			<section>
                <?php $admin->bugs_page(); ?>
			</section>
		</div>
    <?php else: ?>
        <?php handle_error_page(); ?>
    <?php endif ?>
</div>
