<?php
    include_once 'view/my-account/layout/header.php';
?>  
    <div class="main">
        <div class="grid wide">
            <div class="row" style="justify-content: center;">
                <div class="l-8 m-10 c-12">
                    <!-- Search -->
                    <div class="top__search__box border-radius-smooth ground-color-white mrg-top-40 box-shadow-6">
                        <div class="search__box">
                            <input class="search__input" type="text" placeholder="Tìm kiếm người quen ...">
                            <a id="search__url" href="">
                                <i class="fas fa-search"></i>
                            </a>
                        </div>
                    </div>
                    <div id="search__area">
                        <!-- User -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Go to top -->
    <div class="teleport__top">
        <a href="#top">
            <i class="fas fa-angle-up"></i>
        </a>
    </div>
    <!-- footer -->
    <footer class="footer">
        <div class="grid wide">
            <div class="row">
                <div class="footer__contact">
                    <div class="social__contact">
                        <label>Mạng xã hội</label>
                        <a href="">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                    <div class="copyright">
                        Một sản phẩm của Pê tê bóc
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
    <script type="module" src="./assets/js/search.js"></script>
    <script type="module" src="./assets/js/autoUpdateSearchKey.js"></script>
</body>
</html>