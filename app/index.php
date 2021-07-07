
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
                            <a id="search__url" href="search.php">
                                <i class="fas fa-search"></i>
                            </a>
                        </div>
                    </div>
                    <div id="post__area">
                        <!-- Post -->
  
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal edit comment -->
    <div class="edit__comment-frame">
        <div class="modal__overlay">
            <div style="background-color: #fff; margin: auto; position: relative; border-radius: 5px; width: 60%; margin-top: 25%;">
                <div action="" method="POST" class="form__comment">
                    <div class="form__heading font-rajdhani">
                        Edit comment
                        <span id="close__edit-comment" class="close__edit">
                            <i class="fas fa-times"></i>
                        </span>
                    </div>
                    <textarea name="edit__comment" id="edit__comment-input" cols="30" rows="3"></textarea>
                    <button id="edit__comment">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Add comment -->
    <div class="add__comment-frame">
        <div class="modal__overlay">
            <div style="background-color: #fff; margin: auto; position: relative; border-radius: 5px; width: 60%; margin-top: 25%;">
                <div action="" method="POST" class="form__comment">
                    <div class="form__heading font-rajdhani">
                        Comment
                        <span id="close__add-comment" class="close__edit">
                            <i class="fas fa-times"></i>
                        </span>
                    </div>
                    <textarea name="add__comment" id="add__comment-input" cols="30" rows="3"></textarea>
                    <button id="add__comment">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal edit post -->
    <div class="edit__post-frame">
        <div class="modal__overlay">
            <div class="modal__body" style="width: 540px;">
                <div class="form__edit__post" action="" method="POST">
                    <div class="form__heading font-rajdhani">
                        Edit post
                        <span id="close__edit-post" class="close__edit">
                            <i class="fas fa-times"></i>
                        </span>
                    </div>
                    <div class="form__edit-body">
                        <div class="form__edit-body--top">
                            <img class="circle-avatar post__avatar" id="form__edit-avatar" src="" alt="">
                            <div class="flex-col pad-left-12 flex-growth-2">
                                <span class="font-verdana--geneva post__owner" id="form__edit-realname"></span>
                                <span class="edit__mode">
                                    <i id="mode-selected" class="fas fa-users"></i>                        
                                </span>
                            </div>
                        </div>
                        <textarea class="form__edit-content" id="form__edit-content" rows="4"> </textarea>
                    </div>
                    <div class="form__edit__image">
                        <img class="post__image" id="form__edit-image" src="" alt="">
                        <label class="hover-08" for="edit-post-image">Edit</label>
                        <input id="edit-post-image" type="file">
                    </div>
                    <div class="form__edit-footer">
                        <button class="edit__button">Save</button>
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
    <script type="module" src="./assets/js/post.js"></script>
    <script type="module" src="./assets/js/autoUpdateSearchKey.js"></script>
    <script>
        closeEditPostModal();
        closeEditCommentModal();
        closeAddCommentModal();
    </script>
   <?php
        include_once 'view/my-account/layout/footer.php';
   ?>

</body>
</html>