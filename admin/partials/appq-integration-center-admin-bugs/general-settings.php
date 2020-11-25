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
$api = new IntegrationCenterRestApi($campaign->id,null,null);
?>
<h3> General Settings   
	<button data-toggle="modal" data-target="#import_from_cp_modal" type="button" class="btn btn-success float-right">Import from cp</button>
</h3>
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
    <div class="row">
    	<?php if (property_exists($campaign->bugtracker,'default_bug')) : ?>
			<button id="update_default_bug" type="button" class="col-sm-2 btn btn-primary">Update default bug</button>
			<a href="<?= $campaign->bugtracker->default_bug?>" class="btn btn-secondary" target="_blank">
				<i class="fa fa-external"></i> Show default bug
			</a>
		<?php else: ?>
			<button id="import_default_bug" type="button" class="col-sm-2 btn btn-primary">Import default bug</button>
		<?php endif;?>
	</div>
    <div class="row">
    	<button id="save_general_settings" type="button" class="col-sm-2 offset-sm-10 btn btn-primary">Save</button>
    </div>
</form>


<div class="row">
    <h4 class="col-sm-12"> Available fields <button type="button" class="btn btn-primary float-right"  data-toggle="modal" data-target="#addFieldModal">Add new</button> </h4>
    <div class="col-sm-12 available_fields">
		<?php foreach($api->mappings as $key => $value) : ?>
		<span <?= array_key_exists('type',$value) ? 'class="'.$value['type'].'"' : '' ?>> <?= $key ?> - <?= $value['description'] ?> </span> 
		<?php endforeach ?>
        <?php foreach ($custom_fields as $custom_field) : ?>
            <span data-target="#addFieldModal" data-map="<?= esc_attr($custom_field->map) ?>" data-source="<?= esc_attr($custom_field->source) ?>" data-name="<?= esc_attr($custom_field->name) ?>" class="custom"> <?=$custom_field->name ?> </span>
        <?php endforeach ?>
    </div>
</div>

<?php 
$this->partial('bugs/add-field-modal', array());
$this->partial('bugs/import-configuration-modal', array()) 
?>
