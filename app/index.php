
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
                            <input class="search__input" type="text" placeholder="Tìm kiếm">
                            <a href="">
                                <i class="fas fa-search"></i>
                            </a>
                        </div>
                    </div>
                    <div id="post__area">

                        <!-- Post -->
                        <!-- <div class="post__box border-radius-smooth ground-color-white box-shadow-6">
                            <div class="post__box-body">
                                <div class="post__heading">
                                    <figure class="">
                                        <img class="post__avatar circle-avatar" src="./assets/img/avatar/186608.jpg" alt="">
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
                                        <ul class="post__setting-list box-shadow-6 font-rajdhani">
                                            <li id="post__setting-edit" class="post__setting-select">Edit</li>
                                            <li id="post__setting-report" class="post__setting-select">Report</li>
                                            <li id="post__setting-remove" class="post__setting-select">Remove</li>
                                        </ul>
                                    </span>
                                </div>
                                <div class="post__content">
                                    <p>Đây là 1 post test để xây dựng UI Đây là 1 post test để xây dựng UI Đây là 1 post test để xây dựng UI Đây là 1 post test để xây dựng UI Đây là 1 post test để xây dựng UI</p>
                                </div>
                            </div>
                            <div class="post__box-image">
                                <img src="./assets/img/post/pixel-slide1.jpg" alt="">
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
                                    <img class="post__avatar circle-avatar post__user__comment-avatar" src="./assets/img/avatar/186608.jpg" alt="">
                                    <div class="post__user__comment-body">
                                        <div>
                                            <span class="font-verdana--geneva post__user__comment-name">gaughegom</span>
                                            <span class="post__user__comment-time">2021-5-7</span>
                                        </div>
                                        <div class="post__user__comment-content">Đây là comment reply để test  Đây là comment reply để test Đây là comment reply để test Đây là comment reply để test</div>
                                    </div>
                                    <span class="post__user__comment-setting">
                                        <i class="fas fa-ellipsis-h"></i>
                                        <ul class="post__user__comment-setting-list box-shadow-6 font-rajdhani">
                                            <li class="post__user__comment-setting-select comment__edit">Edit</li>
                                            <li class="post__user__comment-setting-select commetn__remove">Remove</li>
                                        </ul>
                                    </span>
                                </div>
                                <div class="post__user__comment">
                                    <img class="post__avatar circle-avatar post__user__comment-avatar" src="./assets/img/avatar/186608.jpg" alt="">
                                    <div class="post__user__comment-body">
                                        <div>
                                            <span class="font-verdana--geneva post__user__comment-name">gaughegom</span>
                                            <span class="post__user__comment-time">2021-5-7</span>
                                        </div>
                                        <div class="post__user__comment-content">Đây là comment reply để test  Đây là comment reply để test Đây là comment reply để test Đây là comment reply để test</div>
                                    </div>
                                    <span class="post__user__comment-setting">
                                        <i class="fas fa-ellipsis-h"></i>
                                        <ul class="post__user__comment-setting-list box-shadow-6 font-rajdhani">
                                            <li class="post__user__comment-setting-select comment__edit">Edit</li>
                                            <li class="post__user__comment-setting-select commetn__remove">Remove</li>
                                        </ul>
                                    </span>
                                </div>
                                
                                <div class="post__comment-load">
                                    Xem tất cả bình luận
                                </div>
                            </div>
                        </div> -->
    
                        <!-- Post share-->
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
                                        <ul class="post__setting-list box-shadow-6 font-rajdhani">
                                            <li id="post__setting-edit" class="post__setting-select">Edit</li>
                                            <li id="post__setting-report" class="post__setting-select">Report</li>
                                            <li id="post__setting-remove" class="post__setting-select">Remove</li>
                                        </ul>
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
                                    <img class="post__avatar circle-avatar post__user__comment-avatar" src="./assets/img/avatar/186608.jpg" alt="">
                                    <div class="post__user__comment-body">
                                        <span class="font-verdana--geneva post__user__comment-name">gaughegom</span>
                                        <div class="post__user__comment-content">Đây là comment reply để test  Đây là comment reply để test Đây là comment reply để test Đây là comment reply để test</div>
                                    </div>
                                    <span class="post__user__comment-setting">
                                        <i class="fas fa-ellipsis-h"></i>
                                        <ul class="post__user__comment-setting-list box-shadow-6 font-rajdhani">
                                            <li class="post__user__comment-setting-select comment__edit">Edit</li>
                                            <li class="post__user__comment-setting-select commetn__remove">Remove</li>
                                        </ul>
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
                                        <ul class="post__user__comment-setting-list box-shadow-6 font-rajdhani">
                                            <li class="post__user__comment-setting-select comment__edit">Edit</li>
                                            <li class="post__user__comment-setting-select commetn__remove">Remove</li>
                                        </ul>
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
                                        <ul class="post__user__comment-setting-list box-shadow-6 font-rajdhani">
                                            <li class="post__user__comment-setting-select comment__edit">Edit</li>
                                            <li class="post__user__comment-setting-select commetn__remove">Remove</li>
                                        </ul>
                                    </span>
                                </div>
                                <div class="post__comment-load">
                                    Xem tất cả bình luận
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal edit comment -->
    <div class="edit__comment-frame">
        <div class="modal__overlay">
            <div style="background-color: #fff; margin: auto; position: relative; border-radius: 5px; width: 60%; margin-top: 25%;">
                <form action="" method="POST" class="form__comment">
                    <div class="form__heading font-rajdhani">
                        Edit comment
                        <span id="close__edit-comment" class="close__edit">
                            <i class="fas fa-times"></i>
                        </span>
                    </div>
                    <textarea name="edit__comment" id="edit__comment-input" cols="30" rows="3"></textarea>
                    <button>Save</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Add comment -->
    <div class="add__comment-frame">
        <div class="modal__overlay">
            <div style="background-color: #fff; margin: auto; position: relative; border-radius: 5px; width: 60%; margin-top: 25%;">
                <form action="" method="POST" class="form__comment">
                    <div class="form__heading font-rajdhani">
                        Comment
                        <span id="close__add-comment" class="close__edit">
                            <i class="fas fa-times"></i>
                        </span>
                    </div>
                    <textarea name="add__comment" id="add__comment-input" cols="30" rows="3"></textarea>
                    <button>Submit</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal edit post -->
    <div class="edit__post-frame">
        <div class="modal__overlay">
            <div class="modal__body" style="width: 540px;">
                <form class="form__edit__post" action="" method="POST">
                    <div class="form__heading font-rajdhani">
                        Edit post
                        <span id="close__edit-post" class="close__edit">
                            <i class="fas fa-times"></i>
                        </span>
                    </div>
                    <div class="form__edit-body">
                        <div class="form__edit-body--top">
                            <img class="circle-avatar post__avatar" src="./assets/img/avatar/186608.jpg" alt="">
                            <div class="flex-col pad-left-12 flex-growth-2">
                                <span class="font-verdana--geneva post__owner">gaughegom</span>
                                <span class="edit__mode">
                                    <i id="mode-selected" class="fas fa-unlock-alt"></i>
                                    <!-- <i class="fas fa-users" style="display: none;"></i> -->
                                    <ul class="mode-list box-shadow-6 font-rajdhani">
                                        <li id="mode-private" class="mode-select">Private</li>
                                        <li id="mode-public" class="mode-select">Public</li>
                                    </ul>
                                </span>
                            </div>
                        </div>
                        <div class="form__edit-content">
                            Test UI
                        </div>
                    </div>
                    <div class="form__edit__image">
                        <img class="post__image" src="./assets/img/post/pixel-slide1.jpg" alt="">
                        <label class="hover-08" for="edit-post-image">Edit</label>
                        <input id="edit-post-image" type="file">
                    </div>
                    <div class="form__edit-footer">
                        <button class="edit__button">Save</button>
                    </div>
                </form>
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