                <div class="content__wrapper mrg-top-40">
                    <div class="row no-gutters font-rajdhani">
                        <!-- Stretch card -->
                        <div class="l-3 m-6 c-6">
                            <div class="stretch__card">
                                <div id="user__count" class="stretch__card-heading">
                                    Tài khoản
                                </div>
                                <div id="number__user" class="stretch__card-body">
                                    80
                                </div>
                            </div>
                        </div>
                        <div class="l-3 m-6 c-6">
                            <div class="stretch__card">
                                <div id="onl__count" class="stretch__card-heading">
                                    Online
                                </div>
                                <div id="number__online" class="stretch__card-body">
                                    3
                                </div>
                            </div>
                        </div>
                        <div class="l-3 m-6 c-6">
                            <div class="stretch__card">
                                <div id="log__count" class="stretch__card-heading">
                                    Truy cập
                                </div>
                                <div id="number__log" class="stretch__card-body">
                                    50
                                </div>
                            </div>
                        </div>
                        <div class="l-3 m-6 c-6">
                            <div class="stretch__card">
                                <div id="post__count" class="stretch__card-heading">
                                    Lượt post
                                </div>
                                <div id="number__post" class="stretch__card-body">
                                    10
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row no-gutters font-rajdhani mrg-top-80">
                        <!-- Client log -->
                        <div class="l-6 m-12 c-12">
                            <div class="box__half pad-30">
                                <div class="box__heading">
                                    Client log
                                </div>
                                <div class="box__content">
                                    <ul class="row no-gutters table__log">
                                        <li class="l-2 m-2 c-2 table__log-col">
                                            Id
                                        </li>
                                        <li class="l-6 m-6 c-6 table__log-col">
                                            Username
                                        </li>
                                        <li class="l-4 m-4 c-4 table__log-col">
                                            Time
                                        </li>
                                    </ul>
                                    <ul class="row no-gutters table__log__item">
                                        <li class="l-2 m-2 c-2 tabl__log__cell">
                                            1
                                        </li>
                                        <li class="l-6 m-6 c-6 tabl__log__cell">
                                            <a class="log__thumb" href="">
                                                <img class="circle-avatar log__avatar" src="../../assets/img/avatar/186608.jpg" alt="">
                                                <span class="log__username">Gaughegom</span>
                                            </a>
                                        </li>
                                        <li class="l-4 m-4 c-4 tabl__log__cell">
                                            2021-06-22 10:09:30
                                        </li>
                                    </ul>
                                    <ul class="row no-gutters table__log__item">
                                        <li class="l-2 m-2 c-2 tabl__log__cell">
                                            2
                                        </li>
                                        <li class="l-6 m-6 c-6 tabl__log__cell">
                                            <a class="log__thumb" href="">
                                                <img class="circle-avatar log__avatar" src="../../assets/img/avatar/186608.jpg" alt="">
                                                <span class="log__username">Gaughegom</span>
                                            </a>
                                        </li>
                                        <li class="l-4 m-4 c-4 tabl__log__cell">
                                            2021-06-22 10:09:30
                                        </li>
                                    </ul>
                                    <ul class="row no-gutters table__log__item">
                                        <li class="l-2 m-2 c-2 tabl__log__cell">
                                            3
                                        </li>
                                        <li class="l-6 m-6 c-6 tabl__log__cell">
                                            <a class="log__thumb" href="">
                                                <img class="circle-avatar log__avatar" src="../../assets/img/avatar/186608.jpg" alt="">
                                                <span class="log__username">Gaughegom</span>
                                            </a>
                                        </li>
                                        <li class="l-4 m-4 c-4 tabl__log__cell">
                                            2021-06-22 10:09:30
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- Line chart -->
                        <div class="l-6 m-12 c-12">
                            <div class="box__half pad-30">
                                <div class="box__heading">
                                    <canvas id="line__chart-user"></canvas> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        LineChart();
        createDashboard();
    </script>
</body>
</html>