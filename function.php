<?php
include_once 'front.php';
function menu($db,$view){
    $db->reset();
    $list=$db->where('active',1)->orderBy('ind','ASC')->orderBy('id')->get('menu');
    $str.='
    <ul class="menu hidden-sm hidden-xs">';
    foreach($list as $item){
        if($view==$item['view']) $active=' class="active"';
        else $active='';
        if($item['view']=='trang-chu'){
            $title='<i class="fa fa-home"></i>';
        }else{
            $title=$item['title'];
        }
        $str.='
        <li'.$active.'><a href="'.myWeb.$item['view'].'">'.$title.'</a></li>';
    }
    $str.='               
    </ul>'  ;
    $str.='
    <nav class="navbar navbar-default hidden-md hidden-lg">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
    
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">';
    foreach($list as $item){
        if($view==$item['view']) $active=' class="active"';
        else $active='';
        if($item['view']=='trang-chu'){
            $title='<i class="fa fa-home"></i>';
        }else{
            $title=$item['title'];
        }
        $str.='
        <li'.$active.'><a href="'.myWeb.$item['view'].'">'.$title.'</a></li>';
    }
    $str.='
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>';
    return $str;
}
function foot_menu($db,$view){
    $db->reset();
    $list=$db->where('active',1)->orderBy('ind','ASC')->orderBy('id')->get('menu');
    $str.='
    <ul class="pull-right">';
    foreach($list as $item){
        $str.='
        <li><a href="'.myWeb.$item['view'].'">'.$item['title'].'</a></li>';   
    }
    $str.='
    </ul>';
    return $str;
}
function home($db){
    //common::widget('layer_slider');
    //$layer_slider=new layer_slider($db);
    
    $str='
    <section id="ind-slider">
        <div class="container">
            '.wow_slider($db).'
        </div>
    </section>';
    
    common::page('about');
    $about=new about($db);
    $str.=$about->ind_about();
    
    common::page('product');
    $product=new product($db);
    $str.=$product->ind_product();
    
    /*$str.=partner($db);*/
    return $str;
}
function wow_slider($db){
    $db->reset();
    $list=$db->where('active',1)->orderBy('ind','ASC')->get('slider');
    $str.='
    <link rel="stylesheet" type="text/css" href="'.myWeb.'engine/style.css" />
	<!-- Start WOWSlider.com BODY section --> <!-- add to the <body> of your page -->
	<div id="wowslider-container1">
	<div class="ws_images"><ul>';
    $i=1;
    foreach($list as $item){
        $img='<img src="'.webPath.$item['img'].'" alt="" title=""/>';
        $lnk=$item['lnk']!=''?'<a href="'.$item['lnk'].'">'.$img.'</a>':$img;
        $str.='
        <li>'.$lnk.'</li>';
        $tmp.='
        <a href="#" title=""><span>'.$i.'</span></a>';
        $i++;
    }
    $str.='
	</ul></div>
	<div class="ws_bullets"><div>
		'.$tmp.'
	</div></div><div class="ws_script" style="position:absolute;left:-99%"></div>
	<div class="ws_shadow"></div>
	</div>	
	<script type="text/javascript" src="'.myWeb.'engine/wowslider.js"></script>
	<script type="text/javascript" src="'.myWeb.'engine/script.js"></script>
	<!-- End WOWSlider.com BODY section -->';
    return $str;
}
function slide($db){
    $db->reset();
    $list=$db->where('active',1)->orderBy('ind','ASC')->get('slider');
    $count=$db->count;
    $str.='
    <section id="main-slider" class="no-margin">
        <div class="carousel slide">
            <ol class="carousel-indicators">';
    for($i=0;$i<$count;$i++){
        $str.='
        <li data-target="#main-slider" data-slide-to="'.$i.'" '.($i==0?'class="active"':'').'></li>';
    }
    $str.='
            </ol>
            <div class="carousel-inner">';
    $i=0;
    foreach($list as $item){
        $str.='
        <div class="item'.($i==0?' active':'').'" style="background-image: url('.webPath.$item['img'].')">
            <div class="container">
                <div class="row slide-margin">
                    <div class="col-sm-6">
                        <div class="carousel-content">
                            <h1 class="animation animated-item-1">'.$item['title'].'</h1>
                            <h2 class="animation animated-item-2">'.$item['sum'].'</h2>
                            <a class="btn-slide animation animated-item-3" href="#">Xem Thêm</a>
                        </div>
                    </div>

                    <!--div class="col-sm-6 hidden-xs animation animated-item-4">
                        <div class="slider-img">
                            <img src="images/slider/img1.png" class="img-responsive">
                        </div>
                    </div-->

                </div>
            </div>
        </div><!--/.item-->';
        $i++;
    }
    $str.='
            </div><!--/.carousel-inner-->
        </div><!--/.carousel-->
        <a class="prev hidden-xs" href="#main-slider" data-slide="prev">
            <i class="fa fa-chevron-left"></i>
        </a>
        <a class="next hidden-xs" href="#main-slider" data-slide="next">
            <i class="fa fa-chevron-right"></i>
        </a>
    </section><!--/#main-slider-->';
    return $str;
}
function contact($db){
    common::page('contact');
    $contact=new contact($db);
    $str=$contact->breadcrumb();
    $str.=$contact->contact();
    return $str;
}
function about($db){
    //common::widget('layer_slider');
    //$layer_slider=new layer_slider($db);
    
    $str='
    <section id="ind-slider">
        <div class="container">
            '.wow_slider($db).'
        </div>
    </section>';
    
    common::page('about');
    $about=new about($db);
    //$str=$about->breadcrumb();
    $str.=$about->about_one();
    return $str;
}
function manual($db){
    //common::widget('layer_slider');
    //$layer_slider=new layer_slider($db);
    
    $str='
    <section id="ind-slider">
        <div class="container">
            '.wow_slider($db).'
        </div>
    </section>';
    
    common::page('manual');
    $manual=new manual($db);
    //$str=$about->breadcrumb();
    $str.=$manual->manual_one();
    return $str;
}
function product($db){
    common::page('product');
    $pd=new product($db,$view);
    $str=$pd->breadcrumb();
    if(isset($_GET['id'])){
        $id=intval($_GET['id']);
        $str.=$pd->product_one($id);
    }else{
        $str.=$pd->product_cate();
    }
    return $str;
}
function partner($db){
    $list=$db->where('active',1)->orderBy('ind','ASC')->orderBy('id')->get('partner');    
    $str.='
    <section id="partner">
        <div class="container">
            <div class="center wow fadeInDown">
                <h2>Đại Diện Phân Phối</h2>
                <p class="lead">
                    Đại diện chính thức của công ty L&rsquo;avoine Việt Nam
                </p>
            </div>    
            <div class="partners col-md-12">
                <div class="your-class">';
    foreach($list as $item){
        $img=$item['img']==''?selfPath.'square-facebook.png':webPath.$item['img'];
        $str.='
        <div>
        <a href="'.$item['facebook'].'" target="_blank">
            <img src="'.$img.'" class="img-responsive center-block"/>
            <h2 class="text-center">'.$item['title'].'</h2>
        </a>
        </div>';
    }
    $str.='
                </div>
            </div>        
        </div><!--/.container-->
    </section><!--/#partner-->';
    $str.='   
    <script>
    $(".your-class").slick({
      slidesToShow: 5,
      slidesToScroll: 1,
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 5,
            slidesToScroll: 3,
            infinite: true,
            dots: true
          }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
      ],
      autoplay: true,
      autoplaySpeed: 2000,
    });
    </script>';
    return $str;
}
function social($db){
    $basic_config=$db->where('id',1)->getOne('basic_config','social_twitter, social_facebook, social_google_plus');
    $str.='
    <div class="social">
        <a href="'.$basic_config['social_twitter'].'" target="_blank"><i class="fa fa-twitter"></i></a>
        <a href="'.$basic_config['social_facebook'].'" target="_blank"><i class="fa fa-facebook"></i></a>
        <a href="'.$basic_config['social_google_plus'].'" target="_blank"><i class="fa fa-google-plus"></i></a>
    </div>';
    return $str;
}
function search($db){
    $hint=$_GET['hint'];
    common::load('search','page');
    $obj = new search($db,$hint);
    $obj->add('product','Sản Phẩm','san-pham');
    $str.=$obj->output();
    return $str;
}
?>
