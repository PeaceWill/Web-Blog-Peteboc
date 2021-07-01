<?php
    include_once 'lib/session.php';
    if (!Session::checkSession('user')) {
        header('location: index.php');
    }
    include_once 'view/my-account/layout/header.php';
    include_once 'view/my-account/layout/sidebar.php';
?>
               <!-- info -->
               <div class="row l-9 m-9 c-9">
                   <div class="l-12 m-12 c-12">
                       <div class="pad-30">
                           <form class="form__profile" method="GET" action="">
                                <div class="form__profile-heading font-rajdhani">
                                    <h3>Tạo token</h3>
                                </div>
                                <div class="form__profile-group">
                                    <div class="flex-row flex-align" style="width: 100%;">
                                        <input class="form__profile-input" type="text">
                                        <span class="copy__token">
                                            <i class="far fa-copy"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="form__profile-group">
                                    <button class="submit-button--smooth">Tạo mã</button>
                                </div>
                           </form>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </div>
</body>
</html>