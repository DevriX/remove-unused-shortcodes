<?php

namespace RMUS\Admin;

class Admin
{
    var $notices;

    public function setup()
    {
        add_action('admin_menu', array($this, 'pages'));

        return $this;
    }

    public function pages()
    {
        add_submenu_page(
            'options-general.php',
            __('Remove Unused Shortcodes', RMUS_DOMAIN),
            __('Unused Shortcodes'),
            'manage_options',
            'rmus',
            array($this, 'display')
        );

        $this->maybeUpdate();
    }

    private function maybeUpdate()
    {
        global $pagenow;

        if ( 'options-general.php' != $pagenow )
            return;

        if ( empty($_GET['page']) || 'rmus' != $_GET['page'] )
            return;

        if ( !isset($_POST['rmus_update']) )
            return;

        if ( !isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'rmus_update') )
            return;

        $items = array();

        if ( !empty($_POST['rmus_items']) ) {
            $items = preg_split("/\\r\\n|\\r|\\n/", $_POST['rmus_items']);
            $items = array_map('trim', $items);
            $items = array_filter($items);
            $items = array_unique($items);
        }

        if ( $items ) {
            update_option('rmus_items', $items);
        } else {
            delete_option('rmus_items');
        }

        $GLOBALS['rmus_items'] = $items;

        $this->notices = '<div class="is-dismissible notice updated"><p>'
            . __('Changes saved successfully!', RMUS_DOMAIN)
            . '</p></div>';
    }

    public function display()
    {
        ?>

        <div class="wrap">
            <h2><?php _e('Remove Unused Shortcodes'); ?></h2>

            <?php if ( $this->notices ) : ?>
                <?php print $this->notices; ?>
            <?php endif; ?>

            <form method="post" id="poststuff" class="gc-settings">
                <div id="postbox-container" class="postbox-container">
                    <div class="meta-box-sortables ui-sortable" id="normal-sortables">

                        <div class="postbox">
                            <h3 class="hndle"><span><?php _e('Fast Documentation', RMUS_DOMAIN); ?></span></h3>
                            <div class="inside">
                                <p><?php _e('This plugin allows you to remove unused shortcodes from your WordPress blog/site easily without having to go through the process of editing posts and pages to remove them and update.'); ?></p>

                                <p><?php _e('What it does is it registers these shortcodes to become recognized by WordPress, with an empty output.'); ?></p>

                                <p><?php _e('Insert each shortcode you want to remove per line in the following settings. Make sure to insert the shortcode handle name only and not the shortcode as being used in the front-end, here are couple examples:'); ?></p>

                                <li><?php _e('[remove_dis]OK.[/remove_dis] => the shortcode name here is <code>remove_dis</code>'); ?></li>
                                <li><?php _e('[youtube_stats video=s57dlW-5qW4] => the shortcode name is <code>youtube_stats</code>'); ?></li>

                                <p><?php _e('If you need more help open a new issue on the project Github page - <a href="https://github.com/elhardoum/remove-unused-shortcodes">https://github.com/elhardoum/remove-unused-shortcodes</a>'); ?>
                            </div>
                        </div>

                        <div class="postbox">
                            <h3 class="hndle"><span><?php _e('Shortcodes to remove', RMUS_DOMAIN); ?></span></h3>
                            <div class="inside">
                                <textarea class="widefat" rows="11" placeholder="<?php esc_attr_e('Insert 1 item per line'); ?>" name="rmus_items"><?php echo implode(PHP_EOL, $GLOBALS['rmus_items']); ?></textarea>
                            </div>
                        </div>

                        <div class="postbox">
                            <h3 class="hndle"><?php _e('Save Changes', RMUS_DOMAIN); ?></h3>
                            <div class="inside">
                                <p>
                                    <?php wp_nonce_field('rmus_update'); ?>
                                    <input type="submit" name="rmus_update" class="button button-primary" value="<?php _e('Save Changes', RMUS_DOMAIN); ?>" />
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </form>

        </div>

        <?php
    }
}