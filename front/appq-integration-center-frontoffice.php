<?php

$admin = new AppQ_Integration_Center_Admin('appq-integration-center', APPQ_INTEGRATION_CENTERVERSION);
$cp_id = $admin->get_campaign_id();
$available_campaign_ids = $admin->get_customer_available_campaign_ids();

get_header();
if (in_array($cp_id, $available_campaign_ids) || current_user_can('manage_options')) : ?>
  <?php $admin->get_campaign($cp_id); ?>
  <div id="content">
    <section>
      <div class="section-body">
        <?php $admin->bugs_page(); ?>
      </div>
    </section>
  </div>
  <div class="offcanvas">
    <?php $admin->available_fields($admin->campaign); ?>
  </div>

<?php else :
  $admin->partial('generic-error-page');
endif;
get_footer();