<?php
/**
 * Plugin Name: CBMW Leaders Hub
 * Description: A standalone frontend toolkit hub for CBMW Walk Leaders using a tabbed shortcode interface.
 * Version: 1.0
 * Author: Local Developer
 */

if (!defined('ABSPATH')) { exit; }

// Register the frontend shortcode: [cbmw_leaders_hub]
add_shortcode('cbmw_leaders_hub', 'clh_render_leaders_hub');

function clh_render_leaders_hub() {
    // Capture the active tab from the URL parameter (defaults to dashboard home)
    $current_tab = isset($_GET['lh_tab']) ? sanitize_text_field($_GET['lh_tab']) : 'dashboard';
    
    // Automatically capture the URL path of the current public page
    $current_page_url = strtok($_SERVER["REQUEST_URI"], '?');

    // Use output buffering to render cleanly inside the WordPress content layout
    ob_start();
    ?>
    <div class="cbmw-leaders-hub-wrap">
        
        <!-- Frontend Tab Navigation (Replicates the look of the admin panel tabs) -->
        <nav class="cbmw-lh-nav-wrapper">
            <a href="<?php echo esc_url(add_query_arg('lh_tab', 'dashboard', $current_page_url)); ?>" 
               class="cbmw-lh-nav-tab <?php echo $current_tab === 'dashboard' ? 'active' : ''; ?>">
               Hub Home
            </a>
            <a href="<?php echo esc_url(add_query_arg('lh_tab', 'submit-walk', $current_page_url)); ?>" 
               class="cbmw-lh-nav-tab <?php echo $current_tab === 'submit-walk' ? 'active' : ''; ?>">
               Submit Walk Offer
            </a>
            <a href="<?php echo esc_url(add_query_arg('lh_tab', 'routes', $current_page_url)); ?>" 
               class="cbmw-lh-nav-tab <?php echo $current_tab === 'routes' ? 'active' : ''; ?>">
               Route Database
            </a>
            <a href="<?php echo esc_url(add_query_arg('lh_tab', 'resources', $current_page_url)); ?>" 
               class="cbmw-lh-nav-tab <?php echo $current_tab === 'resources' ? 'active' : ''; ?>">
               Leader Resources
            </a>
        </nav>

        <!-- Dynamic Content Router Area -->
        <div class="cbmw-lh-content-body">
            <?php
            if ($current_tab === 'submit-walk') {
                echo '<div class="cbmw-lh-iframe"><iframe src="https://github.io" sandbox="allow-scripts allow-same-origin allow-forms allow-downloads"></iframe></div>';
            } else if ($current_tab === 'routes') {
                echo '<div class="cbmw-lh-iframe"><iframe src="https://github.io" sandbox="allow-scripts allow-same-origin allow-forms allow-downloads"></iframe></div>';
            } else if ($current_tab === 'resources') {
                echo '<div class="cbmw-lh-resources-box">';
                echo '<h3>Walk Leader Resources</h3>';
                echo '<p>Download risk assessment templates, dynamic safety checklists, and leadership guidelines here.</p>';
                echo '</div>';
            } else {
                // Inline inclusion of the dashboard matrix markup to keep this file self-contained
                clh_render_dashboard_grid($current_page_url);
            }
            ?>
        </div>
    </div>

    <style>
        /* Replicated Tab Layout Framework safely isolated from theme styling conflicts */
        .cbmw-lh-nav-wrapper { display: flex; flex-wrap: wrap; border-bottom: 1px solid #ccc; margin-bottom: 30px; gap: 4px; }
        .cbmw-lh-nav-tab { padding: 8px 14px; text-decoration: none !important; font-size: 14px; font-weight: 600; background: #e5e5e5; color: #555 !important; border: 1px solid #ccc; border-bottom: none; border-radius: 4px 4px 0 0; margin-bottom: -1px; transition: background 0.15s ease; }
        .cbmw-lh-nav-tab:hover { background: #fafafa; color: #00a0d2 !important; }
        .cbmw-lh-nav-tab.active { background: #fff; color: #000 !important; border-bottom: 1px solid #fff; position: relative; z-index: 2; }
        
        /* Frontend App Iframe Containers */
        .cbmw-lh-iframe { width: 100%; height: 75vh; min-height: 500px; }
        .cbmw-lh-iframe iframe { width: 100%; height: 100%; border: none; background: #fff; }
        
        /* Fallback content style block */
        .cbmw-lh-resources-box { padding: 20px; background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; }
    </style>
    <?php
    return ob_get_clean();
}

// Visual matrix home view (formerly leaders-hub-template.php, now nicely self-contained)
function clh_render_dashboard_grid($current_page_url) {
    ?>
    <div class="lh-dashboard-container">
        <header class="lh-header">
          <h1>CBMW Leaders Hub</h1>
          <p>Welcome to the walk coordinator space. Select a toolkit utility below.</p>
        </header>

        <main class="lh-grid">
          <!-- Card 1: Submit a Walk -->
          <a href="<?php echo esc_url(add_query_arg('lh_tab', 'submit-walk', $current_page_url)); ?>" class="lh-card">
            <div class="lh-card-icon"><span>📅</span></div>
            <h2>Submit Walk Offer</h2>
            <p>Propose your available dates and itineraries for upcoming seasonal schedules.</p>
          </a>

          <!-- Card 2: Route Database lookup -->
          <a href="<?php echo esc_url(add_query_arg('lh_tab', 'routes', $current_page_url)); ?>" class="lh-card">
            <div class="lh-card-icon"><span>🗺️</span></div>
            <h2>Walk Route Database</h2>
            <p>Browse existing risk-assessed routes, elevation specs, and start grid references.</p>
          </a>

          <!-- Card 3: Resources & Forms -->
          <a href="<?php echo esc_url(add_query_arg('lh_tab', 'resources', $current_page_url)); ?>" class="lh-card">
            <div class="lh-card-icon"><span>📚</span></div>
            <h2>Leader Resources</h2>
            <p>Access insurance documentations, incident forms, and training manual databases.</p>
          </a>
        </main>
    </div>

    <style>
        /* Interactive grid engine CSS */
        .lh-dashboard-container { width: 100%; max-width: 1000px; margin: 0 auto; }
        .lh-header { margin-bottom: 40px; text-align: center; }
        .lh-header h1 { font-size: 2.5rem; color: #1e293b; font-weight: 700; margin-bottom: 10px; line-height: 1.2; }
        .lh-header p { font-size: 1.1rem; color: #64748b; }
        .lh-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 25px; }
        .lh-card { background: #ffffff; border-radius: 12px; padding: 30px 24px; text-decoration: none !important; color: #333 !important; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); border: 1px solid #e2e8f0; transition: all 0.25s ease; display: flex; flex-direction: column; align-items: center; text-align: center; }
        .lh-card:hover { transform: translateY(-5px); box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); border-color: #3b82f6; }
        .lh-card-icon { font-size: 2.5rem; margin-bottom: 16px; background: #eff6ff; width: 70px; height: 70px; display: flex; align-items: center; justify-content: center; border-radius: 50%; }
        .lh-card-icon span { font-family: "Apple Color Emoji", "Segoe UI Emoji", sans-serif !important; }
        .lh-card:hover .lh-card-icon { background: #3b82f6; }
        .lh-card:hover .lh-card-icon span { filter: brightness(0) invert(1); }
        .lh-card h2 { font-size: 1.25rem; color: #1e293b; margin-bottom: 8px; font-weight: 600; }
        .lh-card p { font-size: 0.9rem; color: #64748b; line-height: 1.4; }
        @media (max-width: 480px) { .lh-grid { grid-template-columns: 1fr; } }
    </style>
    <?php
}
