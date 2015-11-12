<?php
include 'tmpl/top.php';
?>
<!-- Page Content -->
    <div id="page-content">
        <!-- Breadcrumb -->
        <div class="container">
            <ol class="breadcrumb">
                <li><a href="#">Главная</a></li>
                <li class="active">Авторизация</li>
            </ol>
        </div>
        <!-- end Breadcrumb -->

        <div class="container">
            <header><h1>Авторизация</h1></header>
            <div class="row">
                <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">
                    <form role="form" id="form-create-account" method="post" >
                        <div class="form-group">
                            <label for="form-create-account-email">Email:</label>
                            <input type="email" class="form-control" id="form-create-account-email" required>
                        </div><!-- /.form-group -->
                        <div class="form-group">
                            <label for="form-create-account-password">Пароль:</label>
                            <input type="password" class="form-control" id="form-create-account-password" required>
                        </div><!-- /.form-group -->
                        <div class="form-group clearfix">
                            <button type="submit" class="btn pull-right btn-default" id="account-submit">Войти в личный кабинет</button>
                        </div><!-- /.form-group -->
                    </form>
                    <hr>
                    <div class="center"><a href="#">Сбросить пароль</a></div>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container -->
    </div>
    <!-- end Page Content -->
<?php
include 'tmpl/minifooter.php';
?>