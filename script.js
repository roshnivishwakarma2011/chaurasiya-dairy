// Function to handle product order submission
function orderProduct(product) {
    // Get the user's name and email (can be set dynamically via a form or prompts)
    let name = prompt("Enter your name:");
    let email = prompt("Enter your email:");

    // Ensure user provides the necessary information
    if (name && email) {
        // Prepare data to send to the server
        let orderData = new FormData();
        orderData.append('product', product);
        orderData.append('name', name);
        orderData.append('email', email);

        // Send the order data to the PHP backend (order.php)
        fetch('order.php', {
            method: 'POST',
            body: orderData
        })
        .then(response => response.json())  // Parse JSON response from the server
        .then(data => {
            if (data.status === 'success') {
                alert('Your order has been placed successfully!');
                updateOrderList(product); // Optionally update the order list on the page
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Something went wrong.');
        });
    } else {
        alert('Please provide both your name and email!');
    }
}

// Function to update the order list dynamically on the page
function updateOrderList(product) {
    const orderList = document.getElementById('orderList');
    const listItem = document.createElement('li');
    listItem.textContent = `Ordered: ${product}`;
    orderList.appendChild(listItem);
}
