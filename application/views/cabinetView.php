<div id="page-content">
       
       
        <!-- Breadcrumb -->
        <div class="container">
            <ol class="breadcrumb">
                <li><a href="/">Главная</a></li>
                <li class="active">Авторизация</li>
            </ol>
        </div>
  
  
  
   <div class="container">
            
            
            <header><h1>Авторизация</h1></header>
            <div class="row">
                <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">
                     <?
						   echo form_open('cabinet/validate_credentials');
						   echo form_input('username','','ваш E-mail');
						   echo @form_password('password','','ваш пароль');
						   echo form_submit('submit','Войти в кабинет');
						   //echo anchor('cabinet/register','Зарегистрироваться');
						   //echo '&nbsp;&nbsp;&nbsp;'.anchor('cabinet/forgotpass','Забыли пароль ? ');
						  
	?>
	<? echo validation_errors('<p class="errors blackText">'); ?>
	
                        
                   <? echo form_close();?>
                    <hr>
                    <div class="center"><a href="/cabinet/forgotpass">Сбросить пароль</a></div>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container -->
    </div>
    <!-- end Page Content -->
<br><br><br><br>