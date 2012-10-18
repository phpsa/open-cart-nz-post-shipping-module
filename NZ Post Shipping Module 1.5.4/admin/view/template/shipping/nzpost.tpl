<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/shipping.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="form">
          <tr>
            <td><span class="required">*</span> <?php echo $entry_api_key; ?></td>
            <td><input type="text" name="nzpost_api_key" value="<?php echo $nzpost_api_key; ?>" />
              <?php if ($error_api_key) { ?>
              <span class="error"><?php echo $error_api_key; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_source_postcode; ?></td>
            <td><input type="text" name="nzpost_source_postcode" value="<?php echo $nzpost_source_postcode; ?>" />
              <?php if ($error_source_postcode) { ?>
              <span class="error"><?php echo $error_source_postcode; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_test; ?></td>
            <td><?php if ($nzpost_test) { ?>
              <input type="radio" name="nzpost_test" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="nzpost_test" value="0" />
              <?php echo $text_no; ?>
              <?php } else { ?>
              <input type="radio" name="nzpost_test" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="nzpost_test" value="0" checked="checked" />
              <?php echo $text_no; ?>
              <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_national_options; ?></td>
            <td id="national-options">
              <div id="NZ">
                <div class="scrollbox">
                  <div class="even">
                    <?php if ($nzpost_national_tracking) { ?>
                    <input type="checkbox" name="nzpost_national_tracking" value="1" checked="checked" />
                    <?php echo $text_nzpost_national_tracking; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="nzpost_national_tracking" value="1" />
                    <?php echo $text_nzpost_national_tracking; ?>
                    <?php } ?>
                  </div>
                  <div class="odd">
                    <?php if ($nzpost_national_signature) { ?>
                    <input type="checkbox" name="nzpost_national_signature" value="1" checked="checked" />
                    <?php echo $text_nzpost_national_signature; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="nzpost_national_signature" value="1" />
                    <?php echo $text_nzpost_national_signature; ?>
                    <?php } ?>
                  </div>
                  <div class="even">
                    <?php if ($nzpost_national_postage_only) { ?>
                    <input type="checkbox" name="nzpost_national_postage_only" value="1" checked="checked" />
                    <?php echo $text_nzpost_national_postage_only; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="nzpost_national_postage_only" value="1" />
                    <?php echo $text_nzpost_national_postage_only; ?>
                    <?php } ?>
                  </div>
                </div>
              </div>
              <a onclick="$(this).parent().find(':checkbox').attr('checked', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').attr('checked', false);"><?php echo $text_unselect_all; ?></a></td>
          </tr>
          <tr>
            <td><?php echo $entry_tax; ?></td>
            <td><select name="nzpost_tax_class_id">
                <option value="0"><?php echo $text_none; ?></option>
                <?php foreach ($tax_classes as $tax_class) { ?>
                <?php if ($tax_class['tax_class_id'] == $nzpost_tax_class_id) { ?>
                <option value="<?php echo $tax_class['tax_class_id']; ?>" selected="selected"><?php echo $tax_class['title']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_international_options; ?></td>
            <td id="international-options">
              <div id="International">
                <div class="scrollbox">
                  <div class="even">
                    <?php if ($nzpost_international_tracking) { ?>
                    <input type="checkbox" name="nzpost_international_tracking" value="1" checked="checked" />
                    <?php echo $text_nzpost_international_tracking; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="nzpost_international_tracking" value="1" />
                    <?php echo $text_nzpost_international_tracking; ?>
                    <?php } ?>
                  </div>
                  <div class="odd">
                    <?php if ($nzpost_international_signature) { ?>
                    <input type="checkbox" name="nzpost_international_signature" value="1" checked="checked" />
                    <?php echo $text_nzpost_international_signature; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="nzpost_international_signature" value="1" />
                    <?php echo $text_nzpost_international_signature; ?>
                    <?php } ?>
                  </div>
                </div>
              </div>
              <a onclick="$(this).parent().find(':checkbox').attr('checked', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').attr('checked', false);"><?php echo $text_unselect_all; ?></a></td>
          </tr>
          <tr>
            <td><?php echo $entry_international_tax; ?></td>
            <td><select name="nzpost_international_tax_class_id">
                <option value="0"><?php echo $text_none; ?></option>
                <?php foreach ($tax_classes as $tax_class) { ?>
                <?php if ($tax_class['tax_class_id'] == $nzpost_international_tax_class_id) { ?>
                <option value="<?php echo $tax_class['tax_class_id']; ?>" selected="selected"><?php echo $tax_class['title']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_display_weight; ?></td>
            <td><?php if ($nzpost_display_weight) { ?>
              <input type="radio" name="nzpost_display_weight" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="nzpost_display_weight" value="0" />
              <?php echo $text_no; ?>
              <?php } else { ?>
              <input type="radio" name="nzpost_display_weight" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="nzpost_display_weight" value="0" checked="checked" />
              <?php echo $text_no; ?>
              <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_geo_zone; ?></td>
            <td><select name="nzpost_geo_zone_id">
                <option value="0"><?php echo $text_all_zones; ?></option>
                <?php foreach ($geo_zones as $geo_zone) { ?>
                <?php if ($geo_zone['geo_zone_id'] == $nzpost_geo_zone_id) { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_status; ?></td>
            <td><select name="nzpost_status">
                <?php if ($nzpost_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_sort_order; ?></td>
            <td><input type="text" name="nzpost_sort_order" value="<?php echo $nzpost_sort_order; ?>" size="1" /></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?>