<?php
common::load('base','page');
class about{
    private $db;
    private $lang;
    private $view;
    function __construct($db,$lang='vi'){
        $this->db=$db;
        $this->db->reset();
        $this->lang=$lang;
        $db->where('id',2);
        $item=$db->getOne('menu');
        if($lang=='en'){
            $this->view=$item['e_view'];
        }else{
            $this->view=$item['view'];
        }
    }
    function ind_about(){
        $this->db->where('active',1);
        $this->db->orderBy('id','ASC');
        $item=$this->db->getOne('about');
        $lnk=myWeb.$this->view;
        $str='
        <section id="ind-about">
            <div class="container">
                <div class="row wow fadeInUp" data-wow-duration="2s">
                    <div class="col-md-3">
                        <img src="'.webPath.$item['img'].'" class="img-responsive" alt="" title=""/>
                    </div>
                    <div class="col-md-9 clearfix">
                        '.common::str_cut($item['sum'],320).'
                        <p class="text-right">
                            <a href="'.$lnk.'">Xem thêm</a>
                        </p>
                    </div>
                </div>                                
            </div><!--/.container-->
        </section><!--/#feature-->';
        return $str;
    }
    function breadcrumb(){
        $this->db->reset();
        $str.='
        <div class="container">
        <ul class="breadcrumb clearfix">
        	<li><a href="'.myWeb.'"><i class="fa fa-home"></i></a></li>
            <li><a href="'.myWeb.$this->view.'">Giới Thiệu</a></li>';
        if(isset($_GET['id'])){
            $this->db->where('id',intval($_GET['id']));
            $item=$this->db->getOne('about','id,title');
            $str.='
            <li><a href="#">'.$item['title'].'</a></li>';
        }
        $str.='
        </ul>
        </div>';
        return $str;
    }
    
    function about_all(){
        $page=isset($_GET['page'])?intval($_GET['page']):1;
        $this->db->where('active',1);
        $this->db->orderBy('id');
        $this->db->pageLimit=10;
        $list=$this->db->paginate('about',$page);
        $count=$this->db->totalCount;
        foreach($list as $item){
            $str.=$this->about_item($item);
        }
        
        $pg=new Pagination(array('limit'=>limit,'count'=>$count,'page'=>$page,'type'=>0));
        $pg->set_url(array('def'=>myWeb.$this->view,'url'=>myWeb.'[p]/'.$this->view));

        $str.= '<div class="pagination-centered">'.$pg->process().'</div>';
        return $str;
    }
    function about_item($item){
        $lnk=myWeb.$this->view.'/'.common::slug($item['title']).'-i'.$item['id'];
        $str.='
        <a href="'.$lnk.'" class="about-item clearfix">
            <img src="'.webPath.$item['img'].'" class="img-responsive" alt="" title=""/>
            <div>
                <h2>'.$item['title'].'</h2>
                <span>'.nl2br(common::str_cut($item['sum'],620)).'</span>
            </div>
        </a>';
        return $str;
    }
    
    function about_one(){
        $id=1;
        $item=$this->db->where('id',$id)->getOne('about');
        $str.='  
        <section id="about-us">
        <div class="container">
			<div class="wow fadeInDown row">
            <div class="col-md-12">
                <article>
                    <div class="text-center">
                        <h2 class="title">'.$item['title'].'</h2>
                    </div>
                    <p>'.$item['content'].'</p>
                </article>
			</div>
            </div>
        </div>
        </section>';
        return $str;
    }
}


?>
