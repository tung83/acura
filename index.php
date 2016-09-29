<?php include 'function.php';?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <title>.:Acura:.</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="<?=selfPath?>logo.png"/>   
    <?=common::basic_css()?> 
    <?=common::basic_js()?>
</head>
<body>
    <header>
        <div class="container">
            <div class="row">
                <div class="col-md-6 logo-and-slogan clearfix">
                    <a href="<?=myWeb?>"><img src="<?=selfPath?>logo.png" alt="" title=""/></a>
                    <div class="text-center">
                        CTY TNHH SẢN XUẤT - THƯƠNG MẠI
                        <p>ĐẠI HƯNG</p>
                    </div>                    
                </div>
                <div class="col-md-6 search-and-menu clearfix">
                    <div class="clearfix">
                        <form class="form form-inline search pull-right" id="search" action="javascript:void(0)" role="form">
                            <input type="text" id="hint" class="form-control" placeholder="Tìm kiếm..."/>
                        </form>
                    </div>
                    <?=menu($db,$view)?>
                </div>
            </div>
        </div>    
    </header>
    <?php
    switch($view){
        case 'san-pham':
            echo product($db);
            break;
        case 'gioi-thieu':
            echo about($db);
            break;
        case 'huong-dan-su-dung':
            echo manual($db);
            break;
        case 'lien-he':
            echo contact($db);
            break;
        case 'tim-kiem':
            echo search($db);
            break;
        default:
            echo home($db);
            break;
    }
    ?>
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <?=common::qtext($db,4)?>
                </div>
                <div class="col-md-6 text-right counter-and-copy-right" style="color: #541e12;">
                <?=social($db)?>
                <?php
                    common::load('class.visitors');
                    $vs=new visitors($db);
                ?>
                    <div>
                        Đang online: <b><?=$vs->getOnlineVisitors();?></b>
                    </div>
                    <div>
                        Lượt truy cập: <b><?=$vs->getCounter();?></b>
                    </div>
                    <div>
                        Bản quyền thuộc <a>Công ty TNHH Đại Hưng</a>
                    </div>
                    <div>
                        Thiết kế & phát triển bởi <a href="http://www.emsvn.com">emsvn.com</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.7&appId=1526299550957309";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
</body>
</html>