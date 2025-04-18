<?php
header('Content-Type: application/json');
include "db.php"; // Include database connection file
session_start();

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'getProducts':
        echo json_encode(getProducts());
        break;

    case 'addToCart':
        echo json_encode(addToCart($_POST));
        break;

    case 'getCart':
        echo json_encode(getCart());
        break;

    case 'checkout':
        echo json_encode(checkout());
        break;

    default:
        echo json_encode(['error' => 'Invalid action']);
}

function getProducts() {
    global $conn;

    // Use a prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM products");
    $stmt->execute();
    $result = $stmt->get_result();

    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    return $products;
}

function addToCart($data) {
    if (empty($data['id'])) {
        return ['error' => 'Invalid product ID'];
    }

    $id = (int) $data['id']; // Ensure the ID is an integer for security

    // Initialize the cart if not already set
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Add product to the cart, or increment quantity if already in cart
    if (!isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] = 1;
    } else {
        $_SESSION['cart'][$id]++;
    }

    return ['success' => true, 'message' => 'Item added to cart'];
}

function getCart() {
    global $conn;
    $cartItems = [];

    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $id => $qty) {
            // Prepare and execute query to fetch product details for each cart item
            $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
            $stmt->bind_param("i", $id); // Bind the ID as an integer
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                $row['quantity'] = $qty;
                $cartItems[] = $row;
            }
        }
    }

    return $cartItems;
}

function checkout() {
    // Clear the cart after checkout
    $_SESSION['cart'] = [];
    return ['success' => true, 'message' => 'Order placed successfully'];
}
?>
