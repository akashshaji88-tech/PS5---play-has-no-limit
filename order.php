<?php
/**
 * PS5 ADVERTISING PAGE — order.php
 * Processes game orders via AJAX POST.
 */

header('Content-Type: application/json');
require_once 'db.php';

// Enable error reporting for debug (returns JSON formatted errors)
ini_set('display_errors', 0);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

// Extract and sanitize input
$game_id   = isset($_POST['game_id']) ? intval($_POST['game_id']) : 0;
$edition   = isset($_POST['edition']) ? trim(htmlspecialchars($_POST['edition'])) : '';
$name      = isset($_POST['name']) ? trim(htmlspecialchars($_POST['name'])) : '';
$email     = isset($_POST['email']) ? trim(htmlspecialchars($_POST['email'])) : '';
$address   = isset($_POST['address']) ? trim(htmlspecialchars($_POST['address'])) : '';

// Validation
if ($game_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Please select a valid game.']);
    exit;
}
if (empty($edition)) {
    echo json_encode(['success' => false, 'message' => 'Please select a game edition.']);
    exit;
}
if (empty($name) || strlen($name) < 2) {
    echo json_encode(['success' => false, 'message' => 'Please enter a valid name (minimum 2 characters).']);
    exit;
}
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Please enter a valid email address.']);
    exit;
}
if (empty($address) || strlen($address) < 8) {
    echo json_encode(['success' => false, 'message' => 'Please enter a valid delivery address or contact number.']);
    exit;
}

try {
    // 1. Fetch game details to verify pricing and title
    $stmt = $pdo->prepare("SELECT * FROM `games` WHERE `id` = ?");
    $stmt->execute([$game_id]);
    $game = $stmt->fetch();
    
    if (!$game) {
        echo json_encode(['success' => false, 'message' => 'Game not found in database.']);
        exit;
    }
    
    // 2. Calculate dynamic price based on Edition
    $basePrice = floatval($game['price']);
    $totalPrice = $basePrice;
    
    if ($edition === 'Digital Deluxe Edition') {
        $totalPrice += 10.00; // Deluxe edition mark-up
    } elseif ($edition === 'Digital Edition') {
        $totalPrice -= 5.00;  // Digital discount
    }
    
    // 3. Generate unique transaction ID
    $transactionId = 'PS5-' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 12));
    
    // 4. Insert order into the database
    $insertStmt = $pdo->prepare("INSERT INTO `orders` 
        (`transaction_id`, `game_id`, `edition`, `customer_name`, `customer_email`, `customer_address`, `total_price`) 
        VALUES (:trans_id, :game_id, :edition, :name, :email, :address, :total_price)");
        
    $insertStmt->execute([
        'trans_id' => $transactionId,
        'game_id' => $game_id,
        'edition' => $edition,
        'name' => $name,
        'email' => $email,
        'address' => $address,
        'total_price' => $totalPrice
    ]);
    
    // 5. Return success payload
    echo json_encode([
        'success' => true,
        'message' => 'Order placed successfully!',
        'details' => [
            'transaction_id' => $transactionId,
            'game_title'     => $game['title'],
            'edition'        => $edition,
            'customer_name'  => $name,
            'total_price'    => number_format($totalPrice, 2)
        ]
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Backend database error: ' . $e->getMessage()
    ]);
}
