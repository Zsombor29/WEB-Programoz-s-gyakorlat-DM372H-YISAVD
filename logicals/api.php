<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json; charset=utf-8');

try {
    include('../includes/db.php');
    $dbh = getDbConnection();
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'hiba',
        'uzenet' => 'Adatbázis kapcsolódási hiba: ' . $e->getMessage()
    ]);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$method = $_SERVER['REQUEST_METHOD'];

try {
    if ($method === 'GET') {
        $stmt = $dbh->query("
            SELECT pizzanev, darab, felvetel, kiszallitas
            FROM rendeles
            ORDER BY felvetel DESC
        ");

        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    elseif ($method === 'POST') {
        $stmt = $dbh->prepare("
            INSERT INTO rendeles (pizzanev, darab, felvetel, kiszallitas)
            VALUES (?, ?, NOW(), DATE_ADD(NOW(), INTERVAL 2 HOUR))
        ");

        $stmt->execute([
            trim($input['pizzanev']),
            (int)$input['darab']
        ]);

        echo json_encode([
            'status' => 'sikeres',
            'uzenet' => 'Új rendelés sikeresen létrehozva.'
        ]);
    }

    elseif ($method === 'PUT') {
        $stmt = $dbh->prepare("
            UPDATE rendeles
            SET pizzanev = ?,
                darab = ?,
                felvetel = NOW(),
                kiszallitas = DATE_ADD(NOW(), INTERVAL 2 HOUR)
            WHERE felvetel = ?
        ");

        $stmt->execute([
            trim($input['pizzanev']),
            (int)$input['darab'],
            trim($input['eredetiFelvetel'])
        ]);

        echo json_encode([
            'status' => 'sikeres',
            'uzenet' => 'Rendelés sikeresen módosítva.'
        ]);
    }

    elseif ($method === 'DELETE') {
        $stmt = $dbh->prepare("
            DELETE FROM rendeles
            WHERE felvetel = ?
        ");

        $stmt->execute([
            trim($input['felvetel'])
        ]);

        echo json_encode([
            'status' => 'sikeres',
            'uzenet' => 'Rendelés sikeresen törölve.'
        ]);
    }

    else {
        http_response_code(405);
        echo json_encode([
            'status' => 'hiba',
            'uzenet' => 'Nem engedélyezett metódus.'
        ]);
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'hiba',
        'uzenet' => $e->getMessage()
    ]);
}
?>