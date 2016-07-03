<nav class="navbar navbar-default navbar-fixed-top" id="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/"><?php NAME_WEBSITE?></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <?php if(isset($_SESSION['user_name'])&&$_SESSION['role_id']==3){?>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="<?php echo base_url()?>">Xin chào <?php echo $_SESSION['user_name']?></a></li>
                <li><a href="<?php echo base_url().SiteDefault?>postnews1">Đăng tin cho thuê</a></li>
                </ul>
            <?php }else{?>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="<?php echo base_url().SiteDefault?>register">Đăng kí</a></li>
                <li><a href="<?php echo base_url().SiteDefault?>login">Đăng nhập</a></li>
                <li><a href="<?php echo base_url().SiteDefault?>postnews1">Đăng tin cho thuê</a></li>
            </ul>
            <?php }?>
        </div><!-- /.navbar-collapse -->
    </div>
</nav>
