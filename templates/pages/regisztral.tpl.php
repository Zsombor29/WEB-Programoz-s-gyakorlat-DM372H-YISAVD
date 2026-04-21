<?php if(isset($uzenet)) { ?>
    <h1><?= $uzenet ?></h1>
    <?php if($ujra) { ?>
        <a href="belepes">Próbáld újra!</a>
    <?php } else { ?>
        <p><a href="belepes">Tovább a belépéshez</a></p>
    <?php } ?>
<?php } ?>
