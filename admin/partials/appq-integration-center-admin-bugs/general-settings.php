<h3> General Settings</h3>
<div class="container">
    <div class="form-group row">
        <label for="type" class="col-sm-2 col-form-label">Type</label>
        <div class="col-sm-10">
            <select class="custom-select">
              <option selected>Select bugtracker type</option>
              <?php foreach ($integrations as $integration) : ?>
                  <option <?= !empty($campaign->bugtracker) && $campaign->bugtracker->integration === $integration['slug'] ? 'selected="selected"' : '' ?>value="<?= $integration['slug'] ?>"><?= $integration['name'] ?></option>
              <?php endforeach ?>
            </select>
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
</div>