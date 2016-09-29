<?php
class search{
    private $db,$lang,$hint,$stack,$field_search,$field_get;
    function __construct($db,$hint,$lang='vi'){
        $this->lang=$lang;
        $this->db=$db;
        $this->db->reset();
        $hint=explode('-',$hint);
        $hint=implode(' ',$hint);
        $this->hint=$hint;
        $this->stack=array();
        $this->field_search=array('title');
        $this->field_get=array('id,title,price,price_reduce');
    }
    function field_search($arr=null){
        foreach((array)$arr as $item){
            array_push($this->field_search,$item);
        }
        return $this;
    }
    function field_get($arr=null){
        foreach((array)$arr as $item){
            array_push($this->field_get,$item);
        }
        return $this;  
    }
    function add($table,$label,$view){
        $this->db->reset();
        //build or query
        foreach($this->field_search as $val){
            $tmp[]= $val.' like "%'.$this->hint.'%"';
        }
        $or_query=implode(' OR ',$tmp);
        //build or query
        $field_get=implode(',',$this->field_get);
        $sql='
        select '.$field_get.' from '.$table.' where active=1 and ( '.$or_query.' )';
        $list=$this->db->rawQuery($sql);
        if($this->db->count>0){
            $this->stack[]=array('label'=>$label,'view'=>$view,'list'=>$list);
        }        
        $this->field_search=array('title');
        $this->field_get=array('id','title');
        return $this;
    }
    function total(){
        $i=0;
        foreach($this->stack as $item){
            $i+=count($item['list']);
        }
        return $i;
    }
    function breadcrumb(){
        $str.='
        <ul class="breadcrumb clearfix">
        	<li><a href="'.myWeb.'"><i class="fa fa-home"></i></a></li>
            <li><a>Tìm kiếm</a></li>';
        $str.='
        </ul>';
        return $str;
    }
    function output(){
        $str='
        <section id="search">
        <div class="container">
        <h1 class="search-title">Có '.$this->total().' kết quả với từ khoá <b style="color:#f00">"'.$this->hint.'"</b></h1>';
        common::load('product','page');
        $obj=new product($this->db);
        foreach($this->stack as $item){
            $i=1;
            foreach($item['list'] as $sub_item){
                if($i%5==1){
                    $str.='
                    <div class="row">';
                }
                $str.=$obj->product_item($sub_item);
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
}
?>