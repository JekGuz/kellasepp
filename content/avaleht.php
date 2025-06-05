<?php
if (isset($_SESSION['kasutaja'])):
    ?>
    <section>
        <?php if (isAdmin()): ?>
            <div id="avaleht">
                <h2>Tere tulemast, <?= htmlspecialchars($_SESSION['kasutaja']) ?>!</h2>
                <p>
                    Olete jõudnud <strong>kellassepa sisekeskkonda</strong>, kus saate mugavalt hallata tellimusi, teenuseid ja klientide andmeid.
                </p>

                <p><strong>Veebikeskkonnas saate:</strong></p>

                <ul>
                    <li>📋 vaadata ja lisada tellimusi</li>
                    <li>🔧 hallata teenuseid ja hindu</li>
                    <li>👤 hallata klientide andmeid</li>
                    <li>🕒 jälgida tööde ajalugu ja staatust</li>
                </ul>

                <p>
                    Kui vajate abi, pöörduge administraatori poole või kasutage tugilehte.
                    <br>
                    <em>Täname, et kasutate meie süsteemi! Soovime teile täpset ja meeldivat tööaega</em>
                </p>
            </div>
        <?php else: ?>
            <div id="avaleht">
                <h2>Tere tulemast, <?= htmlspecialchars($_SESSION['kasutaja']) ?>!</h2>
                <p>
                    Tere tulemast <strong>kellassepa sisekeskkonda</strong>!
                    Sul on juurdepääs tellimuste vaatamiseks ning klienditeabe jälgimiseks.
                </p>

                <p><strong>Veebikeskkonnas saad:</strong></p>

                <ul>
                    <li>📋 vaadata oma tellimuste nimekirja</li>
                    <li>👤 kontrollida oma kontaktandmeid</li>
                    <li>🕒 jälgida tööde edenemist ja staatust</li>
                </ul>

                <p>
                    Kui soovid midagi muuta või vajad abi, pöördu administraatori poole.
                    <br>
                    <em>Aitäh, et kasutad meie süsteemi! Soovime sulle head ja täpset päeva</em>
                </p>
            </div>
        <?php endif; ?>
    </section>
<?php endif; ?>