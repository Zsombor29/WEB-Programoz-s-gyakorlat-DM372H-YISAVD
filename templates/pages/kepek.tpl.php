<h2>Képgaléria</h2>
<p>Az alábbi galériában pizzáinkról és pizzériánkról készült képek láthatók.</p>

<?php
$dir = './images/upload/';
$kepek = array();

if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
            if ($file != "." && $file != "..") {
                $kepek[] = $file;
            }
        }
        closedir($dh);
    }
}
?>

<div class="gallery-container">
    <?php foreach($kepek as $kep): ?>
        <div class="gallery-item">
            <img src="images/upload/<?= htmlspecialchars($kep) ?>" alt="Pizza kép">
        </div>
    <?php endforeach; ?>
</div>

<hr>

<?php if(isset($_SESSION['login'])): ?>
    <h3>Kép feltöltése</h3>
    <form action="feltolt" method="post" enctype="multipart/form-data">
        <input type="file" name="kep" required>
        <button type="submit">Feltöltés</button>
    </form>
<?php else: ?>
    <p>Képfeltöltéshez jelentkezz be.</p>
<?php endif; ?>
