<?php session_start() ?>
<?php include "Assets/header.php" ?>
<!--Content-->
<h1>Handy Review Forum</h1>
<div class="content-wrapper">

    <div class="flexdiv">
        <div class="card" style="width: 18rem;">
            <img src="./Public/login.png" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Login/Registrieren</h5>
                <p class="card-text">Diese Seite benötigen ein Login, um einige Funktionen freizuschalten. Ohne Login ist lediglich das einsehen von Produkten möglich.</p>
                <a href="/register.php" class="btn btn-primary">Zum Login</a>
            </div>
        </div>
        <div class="card" style="width: 18rem;">
            <img src="./Public/newp.png" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Neue Produkte Erstellen</h5>
                <p class="card-text">Hier können neue Produkte erstellt werden, um reviewed zu werden.</p>
                <a href="/createNewProduct.php" class="btn btn-primary">Zur Erstellung</a>
            </div>
        </div>
        <div class="card" style="width: 18rem;">
            <img src="./Public/detail.png" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Reviews</h5>
                <p class="card-text">Nach dem man ein Produkt ausgewählt hat, kann man hier Reviews lesen, schreiben, bewerten und kommentieren.</p>
                <a href="/displayProduct.php" class="btn btn-primary">Zur Produktübersicht</a>
            </div>
        </div>
    </div>
    <hr>
    <form class="dbupdate" action="updateDB.php" method="post">
        <button type="submit" name="updatebutton" class="btn btn-primary">Update DB</button>
    </form>
    <hr>
    <form class="dbflush" action="flushDB.php" method="post">
        <button type="submit" name="updatebutton" class="btn btn-primary">Flush DB</button>
    </form>
</div>



<!--Content end-->
<?php include "Assets/footer.php" ?>