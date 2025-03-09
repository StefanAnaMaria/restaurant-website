// Function to show custom notification
function showCustomNotification(message) {
    const notification = document.getElementById('cartNotification');
    notification.textContent = message; // Set the notification message
    notification.style.display = 'block'; // Show the notification
    setTimeout(() => {
        notification.style.display = 'none'; // Hide after 2 seconds
    }, 2000); // Adjust the duration as needed
}

// Function to add a product to the cart
function addToCart(productId, productName, productPrice) {
    console.log('Adding to cart:', productId, productName, productPrice); // Debugging line
    fetch('../pages/add_to_cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            id: productId,
            name: productName,
            price: productPrice
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log('Data received from add_to_cart.php:', data); // Debugging line
        if (data.success) {
            updateCartBadge(data.cartCount); // Update the cart badge with the new count
            showCustomNotification('Produsul a fost adăugat în coș!'); // Show custom notification
        } else {
            showCustomNotification('A apărut o eroare. Te rugăm să încerci din nou.'); // Show error notification
        }
    })
    .catch((error) => {
        console.error('Error adding to cart:', error);
        showCustomNotification('A apărut o eroare. Te rugăm să încerci din nou.'); // Show error notification
    });
}

// Function to remove a product from the cart
function removeFromCart(productId) {
    console.log('Removing from cart:', productId); // Debugging line
    fetch('../pages/remove_from_cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id: productId })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log('Data received from remove_from_cart.php:', data); // Debugging line
        if (data.success) {
            updateCartBadge(data.cartCount); // Update the cart badge after removal
            showCustomNotification('Produsul a fost șters din coș!'); // Show removal notification
            location.reload(); // Reload the page to reflect changes
        } else {
            showCustomNotification('A apărut o eroare. Te rugăm să încerci din nou.'); // Show error notification
        }
    })
    .catch((error) => {
        console.error('Error removing from cart:', error);
        showCustomNotification('A apărut o eroare. Te rugăm să încerci din nou.'); // Show error notification
    });
}

// Function to update the cart badge count
function updateCartBadge(cartCount) {
    const badge = document.querySelector('.cart-badge');
    if (badge) {
        badge.textContent = cartCount; // Update with provided count
    } else {
        console.error('Cart badge element not found.');
    }
}

// Function to update the quantity of a product in the cart
function updateQuantity(productId, change) {
    const quantityElement = document.getElementById(`quantity-${productId}`);
    let currentQuantity = parseInt(quantityElement.textContent);

    // Calculate new quantity
    let newQuantity = currentQuantity + change;

    // Ensure quantity does not go below 1
    if (newQuantity < 1) {
        newQuantity = 1; // Prevent negative quantity
    }

    // Update the quantity in the UI
    quantityElement.textContent = newQuantity;

    // Get the price of the product
    const priceElement = document.querySelector(`.price-${productId}`);
    const price = parseFloat(priceElement.textContent); // Assuming price is displayed in the format "XX Lei"
    
    // Calculate new total for this item
    const newTotal = (price * newQuantity).toFixed(2); // Calculate total and format to 2 decimal places
    const totalElement = document.querySelector(`.total-${productId}`);
    totalElement.textContent = `${newTotal} Lei`; // Update the total for this item

    // Update overall cart total
    updateCartTotal();

    // Send the updated quantity to the server
    fetch('update_cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id: productId, quantity: newQuantity })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            updateCartBadge(data.cartCount); // Update the cart badge with the new count
            showCustomNotification('Cantitatea a fost actualizată!'); // Show notification
        } else {
            showCustomNotification('A apărut o eroare. Te rugăm să încerci din nou.'); // Show error notification
        }
    })
    .catch((error) => {
        console.error('Error updating quantity:', error);
        showCustomNotification('A apărut o eroare. Te rugăm să încerci din nou.'); // Show error notification
    });
}

// Function to update the overall cart total
function updateCartTotal() {
    let total = 0;
    const rows = document.querySelectorAll('#cart-items tbody tr');

    rows.forEach(row => {
        const totalElement = row.querySelector('td:nth-child(4)'); // Assuming total is in the 4th column
        const itemTotal = parseFloat(totalElement.textContent);
        total += itemTotal;
    });

    // Update the overall total display
    const overallTotalElement = document.getElementById('overall-total'); // Assuming you have an element with this ID
    overallTotalElement.textContent = `${total.toFixed(2)} Lei`; // Update the overall total
}