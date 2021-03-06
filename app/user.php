<?php
    include_once 'view/my-account/layout/header.php';
?>
    <div class="white__background__wrap">
        <div class="grid wide">
            <div class="row" style="justify-content: center">
                <div class="l-8 m-10 c-12 user__info__wrap">
                    
                </div>
            </div>
        </div>
    </div>
    <script src='./assets/js/modal.js'></script>
    <script type="module" src="./assets/js/homepage.js"></script>
    <div class="main">
        <div class="grid wide">
            <div class="row" style="justify-content: center;">
                <div class="l-8 m-10 c-12" id="post__area">
                    <!-- Post -->
                    <!-- Share post -->
                    <!-- <div class="post__box post__shared border-radius-smooth ground-color-white box-shadow-6">
                        <div class="post__box-body">
                            <div class="post__heading">
                                <figure class="">
                                    <img class="post__avatar circle-avatar circle-avatar" src="./assets/img/avatar/186608.jpg" alt="">
                                </figure>
                                <div class="flex-col pad-left-12 flex-growth-2">
                                    <span class="font-verdana--geneva post__owner">Hưng Nguyễn</span>
                                    <div style="display: flex;">
                                        <span class="post__time">2021-06-20 11:30:26</span>
                                        <span class="post__mode">
                                            <i class="fas fa-unlock-alt"></i>
                                        </span>
                                    </div>
                                </div>
                                <span class="post__setting">
                                    <i class="fas fa-ellipsis-h"></i>
                                </span>
                            </div>
                            <div class="post__content">
                                <p>Đây là 1 post test để xây dựng UI Đây là 1 post test để xây dựng UI Đây là 1 post test để xây dựng UI Đây là 1 post test để xây dựng UI Đây là 1 post test để xây dựng UI</p>
                            </div>
                        </div>
                        <div class="post__box-image">
                            <img src="./assets/img/post/pixel-slide1.jpg" alt="">
                        </div>
                        <div class="content__shared">
                            <div class="content__shared-heading">
                                <a href="">
                                    <span class="post__shared-username">gaughegom</span>
                                </a>
                                <span class="post__shared-time">2021 06 13</span>
                            </div>
                            <div class="content__shared-body">
                                Đây là nội dung để test UI share 1 post  Đây là nội dung để test UI share 1 post  Đây là nội dung để test UI share 1 post  Đây là nội dung để test UI share 1 post
                            </div>
                        </div>
                        <div class="post__footer">
                            <span class="post__activity border-radius-smooth" id="post__comment-activity">
                                <i class="far fa-comment"></i>
                                Bình luận
                            </span>
                            <span class="post__activity border-radius-smooth" id="post__share-activity">
                                <i class="fas fa-share-square"></i>
                                Chia sẻ
                            </span>
                        </div>
                        <div class="post__comment-area">
                            <div class="post__user__comment">
                                <img class="post__avatar circle-avatar circle-avatar post__user__comment-avatar" src="./assets/img/avatar/186608.jpg" alt="">
                                <div class="post__user__comment-body">
                                    <span class="font-verdana--geneva post__user__comment-name">gaughegom</span>
                                    <div class="post__user__comment-content">Đây là comment reply để test  Đây là comment reply để test Đây là comment reply để test Đây là comment reply để test</div>
                                </div>
                                <span class="post__user__comment-setting">
                                    <i class="fas fa-ellipsis-h"></i>
                                </span>
                            </div>
                            <div class="post__user__comment">
                                <img class="post__avatar circle-avatar post__user__comment-avatar" src="./assets/img/avatar/186608.jpg" alt="">
                                <div class="post__user__comment-body">
                                    <span class="font-verdana--geneva post__user__comment-name">gaughegom</span>
                                    <div class="post__user__comment-content">Đây là comment reply để test  Đây là comment reply để test Đây là comment reply để test Đây là comment reply để test</div>
                                </div>
                                <span class="post__user__comment-setting">
                                    <i class="fas fa-ellipsis-h"></i>
                                </span>
                            </div>
                            <div class="post__user__comment">
                                <img class="post__avatar circle-avatar post__user__comment-avatar" src="./assets/img/avatar/186608.jpg" alt="">
                                <div class="post__user__comment-body">
                                    <span class="font-verdana--geneva post__user__comment-name">gaughegom</span>
                                    <div class="post__user__comment-content">Đây là comment reply để test  Đây là comment reply để test Đây là comment reply để test Đây là comment reply để test</div>
                                </div>
                                <span class="post__user__comment-setting">
                                    <i class="fas fa-ellipsis-h"></i>
                                </span>
                            </div>
                            <div class="post__comment-load">
                                Xem tắt cả bình luận
                            </div>
                        </div>
                    </div> -->
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
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>">
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
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>">
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
                        <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>">
                        <textarea class="form__edit-content" id="form__edit-content"> </textarea>
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
    <script>
        closeEditPostModal();
        closeEditCommentModal();
        closeAddCommentModal();
    </script>
</body>
</html>