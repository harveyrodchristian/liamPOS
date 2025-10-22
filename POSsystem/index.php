<?php include('db_connect.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Minglanilla Liam Store POS</title>
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

    #time {
      font-size: 0.875rem;
      color: var(--text-secondary);
      font-weight: 500;
    }

    .container {
      max-width: 1400px;
      margin: 2rem auto;
      padding: 0 2rem;
    }

    .main-content {
      display: grid;
      grid-template-columns: 2fr 1fr;
      gap: 2rem;
      margin-bottom: 2rem;
    }

    .products-section {
      background: var(--surface-color);
      border-radius: var(--radius-lg);
      padding: 1.5rem;
      box-shadow: var(--shadow-sm);
      border: 1px solid var(--border-color);
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

    .btn-danger {
      background: var(--danger-color);
      color: white;
    }

    .btn-danger:hover {
      background: #dc2626;
      transform: translateY(-1px);
    }

    .btn-sm {
      padding: 0.5rem 0.75rem;
      font-size: 0.75rem;
    }

    .products-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
      gap: 1rem;
    }

    .product-card {
      background: var(--surface-color);
      padding: 1.25rem;
      border-radius: var(--radius-lg);
      border: 1px solid var(--border-color);
      text-align: center;
      cursor: pointer;
      transition: all 0.2s ease;
      position: relative;
    }

    .product-card:hover {
      transform: translateY(-2px);
      box-shadow: var(--shadow-md);
      border-color: var(--accent-color);
    }

    .product-card.low-stock {
      border-color: var(--warning-color);
      background: #fef3c7;
    }

    .product-card.out-of-stock {
      opacity: 0.6;
      cursor: not-allowed;
    }

    .product-name {
      font-weight: 600;
      margin-bottom: 0.5rem;
      color: var(--text-primary);
    }

    .product-price {
      color: var(--accent-color);
      font-weight: 700;
      font-size: 1.125rem;
      margin-bottom: 0.5rem;
    }

    .product-stock {
      font-size: 0.75rem;
      color: var(--text-secondary);
      padding: 0.25rem 0.5rem;
      background: var(--background-color);
      border-radius: var(--radius-sm);
      display: inline-block;
    }

    .product-stock.low {
      background: #fef3c7;
      color: #92400e;
    }

    .product-stock.out {
      background: #fee2e2;
      color: #991b1b;
    }

    .cart-section {
      background: var(--surface-color);
      border-radius: var(--radius-lg);
      padding: 1.5rem;
      box-shadow: var(--shadow-sm);
      border: 1px solid var(--border-color);
      height: fit-content;
    }

    .cart-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 1rem;
    }

    .cart-table th,
    .cart-table td {
      padding: 0.75rem 0.5rem;
      text-align: left;
      border-bottom: 1px solid var(--border-color);
    }

    .cart-table th {
      background: var(--background-color);
      font-weight: 600;
      color: var(--text-primary);
      font-size: 0.875rem;
    }

    .cart-table td {
      font-size: 0.875rem;
    }

    .quantity-controls {
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .qty-btn {
      width: 24px;
      height: 24px;
      border: 1px solid var(--border-color);
      background: var(--surface-color);
      border-radius: var(--radius-sm);
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      font-size: 0.75rem;
      transition: all 0.2s ease;
    }

    .qty-btn:hover {
      background: var(--background-color);
      border-color: var(--primary-color);
    }

    .remove-btn {
      color: var(--danger-color);
      background: none;
      border: none;
      cursor: pointer;
      padding: 0.25rem;
      border-radius: var(--radius-sm);
      transition: all 0.2s ease;
    }

    .remove-btn:hover {
      background: #fee2e2;
    }

    .cart-total {
      background: var(--background-color);
      padding: 1rem;
      border-radius: var(--radius-md);
      margin-bottom: 1rem;
      text-align: center;
    }

    .total-label {
      font-size: 0.875rem;
      color: var(--text-secondary);
      margin-bottom: 0.25rem;
    }

    .total-amount {
      font-size: 1.5rem;
      font-weight: 700;
      color: var(--text-primary);
    }

    .checkout-section {
      display: flex;
      flex-direction: column;
      gap: 0.75rem;
    }

    .btn-checkout {
      width: 100%;
      padding: 1rem;
      font-size: 1rem;
      font-weight: 600;
    }

    .btn-clear-cart {
      width: 100%;
      background: var(--text-secondary);
    }

    .btn-clear-cart:hover {
      background: #4b5563;
    }

    /* Modal styles */
    .modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      justify-content: center;
      align-items: center;
      z-index: 1000;
    }

    .modal-content {
      background: var(--surface-color);
      padding: 2rem;
      border-radius: var(--radius-lg);
      width: 90%;
      max-width: 500px;
      box-shadow: var(--shadow-lg);
      animation: fadeIn 0.3s ease;
      border: 1px solid var(--border-color);
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: scale(0.95);
      }
      to {
        opacity: 1;
        transform: scale(1);
      }
    }

    .modal-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 1.5rem;
    }

    .modal-title {
      font-size: 1.25rem;
      font-weight: 600;
      color: var(--text-primary);
      margin: 0;
    }

    .close-btn {
      background: none;
      border: none;
      font-size: 1.5rem;
      cursor: pointer;
      color: var(--text-secondary);
      padding: 0.25rem;
      border-radius: var(--radius-sm);
      transition: all 0.2s ease;
    }

    .close-btn:hover {
      background: var(--background-color);
      color: var(--text-primary);
    }

    .form-group {
      margin-bottom: 1.25rem;
    }

    .form-group label {
      font-weight: 500;
      display: block;
      margin-bottom: 0.5rem;
      color: var(--text-primary);
    }

    .form-group input,
    .form-group select {
      width: 100%;
      padding: 0.75rem;
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      font-size: 0.875rem;
      transition: all 0.2s ease;
    }

    .form-group input:focus,
    .form-group select:focus {
      outline: none;
      border-color: var(--accent-color);
      box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }

    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1rem;
    }

    .modal-actions {
      display: flex;
      gap: 0.75rem;
      justify-content: flex-end;
      margin-top: 2rem;
    }

    /* Responsive design */
    @media (max-width: 768px) {
      .main-content {
        grid-template-columns: 1fr;
        gap: 1rem;
      }

      .container {
        padding: 0 1rem;
      }

      .products-grid {
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
      }

      .form-row {
        grid-template-columns: 1fr;
      }

      .modal-content {
        margin: 1rem;
        width: calc(100% - 2rem);
      }
    }

    /* Loading states */
    .loading {
      opacity: 0.6;
      pointer-events: none;
    }

    /* Success/Error messages */
    .alert {
      padding: 0.75rem 1rem;
      border-radius: var(--radius-md);
      margin-bottom: 1rem;
      font-size: 0.875rem;
    }

    .alert-success {
      background: #d1fae5;
      color: #065f46;
      border: 1px solid #a7f3d0;
    }

    .alert-error {
      background: #fee2e2;
      color: #991b1b;
      border: 1px solid #fecaca;
    }
  </style>
</head>
<body>
  <header>
    <div class="logo"><i class="fas fa-store"></i> Minglanilla Liam Store</div>
    <nav style="display: flex; gap: 1rem;">
      <a href="index.php" style="color: var(--text-secondary); text-decoration: none; padding: 0.5rem 1rem; border-radius: var(--radius-md); transition: all 0.2s ease;">
        <i class="fas fa-store"></i> POS
      </a>
      <a href="reports.php" style="color: var(--text-secondary); text-decoration: none; padding: 0.5rem 1rem; border-radius: var(--radius-md); transition: all 0.2s ease;">
        <i class="fas fa-chart-line"></i> Reports
      </a>
    </nav>
    <div id="time"></div>
  </header>

  <div class="container">
    <div class="main-content">
      <div class="products-section">
        <div class="section-header">
          <h2 class="section-title">Products</h2>
          <button id="addProductBtn" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Product
          </button>
        </div>
        <div class="products-grid" id="productsGrid"></div>
      </div>

      <div class="cart-section">
        <h3 class="section-title">Shopping Cart</h3>
        <table class="cart-table" id="cartTable">
          <thead>
            <tr>
              <th>Product</th>
              <th>Price</th>
              <th>Qty</th>
              <th>Total</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
        
        <div class="cart-total">
          <div class="total-label">Total Amount</div>
          <div class="total-amount">₱<span id="cartTotal">0.00</span></div>
        </div>
        
        <div class="checkout-section">
          <button id="checkout" class="btn btn-success btn-checkout">
            <i class="fas fa-credit-card"></i> Checkout
          </button>
          <button id="clearCart" class="btn btn-clear-cart">
            <i class="fas fa-trash"></i> Clear Cart
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Add Category Modal -->
  <div class="modal" id="addCategoryModal">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Add New Category</h3>
        <button class="close-btn" id="closeCategoryModal">&times;</button>
      </div>
      
      <div class="form-group">
        <label for="categoryName">Category Name</label>
        <input type="text" id="categoryName" placeholder="Enter category name">
      </div>
      
      <div class="form-group">
        <label for="categoryDescription">Description (Optional)</label>
        <textarea id="categoryDescription" placeholder="Category description" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: var(--radius-md); font-size: 0.875rem; resize: vertical; min-height: 60px;"></textarea>
      </div>
      
      <div class="modal-actions">
        <button id="closeCategoryModal" class="btn btn-clear-cart">Cancel</button>
        <button id="saveCategory" class="btn btn-success">Save Category</button>
      </div>
    </div>
  </div>

  <!-- Add Product Modal -->
  <div class="modal" id="addProductModal">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Add New Product</h3>
        <button class="close-btn" id="closeModal">&times;</button>
      </div>
      
      <div class="form-group">
        <label for="productName">Product Name</label>
        <input type="text" id="productName" placeholder="Enter product name">
      </div>
      
      <div class="form-group">
        <label for="productCategory">Category</label>
        <div style="display: flex; gap: 0.5rem;">
          <select id="productCategory" style="flex: 1;">
            <option value="">Select Category</option>
          </select>
          <button type="button" id="addCategoryBtn" class="btn btn-sm" style="background: var(--accent-color); color: white;">
            <i class="fas fa-plus"></i>
          </button>
        </div>
      </div>
      
      <div class="form-group">
        <label for="productDescription">Description (Optional)</label>
        <textarea id="productDescription" placeholder="Product description" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: var(--radius-md); font-size: 0.875rem; resize: vertical; min-height: 60px;"></textarea>
      </div>
      
      <div class="form-row">
        <div class="form-group">
          <label for="originalPrice">Cost Price</label>
          <input type="number" step="0.01" id="originalPrice" placeholder="0.00">
        </div>
        <div class="form-group">
          <label for="sellingPrice">Selling Price</label>
          <input type="number" step="0.01" id="sellingPrice" placeholder="0.00">
        </div>
      </div>
      
      <div class="form-row">
        <div class="form-group">
          <label for="productStock">Stock Quantity</label>
          <input type="number" id="productStock" value="0" min="0">
        </div>
        <div class="form-group">
          <label for="lowStockThreshold">Low Stock Alert</label>
          <input type="number" id="lowStockThreshold" value="5" min="1">
        </div>
      </div>
      
      <div class="modal-actions">
        <button id="closeModal" class="btn btn-clear-cart">Cancel</button>
        <button id="saveProduct" class="btn btn-success">Save Product</button>
      </div>
    </div>
  </div>

  <script>
    let products = [];
    let cart = [];
    let categories = [];

    // Load categories
    function loadCategories() {
      fetch('includes/manage_categories.php?action=list')
        .then(res => res.json())
        .then(data => {
          if (data.status === 'success') {
            categories = data.categories;
            updateCategorySelect();
          }
        })
        .catch(error => {
          console.error('Error loading categories:', error);
        });
    }

    function updateCategorySelect() {
      const select = document.getElementById('productCategory');
      select.innerHTML = '<option value="">Select Category</option>';
      
      categories.forEach(category => {
        const option = document.createElement('option');
        option.value = category.id;
        option.textContent = category.name;
        select.appendChild(option);
      });
    }

    // Fetch products from database
    function loadProducts() {
      fetch('includes/fetch_products.php')
        .then(res => res.json())
        .then(data => {
          products = data;
          displayProducts();
        })
        .catch(error => {
          console.error('Error loading products:', error);
          showAlert('Error loading products. Please refresh the page.', 'error');
        });
    }

    function displayProducts() {
      const grid = document.getElementById('productsGrid');
      grid.innerHTML = '';
      
      if (products.length === 0) {
        grid.innerHTML = '<div style="grid-column: 1/-1; text-align: center; padding: 2rem; color: var(--text-secondary);">No products available. Add some products to get started!</div>';
        return;
      }

      products.forEach(p => {
        const card = document.createElement('div');
        card.className = 'product-card';
        
        // Add stock status classes
        if (p.stock === 0) {
          card.classList.add('out-of-stock');
        } else if (p.stock <= 5) {
          card.classList.add('low-stock');
        }

        const stockClass = p.stock === 0 ? 'out' : p.stock <= 5 ? 'low' : '';
        
        card.innerHTML = `
          <div class="product-name">${p.name}</div>
          <div class="product-price">₱${p.price.toFixed(2)}</div>
          <div class="product-stock ${stockClass}">Stock: ${p.stock}</div>
        `;
        
        if (p.stock > 0) {
          card.onclick = () => addToCart(p);
        }
        
        grid.appendChild(card);
      });
    }

    function addToCart(product) {
      const existing = cart.find(i => i.id === product.id);
      if (existing) {
        if (existing.quantity < product.stock) {
          existing.quantity++;
        } else {
          showAlert('Not enough stock available!', 'error');
          return;
        }
      } else {
        cart.push({...product, quantity: 1});
      }
      updateCart();
      showAlert(`${product.name} added to cart`, 'success');
    }

    function removeFromCart(productId) {
      cart = cart.filter(item => item.id !== productId);
      updateCart();
    }

    function updateQuantity(productId, change) {
      const item = cart.find(i => i.id === productId);
      if (!item) return;

      const newQuantity = item.quantity + change;
      if (newQuantity <= 0) {
        removeFromCart(productId);
        return;
      }

      const product = products.find(p => p.id === productId);
      if (newQuantity > product.stock) {
        showAlert('Not enough stock available!', 'error');
        return;
      }

      item.quantity = newQuantity;
      updateCart();
    }

    function updateCart() {
      const tbody = document.querySelector('#cartTable tbody');
      tbody.innerHTML = '';
      let total = 0;
      
      cart.forEach(item => {
        const tr = document.createElement('tr');
        const subtotal = item.price * item.quantity;
        total += subtotal;
        
        tr.innerHTML = `
          <td>${item.name}</td>
          <td>₱${item.price.toFixed(2)}</td>
          <td>
            <div class="quantity-controls">
              <button class="qty-btn" onclick="updateQuantity(${item.id}, -1)">-</button>
              <span>${item.quantity}</span>
              <button class="qty-btn" onclick="updateQuantity(${item.id}, 1)">+</button>
            </div>
          </td>
          <td>₱${subtotal.toFixed(2)}</td>
          <td>
            <button class="remove-btn" onclick="removeFromCart(${item.id})" title="Remove item">
              <i class="fas fa-trash"></i>
            </button>
          </td>
        `;
        tbody.appendChild(tr);
      });
      
      document.getElementById('cartTotal').textContent = total.toFixed(2);
      
      // Show/hide cart actions based on cart content
      const checkoutBtn = document.getElementById('checkout');
      const clearBtn = document.getElementById('clearCart');
      const hasItems = cart.length > 0;
      
      checkoutBtn.style.display = hasItems ? 'flex' : 'none';
      clearBtn.style.display = hasItems ? 'flex' : 'none';
    }

    function clearCart() {
      if (cart.length === 0) return;
      
      if (confirm('Are you sure you want to clear the cart?')) {
        cart = [];
        updateCart();
        showAlert('Cart cleared', 'success');
      }
    }

    function showAlert(message, type = 'success') {
      // Remove existing alerts
      const existingAlerts = document.querySelectorAll('.alert');
      existingAlerts.forEach(alert => alert.remove());
      
      const alert = document.createElement('div');
      alert.className = `alert alert-${type}`;
      alert.textContent = message;
      
      // Insert at the top of the container
      const container = document.querySelector('.container');
      container.insertBefore(alert, container.firstChild);
      
      // Auto remove after 3 seconds
      setTimeout(() => {
        if (alert.parentNode) {
          alert.remove();
        }
      }, 3000);
    }

    // Checkout functionality
    document.getElementById('checkout').addEventListener('click', () => {
      if (cart.length === 0) {
        showAlert('Cart is empty', 'error');
        return;
      }

      const total = parseFloat(document.getElementById('cartTotal').textContent);
      
      // Create a more user-friendly payment modal
      const paymentAmount = prompt(`Total Amount: ₱${total.toFixed(2)}\n\nEnter amount paid:`);
      
      if (!paymentAmount || isNaN(paymentAmount) || parseFloat(paymentAmount) < total) {
        showAlert('Invalid payment amount', 'error');
        return;
      }

      const amountPaid = parseFloat(paymentAmount);
      const change = amountPaid - total;

      // Show loading state
      const checkoutBtn = document.getElementById('checkout');
      const originalText = checkoutBtn.innerHTML;
      checkoutBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
      checkoutBtn.disabled = true;

      fetch('save_sale.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({ items: cart, total, amountPaid, change })
      })
      .then(res => res.json())
      .then(data => {
        if (data.status === 'success') {
          showAlert(`Sale completed! Change: ₱${change.toFixed(2)}`, 'success');
          cart = [];
          updateCart();
          loadProducts();
          
          // Generate receipt (optional)
          generateReceipt(data.saleId || Date.now(), total, amountPaid, change);
        } else {
          showAlert('Failed to process sale', 'error');
        }
      })
      .catch(error => {
        console.error('Checkout error:', error);
        showAlert('Error processing sale', 'error');
      })
      .finally(() => {
        checkoutBtn.innerHTML = originalText;
        checkoutBtn.disabled = false;
      });
    });

    // Clear cart functionality
    document.getElementById('clearCart').addEventListener('click', clearCart);

    // Add product modal control
    const modal = document.getElementById('addProductModal');
    const categoryModal = document.getElementById('addCategoryModal');
    
    document.getElementById('addProductBtn').onclick = () => {
      // Clear form
      document.getElementById('productName').value = '';
      document.getElementById('productCategory').value = '';
      document.getElementById('originalPrice').value = '';
      document.getElementById('sellingPrice').value = '';
      document.getElementById('productStock').value = '0';
      document.getElementById('lowStockThreshold').value = '5';
      document.getElementById('productDescription').value = '';
      
      modal.style.display = 'flex';
    };

    // Add category button
    document.getElementById('addCategoryBtn').onclick = () => {
      document.getElementById('categoryName').value = '';
      document.getElementById('categoryDescription').value = '';
      categoryModal.style.display = 'flex';
    };

    // Category modal controls
    document.getElementById('closeCategoryModal').onclick = () => categoryModal.style.display = 'none';
    window.onclick = (e) => { 
      if (e.target === modal) modal.style.display = 'none';
      if (e.target === categoryModal) categoryModal.style.display = 'none';
    };

    // Save category
    document.getElementById('saveCategory').addEventListener('click', () => {
      const name = document.getElementById('categoryName').value.trim();
      const description = document.getElementById('categoryDescription').value.trim();

      if (!name) {
        showAlert('Please enter a category name', 'error');
        return;
      }

      const saveBtn = document.getElementById('saveCategory');
      const originalText = saveBtn.innerHTML;
      saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
      saveBtn.disabled = true;

      fetch('includes/manage_categories.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: new URLSearchParams({ 
          action: 'add',
          name, 
          description 
        })
      })
      .then(res => res.json())
      .then(result => {
        if (result.status === 'success') {
          showAlert('Category added successfully!', 'success');
          categoryModal.style.display = 'none';
          loadCategories(); // Reload categories
        } else {
          showAlert(result.message || 'Failed to add category', 'error');
        }
      })
      .catch(error => {
        console.error('Add category error:', error);
        showAlert('Error adding category', 'error');
      })
      .finally(() => {
        saveBtn.innerHTML = originalText;
        saveBtn.disabled = false;
      });
    });
    
    document.getElementById('closeModal').onclick = () => modal.style.display = 'none';
    window.onclick = (e) => { 
      if (e.target === modal) modal.style.display = 'none'; 
    };

    // Save new product
    document.getElementById('saveProduct').addEventListener('click', () => {
      const name = document.getElementById('productName').value.trim();
      const categoryId = document.getElementById('productCategory').value;
      const originalPrice = parseFloat(document.getElementById('originalPrice').value);
      const sellingPrice = parseFloat(document.getElementById('sellingPrice').value);
      const stock = parseInt(document.getElementById('productStock').value);
      const lowStock = parseInt(document.getElementById('lowStockThreshold').value);
      const description = document.getElementById('productDescription').value.trim();

      // Validation
      if (!name) {
        showAlert('Please enter a product name', 'error');
        return;
      }
      
      if (!categoryId) {
        showAlert('Please select a category', 'error');
        return;
      }
      
      if (!sellingPrice || sellingPrice <= 0) {
        showAlert('Please enter a valid selling price', 'error');
        return;
      }
      
      if (originalPrice && originalPrice > sellingPrice) {
        showAlert('Selling price should be higher than cost price', 'error');
        return;
      }
      
      if (stock < 0) {
        showAlert('Stock quantity cannot be negative', 'error');
        return;
      }

      // Show loading state
      const saveBtn = document.getElementById('saveProduct');
      const originalText = saveBtn.innerHTML;
      saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
      saveBtn.disabled = true;

      fetch('includes/add_product.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: new URLSearchParams({ 
          name, 
          categoryId, 
          originalPrice, 
          sellingPrice, 
          stock, 
          lowStock, 
          description 
        })
      })
      .then(res => res.text())
      .then(result => {
        if (result === 'success') {
          showAlert('Product added successfully!', 'success');
          modal.style.display = 'none';
          loadProducts();
        } else {
          showAlert('Failed to add product', 'error');
        }
      })
      .catch(error => {
        console.error('Add product error:', error);
        showAlert('Error adding product', 'error');
      })
      .finally(() => {
        saveBtn.innerHTML = originalText;
        saveBtn.disabled = false;
      });
    });

    // Generate receipt function
    function generateReceipt(saleId, total, amountPaid, change) {
      const receiptWindow = window.open('', '_blank', 'width=400,height=600');
      const receiptContent = `
        <html>
        <head>
          <title>Receipt - Sale #${saleId}</title>
          <style>
            body { font-family: monospace; margin: 20px; }
            .header { text-align: center; margin-bottom: 20px; }
            .items { margin: 20px 0; }
            .total { border-top: 1px solid #000; padding-top: 10px; margin-top: 20px; }
            .footer { text-align: center; margin-top: 30px; font-size: 12px; }
          </style>
        </head>
        <body>
          <div class="header">
            <h2>Minglanilla Liam Store</h2>
            <p>Receipt #${saleId}</p>
            <p>${new Date().toLocaleString()}</p>
          </div>
          
          <div class="items">
            ${cart.map(item => `
              <div style="display: flex; justify-content: space-between;">
                <span>${item.name} x${item.quantity}</span>
                <span>₱${(item.price * item.quantity).toFixed(2)}</span>
              </div>
            `).join('')}
          </div>
          
          <div class="total">
            <div style="display: flex; justify-content: space-between;">
              <strong>Total:</strong>
              <strong>₱${total.toFixed(2)}</strong>
            </div>
            <div style="display: flex; justify-content: space-between;">
              <span>Amount Paid:</span>
              <span>₱${amountPaid.toFixed(2)}</span>
            </div>
            <div style="display: flex; justify-content: space-between;">
              <span>Change:</span>
              <span>₱${change.toFixed(2)}</span>
            </div>
          </div>
          
          <div class="footer">
            <p>Thank you for your purchase!</p>
            <p>Visit us again soon!</p>
          </div>
        </body>
        </html>
      `;
      
      receiptWindow.document.write(receiptContent);
      receiptWindow.document.close();
    }

    // Update time display
    function updateTime() {
      const now = new Date();
      document.getElementById('time').textContent = now.toLocaleString();
    }
    
    setInterval(updateTime, 1000);
    updateTime();
    
    // Initialize the application
    loadCategories();
    loadProducts();
  </script>
</body>
</html>
