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
                                <div class="profile__history-box font-rajdhani">
                                    <table style="width:100%" cellspacing="0" cellpadding="0">
                                        <tr class="profile__history-box--row profile__history-box--title">
                                            <th style="width: 60%;">Action</th>
                                            <th style="width: 40%;">Time</th> 
                                        </tr>
                                        <!-- data -->
                                    </table>
                                </div>
                           </div>
                       </div>
                   </div>
               </div>
               <script type="module" src="./assets/js/history.js"></script>
           </div>
       </div>
   </div>
</body>
</html>