<h2>Fetch API CRUD - Rendelések kezelése</h2>

<div id="uzenet"></div>

<form id="rendelesForm" class="crud-form">
    <div style="display: none;">
        <label>Azonosító:</label><br>
        <input type="number" id="az" readonly>
    </div>

    <div>
        <label>Pizza neve:</label><br>
        <input type="text" id="pizzanev" required>
    </div>

    <div>
        <label>Darab:</label><br>
        <input type="number" id="darab" min="1" required>
    </div>

    <div>
        <label>Méret:</label><br>
        <select id="meret" required>
            <option value="apród">apród</option>
            <option value="főnemes">főnemes</option>
            <option value="lovag">lovag</option>
            <option value="király">király</option>
        </select>
    </div>

    <div>
        <label>Vevő neve:</label><br>
        <input type="text" id="vevonev" required>
    </div>
    <br>
    <button type="submit" id="mentesGomb">Mentés</button>
    <button type="button" onclick="formTorles()">Mégse</button>
</form>

<table class="crud-table">
    <thead>
        <tr>
            <th>Azonosító</th>
            <th>Pizza neve</th>
            <th>Darab</th>
            <th>Méret</th>
            <th>Vevő neve</th>
            <th>Műveletek</th>
        </tr>
    </thead>
    <tbody id="rendelesTablaBody"></tbody>
</table>
