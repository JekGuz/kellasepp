<nav>
    <ul class="menu">
        <li>
            <a href="?leht=avaleht.php">Avaleht</a>
        </li>
        <li>
            <a href="?leht=table.php">Tellimused</a>
        </li>
        <li>
            <a href="?leht=inputADD.php">Lisamisvorm</a>
        </li>
        <!--<li>
            <a href="?leht=sort.php">SORT/OTSING</a>
        </li> -->

        <li>
            <form action="logout.php" method="post">
                <a id="kasutaja"><?= htmlspecialchars($_SESSION['kasutaja']) ?>
                <img src="content/use.png" alt="user" width="20">
                <button type="submit" name="logout" style="background: none; border: none; cursor: pointer;">
                    <img src="content/uks.png" alt="Logi välja" width="20"">
                </button><a>
                <?php
                if (isset($_SESSION['kasutaja'])) {
                ?>
            </form>
        </li>
    </ul>
</nav>
<?php
}
?>