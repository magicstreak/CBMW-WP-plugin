<?php
/**
 * Plugin Name: CBMW Admin Portal
 * Description: Hosts the CBMW walk programme management portal.
 * Version: 1.3
 * Author: Local Developer
 */

if (!defined('ABSPATH')) { exit; }

// Attach functions to the native WordPress administration menu tree
add_action('admin_menu', 'cap_register_portal_menus');

// FIX: Block WordPress from rewriting or overriding emojis inside your backend screens
add_action('admin_init', 'cap_kill_admin_emoji_rewriter');

function cap_kill_admin_emoji_rewriter() {
    // Remove the core JavaScript scanner that changes text emojis into images on load
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');
}

function cap_register_portal_menus() {
    add_menu_page(
        'CBMW Admin Portal', 
        'CBMW Admin Portal', 
        'manage_options', 
        'custom-admin-portal', 
        'cap_render_master_router', 
        'dashicons-grid-view', 
        2
    );
}

function cap_render_master_router() {
    $current_tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'dashboard';
    ?>
    <div class="wrap" style="margin-top: 20px;">
        
        <!-- WordPress Style Navigation Header Tabs -->
        <nav class="nav-tab-wrapper wp-clearfix" style="margin-bottom: 25px;">
            <a href="<?php echo admin_url('admin.php?page=custom-admin-portal&tab=dashboard'); ?>" 
               class="nav-tab <?php echo $current_tab === 'dashboard' ? 'nav-tab-active' : ''; ?>">
               Dashboard Home
            </a>
            <a href="<?php echo admin_url('admin.php?page=custom-admin-portal&tab=scheduler'); ?>" 
               class="nav-tab <?php echo $current_tab === 'scheduler' ? 'nav-tab-active' : ''; ?>">
               Programme Scheduler
            </a>
            <a href="<?php echo admin_url('admin.php?page=custom-admin-portal&tab=builder'); ?>" 
               class="nav-tab <?php echo $current_tab === 'builder' ? 'nav-tab-active' : ''; ?>">
               Programme Builder
            </a>
            <a href="<?php echo admin_url('admin.php?page=custom-admin-portal&tab=database'); ?>" 
               class="nav-tab <?php echo $current_tab === 'database' ? 'nav-tab-active' : ''; ?>">
               Walk Route Database
            </a>
            <a href="<?php echo admin_url('admin.php?page=custom-admin-portal&tab=leaders'); ?>" 
               class="nav-tab <?php echo $current_tab === 'leaders' ? 'nav-tab-active' : ''; ?>">
               Leaders Database
            </a>
            <a href="<?php echo admin_url('admin.php?page=custom-admin-portal&tab=stats'); ?>" 
               class="nav-tab <?php echo $current_tab === 'stats' ? 'nav-tab-active' : ''; ?>">
               Post Walk Stats
            </a>
        </nav>

        <?php
        if ($current_tab === 'scheduler') {
                                echo '<div class="wrap" style="margin: 0; padding: 0; height: calc(100vh - 32px);">';
        echo '<iframe src="https://magicstreak.github.io/CBMW-walk-scheduler/" style="width:100%; height:100%; border:none;" sandbox="allow-scripts allow-same-origin allow-forms allow-downloads"></iframe>';
        echo '</div>';
        } else if ($current_tab === 'builder') {
                    echo '<div class="wrap" style="margin: 0; padding: 0; height: calc(100vh - 32px);">';
        echo '<iframe src="https://magicstreak.github.io/programme-builder/" style="width:100%; height:100%; border:none;" sandbox="allow-scripts allow-same-origin allow-forms allow-downloads"></iframe>';
        echo '</div>';
        } else if ($current_tab === 'database') {
                                echo '<div class="wrap" style="margin: 0; padding: 0; height: calc(100vh - 32px);">';
        echo '<iframe src="https://magicstreak.github.io/CBMW-Programme-Planner/" style="width:100%; height:100%; border:none;" sandbox="allow-scripts allow-same-origin allow-forms allow-downloads"></iframe>';
        echo '</div>';
        
        } else if ($current_tab === 'leaders') {
                               echo '<div class="wrap" style="margin: 0; padding: 0; height: calc(100vh - 32px);">';
        echo '<iframe src="http://test.cbmwalkers.org/leader-directory-2/" style="width:100%; height:100%; border:none;" sandbox="allow-scripts allow-same-origin allow-forms allow-downloads"></iframe>';
        echo '</div>';
        }else if ($current_tab === 'stats') {
            include plugin_dir_path(__FILE__) . 'pages/post-walk-stats.php';
        } else {
            include plugin_dir_path(__FILE__) . 'portal-template.php';
        }
        ?>
    </div>
    <?php
}
