<?php include('db_connect.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sales Reports - Minglanilla Liam Store</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    :root {
      --primary-color: #374151;
      --secondary-color: #6b7280;
      --accent-color: #10b981;
      --danger-color: #ef4444;
      --warning-color: #f59e0b;
      --background-color: #f9fafb;
      --surface-color: #ffffff;
      --border-color: #e5e7eb;
      --text-primary: #111827;
      --text-secondary: #6b7280;
      --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
      --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
      --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
      --radius-sm: 0.375rem;
      --radius-md: 0.5rem;
      --radius-lg: 0.75rem;
    }

    * {
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      background-color: var(--background-color);
      color: var(--text-primary);
      margin: 0;
      padding: 0;
      line-height: 1.6;
    }

    header {
      background: var(--surface-color);
      padding: 1rem 2rem;
      box-shadow: var(--shadow-sm);
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-bottom: 1px solid var(--border-color);
    }

    .logo {
      font-size: 1.5rem;
      font-weight: 700;
      color: var(--primary-color);
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }

    .logo i {
      color: var(--accent-color);
    }

    .nav-links {
      display: flex;
      gap: 1rem;
    }

    .nav-links a {
      color: var(--text-secondary);
      text-decoration: none;
      padding: 0.5rem 1rem;
      border-radius: var(--radius-md);
      transition: all 0.2s ease;
    }

    .nav-links a:hover,
    .nav-links a.active {
      background: var(--background-color);
      color: var(--text-primary);
    }

    .container {
      max-width: 1400px;
      margin: 2rem auto;
      padding: 0 2rem;
    }

    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 1.5rem;
      margin-bottom: 2rem;
    }

    .stat-card {
      background: var(--surface-color);
      padding: 1.5rem;
      border-radius: var(--radius-lg);
      box-shadow: var(--shadow-sm);
      border: 1px solid var(--border-color);
    }

    .stat-value {
      font-size: 2rem;
      font-weight: 700;
      margin-bottom: 0.5rem;
    }

    .stat-label {
      color: var(--text-secondary);
      font-size: 0.875rem;
    }

    .stat-card.sales .stat-value { color: var(--accent-color); }
    .stat-card.revenue .stat-value { color: var(--primary-color); }
    .stat-card.products .stat-value { color: var(--warning-color); }
    .stat-card.low-stock .stat-value { color: var(--danger-color); }

    .reports-section {
      background: var(--surface-color);
      border-radius: var(--radius-lg);
      padding: 1.5rem;
      box-shadow: var(--shadow-sm);
      border: 1px solid var(--border-color);
      margin-bottom: 2rem;
    }

    .section-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 1.5rem;
    }

    .section-title {
      font-size: 1.25rem;
      font-weight: 600;
      color: var(--text-primary);
      margin: 0;
    }

    .btn {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.75rem 1rem;
      border: none;
      border-radius: var(--radius-md);
      font-weight: 500;
      font-size: 0.875rem;
      cursor: pointer;
      transition: all 0.2s ease;
      text-decoration: none;
    }

    .btn-primary {
      background: var(--primary-color);
      color: white;
    }

    .btn-primary:hover {
      background: #1f2937;
      transform: translateY(-1px);
    }

    .btn-success {
      background: var(--accent-color);
      color: white;
    }

    .btn-success:hover {
      background: #059669;
      transform: translateY(-1px);
    }

    .filters {
      display: flex;
      gap: 1rem;
      margin-bottom: 1.5rem;
      flex-wrap: wrap;
    }

    .filter-group {
      display: flex;
      flex-direction: column;
      gap: 0.25rem;
    }

    .filter-group label {
      font-size: 0.75rem;
      font-weight: 500;
      color: var(--text-secondary);
    }

    .filter-group input,
    .filter-group select {
      padding: 0.5rem;
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      font-size: 0.875rem;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 1rem;
    }

    th, td {
      padding: 0.75rem;
      text-align: left;
      border-bottom: 1px solid var(--border-color);
    }

    th {
      background: var(--background-color);
      font-weight: 600;
      color: var(--text-primary);
      font-size: 0.875rem;
    }

    td {
      font-size: 0.875rem;
    }

    .no-data {
      text-align: center;
      padding: 2rem;
      color: var(--text-secondary);
    }

    @media (max-width: 768px) {
      .container {
        padding: 0 1rem;
      }
      
      .stats-grid {
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      }
      
      .filters {
        flex-direction: column;
      }
      
      .nav-links {
        flex-direction: column;
        gap: 0.5rem;
      }
    }
  </style>
</head>
<body>
  <header>
    <div class="logo">
      <i class="fas fa-chart-line"></i> Sales Reports
    </div>
    <nav class="nav-links">
      <a href="index.php"><i class="fas fa-store"></i> POS</a>
      <a href="reports.php" class="active"><i class="fas fa-chart-line"></i> Reports</a>
    </nav>
  </header>

  <div class="container">
    <!-- Statistics Cards -->
    <div class="stats-grid">
      <div class="stat-card sales">
        <div class="stat-value" id="totalSales">0</div>
        <div class="stat-label">Total Sales Today</div>
      </div>
      <div class="stat-card revenue">
        <div class="stat-value" id="totalRevenue">₱0.00</div>
        <div class="stat-label">Revenue Today</div>
      </div>
      <div class="stat-card products">
        <div class="stat-value" id="totalProducts">0</div>
        <div class="stat-label">Total Products</div>
      </div>
      <div class="stat-card low-stock">
        <div class="stat-value" id="lowStockCount">0</div>
        <div class="stat-label">Low Stock Items</div>
      </div>
    </div>

    <!-- Recent Sales -->
    <div class="reports-section">
      <div class="section-header">
        <h2 class="section-title">Recent Sales</h2>
        <button class="btn btn-primary" onclick="refreshData()">
          <i class="fas fa-sync-alt"></i> Refresh
        </button>
      </div>
      
      <div class="filters">
        <div class="filter-group">
          <label>Date From</label>
          <input type="date" id="dateFrom" value="<?php echo date('Y-m-d'); ?>">
        </div>
        <div class="filter-group">
          <label>Date To</label>
          <input type="date" id="dateTo" value="<?php echo date('Y-m-d'); ?>">
        </div>
        <div class="filter-group">
          <label>&nbsp;</label>
          <button class="btn btn-success" onclick="filterSales()">
            <i class="fas fa-filter"></i> Filter
          </button>
        </div>
      </div>
      
      <table id="salesTable">
        <thead>
          <tr>
            <th>Sale ID</th>
            <th>Date</th>
            <th>Total</th>
            <th>Amount Paid</th>
            <th>Change</th>
            <th>Items</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>

    <!-- Top Products -->
    <div class="reports-section">
      <div class="section-header">
        <h2 class="section-title">Top Selling Products</h2>
      </div>
      
      <table id="topProductsTable">
        <thead>
          <tr>
            <th>Product</th>
            <th>Category</th>
            <th>Quantity Sold</th>
            <th>Revenue</th>
            <th>Stock</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div>

  <script>
    // Load initial data
    document.addEventListener('DOMContentLoaded', function() {
      loadStatistics();
      loadRecentSales();
      loadTopProducts();
    });

    function loadStatistics() {
      fetch('get_statistics.php')
        .then(res => res.json())
        .then(data => {
          if (data.status === 'success') {
            document.getElementById('totalSales').textContent = data.stats.totalSales;
            document.getElementById('totalRevenue').textContent = '₱' + data.stats.totalRevenue.toFixed(2);
            document.getElementById('totalProducts').textContent = data.stats.totalProducts;
            document.getElementById('lowStockCount').textContent = data.stats.lowStockCount;
          }
        })
        .catch(error => {
          console.error('Error loading statistics:', error);
        });
    }

    function loadRecentSales() {
      const dateFrom = document.getElementById('dateFrom').value;
      const dateTo = document.getElementById('dateTo').value;
      
      fetch(`get_sales.php?from=${dateFrom}&to=${dateTo}`)
        .then(res => res.json())
        .then(data => {
          const tbody = document.querySelector('#salesTable tbody');
          tbody.innerHTML = '';
          
          if (data.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6" class="no-data">No sales found for the selected period</td></tr>';
            return;
          }
          
          data.forEach(sale => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
              <td>#${sale.id}</td>
              <td>${new Date(sale.sale_date).toLocaleDateString()}</td>
              <td>₱${parseFloat(sale.total).toFixed(2)}</td>
              <td>₱${parseFloat(sale.amount_paid).toFixed(2)}</td>
              <td>₱${parseFloat(sale.change_amount).toFixed(2)}</td>
              <td>${sale.item_count}</td>
            `;
            tbody.appendChild(tr);
          });
        })
        .catch(error => {
          console.error('Error loading sales:', error);
        });
    }

    function loadTopProducts() {
      fetch('get_top_products.php')
        .then(res => res.json())
        .then(data => {
          const tbody = document.querySelector('#topProductsTable tbody');
          tbody.innerHTML = '';
          
          if (data.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" class="no-data">No sales data available</td></tr>';
            return;
          }
          
          data.forEach(product => {
            const tr = document.createElement('tr');
            const stockClass = product.stock === 0 ? 'out' : product.stock <= 5 ? 'low' : '';
            tr.innerHTML = `
              <td>${product.name}</td>
              <td>${product.category}</td>
              <td>${product.quantity_sold}</td>
              <td>₱${parseFloat(product.revenue).toFixed(2)}</td>
              <td><span class="${stockClass}">${product.stock}</span></td>
            `;
            tbody.appendChild(tr);
          });
        })
        .catch(error => {
          console.error('Error loading top products:', error);
        });
    }

    function filterSales() {
      loadRecentSales();
    }

    function refreshData() {
      loadStatistics();
      loadRecentSales();
      loadTopProducts();
    }
  </script>
</body>
</html>
