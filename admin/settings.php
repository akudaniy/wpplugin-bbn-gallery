<?php
/**
 * Update plugin settings
 */
add_action('admin_init', 'bbn_save_options');
function bbn_save_options() {

  if( isset($_POST['bbn_save_options']) ) :

    $updates = array_merge( bbn_options_items_default(), $_POST['bbn_options'] );
    update_option( 'bbn_options', $updates );

    add_action( 'admin_notices', 'bbn_admin_notice_options_saved' );

  endif;
}



add_action('admin_init', 'bbn_reset_options');
function bbn_reset_options() {

  if( isset($_POST['bbn_reset_options']) ) :
    update_option('bbn_options', bbn_options_items_default() );
    add_action( 'admin_notices', 'bbn_admin_notice_options_reset' );
  endif;

}



/**
 * Notification for updated plugin settings
 */
function bbn_admin_notice_options_saved() {
  echo '<div class="updated settings-error is-dismissible"><p>Settings saved</p></div>';
}

function bbn_admin_notice_options_reset() {
  echo '<div class="error settings-error is-dismissible"><p>Settings reset to default</p></div>';
}


function bbn_settings_fn() {
  global $wpdb;
  $options = bbn_options_items();
  
  ?>

  <div class="wrap">
  <h2>Adi Image Gallery Settings</h2>

  <form action="" method="post">

    <table class="form-table">
    <tbody>

    <tr>
    <th scope="row"><label for="bbn_image_size">Image Size</label></th>
    <td>
      <select id="bbn_image_size" name="bbn_options[bbn_image_size]">
        <option value="thumbnail" <?php selected( $options['bbn_image_size'], 'thumbnail' ); ?>>Thumbnail</option>
        <option value="large" <?php selected( $options['bbn_image_size'], 'large' ); ?>>Large</option>
        <option value="original" <?php selected( $options['bbn_image_size'], 'original' ); ?>>Original</option>        
      </select>
      <p class="description">Ukuran gambar yang mau ditampilkan pada gallery</p>
    </td>
    </tr>

    <tr valign="top">
      <th scope="row"><label for="bbn_single_amount">Single Page Images</label></th>
      <td>
        <input type="text" id="bbn_single_amount" name="bbn_options[bbn_single_amount]" class="regular-text" value="<?php echo $options['bbn_single_amount'] ?>" />
        <p class="description">Jumlah image yang tampil pada halaman single post</p>
      </td>
    </tr>

    <tr valign="top">
      <th scope="row"><label for="bbn_image_link">Image Link</label></th>
      <td>
        <select id="bbn_image_link" name="bbn_options[bbn_image_link]">
          <option value="page" <?php selected( $options['bbn_image_link'], 'page' ); ?>>Attachment Page</option>
          <option value="source" <?php selected( $options['bbn_image_link'], 'source' ); ?>>Media File</option>
        </select>
        <p class="description">Image di gallery mau link ke attachment page, atau media file</p>
      </td>
    </tr>

    <tr valign="top">
      <th scope="row">Other Settings</th>
      <td>
        <label for="bbn_randomize">
          <input type="checkbox" id="bbn_randomize" name="bbn_options[bbn_randomize]" <?php checked($options['bbn_randomize'], 'on') ?> /> Randomize Images
        </label>
        <p class="description">Acak urutan penampilan gambar dalam gallery di single post</p>
        <br/>
      </td>
    </tr>

    <tr valign="top">
      <th scope="row"><label for="bbn_custom_css">Custom CSS</label></th>
      <td>
        <p>
          <label for="bbn_custom_css">
            Secara default terisi CSS styling untuk penampilan gallery. Masukkan style CSS yang diinginkan 
            ke dalam form berikut.
          </label>
        </p>

        <p>
          <textarea class="large-text code" id="bbn_custom_css" cols="50" rows="5" name="bbn_options[bbn_custom_css]"><?php echo stripslashes( $options['bbn_custom_css'] ) ?></textarea>
        </p>
      </td>
    </tr>

    </tbody>
    </table>

    <p class="">
      <input type="submit" name="bbn_save_options" id="bbn_save_options" class="button button-primary" value="Save Settings" />
      <input type="submit" name="bbn_reset_options" id="bbn_reset_options" class="button button-secondary" value="Reset Settings" />
    </p>

  </form>

  <?php // print_r( $options ); ?>

  </div><!--.wrap-->

<?php 

} // endof function bbn_get_url_page()



/**
 * Register Wolppr custom menu in WordPress Administration screen
 *
 * @uses admin_menu hook
 */
function bbn_menu () {
  $icon_url = BBN_PLUGIN_DIR_URL . '/lib/img/bbn-icons.png';
  add_menu_page('BBN Settings &#38; Options', 'BBN Settings', 'edit_posts', 'bbn-settings', 'bbn_settings_fn', $icon_url, '4.526');
}
add_action( 'admin_menu' ,'bbn_menu' );
