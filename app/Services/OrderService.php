<?php

declare(strict_types=1);

namespace App\Services;

use mysqli;
use PDO;
use Throwable;

/**
 * Service: Order Processing & Storage Engine
 * Handles checkout validation, atomic database transactions,
 * order number generation, and retrieval for Lorem Ipsum Luxury Jewelry.
 */
final class OrderService
{
    public const SCHEMA_ORDERS_SQL = <<<'SQL'
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_number VARCHAR(50) NOT NULL UNIQUE,
    user_id INT NULL,
    customer_name VARCHAR(150) NOT NULL,
    customer_email VARCHAR(255) NOT NULL,
    customer_phone VARCHAR(50) NOT NULL,
    shipping_address TEXT NOT NULL,
    apartment VARCHAR(100) NULL,
    city VARCHAR(100) NOT NULL,
    state VARCHAR(100) NULL,
    postal_code VARCHAR(30) NULL,
    country VARCHAR(100) NOT NULL DEFAULT 'Pakistan',
    payment_method VARCHAR(50) NOT NULL DEFAULT 'cod',
    payment_status ENUM('Pending', 'Paid', 'Failed', 'Refunded') NOT NULL DEFAULT 'Pending',
    order_status ENUM('Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled') NOT NULL DEFAULT 'Pending',
    subtotal DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    shipping_fee DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    total_amount DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    notes TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_orders_user_id (user_id),
    INDEX idx_orders_status (order_status),
    INDEX idx_orders_email (customer_email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
SQL;

    public const SCHEMA_ORDER_ITEMS_SQL = <<<'SQL'
CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id VARCHAR(100) NULL,
    product_name VARCHAR(255) NOT NULL,
    product_image VARCHAR(255) NULL,
    price DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    quantity INT NOT NULL DEFAULT 1,
    line_total DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_order_items_order (order_id),
    CONSTRAINT fk_order_items_order FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
SQL;

    /**
     * Resolves a database connection instance (PDO or MySQLi).
     *
     * @return PDO|mysqli
     */
    public static function getConnection(): PDO|mysqli
    {
        // 1. Try global PDO wrapper
        if (function_exists('get_pdo_connection')) {
            try {
                $conn = get_pdo_connection();
                $pdo = $conn->pdo();
                if ($pdo instanceof PDO) {
                    return $pdo;
                }
            } catch (Throwable) {
                // Fall back
            }
        }

        // 2. Ensure db.php is included
        if (!defined('DB_HOST')) {
            $dbPath = dirname(__DIR__, 2) . '/config/db.php';
            if (is_file($dbPath)) {
                require_once $dbPath;
            }
        }

        $host = defined('DB_HOST') ? (string) DB_HOST : 'localhost';
        $user = defined('DB_USER') ? (string) DB_USER : 'root';
        $pass = defined('DB_PASS') ? (string) DB_PASS : '';
        $dbname = defined('DB_NAME') ? (string) DB_NAME : 'jewels_db';
        $port = defined('DB_PORT') ? (int) DB_PORT : 3306;

        try {
            if (file_exists('/tmp/mysql.sock')) {
                $dsn = sprintf('mysql:unix_socket=/tmp/mysql.sock;dbname=%s;charset=utf8mb4', $dbname);
            } else {
                $dsn = sprintf('mysql:host=%s;port=%d;dbname=%s;charset=utf8mb4', $host, $port, $dbname);
            }
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            return new PDO($dsn, $user, $pass, $options);
        } catch (Throwable) {
            if (function_exists('get_db_connection')) {
                $mysqli = get_db_connection();
                if ($mysqli instanceof mysqli) {
                    return $mysqli;
                }
            }
            throw new \RuntimeException('Database connection could not be established for OrderService.');
        }
    }

    /**
     * Ensures both orders and order_items tables exist.
     */
    public static function ensureTables(PDO|mysqli|null $conn = null): void
    {
        $db = $conn ?? self::getConnection();

        if ($db instanceof PDO) {
            $db->exec(self::SCHEMA_ORDERS_SQL);
            $db->exec(self::SCHEMA_ORDER_ITEMS_SQL);
        } elseif ($db instanceof mysqli) {
            $db->query(self::SCHEMA_ORDERS_SQL);
            $db->query(self::SCHEMA_ORDER_ITEMS_SQL);
        }
    }

    /**
     * Generates a unique, luxurious order number (e.g. ORD-2026-A8F4-102).
     */
    public static function generateOrderNumber(): string
    {
        $year = date('Y');
        $random = strtoupper(bin2hex(random_bytes(2)));
        $num = mt_rand(100, 999);
        return "ORD-{$year}-{$random}-{$num}";
    }

    /**
     * Validates input payload and creates an order with its line items atomically.
     *
     * @param array $input Raw form data or JSON payload
     * @return array [success => bool, order_id => int, order_number => string, errors => array]
     */
    public static function createOrder(array $input): array
    {
        $errors = [];

        // 1. Sanitize & Validate Customer Information
        $fullName = trim((string) ($input['full_name'] ?? ''));
        if (empty($fullName) && (!empty($input['first_name']) || !empty($input['last_name']))) {
            $fullName = trim(($input['first_name'] ?? '') . ' ' . ($input['last_name'] ?? ''));
        }

        if (mb_strlen($fullName) < 2 || mb_strlen($fullName) > 150) {
            $errors['full_name'] = 'Please enter your full name (at least 2 characters).';
        }

        $email = trim((string) ($input['email'] ?? ''));
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Please provide a valid email address for your order confirmation.';
        }

        $phone = trim((string) ($input['phone'] ?? ''));
        $cleanPhone = preg_replace('/[^\d+]/', '', $phone);
        if (strlen($cleanPhone) < 7 || strlen($cleanPhone) > 20) {
            $errors['phone'] = 'Please provide a valid phone number (at least 7 digits).';
        }

        $address = trim((string) ($input['address'] ?? ''));
        if (mb_strlen($address) < 5) {
            $errors['address'] = 'Please provide your full delivery street address.';
        }

        $apartment = trim((string) ($input['apartment'] ?? ''));
        $city = trim((string) ($input['city'] ?? ''));
        if (empty($city)) {
            $errors['city'] = 'Please specify your city.';
        }

        $state = trim((string) ($input['state'] ?? ''));
        $postalCode = trim((string) ($input['postal_code'] ?? ''));
        $country = trim((string) ($input['country'] ?? 'Pakistan'));
        if (empty($country)) {
            $country = 'Pakistan';
        }

        $paymentMethod = trim((string) ($input['payment_method'] ?? 'cod'));
        $validPaymentMethods = ['cod', 'bank_transfer', 'card'];
        if (!in_array($paymentMethod, $validPaymentMethods, true)) {
            $paymentMethod = 'cod';
        }

        $notes = trim((string) ($input['notes'] ?? ''));
        $userId = !empty($input['user_id']) ? (int) $input['user_id'] : null;

        // 2. Validate Cart Items
        $cartItems = $input['cart_items'] ?? [];
        if (is_string($cartItems)) {
            $decoded = json_decode($cartItems, true);
            $cartItems = is_array($decoded) ? $decoded : [];
        }

        if (!is_array($cartItems) || count($cartItems) === 0) {
            $errors['cart'] = 'Your shopping bag is empty. Please add items before placing an order.';
        }

        $validatedItems = [];
        $calculatedSubtotal = 0.0;

        foreach ($cartItems as $index => $item) {
            if (!is_array($item)) {
                continue;
            }

            $productName = trim((string) ($item['title'] ?? $item['name'] ?? 'Artisan Jewelry Piece'));
            if (empty($productName)) {
                $productName = 'Artisan Jewelry Piece #' . ($index + 1);
            }

            $priceNum = isset($item['priceNum']) ? (float) $item['priceNum'] : (isset($item['price']) ? (float) preg_replace('/[^\d.]/', '', (string) $item['price']) : 0.0);
            if ($priceNum < 0) {
                $priceNum = 0.0;
            }

            $qty = isset($item['qty']) ? (int) $item['qty'] : (isset($item['quantity']) ? (int) $item['quantity'] : 1);
            if ($qty < 1) {
                $qty = 1;
            }

            $lineTotal = round($priceNum * $qty, 2);
            $calculatedSubtotal += $lineTotal;

            $validatedItems[] = [
                'product_id'    => (string) ($item['id'] ?? null),
                'product_name'  => mb_substr($productName, 0, 255),
                'product_image' => mb_substr((string) ($item['img'] ?? $item['image'] ?? ''), 0, 255),
                'price'         => $priceNum,
                'quantity'      => $qty,
                'line_total'    => $lineTotal,
            ];
        }

        if (count($validatedItems) === 0 && empty($errors['cart'])) {
            $errors['cart'] = 'No valid items found in your order.';
        }

        if (!empty($errors)) {
            return [
                'success' => false,
                'errors'  => $errors,
            ];
        }

        // Complimentary shipping
        $shippingFee = 0.00;
        $totalAmount = round($calculatedSubtotal + $shippingFee, 2);

        // 3. Database Insertion with Transaction
        $db = self::getConnection();
        self::ensureTables($db);

        $orderNumber = self::generateOrderNumber();
        $paymentStatus = ($paymentMethod === 'card') ? 'Paid' : 'Pending';
        $orderStatus = 'Pending';

        if ($db instanceof PDO) {
            try {
                $db->beginTransaction();

                // Insert main order
                $stmt = $db->prepare(
                    'INSERT INTO orders (
                        order_number, user_id, customer_name, customer_email, customer_phone,
                        shipping_address, apartment, city, state, postal_code, country,
                        payment_method, payment_status, order_status,
                        subtotal, shipping_fee, total_amount, notes
                    ) VALUES (
                        :order_number, :user_id, :customer_name, :customer_email, :customer_phone,
                        :shipping_address, :apartment, :city, :state, :postal_code, :country,
                        :payment_method, :payment_status, :order_status,
                        :subtotal, :shipping_fee, :total_amount, :notes
                    )'
                );

                $stmt->execute([
                    ':order_number'     => $orderNumber,
                    ':user_id'          => $userId,
                    ':customer_name'    => $fullName,
                    ':customer_email'   => $email,
                    ':customer_phone'   => $phone,
                    ':shipping_address' => $address,
                    ':apartment'        => $apartment,
                    ':city'             => $city,
                    ':state'            => $state,
                    ':postal_code'      => $postalCode,
                    ':country'          => $country,
                    ':payment_method'   => $paymentMethod,
                    ':payment_status'   => $paymentStatus,
                    ':order_status'     => $orderStatus,
                    ':subtotal'         => $calculatedSubtotal,
                    ':shipping_fee'     => $shippingFee,
                    ':total_amount'     => $totalAmount,
                    ':notes'            => $notes,
                ]);

                $orderId = (int) $db->lastInsertId();

                // Insert order line items
                $itemStmt = $db->prepare(
                    'INSERT INTO order_items (
                        order_id, product_id, product_name, product_image,
                        price, quantity, line_total
                    ) VALUES (
                        :order_id, :product_id, :product_name, :product_image,
                        :price, :quantity, :line_total
                    )'
                );

                foreach ($validatedItems as $item) {
                    $itemStmt->execute([
                        ':order_id'      => $orderId,
                        ':product_id'    => $item['product_id'],
                        ':product_name'  => $item['product_name'],
                        ':product_image' => $item['product_image'],
                        ':price'         => $item['price'],
                        ':quantity'      => $item['quantity'],
                        ':line_total'    => $item['line_total'],
                    ]);
                }

                $db->commit();

                return [
                    'success'      => true,
                    'order_id'     => $orderId,
                    'order_number' => $orderNumber,
                    'total'        => $totalAmount,
                    'items_count'  => count($validatedItems),
                ];
            } catch (Throwable $e) {
                if ($db->inTransaction()) {
                    $db->rollBack();
                }
                return [
                    'success' => false,
                    'errors'  => ['general' => 'Database error while saving order: ' . $e->getMessage()],
                ];
            }
        } elseif ($db instanceof mysqli) {
            $db->begin_transaction();
            try {
                $sql = 'INSERT INTO orders (
                    order_number, user_id, customer_name, customer_email, customer_phone,
                    shipping_address, apartment, city, state, postal_code, country,
                    payment_method, payment_status, order_status,
                    subtotal, shipping_fee, total_amount, notes
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';

                $stmt = $db->prepare($sql);
                if (!$stmt) {
                    throw new \RuntimeException('Failed to prepare order insert: ' . $db->error);
                }

                $stmt->bind_param(
                    'sissssssssssssddds',
                    $orderNumber,
                    $userId,
                    $fullName,
                    $email,
                    $phone,
                    $address,
                    $apartment,
                    $city,
                    $state,
                    $postalCode,
                    $country,
                    $paymentMethod,
                    $paymentStatus,
                    $orderStatus,
                    $calculatedSubtotal,
                    $shippingFee,
                    $totalAmount,
                    $notes
                );

                $stmt->execute();
                $orderId = (int) $db->insert_id;
                $stmt->close();

                $itemSql = 'INSERT INTO order_items (
                    order_id, product_id, product_name, product_image,
                    price, quantity, line_total
                ) VALUES (?, ?, ?, ?, ?, ?, ?)';

                $itemStmt = $db->prepare($itemSql);
                if (!$itemStmt) {
                    throw new \RuntimeException('Failed to prepare item insert: ' . $db->error);
                }

                foreach ($validatedItems as $item) {
                    $itemStmt->bind_param(
                        'isssd id',
                        $orderId,
                        $item['product_id'],
                        $item['product_name'],
                        $item['product_image'],
                        $item['price'],
                        $item['quantity'],
                        $item['line_total']
                    );
                    $itemStmt->execute();
                }
                $itemStmt->close();

                $db->commit();

                return [
                    'success'      => true,
                    'order_id'     => $orderId,
                    'order_number' => $orderNumber,
                    'total'        => $totalAmount,
                    'items_count'  => count($validatedItems),
                ];
            } catch (Throwable $e) {
                $db->rollback();
                return [
                    'success' => false,
                    'errors'  => ['general' => 'Database error while saving order: ' . $e->getMessage()],
                ];
            }
        }

        return [
            'success' => false,
            'errors'  => ['general' => 'Unsupported database driver.'],
        ];
    }

    /**
     * Retrieves an order and its line items by order_number or order_id.
     */
    public static function getOrder(int|string $identifier): ?array
    {
        $db = self::getConnection();
        self::ensureTables($db);

        $isId = is_numeric($identifier);
        $field = $isId ? 'id' : 'order_number';

        if ($db instanceof PDO) {
            $stmt = $db->prepare("SELECT * FROM orders WHERE {$field} = :val LIMIT 1");
            $stmt->execute([':val' => $identifier]);
            $order = $stmt->fetch();
            if (!$order) {
                return null;
            }

            $itemsStmt = $db->prepare("SELECT * FROM order_items WHERE order_id = :oid ORDER BY id ASC");
            $itemsStmt->execute([':oid' => $order['id']]);
            $order['items'] = $itemsStmt->fetchAll();

            return $order;
        } elseif ($db instanceof mysqli) {
            $stmt = $db->prepare("SELECT * FROM orders WHERE {$field} = ? LIMIT 1");
            $stmt->bind_param($isId ? 'i' : 's', $identifier);
            $stmt->execute();
            $res = $stmt->get_result();
            $order = $res->fetch_assoc();
            $stmt->close();

            if (!$order) {
                return null;
            }

            $itemsStmt = $db->prepare("SELECT * FROM order_items WHERE order_id = ? ORDER BY id ASC");
            $itemsStmt->bind_param('i', $order['id']);
            $itemsStmt->execute();
            $itemsRes = $itemsStmt->get_result();
            $order['items'] = [];
            while ($row = $itemsRes->fetch_assoc()) {
                $order['items'][] = $row;
            }
            $itemsStmt->close();

            return $order;
        }

        return null;
    }

    /**
     * Retrieves all orders for administrative display.
     */
    public static function getAllOrders(?string $status = null, int $limit = 50): array
    {
        $db = self::getConnection();
        self::ensureTables($db);

        $where = '';
        $params = [];

        if ($status && $status !== 'all') {
            $where = 'WHERE order_status = :status';
            $params[':status'] = $status;
        }

        if ($db instanceof PDO) {
            $stmt = $db->prepare("SELECT * FROM orders {$where} ORDER BY id DESC LIMIT {$limit}");
            $stmt->execute($params);
            $orders = $stmt->fetchAll();

            foreach ($orders as &$ord) {
                $itemsStmt = $db->prepare("SELECT * FROM order_items WHERE order_id = :oid");
                $itemsStmt->execute([':oid' => $ord['id']]);
                $ord['items'] = $itemsStmt->fetchAll();
            }

            return $orders;
        }

        return [];
    }
}
