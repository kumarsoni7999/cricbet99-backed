<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get JSON data from the request body
    $jsonData = file_get_contents('php://input');
    
    // Decode the JSON into a PHP array
    $data = json_decode($jsonData, true);

    // Load existing data.json file content
    $file = 'data.json';
    if (!file_exists($file)) {
        file_put_contents($file, json_encode([])); // Create an empty JSON file if it doesn't exist
    }
    $existingData = json_decode(file_get_contents($file), true);

    // Generate a random key and add the new data
    $randomKey = rand(100000, 999999);
    $data['date'] = date('Y-m-d'); // Add today's date
    $existingData[$randomKey] = $data;

    // Save the updated data back to data.json
    file_put_contents($file, json_encode($existingData, JSON_PRETTY_PRINT));

    // Respond with success
    echo json_encode(['success' => true, 'message' => 'Data saved successfully.']);
    exit;
}

// If accessed via GET, return the data.json file content
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Content-Type: application/json');
    echo file_get_contents('data.json');
    exit;
}

// For unsupported methods
http_response_code(405);
echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
exit;
?>
