
	<select  id="<?= $setting_name ?>" name="<?= $setting_name ?>" class="custom-select">
	  <option selected disabled>Select Option</option>
	  <?php $options = array_key_exists('select_options',$setting_data) ? $setting_data['select_options'] : array(); ?>
	  <?php $value = array_key_exists('value',$setting_data) ? $setting_data['value'] : false; ?>
	  <?php foreach ( $options as $option) : ?>
		  <option <?= $value == $option  ? 'selected="selected"' : '' ?> value="<?= $option ?>"><?= $option ?></option>
	  <?php endforeach ?>
	</select>