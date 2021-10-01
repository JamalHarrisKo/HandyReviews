<?php session_start();
include "Assets/header.php" ?>
<!--Content-->

<div class="content-wrapper">
<?php if(!$_SESSION['user']){ ?>
    
    <form class="registration" action="registration.php" method="post">
    <h4>Noch keinen Account:</h4>
        <div class="input-group flex-nowrap">
            <span class="input-group-text" id="name">Name:</span>
            <input type="text" name="name" class="form-control" placeholder="Name" aria-label="Name" aria-describedby="name">
        </div>
        <div class="input-group flex-nowrap">
            <span class="input-group-text" id="email">Email:</span>
            <input type="text" name="email" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="email">
        </div>
        <div class="input-group flex-nowrap">
            <span class="input-group-text" id="password">Password:</span>
            <input type="password" name="password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="password">
        </div>
        <button type="submit" name="submit" class="btn btn-register btn-primary">Registrieren</button>
    </form>
    <hr>
    
    <form class="registration" action="login.php" method="post">
        <h4>Bestehenden Login verwenden:</h4>
        <div class="input-group flex-nowrap">
            <span class="input-group-text" id="email">Email:</span>
            <input type="text" name="email" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="email">
        </div>
        <div class="input-group flex-nowrap">
            <span class="input-group-text" id="password">Password:</span>
            <input type="password" name="password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="password">
        </div>
        <button type="submit" name="submit" class="btn btn-register btn-primary">Login</button>
    </form>
</hr>
<?php } ?>
<?php if($_SESSION['user']){ ?>
 
    <form class="Logout" action="logout.php" method="post">
        <button type="submit" name="logoutbutton" class="btn btn-primary">Logout</button>
    </form>
<?php } ?>
</div>

<!--Content end-->
<?php include "Assets/footer.php" ?>