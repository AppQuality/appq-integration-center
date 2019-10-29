<?php 
/*
 * The general settings partial
 * 
 * @Author: Davide Bizzi <clochard>
 * @Date:   23/10/2019
 * @Filename: general-settings.php
 * @Last modified by:   clochard
 * @Last modified time: 25/10/2019
 */

?>
<h3> General Settings</h3>
<form id="general_settings" class="container">
    <div class="form-group row">
        <label for="type" class="col-sm-2 col-form-label">Type</label>
        <div class="col-sm-10">
            <select name="bugtracker" class="custom-select">
              <option selected disabled>Select bugtracker type</option>
              <?php foreach ($integrations as $integration) : ?>
                  <option <?= !empty($campaign->bugtracker) && $campaign->bugtracker->integration === $integration['slug'] ? 'selected="selected"' : '' ?>value="<?= $integration['slug'] ?>"><?= $integration['name'] ?></option>
              <?php endforeach ?>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-12">
            <div class="custom-control custom-checkbox">
              <input <?= !empty($campaign->bugtracker) && intval($campaign->bugtracker->upload_media) !== 0 ? 'checked="checked"' : '' ?> type="checkbox" class="custom-control-input" name="upload_media" id="upload_media">
              <label class="custom-control-label" for="upload_media">Upload media</label>
            </div>
        </div>
    </div>
    <?php /* MAXIMIZE NOT DONE WORK 
    <div class="row">
        <div class="col-sm-2">
          <div class="form-group form-check">
              <input type="checkbox" class="form-check-input" id="use_ssh" name="use_ssh">
              <label class="form-check-label" for="use_ssh">Connect with SSH</label>
          </div>
        </div>
        <div class="col-sm-5">
            <div class="form-group row">
                <label for="ssh_username" class="col-sm-2 col-form-label">Username</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="ssh_username"placeholder="Username">
                </div>
            </div>
        </div>
        <div class="col-sm-5">
            <div class="form-group row">
                <label for="ssh_password" class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="ssh_password" placeholder="••••••••••">
                </div>
            </div>
        </div>
    </div>
    */ ?>
    <div class="row">
    	<button id="save_general_settings" type="button" class="col-sm-2 offset-sm-10 btn btn-primary">Save</button>
    </div>
</form>
