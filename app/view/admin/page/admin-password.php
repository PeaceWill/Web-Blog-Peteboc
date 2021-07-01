                <div class="content__wrapper mrg-top-40">
                    <div class="row no-gutters font-rajdhani">
                        <div class="l-10 m-10 c-12">
                            <div class="box__half pad-30">
                                <div class="box__heading font-28">
                                    Change password
                                </div>
                                <form id="form__admin-pw" class="form__info" method="POST" action="">
                                    <div class="form__group">
                                        <label class="form__label">Mật khẩu hiện tại</label>
                                        <input class="form__input" type="password" name="current__pw">
                                    </div>
                                    <div class="form__group">
                                        <label class="form__label">Mật khẩu mới</label>
                                        <input class="form__input" type="password" name="new__pw">
                                    </div>
                                    <div class="form__group">
                                        <label class="form__label">Nhập lại mật khẩu</label>
                                        <input class="form__input" type="password" name="re-new__pw">
                                    </div>
                                    <input type="hidden" name="action" value="change-password">
                                    <button id="submit__admin-pw" class="submit-button--smooth mrg-top-40">Cập nhập</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        updatePassword();
    </script>
</body>
</html>