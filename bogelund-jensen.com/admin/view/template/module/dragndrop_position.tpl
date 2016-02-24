<?php echo $header; ?><?php echo $column_left; ?>
<?php $bGljZW5zZV9kZXRhaWw = json_decode(base64_decode($license), true); ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-dragndrop-position" data-toggle="tooltip" title="<?php echo $button_save; ?>" id="button-save" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
		</div>
      <h1><?php echo $heading_title; ?></h1>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
	<?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
	<?php if (!isset($bGljZW5zZV9kZXRhaWw['status']) || !$bGljZW5zZV9kZXRhaWw['status']) { ?>
	<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> Module does not have a license key, <a onClick="$('a[href=\'#tab-support\']').click();">activate it</a> to have access to free update and support system.
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
	<?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-dragndrop-position" class="form-horizontal">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
            <li><a href="#tab-support" data-toggle="tab">Support</a></li>
          </ul>
		  <div class="tab-content">
		    <div class="tab-pane active in" id="tab-general">
			  <div class="form-group">
                <label class="col-sm-2 control-label" for="input-module-status"><?php echo $entry_module_status; ?></label>
                <div class="col-sm-4">
                  <select name="dragndrop_position[status]" id="input-module-status" class="form-control">
                    <?php if ($status == 1) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
			  <div class="form-group">
				<label class="col-sm-2 control-label s_help" for="input-access"><?php echo $entry_access; ?><b><?php echo $help_access; ?></b></label>
                <div class="col-sm-4">
                  <?php foreach ($users as $user) { ?>
                  <?php if ($access && in_array($user['user_id'], $access)) { ?>
                  <div class="checkbox">
				    <label><input type="checkbox" name="dragndrop_position[access][]" value="<?php echo $user['user_id']; ?>" checked /> <?php echo $user['username']; ?></label>
				  </div>
                  <?php } else { ?>
				  <div class="checkbox">
				    <label><input type="checkbox" name="dragndrop_position[access][]" value="<?php echo $user['user_id']; ?>" /> <?php echo $user['username']; ?></label>
				  </div>
                  <?php } ?>
                  <?php } ?>
				  <?php if (isset($error['access'])) { ?>
				  <div class="text-danger"><?php echo $error['access']; ?></div>
				  <?php } ?>
                </div>
              </div>
			  <div class="form-group">
                <label class="col-sm-2 control-label s_help" for="input-sort"><?php echo $entry_sort; ?><b><?php echo $help_sort; ?></b></label>
                <div class="col-sm-4">
                  <select name="dragndrop_position[sort]" id="input-sort" class="form-control">
                    <?php if ($sort == 1) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
			</div>
			<div class="tab-pane" id="tab-support">
			  <div id="rspLicense"></div>
			  <h3 style="margin-bottom: 25px;"><b>Your license</b></h3>
			  <?php if (isset($bGljZW5zZV9kZXRhaWw['status']) && $bGljZW5zZV9kZXRhaWw['status']) { ?>
			  <table class="table">
			    <tbody>
				  <tr>
				    <td style="width: 150px;">License key:</td>
					<td><span><?php echo $license_key; ?></span><input type="hidden" name="dragndrop_position[license]" class="license_detail form-control" value="<?php echo $license; ?>" />
				      <input type="text" name="dragndrop_position[license_key]" class="license_key form-control" style="display: none!important;" value="<?php echo $license_key; ?>" /> <a id="re-actLicense" class="btn btn-success">Re-activate</a></td>
				  </tr>
				  <tr>
				    <td>License for:</td>
					<td><?php echo $bGljZW5zZV9kZXRhaWw['customer']; ?>, <?php echo $bGljZW5zZV9kZXRhaWw['domain']; ?></td>
				  </tr>
				</tbody>
			  </table>
			  <?php } else { ?>
			  <div class="form-group">
                <label class="col-sm-2 control-label" for="input-enter-license-key">Enter your license key:</label>
                <div class="col-xs-4">
                  <input type="text" name="dragndrop_position[license_key]" value="<?php echo $license_key; ?>" placeholder="xxxxx-xxxxx-xxxxx-xxxxx-xxxxx" id="input-enter-license-key" class="license_key form-control" />
                </div>
				<div class="col-xs-6">
                  <a id="actLicense" class="btn btn-success">Activate</a>
				</div>
              </div>
			  <?php } ?>
			  <br /><br /><br />
			  If you not have a license key? <a onclick="window.open('http://www.adikon.eu/login')">Click here</a>.<br />
			  Need help? Use our the <a onclick="window.open('http://www.adikon.eu/support')">support system</a>.<br /><br />
			  Adikon.eu, All Rights Reserved.
			  <script type="text/javascript">
			  var mod_id = '4354';
			  var domain = '<?php echo base64_encode((!empty($_SERVER['HTTP_HOST'])) ? $_SERVER['HTTP_HOST'] : (defined('HTTP_SERVER') ? HTTP_SERVER : '')); ?>';
			  </script>
			  <script type="text/javascript" src="//www.adikon.eu/verify/"></script>
			</div>
		  </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>