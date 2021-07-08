<?php
    include_once 'lib/session.php';
    if (!Session::checkSession('user')) {
        header('location: index.php');
    }
    include_once 'view/my-account/layout/header.php';
    include_once 'view/my-account/layout/sidebar.php';
?>
   <!-- main -->
               <!-- info -->
               <div class="row l-9 m-9 c-9">
                   <div class="l-12 m-12 c-12">
                       <div class="pad-30">
                           <form id="form__update-info" class="form__profile" method="POST" action="">
                                <div class="form__profile-heading font-rajdhani">
                                    <h3>Thông tin</h3>
                                </div>
                                <div class="form__profile-group">
                                    <label class="font-rajdhani">Avatar</label>
                                    <div class="flex-row flex-align">
                                        <img id="profile__avatar" class="circle-avatar profile__avatar" src="" alt="">
                                        <div class="button__wrap">
                                            <label for="upload-avatar">Upload file</label>
                                            <input type="file" accept="image/*" id="upload-avatar" name="avatar">
                                        </div>
                                    </div>
                                </div>
                                <div class="form__profile-group">
                                    <label class="font-rajdhani">Họ tên</label>
                                    <input id="profile__realname" class="form__profile-input" type="text" name="realname">
                                </div>
                                <div class="form__profile-group">
                                    <label class="font-rajdhani">Email</label>
                                    <input id="profile__email" class="form__profile-input" type="text" name="email">
                                </div>
                                <div class="form__profile-group">
                                    <label class="font-rajdhani">Số điện thoại</label>
                                    <input id="profile__phone" class="form__profile-input" type="number" name="phone">
                                </div>
                                <div class="form__profile-group">
                                    <label class="font-rajdhani">Giới tính</label>
                                    <div class="flex-row flex-align space-around" style="width: 100%;">
                                        <div class="form__profile-gender">
                                            <label for="male-gender">Nam</label>
                                            <input type="radio" name="gender" id="male-gender" value="1">
                                        </div>
                                        <div class="form__profile-gender">
                                            <label for="male-gender">Nữ</label>
                                            <input type="radio" name="gender" id="female-gender" value="0">
                                        </div>
                                        <div class="form__profile-gender">
                                            <label for="male-gender">Khác</label>
                                            <input type="radio" name="gender" id="other" value="-1">
                                        </div>
                                    </div>
                                </div>
                                <div class="form__profile-group">
                                    <label class="font-rajdhani">Địa chỉ</label>
                                    <input id="profile__address" class="form__profile-input" type="text" name="address">
                                </div>
                                <div class="form__profile-group">
                                    <label class="font-rajdhani">Link</label>
                                    <input id="profile__link" class="form__profile-input" type="text" placeholder="your link" name="link">
                                </div>
                                <div class="form__profile-group">
                                    <label class="font-rajdhani">Mô tả</label>
                                    <textarea id="profile__description" class="form__profile-input" name="description" rows="5"></textarea>
                                </div>
                                <div class="form__profile-group">
                                    <button id="update__user-info" class="submit-button--smooth">Cập nhập</button>
                                </div>
                           </form>
                       </div>
                   </div>
                   <div class="l-12 m-12 c-12">
                        <div class="pad-30">
                            <form id="form__update-password" class="form__profile" method="POST" action="">
                                <div class="form__profile-heading font-rajdhani">
                                    <h3>Đổi mật khẩu</h3>
                                </div>
                                <div class="form__profile-group">
                                    <label class="font-rajdhani">Mật khẩu hiện tại</label>
                                    <input class="form__profile-input" type="password" name="current-pw">
                                </div>
                                <div class="form__profile-group">
                                    <label class="font-rajdhani">Nhập mật khẩu mới</label>
                                    <input class="form__profile-input" type="password" name="new-pw">
                                </div>
                                <div class="form__profile-group">
                                    <label class="font-rajdhani">Nhập lại mật khẩu</label>
                                    <input class="form__profile-input" type="password" name="comfirm-pw">
                                </div>
                                <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>">
                                <input type="hidden" name="action" value="change-password">
                                <div class="form__profile-group">
                                    <button id="update__user-password" class="submit-button--smooth">Cập nhập</button>
                                </div>
                            </form>
                        </div>
                    </div>
               </div>
           </div>
       </div>
   </div>
   <script src="./assets/js/profile.js"></script>
   <script>
       fetchData();
       updateUser();
   </script>
</body>
</html>