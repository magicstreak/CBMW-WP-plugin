<?php
// Secure the template so it can't be loaded directly
if (!defined('ABSPATH')) { exit; }
?>

<div class="dashboard-container">
    
    <!-- Dashboard Branding Header -->
    <header class="header">
      <h1>CBMW Admin Portal</h1>
      <p>Select an activity card to manage CBMW walk programme</p>
    </header>

    <!-- Interactive Grid System -->
    <main class="grid">

      <!-- Card 1: Programme Scheduler -->
      <a href="<?php echo admin_url('admin.php?page=custom-admin-portal&tab=scheduler'); ?>" class="card">
        <div class="card-icon"><span>📅</span></div>
        <h2>Programme Scheduler</h2>
        <p>Coordinate walk offers for the seasons programme.</p>
      </a>

      <!-- Card 2: Programme Builder -->
      <a href="<?php echo admin_url('admin.php?page=custom-admin-portal&tab=builder'); ?>" class="card">
        <div class="card-icon"><span>🛠️</span></div>
        <h2>Programme Builder</h2>
        <p>Merge the scheduler data with the walk database to create the programme, make any programme specific changes here.</p>
      </a>

      <!-- Card 3: Walk Route Database -->
      <a href="<?php echo admin_url('admin.php?page=custom-admin-portal&tab=database'); ?>" class="card">
        <div class="card-icon"><span>🗺️</span></div>
        <h2>Walk Route Database</h2>
        <p>Catalog of CBMW walking routes</p>
      </a>

      <!-- Card 4: Post Walk Statistics -->
      <a href="<?php echo admin_url('admin.php?page=custom-admin-portal&tab=stats'); ?>" class="card">
        <div class="card-icon"><span>📊</span></div>
        <h2>Post Walk Statistics</h2>
        <p>Review walk numbers with analytical charts and data summaries.</p>
      </a>

    </main>

</div>

<!-- Styling for the Card Layout -->
<style>
    /* Reset & Core Styles for Dashboard Area */
    .dashboard-container {
      width: 100%;
      max-width: 1000px;
      margin: 20px auto;
    }

    /* Header Section */
    .header {
      margin-bottom: 40px;
      text-align: center;
    }
    .header h1 {
      font-size: 2.5rem;
      color: #1e293b;
      font-weight: 700;
      margin-bottom: 10px;
    }
    .header p {
      font-size: 1.1rem;
      color: #64748b;
    }

    /* Card Grid Setup */
    .grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 25px;
    }

    /* Interactive Card Styles */
    .card {
      background: #ffffff;
      border-radius: 12px;
      padding: 30px 24px;
      text-decoration: none;
      color: inherit;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
      border: 1px solid #e2e8f0;
      transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
      position: relative;
      top: 0;
    }

    /* Hover & Interactivity Effects */
    .card:hover {
      top: -5px;
      box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
      border-color: #3b82f6;
    }

/* Force the browser to bypass Dashicons font hijacking */
.card-icon {
  font-size: 2.5rem;
  margin-bottom: 16px;
  background: #eff6ff;
  width: 70px;
  height: 70px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
  transition: background 0.25s ease;
}

/* Add this explicit rule targeting the span container inside the card */
.card-icon span {
  /* Restores default native rendering and overrides WordPress text font hooks */
  font-family: "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji", sans-serif !important;
  font-style: normal !important;
  font-variant: normal !important;
  text-transform: none !important;
  speak: none;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}
    
    /* Dynamic color matching on hover */
    .card:hover .card-icon {
      background: #3b82f6;
    }
    .card:hover .card-icon span {
      filter: brightness(0) invert(1);
    }

    /* Card Typography */
    .card h2 {
      font-size: 1.25rem;
      color: #1e293b;
      margin-bottom: 8px;
      font-weight: 600;
    }
    .card p {
      font-size: 0.9rem;
      color: #64748b;
      line-height: 1.4;
    }

    /* Responsive Breakpoint for Mobile Viewports */
    @media (max-width: 480px) {
      .header h1 { font-size: 2rem; }
      .grid { grid-template-columns: 1fr; }
    }
</style>
