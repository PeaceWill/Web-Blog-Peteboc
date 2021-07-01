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
                           <div class="form__profile">
                                <div class="form__profile-heading font-rajdhani">
                                    <h3>Lịch sử hoạt động</h3>
                                </div>
                                
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </div>
</body>
</html>