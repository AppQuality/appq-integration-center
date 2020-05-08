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
    <div class="row">
    	<button id="save_general_settings" type="button" class="col-sm-2 offset-sm-10 btn btn-primary">Save</button>
    </div>
</form>


<div class="row">
    <h4 class="col-sm-12"> Available fields <button type="button" class="btn btn-primary float-right"  data-toggle="modal" data-target="#addFieldModal">Add new</button> </h4>
    <div class="col-sm-12 available_fields">
        <span> {Bug.message} - Titolo del bug </span> 
        <span> {Bug.steps} - Step by step description del bug </span> 
        <span> {Bug.expected} - Expected result del bug </span> 
        <span> {Bug.actual} - Actual result del bug </span> 
        <span> {Bug.note} - Note del bug </span> 
        <span> {Bug.id} - ID del bug </span> 
        <span> {Bug.internal_id} - Internal id del bug </span> 
        <span> {Bug.status_id} - Status id del bug </span> 
        <span> {Bug.status} - Status name del bug </span> 
        <span> {Bug.severity_id} - Severity id del bug </span> 
        <span> {Bug.severity} - Severity name del bug </span> 
        <span> {Bug.replicability_id} - Replicability id del bug </span> 
        <span> {Bug.replicability} - Replicability name del bug </span> 
        <span> {Bug.type_id} - Bug Type id id del bug </span> 
        <span> {Bug.type} - Bug Type name del bug </span> 
        <span> {Bug.manufacturer} - Manufacturer del device del bug </span> 
        <span> {Bug.model} - Modello del device del bug </span> 
        <span> {Bug.os} - OS del device del bug </span> 
        <span> {Bug.os_version} - OS version del device del bug </span>
        <span> {Bug.media} - Media del bug, le immagini verranno mostrate nel contenuto </span>
        <span> {Bug.media_links} - Link ai media del bug </span>
        <?php foreach ($additional_fields as $additional_field) : ?>
            <span class="additional"> {Bug.field.<?=$additional_field->slug ?>} - Additional field <?=$additional_field->title ?> </span>
        <?php endforeach ?>
        <?php foreach ($custom_fields as $custom_field) : ?>
            <span data-target="#addFieldModal" data-map="<?= esc_attr($custom_field->map) ?>" data-source="<?= esc_attr($custom_field->source) ?>" data-name="<?= esc_attr($custom_field->name) ?>" class="custom"> <?=$custom_field->name ?> </span>
        <?php endforeach ?>
    </div>
</div>

<?php 
$this->partial('bugs/add-field-modal', array()) 
?>