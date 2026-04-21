document.addEventListener("DOMContentLoaded", function() {
    let urlap = document.getElementById('contact-form-data');

    if (urlap) {
        urlap.addEventListener('submit', function(event) {
            let hibak = [];

            let dnev = document.getElementById('nev').value.trim();
            let demail = document.getElementById('email').value.trim();
            let dtargy = document.getElementById('targy').value.trim();
            let duzenet = document.getElementById('uzenet').value.trim();

            if (dnev === '') {
                hibak.push("A név megadása kötelező.");
            }

            if (demail === '') {
                hibak.push("Az e-mail cím megadása kötelező.");
            } else {
                let emailMinta = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailMinta.test(demail)) {
                    hibak.push("Adj meg egy érvényes e-mail címet.");
                }
            }

            if (dtargy === '') hibak.push("A tárgy megadása kötelező.");
            if (duzenet === '') hibak.push("Az üzenet megadása kötelező.");

            if (hibak.length > 0) {
                event.preventDefault();
                document.getElementById('js-hibak').innerHTML = hibak.join('<br>');
            } else {
                document.getElementById('js-hibak').innerHTML = '';
            }
        });
    }
});
