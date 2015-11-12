<!-- Page Content -->
<div id="page-content" ng-app="cabinetApp">
        <!-- Breadcrumb -->
        <div class="container">
            <ol class="breadcrumb">
                <li><a href="/">Главная</a></li>
                <li class="active">Личный кабинет</li>
                <!--li class="active">Заявки</li-->
            </ol>
        </div>
<div class="container">
            <div class="row">
            <!-- sidebar -->
            <div class="col-md-3 col-sm-2">
                <section id="sidebar">
                    <header>
                      <h3>Личный кабинет</h3> 
                    </header>
                    <aside>
                        <ul class="sidebar-navigation">
                            <li class="<?echo $activeOrders;?>"><a href="<?echo $siteRoot;?>/cabinet"></i><span>Заявки</span></a></li>
                            <? if($this->session->userdata('user_type')==1){ ?>
                            <li class="<?echo $activeRooms;?>"><a href="<?echo $siteRoot;?>/cabinet/rooms"><span>Квесты</span></a></li><?}?>
                            <li class="<?echo $activeReferals;?>"><a href="<?echo $siteRoot;?>/cabinet/referals"><span>Рефералы</span></a></li>
                            <!--li><a href="#"><span>Тариф</span></a></li-->
                            <li class="<?echo $activeHome;?>"><a href="<?echo $siteRoot;?>/cabinet/preference"><span>Настройки</span></a></li>
                            <li class="<?echo $activeTransact;?>"><a href="<?echo $siteRoot;?>/cabinet/transaction"><span>Движения по счету</span></a></li>
                           
                          
                            <!--li><a href="#"><span>Написать админам</span></a></li-->
                            <!--li><a href="#"><span>Пополнить баланс</span></a></li-->
                        </ul>
                        <hr class="thick">
                        <dl>
                            <dt>Текущий баланс:</dt>
                            <dd><span class="tag price"><?=$user_data[0]['balanceReal'];?></span></dd><?if($user_data[0]['myPromo']!=''){?>
                            <dt>Ваш промокод:</dt>
                            <dd><span><?echo $user_data[0]['myPromo']?></span></dd><?}?>
                        </dl>
                        
                        <dl>
	                        <?php echo anchor('cabinet/logout', 'Выход'); ?>
                        </dl>
                        
                        <hr class="thick">
                    </aside>
                </section><!-- /#sidebar -->
            </div><!-- /.col-md-3 -->


<div class="col-md-9 col-sm-10">
                    <section id="my-properties">
                        <header><h1><?=$currpage;?></h1></header>
                        <div class="my-properties">
 