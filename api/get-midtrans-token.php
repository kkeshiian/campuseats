<?php
header('Content-Type: application/json');

require_once '../config/midtrans-config.php'; // include config Midtrans

use Midtrans\Snap;

$raw = file_get_contents('php://input');
$data = json_decode($raw, true);

if (!$data || !isset($data['order_id'], $data['gross_amount'], $data['items'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid request']);
    exit;
}

$params = [
    'transaction_details' => [
        'order_id' => $data['order_id'],
        'gross_amount' => $data['gross_amount'],
    ],
    'item_details' => [],
    'customer_details' => [
        'first_name' => 'Pembeli',
        'email' => 'pembeli@email.com',
    ]
];

// Mapping item_details sesuai dokumentasi Midtrans
foreach ($data['items'] as $item) {
    $params['item_details'][] = [
        'id' => $item['id'] ?? 'item',
        'price' => (int)$item['harga'],
        'quantity' => (int)$item['quantity'],
        'name' => $item['nama'],
        // 'brand' => '', // optional
        // 'category' => '', // optional
    ];
}

try {
    $snapToken = Snap::getSnapToken($params);
    echo json_encode(['token' => $snapToken]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
