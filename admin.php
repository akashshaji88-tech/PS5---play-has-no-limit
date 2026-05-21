<?php
/**
 * PS5 ADVERTISING PAGE — admin.php
 * Ultra-Premium, Glassmorphic Dashboard to view and manage customer orders.
 */

session_start();
require_once 'db.php';

// Security configuration
define('ADMIN_PASSWORD', 'admin123'); // Simple default passcode

// Logout action
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    unset($_SESSION['admin_logged']);
    session_destroy();
    header('Location: admin.php');
    exit;
}

// Authentication check
if (isset($_POST['password'])) {
    if (trim($_POST['password']) === ADMIN_PASSWORD) {
        $_SESSION['admin_logged'] = true;
    } else {
        $login_error = "Access Denied: Invalid Admin Passcode.";
    }
}

// Handle Order Status Updates via POST
if (isset($_SESSION['admin_logged']) && isset($_POST['update_status'])) {
    $order_id = intval($_POST['order_id']);
    $new_status = trim(htmlspecialchars($_POST['status']));
    if ($order_id > 0 && in_array($new_status, ['Pending', 'Shipped', 'Cancelled'])) {
        $stmt = $pdo->prepare("UPDATE `orders` SET `order_status` = ? WHERE `id` = ?");
        $stmt->execute([$new_status, $order_id]);
        $update_success = "Order #$order_id status updated successfully to $new_status.";
    }
}

// Handle Order Deletion via POST
if (isset($_SESSION['admin_logged']) && isset($_POST['delete_order'])) {
    $order_id = intval($_POST['order_id']);
    if ($order_id > 0) {
        $stmt = $pdo->prepare("DELETE FROM `orders` WHERE `id` = ?");
        $stmt->execute([$order_id]);
        $update_success = "Order #$order_id deleted successfully.";
    }
}

// Render Login Screen if not logged in
if (!isset($_SESSION['admin_logged'])):
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>PS5 Store — Admin Control Center</title>
  <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@400;600;700&family=Rajdhani:wght@500;700&family=Bebas+Neue&display=swap" rel="stylesheet"/>
  <style>
    :root {
      --blue: #0072CE;
      --sky: #00B4E3;
      --dark: #020509;
      --card: rgba(11, 24, 40, 0.65);
      --border: rgba(0, 180, 227, 0.2);
      --neon: #00E5FF;
    }
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      background: radial-gradient(circle at center, #07101e 0%, var(--dark) 100%);
      color: #fff;
      font-family: 'Rajdhani', sans-serif;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
    }
    .login-container {
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 16px;
      padding: 44px 34px;
      width: 90%;
      max-width: 420px;
      backdrop-filter: blur(20px);
      box-shadow: 0 0 50px rgba(0, 229, 255, 0.15);
      text-align: center;
      animation: fadeInUp 0.6s cubic-bezier(0.22, 1, 0.36, 1);
    }
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .brand {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 42px;
      letter-spacing: 0.05em;
      margin-bottom: 8px;
    }
    .brand span { color: var(--sky); }
    .subtitle {
      font-family: 'Exo 2', sans-serif;
      font-size: 11px;
      font-weight: 700;
      color: rgba(255,255,255,0.4);
      letter-spacing: 0.22em;
      text-transform: uppercase;
      margin-bottom: 34px;
    }
    .form-group {
      margin-bottom: 24px;
      text-align: left;
    }
    .form-group label {
      display: block;
      font-size: 12px;
      text-transform: uppercase;
      letter-spacing: 0.15em;
      color: var(--sky);
      margin-bottom: 8px;
    }
    .form-group input {
      width: 100%;
      background: rgba(255,255,255,0.05);
      border: 1px solid var(--border);
      border-radius: 8px;
      padding: 14px 18px;
      color: #fff;
      font-size: 16px;
      font-family: 'Exo 2', sans-serif;
      transition: all 0.3s;
    }
    .form-group input:focus {
      outline: none;
      border-color: var(--neon);
      box-shadow: 0 0 15px rgba(0, 229, 255, 0.3);
      background: rgba(255,255,255,0.08);
    }
    .btn {
      width: 100%;
      background: linear-gradient(135deg, var(--blue), var(--sky));
      border: none;
      border-radius: 8px;
      color: #fff;
      padding: 14px;
      font-family: 'Exo 2', sans-serif;
      font-weight: 700;
      font-size: 14px;
      text-transform: uppercase;
      letter-spacing: 0.12em;
      cursor: pointer;
      box-shadow: 0 0 20px rgba(0, 114, 206, 0.4);
      transition: all 0.3s;
    }
    .btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 0 30px rgba(0, 229, 255, 0.5);
    }
    .error-msg {
      background: rgba(239, 68, 68, 0.15);
      border: 1px solid rgba(239, 68, 68, 0.4);
      border-radius: 6px;
      color: #ef4444;
      padding: 10px;
      font-size: 13px;
      margin-bottom: 20px;
    }
    .hint {
      margin-top: 24px;
      font-size: 12px;
      color: rgba(255,255,255,0.3);
      letter-spacing: 0.05em;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <div class="brand">PS5 <span>CONTROL</span></div>
    <div class="subtitle">Admin Security Gateway</div>
    
    <?php if (isset($login_error)): ?>
      <div class="error-msg"><?= $login_error ?></div>
    <?php endif; ?>
    
    <form method="POST" action="admin.php">
      <div class="form-group">
        <label for="password">Admin Security Passcode</label>
        <input type="password" id="password" name="password" placeholder="••••••••" required autofocus/>
      </div>
      <button type="submit" class="btn">Authenticate</button>
    </form>
    
    <div class="hint">Default passcode: <strong>admin123</strong></div>
  </div>
</body>
</html>
<?php
exit;
endif;

// Fetch Database statistics
try {
    // Total Orders
    $totalOrders = $pdo->query("SELECT COUNT(*) FROM `orders`")->fetchColumn();
    
    // Total Revenue
    $totalRevenue = $pdo->query("SELECT SUM(`total_price`) FROM `orders`")->fetchColumn();
    $totalRevenue = $totalRevenue ? floatval($totalRevenue) : 0.00;
    
    // Total Active/Pending Orders
    $pendingOrders = $pdo->query("SELECT COUNT(*) FROM `orders` WHERE `order_status` = 'Pending'")->fetchColumn();
    
    // Top Selling Game
    $topGameQuery = $pdo->query("SELECT g.title, COUNT(o.id) as sales 
                                 FROM orders o 
                                 JOIN games g ON o.game_id = g.id 
                                 GROUP BY o.game_id 
                                 ORDER BY sales DESC LIMIT 1");
    $topGame = $topGameQuery->fetch();
    $topGameTitle = $topGame ? $topGame['title'] . " ({$topGame['sales']} sold)" : "N/A";
    
    // Fetch all orders
    $ordersQuery = $pdo->query("SELECT o.*, g.title as game_title, g.poster_path 
                                FROM `orders` o 
                                JOIN `games` g ON o.game_id = g.id 
                                ORDER BY o.order_date DESC");
    $orders = $ordersQuery->fetchAll();
    
} catch (Exception $e) {
    die("Database Query Error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>PS5 Command — Order Administration Control</title>
  <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@300;400;600;700&family=Rajdhani:wght@400;500;600;700&family=Bebas+Neue&display=swap" rel="stylesheet"/>
  <style>
    :root {
      --blue: #0072CE;
      --sky: #00B4E3;
      --neon: #00E5FF;
      --dark: #03060F;
      --mid: #07101E;
      --card: rgba(11, 24, 40, 0.55);
      --border: rgba(0, 180, 227, 0.15);
      --white: #FFFFFF;
      --muted: rgba(255,255,255,0.55);
    }
    
    * { box-sizing: border-box; margin:0; padding:0; }
    body {
      background: var(--dark);
      color: var(--white);
      font-family: 'Rajdhani', sans-serif;
      overflow-x: hidden;
      min-height: 100vh;
      line-height: 1.6;
    }
    
    /* Particles Ambient background */
    .bg-glow {
      position: fixed;
      width: 600px;
      height: 600px;
      background: radial-gradient(circle, rgba(0,180,227,0.06) 0%, transparent 70%);
      top: -10%; left: -10%;
      pointer-events: none;
      z-index: 0;
    }
    .bg-glow-2 {
      position: fixed;
      width: 700px;
      height: 700px;
      background: radial-gradient(circle, rgba(0,229,255,0.04) 0%, transparent 70%);
      bottom: -15%; right: -10%;
      pointer-events: none;
      z-index: 0;
    }

    header {
      position: relative;
      z-index: 10;
      padding: 30px 64px;
      background: rgba(3,6,15,0.8);
      border-bottom: 1px solid var(--border);
      backdrop-filter: blur(12px);
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .brand {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 34px;
      letter-spacing: 0.05em;
    }
    .brand span { color: var(--sky); }
    .nav-actions {
      display: flex;
      align-items: center;
      gap: 20px;
    }
    .btn-logout {
      font-family: 'Exo 2', sans-serif;
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 0.15em;
      text-transform: uppercase;
      color: rgba(255,255,255,0.5);
      border: 1px solid rgba(255,255,255,0.15);
      border-radius: 4px;
      padding: 8px 16px;
      text-decoration: none;
      transition: all 0.3s;
    }
    .btn-logout:hover {
      border-color: #ef4444;
      color: #ef4444;
      background: rgba(239, 68, 68, 0.05);
    }
    .btn-site {
      font-family: 'Exo 2', sans-serif;
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 0.15em;
      text-transform: uppercase;
      color: #fff;
      background: linear-gradient(135deg, var(--blue), var(--sky));
      border-radius: 4px;
      padding: 8px 18px;
      text-decoration: none;
      transition: all 0.3s;
    }
    .btn-site:hover {
      box-shadow: 0 0 15px rgba(0, 229, 255, 0.45);
    }

    main {
      position: relative;
      z-index: 5;
      max-width: 1300px;
      margin: 48px auto;
      padding: 0 64px;
    }

    /* Success Toast Alert */
    .success-alert {
      background: rgba(16, 185, 129, 0.1);
      border: 1px solid rgba(16, 185, 129, 0.4);
      border-radius: 8px;
      color: #10b981;
      padding: 16px 24px;
      font-size: 15px;
      font-family: 'Exo 2', sans-serif;
      margin-bottom: 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      animation: slideIn 0.4s ease;
    }
    @keyframes slideIn {
      from { transform: translateY(-20px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }

    /* Metric Cards Grid */
    .metrics-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 16px;
      margin-bottom: 48px;
    }
    .metric-card {
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 12px;
      padding: 24px;
      backdrop-filter: blur(14px);
      transition: all 0.35s cubic-bezier(0.22, 1, 0.36, 1);
    }
    .metric-card:hover {
      border-color: rgba(0, 229, 255, 0.35);
      transform: translateY(-4px);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
    }
    .metric-title {
      font-family: 'Exo 2', sans-serif;
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 0.18em;
      text-transform: uppercase;
      color: var(--muted);
      margin-bottom: 12px;
    }
    .metric-value {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 38px;
      line-height: 1;
      color: var(--sky);
    }
    .metric-value.green { color: #10b981; }

    /* Orders Section */
    .section-card {
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 16px;
      backdrop-filter: blur(14px);
      overflow: hidden;
    }
    .section-header {
      padding: 24px 34px;
      border-bottom: 1px solid var(--border);
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: rgba(3, 6, 15, 0.3);
    }
    .section-header h2 {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 26px;
      letter-spacing: 0.05em;
    }
    
    /* Table styling */
    .table-responsive {
      overflow-x: auto;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      text-align: left;
    }
    th {
      font-family: 'Exo 2', sans-serif;
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 0.15em;
      text-transform: uppercase;
      color: var(--sky);
      padding: 18px 24px;
      background: rgba(0, 180, 227, 0.04);
      border-bottom: 1px solid var(--border);
    }
    td {
      padding: 20px 24px;
      border-bottom: 1px solid rgba(255,255,255,0.05);
      font-size: 14px;
      vertical-align: middle;
    }
    tr:last-child td {
      border-bottom: none;
    }
    tr:hover td {
      background: rgba(255,255,255,0.02);
    }
    
    /* Custom order status badges */
    .status-badge {
      display: inline-block;
      font-family: 'Exo 2', sans-serif;
      font-size: 10px;
      font-weight: 700;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      padding: 4px 10px;
      border-radius: 4px;
      text-align: center;
      width: 90px;
    }
    .status-badge.pending {
      background: rgba(245, 158, 11, 0.15);
      color: #f59e0b;
      border: 1px solid rgba(245, 158, 11, 0.3);
    }
    .status-badge.shipped {
      background: rgba(16, 185, 129, 0.15);
      color: #10b981;
      border: 1px solid rgba(16, 185, 129, 0.3);
    }
    .status-badge.cancelled {
      background: rgba(239, 68, 68, 0.15);
      color: #ef4444;
      border: 1px solid rgba(239, 68, 68, 0.3);
    }

    /* Actions form styling */
    .status-form {
      display: inline-flex;
      align-items: center;
      gap: 6px;
    }
    select {
      background: rgba(3, 6, 15, 0.8);
      color: #fff;
      border: 1px solid var(--border);
      border-radius: 4px;
      padding: 6px 12px;
      font-family: 'Rajdhani', sans-serif;
      font-size: 13px;
      cursor: pointer;
    }
    select:focus {
      outline: none;
      border-color: var(--neon);
    }
    .btn-action {
      background: rgba(255,255,255,0.1);
      border: 1px solid rgba(255,255,255,0.2);
      color: #fff;
      border-radius: 4px;
      padding: 6px 12px;
      font-family: 'Exo 2', sans-serif;
      font-size: 11px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.1em;
      cursor: pointer;
      transition: all 0.3s;
    }
    .btn-action:hover {
      background: var(--sky);
      border-color: var(--sky);
      color: var(--dark);
    }
    .btn-delete {
      background: rgba(239, 68, 68, 0.1);
      border: 1px solid rgba(239, 68, 68, 0.25);
      color: #ef4444;
      border-radius: 4px;
      padding: 6px 12px;
      font-family: 'Exo 2', sans-serif;
      font-size: 11px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.1em;
      cursor: pointer;
      transition: all 0.3s;
      margin-left: 10px;
    }
    .btn-delete:hover {
      background: #ef4444;
      color: #fff;
      border-color: #ef4444;
    }

    .no-orders {
      padding: 48px;
      text-align: center;
      color: var(--muted);
      font-size: 16px;
      font-family: 'Exo 2', sans-serif;
    }
    
    .game-meta {
      display: flex;
      align-items: center;
      gap: 12px;
    }
    .game-thumb-img {
      width: 44px;
      height: 30px;
      object-fit: cover;
      border-radius: 4px;
      border: 1px solid var(--border);
    }
    
    .cust-info strong {
      display: block;
      color: #fff;
      font-size: 15px;
    }
    .cust-info span {
      display: block;
      color: var(--muted);
      font-size: 12px;
    }
    
    .trans-id {
      font-family: monospace;
      color: var(--neon);
      font-size: 13px;
      font-weight: 700;
    }

    @media (max-width: 1024px) {
      .metrics-grid {
        grid-template-columns: repeat(2, 1fr);
      }
      main, header {
        padding-left: 24px;
        padding-right: 24px;
      }
    }
    @media (max-width: 768px) {
      .metrics-grid {
        grid-template-columns: 1fr;
      }
      header {
        flex-direction: column;
        gap: 16px;
        text-align: center;
      }
    }
  </style>
</head>
<body>
  <div class="bg-glow"></div>
  <div class="bg-glow-2"></div>
  
  <header>
    <div class="brand">PS5 <span>COMMAND</span></div>
    <div class="nav-actions">
      <a href="Index.php" class="btn-site">View Showcase</a>
      <a href="admin.php?action=logout" class="btn-logout">Logout Console</a>
    </div>
  </header>
  
  <main>
    <?php if (isset($update_success)): ?>
      <div class="success-alert">
        <span>✅ <?= $update_success ?></span>
      </div>
    <?php endif; ?>
    
    <!-- Metrics Section -->
    <div class="metrics-grid">
      <div class="metric-card">
        <div class="metric-title">Total Placed Orders</div>
        <div class="metric-value"><?= $totalOrders ?></div>
      </div>
      
      <div class="metric-card">
        <div class="metric-title">Consolidated Revenue</div>
        <div class="metric-value green">$<?= number_format($totalRevenue, 2) ?></div>
      </div>
      
      <div class="metric-card">
        <div class="metric-title">Pending Shipments</div>
        <div class="metric-value" style="color: #f59e0b;"><?= $pendingOrders ?></div>
      </div>
      
      <div class="metric-card">
        <div class="metric-title">Top Selling Title</div>
        <div class="metric-value" style="font-size: 16px; text-transform: uppercase; letter-spacing: 0.05em; font-family: 'Exo 2', sans-serif; font-weight: 600; margin-top: 10px;">
          <?= $topGameTitle ?>
        </div>
      </div>
    </div>
    
    <!-- Orders Section -->
    <div class="section-card">
      <div class="section-header">
        <h2>Live Transaction Log</h2>
      </div>
      
      <div class="table-responsive">
        <?php if (count($orders) > 0): ?>
          <table>
            <thead>
              <tr>
                <th>Transaction</th>
                <th>Game & Edition</th>
                <th>Customer Details</th>
                <th>Price</th>
                <th>Status</th>
                <th>Log Date</th>
                <th style="text-align: right;">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($orders as $order): ?>
                <tr>
                  <td><span class="trans-id"><?= $order['transaction_id'] ?></span></td>
                  <td>
                    <div class="game-meta">
                      <img src="<?= $order['poster_path'] ?>" class="game-thumb-img" alt=""/>
                      <div>
                        <strong style="display:block;"><?= $order['game_title'] ?></strong>
                        <span style="font-size:11px;color:var(--muted);"><?= $order['edition'] ?></span>
                      </div>
                    </div>
                  </td>
                  <td>
                    <div class="cust-info">
                      <strong><?= $order['customer_name'] ?></strong>
                      <span><?= $order['customer_email'] ?></span>
                      <span style="font-size: 11px; max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="<?= $order['customer_address'] ?>"><?= $order['customer_address'] ?></span>
                    </div>
                  </td>
                  <td><strong style="color: #fff;">$<?= number_format($order['total_price'], 2) ?></strong></td>
                  <td>
                    <span class="status-badge <?= strtolower($order['order_status']) ?>"><?= $order['order_status'] ?></span>
                  </td>
                  <td><?= date('Y-m-d H:i', strtotime($order['order_date'])) ?></td>
                  <td style="text-align: right; white-space: nowrap;">
                    <form method="POST" action="admin.php" class="status-form" style="display:inline-block;">
                      <input type="hidden" name="order_id" value="<?= $order['id'] ?>"/>
                      <input type="hidden" name="update_status" value="1"/>
                      <select name="status" onchange="this.form.submit()">
                        <option value="Pending" <?= $order['order_status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="Shipped" <?= $order['order_status'] === 'Shipped' ? 'selected' : '' ?>>Shipped</option>
                        <option value="Cancelled" <?= $order['order_status'] === 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
                      </select>
                    </form>
                    
                    <form method="POST" action="admin.php" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this order? This action is permanent.');">
                      <input type="hidden" name="order_id" value="<?= $order['id'] ?>"/>
                      <input type="hidden" name="delete_order" value="1"/>
                      <button type="submit" class="btn-delete">Delete</button>
                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php else: ?>
          <div class="no-orders">No sales transactions have been logged yet. Placed orders will reflect here instantly.</div>
        <?php endif; ?>
      </div>
    </div>
  </main>
</body>
</html>
