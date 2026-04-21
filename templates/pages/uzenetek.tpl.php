<h2>Beérkezett üzenetek</h2>
<p>Az alábbi táblázatban a legfrissebb üzenetek láthatók.</p>

<?php if (isset($hibauzenet)): ?>
    <p style="color: red;"><?= $hibauzenet ?></p>
<?php endif; ?>

<?php if (count($uzenetek) > 0): ?>
    <table class="message-table">
        <thead>
            <tr>
                <th>Küldő neve</th>
                <th>E-mail</th>
                <th>Tárgy</th>
                <th>Üzenet</th>
                <th>Küldés ideje</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($uzenetek as $u): ?>
                <tr>
                    <td><?= htmlspecialchars($u['nev']) ?></td>
                    <td><?= htmlspecialchars($u['email']) ?></td>
                    <td><?= htmlspecialchars($u['targy']) ?></td>
                    <td><?= nl2br(htmlspecialchars($u['uzenet'])) ?></td>
                    <td><?= htmlspecialchars($u['datum']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Még nem érkezett üzenet.</p>
<?php endif; ?>
