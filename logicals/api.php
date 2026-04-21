<?php

header('Content-Type: application/json; charset=utf-8');

try {
    $dbh = new PDO(
        'mysql:host=localhost;dbname=pizzarendeles;charset=utf8mb4',
        'root',
        '',
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
    );
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

    // READ
    if ($method === 'GET') {
        $stmt = $dbh->query("SELECT az, pizzanev, darab, meret, vevonev FROM rendeles ORDER BY az DESC");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    // CREATE
    elseif ($method === 'POST') {
        if (
            !isset($input['pizzanev']) || trim($input['pizzanev']) === '' ||
            !isset($input['darab']) || (int)$input['darab'] < 1 ||
            !isset($input['meret']) || trim($input['meret']) === '' ||
            !isset($input['vevonev']) || trim($input['vevonev']) === ''
        ) {
            http_response_code(400);
            echo json_encode([
                'status' => 'hiba',
                'uzenet' => 'Hiányzó vagy hibás adatok.'
            ]);
            exit;
        }

        $stmt = $dbh->prepare("INSERT INTO rendeles (pizzanev, darab, meret, vevonev) VALUES (?, ?, ?, ?)");
        $stmt->execute([
            trim($input['pizzanev']),
            (int)$input['darab'],
            trim($input['meret']),
            trim($input['vevonev'])
        ]);

        echo json_encode([
            'status' => 'sikeres',
            'uzenet' => 'Új rendelés sikeresen létrehozva.'
        ]);
    }

    // UPDATE
    elseif ($method === 'PUT') {
        if (
            !isset($input['az']) || (int)$input['az'] < 1 ||
            !isset($input['pizzanev']) || trim($input['pizzanev']) === '' ||
            !isset($input['darab']) || (int)$input['darab'] < 1 ||
            !isset($input['meret']) || trim($input['meret']) === '' ||
            !isset($input['vevonev']) || trim($input['vevonev']) === ''
        ) {
            http_response_code(400);
            echo json_encode([
                'status' => 'hiba',
                'uzenet' => 'Hiányzó vagy hibás adatok a módosításhoz.'
            ]);
            exit;
        }

        $stmt = $dbh->prepare("
            UPDATE rendeles
            SET pizzanev = ?, darab = ?, meret = ?, vevonev = ?
            WHERE az = ?
        ");
        $stmt->execute([
            trim($input['pizzanev']),
            (int)$input['darab'],
            trim($input['meret']),
            trim($input['vevonev']),
            (int)$input['az']
        ]);

        echo json_encode([
            'status' => 'sikeres',
            'uzenet' => 'Rendelés sikeresen módosítva.'
        ]);
    }

    // DELETE
    elseif ($method === 'DELETE') {
        if (!isset($input['az']) || (int)$input['az'] < 1) {
            http_response_code(400);
            echo json_encode([
                'status' => 'hiba',
                'uzenet' => 'Hiányzó azonosító a törléshez.'
            ]);
            exit;
        }

        $stmt = $dbh->prepare("DELETE FROM rendeles WHERE az = ?");
        $stmt->execute([(int)$input['az']]);

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

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'hiba',
        'uzenet' => 'Adatbázis hiba: ' . $e->getMessage()
    ]);
}