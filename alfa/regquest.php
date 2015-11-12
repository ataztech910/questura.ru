<?php
include 'tmpl/top.php';
?>
    <!-- Page Content -->
    <div id="page-content">
        <!-- Breadcrumb -->
        <div class="container">
            <ol class="breadcrumb">
                <li><a href="#">Главная</a></li>
                <li class="active">Регистрация квеструма</li>
            </ol>
        </div>
        <!-- end Breadcrumb -->

        <div class="container">
            <header><h1>Добавление квеструма</h1></header>
            <div class="row">
                <div class="col-md-8 col-sm-12 col-md-offset-2">
                    <form role="form" id="form-create-agency" method="post" >
                        <section>
                            <div class="form-group">
                                <label for="form-create-agency-title">Название:</label>
                                <input type="text" class="form-control" id="form-create-agency-title" required>
                            </div><!-- /.form-group -->

                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <section id="address">
                                    <div class="form-group">
                                        <label for="form-create-agency-email">Email:</label>
                                        <input type="email" class="form-control" id="form-create-agency-email" required>
                                    </div><!-- /.form-group -->
                                </section><!-- /#address -->
                            </div><!-- /.col-md-6 -->
                            <div class="col-md-6 col-sm-6">
                                <section id="contacts">
                                    <div class="form-group">
                                        <label for="form-create-agency-phone">Телефон:</label>
                                        <input type="tel" class="form-control" id="form-create-agency-phone">
                                    </div><!-- /.form-group -->
                                </section><!-- /#address -->
                            </div><!-- /.col-md-6 -->
                        </div><!-- /.row -->
                        <section id="select-package">
                            <header><h3>Выберите вариант размещения на портале<i class="fa fa-question-circle tool-tip"  data-toggle="tooltip" data-placement="right" title="Возможно изменить в личном кабинете в любое время"></i></h3></header>
                            <div class="table-responsive submit-pricing">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Программа Questura</th>
                                        <th class="title">Не учавствую</th>
                                        <th class="title">Учавствую</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class="prices">
                                        <td>Стоимость клиента<i class="fa fa-question-circle tool-tip"  data-toggle="tooltip" data-placement="right" title="Участники программы Questura оплачивают по 300 рублей за клиента. 
                                        Сделка по клиенту считается состоявшейся, после подтверждения в личном кабинете "></i></td>
                                        <td>0</td>
                                        <td>300 рублей</td>
                                    </tr>

                                    <tr>
                                        <td>Отзывы<i class="fa fa-question-circle tool-tip"  data-toggle="tooltip" data-placement="right" title="Посетители могут оставить отзыв, только о тех квестах, в которых они действительно были. 
                                        Учет данного момента доступен только участникам программы Questura"></i></td>
                                        <td class="not-available"><i class="fa fa-times"></i></td>
                                        <td class="available"><i class="fa fa-check"></i></td>

                                    </tr>
                                    <tr>
                                        <td>Рейтинг<i class="fa fa-question-circle tool-tip"  data-toggle="tooltip" data-placement="right" title="Влияент на позиции квеста в списке - Лучшие квесты"></i></td>
                                        <td class="not-available"><i class="fa fa-times"></i></td>
                                        <td class="available"><i class="fa fa-check"></i></td>

                                    </tr>
                                    <tr>
                                        <td>Учет посещений<i class="fa fa-question-circle tool-tip"  data-toggle="tooltip" data-placement="right" title="Ведется для построения списка - Популярные квесты "></i></td>
                                        <td class="not-available"><i class="fa fa-times"></i></td>
                                        <td class="available"><i class="fa fa-check"></i></td>

                                    </tr>
                                    <tr>
                                        <td>Квест года<i class="fa fa-question-circle tool-tip"  data-toggle="tooltip" data-placement="right" title="Ежегодная премия, две номинации: Лучший и Популярный"></i></td>
                                        <td class="not-available"><i class="fa fa-times"></i></td>
                                        <td class="available"><i class="fa fa-check"></i></td>

                                    </tr>
                                    
                                    <tr class="buttons">
                                        <td></td>
                                        <td class="package-selected" data-package="free"><button type="button" class="btn btn-default small">Выбрать</button></td>
                                        <td data-package="silver"><button type="button" class="btn btn-default small">Выбрать</button></td>

                                    </tr>
                                    </tbody>
                                </table>
                            </div><!-- /.submit-pricing -->
                        </section><!-- /#select-package -->
                        <section id="submit">
                            <div class="form-group center">
                                <button type="submit" class="btn btn-default large" id="account-submit">Добавить квеструм</button>
                            </div><!-- /.form-group -->
                        </section>
                    </form>
                    <hr>
                    <section class="center">
                        <figure class="note">Нажимая кнопку “Добавить квеструм”, Вы соглашаетесь с нашими <a href="#">правилами</a></figure>
                    </section>
                </div><!-- /.col-md-8 -->
            </div><!-- /.row -->
        </div><!-- /.container -->
    </div>
    <!-- end Page Content -->

<?php
include 'tmpl/minifooter.php';
?>