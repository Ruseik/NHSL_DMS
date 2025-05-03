<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - NHSL Diet Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .cart-item {
            border-bottom: 1px solid #eee;
            padding: 10px 0;
        }
        .cart-total {
            border-top: 2px solid #dee2e6;
            padding-top: 1rem;
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">NHSL DMS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Diet Entry</a>
                    </li>
                    <?php if ($_SESSION['role'] !== 'diet_clerk'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/analytics">Analytics</a>
                    </li>
                    <?php endif; ?>
                    <?php if ($_SESSION['role'] === 'programmer'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/settings">Settings</a>
                    </li>
                    <?php endif; ?>
                </ul>
                <div class="navbar-text text-white me-3">
                    Welcome, <?php echo htmlspecialchars($_SESSION['full_name']); ?>
                </div>
                <a href="/auth/logout" class="btn btn-light">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Diet Items Entry</h5>
                        <select id="wardSelect" class="form-select" style="width: auto;" required>
                            <option value="">Select Ward</option>
                            <?php foreach ($wards as $ward): ?>
                            <option value="<?php echo htmlspecialchars($ward['id']); ?>">
                                <?php echo htmlspecialchars($ward['name']); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="itemSelect" class="form-label">Select Item</label>
                            <select id="itemSelect" class="form-select">
                                <option value="">Loading items...</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="quantity" min="1" value="1">
                        </div>
                        <button id="addToCart" class="btn btn-primary" disabled>
                            Add to Cart
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Cart</h5>
                    </div>
                    <div class="card-body">
                        <div id="cartItems"></div>
                        <div class="cart-total">
                            <strong>Total Items:</strong> <span id="totalItems">0</span>
                        </div>
                        <button id="saveEntry" class="btn btn-success w-100 mt-3" disabled>
                            Save Entry
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let dietItems = [];
        let cart = [];

        document.addEventListener('DOMContentLoaded', function() {
            const wardSelect = document.getElementById('wardSelect');
            const itemSelect = document.getElementById('itemSelect');
            const quantityInput = document.getElementById('quantity');
            const addToCartBtn = document.getElementById('addToCart');
            const saveEntryBtn = document.getElementById('saveEntry');
            const cartItemsDiv = document.getElementById('cartItems');
            const totalItemsSpan = document.getElementById('totalItems');

            // Load diet items
            fetch('/api/diet-items')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        dietItems = data.items;
                        itemSelect.innerHTML = '<option value="">Select an item</option>' +
                            dietItems.map(item => `<option value="${item.id}">${item.name} (${item.unit})</option>`).join('');
                    }
                });

            // Enable/disable add to cart button based on selections
            function updateAddToCartButton() {
                addToCartBtn.disabled = !wardSelect.value || !itemSelect.value || quantityInput.value < 1;
            }

            wardSelect.addEventListener('change', updateAddToCartButton);
            itemSelect.addEventListener('change', updateAddToCartButton);
            quantityInput.addEventListener('input', updateAddToCartButton);

            // Add item to cart
            addToCartBtn.addEventListener('click', function() {
                const itemId = itemSelect.value;
                const item = dietItems.find(i => i.id === itemId);
                const quantity = parseInt(quantityInput.value);

                if (item && quantity > 0) {
                    const existingItem = cart.find(i => i.id === itemId);
                    if (existingItem) {
                        existingItem.quantity += quantity;
                    } else {
                        cart.push({
                            id: itemId,
                            name: item.name,
                            unit: item.unit,
                            quantity: quantity
                        });
                    }
                    updateCart();
                    itemSelect.value = '';
                    quantityInput.value = '1';
                    updateAddToCartButton();
                }
            });

            // Update cart display
            function updateCart() {
                cartItemsDiv.innerHTML = cart.map(item => `
                    <div class="cart-item">
                        <div class="d-flex justify-content-between">
                            <div>
                                <strong>${item.name}</strong><br>
                                ${item.quantity} ${item.unit}
                            </div>
                            <button class="btn btn-sm btn-danger" onclick="removeFromCart('${item.id}')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                `).join('');

                totalItemsSpan.textContent = cart.length;
                saveEntryBtn.disabled = cart.length === 0 || !wardSelect.value;
            }

            // Remove item from cart
            window.removeFromCart = function(itemId) {
                cart = cart.filter(item => item.id !== itemId);
                updateCart();
            };

            // Save diet entry
            saveEntryBtn.addEventListener('click', function() {
                const data = {
                    ward_id: wardSelect.value,
                    items: cart
                };

                fetch('/api/save-diet-entry', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Diet entry saved successfully!');
                        cart = [];
                        updateCart();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while saving the diet entry.');
                });
            });
        });
    </script>
</body>
</html>