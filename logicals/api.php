<?php
header('Content-Type: application/json; charset=utf-8');

try {
    include('./includes/db.php');
    $dbh = getDbConnection();
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(array('status' => 'hiba', 'uzenet' => 'Adatbázis kapcsolódási hiba: ' . $e->getMessage()));
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$method = $_SERVER['REQUEST_METHOD'];

try {
    if ($method === 'GET') {
        $stmt = $dbh->query("SELECT az, pizzanev, darab, meret, vevonev FROM rendeles ORDER BY az DESC");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    } elseif ($method === 'POST') {
        if (!isset($input['pizzanev'], $input['darab'], $input['meret'], $input['vevonev'])) {
            throw new Exception('Hiányzó adatok.');
        }
        $stmt = $dbh->prepare("INSERT INTO rendeles (pizzanev, darab, meret, vevonev) VALUES (?, ?, ?, ?)");
        $stmt->execute(array(trim($input['pizzanev']), (int)$input['darab'], trim($input['meret']), trim($input['vevonev'])));
        echo json_encode(array('status' => 'sikeres', 'uzenet' => 'Új rendelés sikeresen létrehozva.'));
    } elseif ($method === 'PUT') {
        if (!isset($input['az'], $input['pizzanev'], $input['darab'], $input['meret'], $input['vevonev'])) {
            throw new Exception('Hiányzó adatok a módosításhoz.');
        }
        $stmt = $dbh->prepare("UPDATE rendeles SET pizzanev = ?, darab = ?, meret = ?, vevonev = ? WHERE az = ?");
        $stmt->execute(array(trim($input['pizzanev']), (int)$input['darab'], trim($input['meret']), trim($input['vevonev']), (int)$input['az']));
        echo json_encode(array('status' => 'sikeres', 'uzenet' => 'Rendelés sikeresen módosítva.'));
    } elseif ($method === 'DELETE') {
        if (!isset($input['az'])) {
            throw new Exception('Hiányzó azonosító a törléshez.');
        }
        $stmt = $dbh->prepare("DELETE FROM rendeles WHERE az = ?");
        $stmt->execute(array((int)$input['az']));
        echo json_encode(array('status' => 'sikeres', 'uzenet' => 'Rendelés sikeresen törölve.'));
    } else {
        http_response_code(405);
        echo json_encode(array('status' => 'hiba', 'uzenet' => 'Nem engedélyezett metódus.'));
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(array('status' => 'hiba', 'uzenet' => $e->getMessage()));
}
?>