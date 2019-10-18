<div class="row">
  <div class="col-3">
    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
      <a class="nav-link active" id="general-tab" data-toggle="pill" href="#general" role="tab" aria-controls="general" aria-selected="true">Home</a>
      <?php foreach ($integrations as $integration) : ?>
          <?php 
          $slug = $integration['slug'];
          $name = $integration['name'];
          ?>
          <a class="nav-link" id="<?= $slug ?>-tab" data-toggle="pill" href="#<?= $slug ?>" role="tab" aria-controls="<?= $slug ?>" aria-selected="true"><?= $name ?></a>
      <?php endforeach ?>
    </div>
  </div>
  <div class="col-9">
    <div class="tab-content" id="v-pills-tabContent">
      <div class="tab-pane active" id="general" role="tabpanel" aria-labelledby="general-tab">h.</div>
      <?php foreach ($integrations as $integration) : ?>
          <?php 
          $slug = $integration['slug'];
          $name = $integration['name'];
          $class = $integration['class'];
          ?>
          <div class="tab-pane" id="<?= $slug ?>" role="tabpanel" aria-labelledby="<?= $slug ?>-tab"><?= $class->settings() ?></div>
      <?php endforeach ?>
    </div>
  </div>
</div>