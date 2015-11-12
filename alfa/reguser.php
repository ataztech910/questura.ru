<?php
include 'tmpl/top.php';
?>
 <!-- Page Content -->
    <div id="page-content">
        <!-- Breadcrumb -->
        <div class="container">
            <ol class="breadcrumb">
                <li><a href="#">Главная</a></li>
                <li class="active">Регистрация</li>
            </ol>
        </div>
        <!-- end Breadcrumb -->

        <div class="container">
            <header><h1>Регистрация</h1></header>
            <div class="row">
                <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">
                        <div class="form-group">
                            <label for="form-create-account-promo">Промокод:<i class="fa fa-question-circle tool-tip"  data-toggle="tooltip" data-placement="right" title="Для получения 100 рублей на баланс, которые можно потратить на оплату прохождения квеста, введите промокод. Если у Вас нет промокода, оставте это поле пустым"></i></label>
                            <input type="text" class="form-control" id="form-create-account-promo" required>
                        </div><!-- /.form-group -->
                        <div class="form-group">
                            <label for="form-create-account-full-name">Имя:</label>
                            <input type="text" class="form-control" id="form-create-account-full-name" required>
                        </div><!-- /.form-group -->
                        <div class="form-group">
                            <label for="form-create-account-email">Email:</label>
                            <input type="email" class="form-control" id="form-create-account-email" required>
                        </div><!-- /.form-group -->
                        <div class="form-group">
                            <label for="form-create-account-phone">Телефон:</label>
                            <input type="email" class="form-control" id="form-create-account-phone" required>
                        </div><!-- /.form-group -->
                        <div class="checkbox pull-left">
                            <label>
                                <input type="checkbox" id="account-type-newsletter" name="account-newsletter">Получать новости
                            </label>
                        </div>
                        <div class="form-group clearfix">
                            <button type="submit" class="btn pull-right btn-default" id="account-submit">Зарегистрироваться</button>
                        </div><!-- /.form-group -->
                    </form>
                   
                    <div class="center">
                        <figure class="note">Нажимая кнопку “Зарегистрироваться”, Вы соглашаетесь с нашими <a href="#">правилами</a></figure>
                    </div>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container -->
    </div>
    <!-- end Page Content -->
<?php
include 'tmpl/minifooter.php';
?>