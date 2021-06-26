                <div class="content__wrapper mrg-top-40">
                    <div class="row no-gutters font-rajdhani">
                        <div class="l-10 m-10 c-12" style="margin: auto;">
                            <div class="box__half pad-30">
                                <div class="box__heading font-28">
                                    Tạo tài khoản
                                </div>
                                <form id="form__user-create" class="form__info" method="POST" action="" enctype="multipart/form-data">
                                    <div class="form__group">
                                        <label class="form__label">Tên tài khoản</label>
                                        <input class="form__input" required type="text" name="username">
                                    </div>
                                    <div class="form__group">
                                        <label class="form__label">Avatar</label>
                                        <div class="form__avatar-upload">
                                            <img class="circle-avatar form__info-avatar" src="../../assets/img/avatar/default.jpg" alt="">
                                            <div class="button__wrap">
                                                <label class="button__upload-avatar" for="upload-avatar">Upload file</label>
                                                <input type="file" id="upload-avatar" name="avatar">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form__group">
                                        <label class="form__label">Họ tên</label>
                                        <input class="form__input" required type="text" name="realname">
                                    </div>
                                    <div class="form__group">
                                        <label class="form__label">Email</label>
                                        <input class="form__input" required type="email" name="email">
                                    </div>
                                    <div class="form__group">
                                        <label class="form__label">Mật khẩu</label>
                                        <input class="form__input" required type="password" name="password">
                                    </div>
                                    <div class="form__group">
                                        <label class="form__label">Số điện thoại</label>
                                        <input class="form__input" type="number" name="phone">
                                    </div>
                                    <div class="form__group">
                                        <label class="form__label">Địa chỉ</label>
                                        <input class="form__input" type="text" name="address">
                                    </div>
                                    <div class="form__group">
                                        <label class="form__label">Giới tính</label>
                                        <div class="form__gender__selection">
                                            <div class="gender__selection-group">
                                                <input id="male-gender" class="form__input" required type="radio" name="gender" value="1">
                                                <label for="male-gender">Nam</label>
                                            </div>
                                            <div class="gender__selection-group">
                                                <input id="female-gender" class="form__input" type="radio" name="gender" value="0">
                                                <label for="female-gender">Nữ</label>
                                            </div>
                                            <div class="gender__selection-group">
                                                <input id="other-gender" class="form__input" type="radio" name="gender" value="-1">
                                                <label for="other-gender">Khác</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form__group">
                                        <label class="form__label">Mô tả</label>
                                        <textarea class="form__input" name="description" cols="30" rows="5"></textarea>
                                    </div>
                                    <div class="form__group">
                                        <label class="form__label">Level</label>
                                        <select class="form__input" name="level">
                                            <option value="0">User</option>
                                            <option value="1">Mod</option>
                                            <option value="2">Admin</option>
                                        </select>
                                    </div>
                                    <input type="hidden" name="action" value="create">
                                    <button id="submit__user-create" class="submit-button--smooth mrg-top-40">Thêm</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        createUser();
    </script>
</body>
</html>