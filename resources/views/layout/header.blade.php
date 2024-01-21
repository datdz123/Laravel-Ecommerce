<div class="header">
    <div class="navbar">
        <div class="navbar__left">
            <a href="index.php" class="navbar__logo">
                <img src="./img/logo.jpg" alt="">
            </a>
            <div class="navbar__menu">
                <i id="bars" class="fa fa-bars" aria-hidden="true"></i>
                <ul>
                    <li><a href="index.php">Trang chủ</a></li>
                    <li><a href="index.php?page=congiong">Con giống</a></li>
                    <li>
                        <div style="opacity: 0.7; cursor: default;">Đơn hàng</div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="navbar__center">
            <form action="" method="GET" class="navbar__search">
                <input type="text" value="" placeholder="Nhập để tìm kiếm..." name="txtsearch" class="search" required>
                <i class="fa fa-search" id="searchBtn"></i>
            </form>
        </div>
        <div class="navbar__right">
            <div class="login">
                <a href="index.php?page=login"><i class="fa fa-user"></i></a>
            </div>
            <a href="index.php?page=cart" class="navbar__shoppingCart">
                <img src="./img/shopping-cart.svg" style="width: 24px;" alt="">
                <span>0</span>
            </a>
        </div>
    </div>
</div>
