<?php
class product{
    private $db,$view,$lang,$title;
    function __construct($db,$lang='vi'){
        $this->db=$db;
        $this->db->reset();
        $this->lang=$lang;
        $db->where('id',5);
        $item=$db->getOne('menu');
        if($lang=='en'){
            $this->view=$item['e_view'];
            $this->title=$item['e_title'];
        }else{
            $this->view=$item['view'];
            $this->title=$item['title'];
        }
    }
    function breadcrumb(){
        $this->db->reset();
        $str.='
        <div class="container hidden-md hidden-lg">
        <div class="row">
        <ul class="breadcrumb clearfix">
        	<li><a href="'.myWeb.'"><i class="fa fa-home"></i></a></li>
            <li><a href="'.myWeb.$this->view.'">'.$this->title.'</a></li>';
        if(isset($_GET['id'])){
            $this->db->where('id',intval($_GET['id']));
            $item=$this->db->getOne('product','id,title,pId');
            //$cate_sub=$this->db->where('id',$item['pId'])->getOne('product_cate','id,title,pId');
            //$cate=$this->db->where('id',$cate_sub['pId'])->getOne('product_cate','id,title');
            /*$str.='
            <li><a href="'.myWeb.$this->view.'/'.common::slug($cate['title']).'-cate'.$cate['id'].'">'.$cate['title'].'</a></li>
            <li><a href="'.myWeb.$this->view.'/'.common::slug($cate_sub['title']).'-p'.$cate_sub['id'].'">'.$cate_sub['title'].'</a></li>';*/
            $str.='
            <li><a href="#">'.$item['title'].'</a></li>';
        }elseif(isset($_GET['cate_id'])){
            $cate=$this->db->where('id',intval($_GET['cate_id']))->getOne('product_cate','id,title');
            $str.='
            <li><a href="#">'.$cate['title'].'</a></li>';
        }elseif(isset($_GET['pId'])){
            $cate_sub=$this->db->where('id',intval($_GET['pId']))->getOne('product_cate','id,title,pId');
            $cate=$this->db->where('id',$cate_sub['pId'])->getOne('product_cate','id,title');
            $str.='
            <li><a href="'.myWeb.$this->view.'/'.common::slug($cate['title']).'-cate'.$cate['id'].'">'.$cate['title'].'</a></li>            
            <li><a href="#">'.$cate_sub['title'].'</a></li>';
        }
        $str.='
        </ul>
        </div>
        </div>';
        $str.='
        <div class="product-background hidden-xs hidden-sm">
            
        </div>
        <a name="product-list"> </a>
        <div class="text-center">        
            <h2 class="title">'.$this->title.'</h2>
        </div> ';
        return $str;
    }
    function ind_product(){ 
        $str.='
        <section id="ind-product">
            <div class="container">
                <div class="col-md-12">
                    <div class="your-class">';
        $list=$this->db->where('active',1)->where('home',1)->orderBy('id')->orderBy('id')->get('product');   
        foreach($list as $item){
            $lnk=myWeb.$this->view.'/'.common::slug($item['title']).'-i'.$item['id'];
            $img=$this->first_image($item['id']);
            $str.='
            <div>
            <a href="'.$lnk.'">
                <img src="'.webPath.$img.'" class="img-responsive center-block"/>
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
          slidesToScroll: 3,
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
    function hot_product(){
        $this->db->reset();
        $this->db->where('active',1)->where('home',1);
        $list=$this->db->get('product',null);
        $i=1;
        foreach($list as $item){
            if($i%4==1){
                $str.='
                <div class="row">';
            }
            $str.=$this->product_item($item);
            if($i%4==0){
                $str.='
                </div>';
            }
            $i++;
        }   
        if($i%4!=1){
            $str.='
            </div>';
        }
        return $str;
    }
    function product_item($item){
        $lnk=myWeb.$this->view.'/'.common::slug($item['title']).'-i'.$item['id'];
        $img=$this->first_image($item['id']);
        $str.='
        <div class="col-md-15 col-sm-6 wow fadeInLeft product-item text-center" data-wow-duration="2s">
        <a href="'.$lnk.'">
			<figure>
				<img src="'.webPath.'thumb_'.$img.'" alt="'.$item['title'].'" title="'.$item['title'].'" class="img-responsive center-block">
				<figcaption class="text-center">
					<h3>'.common::str_cut($item['title'],30).'</h3>
					<!--span><b>Giá bán:</b> <em>'.number_format($item['price'],0,'.','.').'VNĐ</em></span-->
				</figcaption>
			</figure>
        </a>
		</div>';
        return $str;
    }
    function product_list_item($item,$type=1){
        $lnk=myWeb.$this->view.'/'.common::slug($item['title']).'-i'.$item['id'];
        $img=$this->first_image($item['id']);
        if(trim($img)==='') $img='holder.js/400x300';else $img=webPath.$img;
        if($type==1){
            $str='
            <div class="col-md-12 col-sm-6 col-md-3 product-item">';    
        }else{
            $str='
            <div class="col-md-12 col-sm-6 col-md-4 product-item">';
        }        
        $str.='
        <a href="'.$lnk.'">
            <div>
                <p>'.($item['price']==0?contact:number_format($item['price'],0,',','.').' VNĐ').'</p>
                <img src="'.$img.'" class="img-responsive" />
                <p>
                    <h2>'.$item['title'].'</h2>
                    <button class="btn btn-default">'.more.'</button>
                </p>
            </div>
        </a>
        </div>';
        return $str;
    }
    function check_pId(){
        if(isset($_GET['pId'])){
            $pId=intval($_GET['pId']);
        }elseif(isset($_GET['id'])){
            $item=$this->db->where('id',intval($_GET['id']))->getOne('product','pId');
            $pId=$item['pId'];
        }else $pId=0;
        return $pId;
    }
    function category(){
        $pId=$this->check_pId();
        $list=$this->db->where('active',1)->orderBy('ind','ASC')->get('product_cate',null,'id,title');
        $str='
        <div class="row text-center product-category">';
        foreach($list as $item){
            if($item['id']==$pId){
                $active=' class="active"';
            }else{
                $active='';
            }
            $str.='
            <a href="'.myWeb.$this->view.'/'.common::slug($item['title']).'-p'.$item['id'].'"'.$active.'>
                '.$item['title'].'
            </a>';
        }
        $str.='
        </div>';
        return $str;
    }
    function product_cate(){
        $pId=$this->check_pId();
        $this->db->reset();
        if($pId>0){
            $lev=$this->db->where('id',$pId)->getOne('product_cate','lev');
            $this->db->where('pId',$pId);
        }
        $this->db->where('active',1)->orderBy('id');
        $this->db->pageLimit=pd_lim;
        $page=isset($_GET['page'])?intval($_GET['page']):1;
        $list=$this->db->paginate('product',$page);
        $count=$this->db->totalCount;
        $i=1;
        $str='
        <section id="recent-works">
            <div class="container">';
        $str.=$this->category();
        $i=1;
        foreach($list as $item){
            if($i%5==1){
                $str.='
                <div class="row">';
            }
            $str.=$this->product_item($item);
            if($i%5==0){
                $str.='
                </div>';
            }
            $i++;
        }  
        if($i%5!=1){
           $str.='
           </div>'; 
        }  
        
        $pg = new Pagination();    
        $pg->pagenumber = $page;
        $pg->pagesize = pd_lim;
        $pg->totalrecords = $count;
        $pg->showfirst = true;
        $pg->showlast = true;
        $pg->paginationcss = "pagination-large";
        $pg->paginationstyle = 1; // 1: advance, 0: normal
        if(!$pId || $pId==0){
            $pg->defaultUrl = myWeb.$this->view;
            $pg->paginationUrl = myWeb.$this->view."/[p]#product-list";            
        }else{
            $cate=$this->db->where('id',$pId)->getOne('product_cate','id, title');
            
            $pg->defaultUrl = myWeb.$this->view.'/'.common::slug($cate['title']).'-p'.$cate['id'];
            $pg->paginationUrl = $pg->defaultUrl ."/[p]#product-list";
        }     
        $str.= '<div class= "col-md-12 text-center">
                  <div class="pagination pagination-centered">'
                        .$pg->process()
                    .'</div>
                    </div>'; 
        $str.='
            </div>
        </section>';
        return $str; 
    }
    function product_list($pId,$type=1){
        $page=isset($_GET['page'])?intval($_GET['page']):1;
        $this->db->reset();
        if($pId!=0) $this->db->where('pId',$pId);
        $this->db->where('active',1)->orderBy('id');
        $this->db->pageLimit=limit;
        $list=$this->db->paginate('product',$page,'id,title,price,price_reduce');
        $str='
        <div class="row">';
        foreach($list as $item){
            $str.=$this->product_list_item($item,$type);
        }
        $str.='
        </div>';
        return $str;
    }
    function product_one($id){
        $this->db->where('id',$id);
        $item=$this->db->getOne('product','id,price,price_reduce,title,content,pId,feature,manual,promotion,video');
        $this->db->where('pId',$item['pId'])->where('id',$item['id'],'<>')->where('active',1)->orderBy('id');
        $list=$this->db->get('product',5);
        $lnk=domain.'/'.$this->view.'/'.common::slug($item['title']).'-i'.$item['id'];
        $str.='
        <section id="recent-works">
        <div class="container">
        '.$this->category().'
        <div class="row product-detail clearfix">
            <div class="col-md-5">
                '.$this->product_image_show($item['id']).'
            </div>
            <div class="col-md-7">
                <article class="product-one">
                <h1>'.$item['title'].'</h1>
                <!--b>Giá Bán Lẻ: <em>'.number_format($item['price'],0,',','.').'VNĐ</em></b-->
                <!--form action="javascript:add_cart('.$item['id'].',1)">
                    <button class="btn btn-default"><i class="fa fa-shopping-cart"></i> Mua Hàng</button>
                </form-->                
                <p>'.$item['feature'].'</p>
                <p>'.$item['content'].'</p>
                </article>
            </div>
        </div>                   
        <div>
                  
        </div>       ';
          
        if(count($list)>0){
            $str.='
            <div class="wow fadeInDown row">
                <h2 class="title">
                        SẢN PHẨM CÙNG LOẠI
                </h1>
            </div>';
           $i=1;
            foreach($list as $item){
                if($i%5==1){
                    $str.='
                    <div class="row">';
                }
                $str.=$this->product_item($item);
                if($i%5==0){
                    $str.='
                    </div>';
                }
                $i++;
            }  
            if($i%5!=1){
               $str.='
               </div>'; 
            }     
        }        
        $str.='
        </div>
        </section>';    
        return $str;
    }
    function product_image_show($id){
        $this->db->reset();
        $list=$this->db->where('active',1)->where('pId',$id)->orderBy('ind','ASC')->orderBy('id')->get('product_image');
        $temp=$tmp='';
        foreach($list as $item){
            $temp.='
            <li>
                <a href="'.webPath.$item['img'].'" >
                    <img src="'.webPath.$item['img'].'" alt="" title="" class=""/>
                </a>
            </li>';
            $tmp.='
            <li>
                <img src="'.webPath.'thumb_'.$item['img'].'" alt="" title=""/>
            </li>';
        }
        $str.='
        <!-- Place somewhere in the <body> of your page -->
        <div id="image-slider" class="flexslider">
          <ul class="slides popup-gallery">
            '.$temp.'
          </ul>
        </div>
        <div id="carousel" class="flexslider" style="margin-top:-50px;margin-bottom:10px">
          <ul class="slides">
            '.$tmp.'
          </ul>
        </div>
        <script>
        $(window).load(function() {
          // The slider being synced must be initialized first
          $("#carousel").flexslider({
            animation: "slide",
            controlNav: false,
            animationLoop: false,
            slideshow: false,
            itemWidth: 80,
            itemMargin: 5,
            asNavFor: "#image-slider"
          });
         
          $("#image-slider").flexslider({
            animation: "slide",
            controlNav: false,
            animationLoop: false,
            slideshow: false,
            sync: "#carousel"
          });
        });
        </script>';
        return $str;
    }
    function first_image($id){
        $this->db->reset();
        $this->db->where('active',1)->where('pId',$id)->orderBy('ind','ASC')->orderBy('id');
        $img=$this->db->getOne('product_image','img');
        return $img['img'];
    }
}
?>