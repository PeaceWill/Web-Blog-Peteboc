                
                <div class="content__wrapper mrg-top-40">
                    <div class="row no-gutters">
                        <div class="l-12 m-12 c-12 pad-30 ">
                            <div class="box pad-30">
                                <div class="box__heading font-rajdhani">
                                    Nội dung giới thiệu
                                </div>
                                <textarea id="editor"></textarea>
                                <button id="submit__intro" class="submit-button--smooth mrg-top-40">Cập nhập</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        tinymce.init({
            selector: '#editor',
            width: '1000px',
            height: '500px'
        });
        updateIntroduction();
    </script>
</body>
</html>