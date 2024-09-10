<style>
    nav{
        display:flex;
        justify-content:space-evenly;
        align-items: center;
        padding: 20px;
        background-color: #4158A6;
    }
    .navbar{
        display:flex;
        gap: 20px;
    }
    .navbar>li{
        list-style-type: none;
    }
    li>a{
        text-decoration: none;
        color:black;
        color:#fff;
    }
    .logo>a>img{
        width: 40px;
    }
</style>

<nav>
    <div class="logo">
        <a href="https://rohitdangol.com/">
            <img src="https://i0.wp.com/rohitdangol.com/wp-content/uploads/2024/05/Asset-1.png?fit=1241%2C1241&ssl=1" alt="Logo">
        </a>
    </div>
    <ul class="navbar">

    <?php if (isset($_SESSION['username'])): ?>
        <li><a href="../auth/home.php">Home</a></li>
            <li><a href="../auth/dashboard.php">Dashboard</a></li>
            <li><a href="../auth/gallery.php">Gallery</a></li>
            <li><a href="../process/logout.php">Logout</a></li>
            
        <?php else: ?>
            <li><a href="./">Home</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="./">Login / Sign Up</a></li>
        <?php endif; ?>

        
        
       

    </ul>

</nav>