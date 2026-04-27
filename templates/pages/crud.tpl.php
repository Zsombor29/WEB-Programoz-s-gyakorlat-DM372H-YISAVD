<h2>Fetch API CRUD - Rendelések kezelése</h2>

<div id="uzenet"></div>

<form id="rendelesForm" class="crud-form">
    <div class="form-group">
        <label>Pizza neve:</label><br>
         <select id="pizzanev" required>
            <option value="">Válassz pizzát</option>
            <option value="Áfonyás">Áfonyás</option>
            <option value="Babos">Babos</option>
            <option value="Barbecue chicken">Barbecue chicken</option>
            <option value="Betyáros">Betyáros</option>
            <option value="Caribi">Caribi</option>
            <option value="Country">Country</option>
            <option value="Csabesz">Csabesz</option>
            <option value="Csupa sajt">Csupa sajt</option>
            <option value="Erdő kapitánya">Erdő kapitánya</option>
            <option value="Erős János">Erős János</option>
            <option value="Excellent">Excellent</option>
            <option value="Főnök kedvence">Főnök kedvence</option>
            <option value="Francia">Francia</option>
            <option value="Frankfurti">Frankfurti</option>
            <option value="Füstös">Füstös</option>
            <option value="Gino">Gino</option>
            <option value="Gombás">Gombás</option>
            <option value="Góré">Góré</option>
            <option value="Görög">Görög</option>
            <option value="Gyros pizza">Gyros pizza</option>
            <option value="HamAndEggs">HamAndEggs</option>
            <option value="Hamm">Hamm</option>
            <option value="Hawaii">Hawaii</option>
            <option value="Hellas">Hellas</option>
            <option value="Hercegnő">Hercegnő</option>
            <option value="Ilike">Ilike</option>
            <option value="Ínyenc">Ínyenc</option>
            <option value="Jázmin álma">Jázmin álma</option>
            <option value="Jobbágy">Jobbágy</option>
            <option value="Juhtúrós">Juhtúrós</option>
            <option value="Kagylós">Kagylós</option>
            <option value="Kétszínű">Kétszínű</option>
            <option value="Kiadós">Kiadós</option>
            <option value="Király pizza">Király pizza</option>
            <option value="Kívánság">Kívánság</option>
            <option value="Kolbászos">Kolbászos</option>
            <option value="Lagúna">Lagúna</option>
            <option value="Lecsó">Lecsó</option>
            <option value="Maffiózó">Maffiózó</option>
            <option value="Magvas">Magvas</option>
            <option value="Magyaros">Magyaros</option>
            <option value="Máj Fair Lady">Máj Fair Lady</option>
            <option value="Mamma fia">Mamma fia</option>
            <option value="Mexikói">Mexikói</option>
            <option value="Mixi">Mixi</option>
            <option value="Nikó">Nikó</option>
            <option value="Nordic">Nordic</option>
            <option value="Nyuszó-Muszó">Nyuszó-Muszó</option>
            <option value="Pacalos">Pacalos</option>
            <option value="Pástétomos">Pástétomos</option>
            <option value="Pásztor">Pásztor</option>
            <option value="Pipis">Pipis</option>
            <option value="Popey">Popey</option>
            <option value="Quattro">Quattro</option>
            <option value="Ráki">Ráki</option>
            <option value="Rettenetes magyar">Rettenetes magyar</option>
            <option value="Röfi">Röfi</option>
            <option value="Sajtos">Sajtos</option>
            <option value="So-ku">So-ku</option>
            <option value="Son-go-ku">Son-go-ku</option>
            <option value="Sonkás">Sonkás</option>
            <option value="Spanyol">Spanyol</option>
            <option value="Spencer">Spencer</option>
            <option value="Szalámis">Szalámis</option>
            <option value="Szardíniás">Szardíniás</option>
            <option value="Szerzetes">Szerzetes</option>
            <option value="Szőke kapitány">Szőke kapitány</option>
            <option value="Tenger gyümölcsei">Tenger gyümölcsei</option>
            <option value="Tonhalas">Tonhalas</option>
            <option value="Törperős">Törperős</option>
            <option value="Tündi kedvence">Tündi kedvence</option>
            <option value="Tüzes halál">Tüzes halál</option>
            <option value="Vega">Vega</option>
            <option value="Zöldike">Zöldike</option>
        </select>
    </div>

    <div class="form-group">
        <label>Mennyiség:</label><br>
        <input type="number" id="darab" min="1" required>
    </div>

    <div class="form-buttons">
        <button type="submit" id="mentesGomb">Mentés</button>
        <button type="button" onclick="formTorles()">Mégse</button>
    </div>
</form>

<table class="crud-table" style="width:100%; border-collapse:collapse; table-layout:fixed;">
    <thead>
        <tr>
            <th style="padding:10px;">Pizza neve</th>
            <th style="padding:10px;">Mennyiség</th>
            <th style="padding:10px;">Rendelés ideje</th>
            <th style="padding:10px;">Kiszállítás ideje</th>
            <th style="padding:10px;">Műveletek</th>
        </tr>
    </thead>
    <tbody id="rendelesTablaBody"></tbody>
</table>