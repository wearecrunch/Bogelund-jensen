<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <?php if ($error) { ?>
  <div class="warning"><?php echo $error; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/total.png" alt="" /> <?php echo $heading_title; ?></h1>
    </div>
    <div class="content">
      <table class="list">
        <thead>
          <tr>
<td width="1"> </td>
            <td class="left"><?php echo $column_name; ?></td>
            <td class="left"><?php echo $column_status; ?></td>
            <td class="right"><?php echo $column_sort_order; ?></td>
            <td class="right"><?php echo $column_action; ?></td>
          </tr>
        </thead>
        <tbody class="dd_sortable_list">
          <?php if ($extensions) { ?>
          <?php foreach ($extensions as $extension) { ?>
          <tr>
<td style="text-align: center;"><img src="view/javascript/DragNDropPosition/image/<?php echo ($this->config->get('dragndrop_position_status')) ? 'ddp_drag_on.png' : 'ddp_drag_off.png'; ?>" alt="Drag" title="Drag" class="ddp_drag" /></td>
            <td class="left"><?php echo $extension['name']; ?></td>
            <td class="left"><?php echo $extension['status'] ?></td>
            <td class="right"><?php echo $extension['sort_order']; ?></td>
            <td class="right"><?php foreach ($extension['action'] as $action) { ?>
              [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
              <?php } ?></td>
          </tr>
          <?php } ?>
          <?php } else { ?>
          <tr>
            <td class="center" colspan="8"><?php echo $text_no_results; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php if ($this->config->get('dragndrop_position_status') && ($this->config->get('dragndrop_position_access') && in_array($this->user->getId(), (array)$this->config->get('dragndrop_position_access')))) { ?>
				<script type="text/javascript"><!--
				$('.dd_sortable_list').dragNdrop_position({php_token: '<?php echo $this->session->data['token']; ?>'});
				//--></script>
			<?php } ?>
<?php echo $footer; ?>