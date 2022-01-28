<div id="content">
    <section>
        <div class="section-body">
            <div class="row">
                <div class="col-sm-12">
                    <?php if (is_user_logged_in()) : ?>
                        <h3 class="lead text-center"><?= __("You cannot view this page. If you think any differently, please write an email to", 'unguess'); ?> <a href="mailto:support@unguess.io">support@unguess.io</a> </h3>
                        <div style="height: 5vh"></div>
                    <?php else : ?>
                        <div class="contain-lg">
                            <img class="img-responsive center-block" src="<?= APPQ_INTEGRATION_CENTER_URL . '/admin/images/logo.svg' ?>" style="max-width:280px" alt="Unguess Logo">
                            <br>
                            <div class="width-8 center-block">
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="text-primary text-center"><?= __('Log in', 'unguess') ?></h3>
                                        <br>
                                        <form class="form form-validate" id="customer_login_form">
                                            <div class="form-group">
                                                <input class="form-control input-old" id="cuFormEmail" name="username" placeholder="<?= __('Email Address', 'unguess') ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="password" class="form-control input-old" placeholder="<?= __('Password', 'unguess') ?>" id="cuFormPassword" name="password" required>
                                                <p class="help-block"><a href="<?= wp_lostpassword_url() ?>"><?= __('Forgot password?', 'unguess') ?></a></p>
                                            </div>
                                            <br>
                                            <input type="hidden" value="ajaxlogin" name="action">
                                            <input type="hidden" name="security" value="<?= wp_create_nonce('ajax-login-nonce'); ?>">
                                            <button class="btn btn-primary btn-block" id="customer_login_form_submit"><?= __('Sign in', 'unguess') ?></button>

                                            <p class="message text-danger text-center" id="customer_help" style="display: none;"></p>
                                        </form>
                                    </div>
                                </div><!-- END .card -->
                                <p>
                                    <a class="btn btn-flat btn-primary" href="https://unguess.io"><i class="fa fa-chevron-left fa-fw"></i> <?= _x("Back to Unguess", 'login', 'unguess'); ?></a>
                                </p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</div><!-- end content -->