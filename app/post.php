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
                        <div class="post__box border-radius-smooth ground-color-white box-shadow-6">
                            <div class="post__box-body">
                                <div class="post__heading">
                                    <div class="flex-col pad-left-12 flex-growth-2">
                                        <span class="font-verdana--geneva post__owner"><?php echo Session::get('display') ?></span>
                                        <span class="edit__mode">
                                            <i id="mode-selected" class="fas fa-users"></i>
                                            <ul class="mode-list box-shadow-6 font-rajdhani">
                                                <li id="mode-private" class="mode-select">Private</li>
                                                <li id="mode-public" class="mode-select">Public</li>
                                            </ul>
                                        </span>
                                    </div>
                                </div>
                                <div class="post__content">
                                    <textarea class="post__textarea" name="content" class="" cols="30" rows="8" placeholder="Bạn muốn đăng gì ..."></textarea>
                                </div>
                            </div>
                            <div class="post__box-image">
                                <img id="post__image" src="" alt="">
                            </div>
                            <div class="post__footer">
                                <span class="post__activity border-radius-smooth" id="upload__post" style="width: 45%;">
                                    <i class="fas fa-paint-brush pad-right-10 "></i>
                                    Đăng tải
                                </span>
                                <label class="button__upload-image" for="upload__image-post" style="width: 45%; text-align: center">
                                    <i class="fas fa-image pad-right-10 "></i>
                                    Upload image
                                </label>
                                <input type="file" id="upload__image-post" style="display: none">
                            </div>
                        </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </div>
   <script type="module" src="./assets/js/up-post.js"></script>
   <script>
       selectMode();
   </script>
</body>
</html>