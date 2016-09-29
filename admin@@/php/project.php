<?php
function mainProcess($db)
{
    if(isset($_GET['pId'])) return project($db);
    else return project_cate($db);
}
function project_cate($db)
{
	$msg='';
    $act='project';
    $table='project_cate';
    if(isset($_POST["Edit"])&&$_POST["Edit"]==1){
		$db->where('id',$_POST['idLoad']);
        $list = $db->get($table);
        $btn=array('name'=>'update','value'=>'Update');
        $form = new form($list);
	} else {
        $btn=array('name'=>'addNew','value'=>'Submit');	
        $form = new form();
	}
	if(isset($_POST["addNew"])||isset($_POST["update"])) {
        $title=htmlspecialchars($_POST['title']);	   
        $meta_kw=htmlspecialchars($_POST['meta_keyword']);
        $meta_desc=htmlspecialchars($_POST['meta_description']);
        $active=$_POST['active']=="on"?1:0;
        $ind=intval($_POST['ind']);
	}
    if(isset($_POST['listDel'])&&$_POST['listDel']!=''){
        $list = explode(',',$_POST['listDel']);
        foreach($list as $item){
            $db->where('id',intval($item));
            try{
               $db->delete($table); 
            } catch(Exception $e) {
                $msg=mysql_error();
            }
        }
        header("location:".$_SERVER['REQUEST_URI'],true);
    }
	if(isset($_POST["addNew"])) {
        $insert = array(
                    'title'=>$title,
                    'active'=>$active,'meta_keyword'=>$meta_kw,
                    'meta_description'=>$meta_desc,'ind'=>$ind
                );
		try{
            $recent = $db->insert($table,$insert);
            header("location:".$_SERVER['REQUEST_URI'],true); 
        } catch(Exception $e) {
            $msg=$e->getMessage();
        }			
	}
	if(isset($_POST["update"]))	{
	   $update=array(
                    'title'=>$title,
                    'active'=>$active,'meta_keyword'=>$meta_kw,
                    'meta_description'=>$meta_desc,'ind'=>$ind
                );
        try{
            $db->where('id',$_POST['idLoad']);
            $db->update($table,$update);  
            header("location:".$_SERVER['REQUEST_URI'],true);   
        } catch (Exception $e){
            $msg=$e->getMessage();
        }
	}
	
	if(isset($_POST["Del"])&&$_POST["Del"]==1) {
        $db->where('id',$_POST['idLoad']);
        try{
           $db->delete($table); 
           header("location:".$_SERVER['REQUEST_URI'],true);
        } catch(Exception $e) {
            $msg=mysql_error();
        }
	}
    $page_head= array(
                    array('#','Danh mục dự án')
                );
	$str=$form->breadcumb($page_head);
	$str.=$form->message($msg);
    $head_title=array('Tiêu đề','Thứ tự','Hiển thị');
	$str.=$form->table_head($head_title);
	
    $page=isset($_GET["page"])?intval($_GET["page"]):1;
    $db->pageLimit=ad_lim;
    $db->orderBy('id');
    $list=$db->paginate($table,$page);

    if($db->count!=0){
        foreach($list as $item){
            $item_id=$item['id'];
            if($item['active']==1){
                $active = '<span class="glyphicon glyphicon-ok"></span>';
            } else {
                $active='<span class="glyphicon glyphicon-remove"></span>';
            }
            $item_content = array(
                $item['title'],
                $item['ind'],
                $active
            );
            if(isset($_POST['Edit'])==1&&$_POST['idLoad']==$item_id) $change=true;
            else $change=false;
            $addition=array(
                array('direction'=>'main.php?act='.$act.'&pId='.$item_id,'icon'=>'eye-open')
            );
            $str.=$form->table_body($item_id,$item_content,$change,$_SERVER['REQUEST_URI'],$addition);      
        }
    }                               
	$str.='					
					</tbody>
				</table>
				</div>';
    $str.=$form->del_list();
    $pg = new Pagination();
    $pg->pagenumber = $page;
    $pg->pagesize = ad_lim;
    $pg->totalrecords = $db->totalCount;
    $pg->paginationstyle = 1; // 1: advance, 0: normal
    $pg->defaultUrl = "main.php?act=$act&type=$type";
    $pg->paginationUrl = "main.php?act=$act&type=$type&page=[p]";
    $str.= $pg->process();
	$str.='			
			</div>
		</div>
		<!-- Row -->
		<form role="form" id="actionForm" name="actionForm" enctype="multipart/form-data" action="" method="post" data-toggle="validator">
		<div class="row">
		<div class="col-lg-12"><h3>Cập nhật - Thêm mới thông tin</h3></div>
        <div class="col-lg-12">
            '.$form->text('title','Tiêu đề').'
            '.$form->text('meta_keyword','Keyword <code>SEO</code>').'
            '.$form->textarea('meta_description','Description <code>SEO</code>').'
            '.$form->number('ind','Thứ tự','',true).'
            '.$form->checkbox('active','Hiển Thị',true).'
        </div>
		'.$form->hidden($_POST['idLoad'],$btn['name'],$btn['value']).'
	</div>
	</form>
	';	
	return $str;	
}
function project($db)
{
	$msg='';
    $act='project';
    $table='project';
    $pId=intval($_GET['pId']);
    if(isset($_POST["Edit"])&&$_POST["Edit"]==1){
		$db->where('id',$_POST['idLoad']);
        $list = $db->get($table);
        $btn=array('name'=>'update','value'=>'Update');
        $form = new form($list);
	} else {
        $btn=array('name'=>'addNew','value'=>'Submit');	
        $form = new form();
	}
	if(isset($_POST["addNew"])||isset($_POST["update"])) {
        $title=htmlspecialchars($_POST['title']);	   
        $sum=htmlspecialchars($_POST['sum']);
        $content=str_replace("'","",$_POST['content']);
        $meta_kw=htmlspecialchars($_POST['meta_keyword']);
        $meta_desc=htmlspecialchars($_POST['meta_description']);
        $active=$_POST['active']=="on"?1:0;
        $file=time().$_FILES['file']['name'];
        $ind=intval($_POST['ind']);
	}
    if(isset($_POST['listDel'])&&$_POST['listDel']!=''){
        $list = explode(',',$_POST['listDel']);
        foreach($list as $item){
            $db->where('id',intval($item));
            try{
               $db->delete($table); 
            } catch(Exception $e) {
                $msg=mysql_error();
            }
        }
        header("location:".$_SERVER['REQUEST_URI'],true);
    }
	if(isset($_POST["addNew"])) {
        $insert = array(
            'title'=>$title,'ind'=>$ind,
            'sum'=>$sum,'content'=>$content,
            'meta_keyword'=>$meta_kw,'meta_description'=>$meta_desc,
            'active'=>$active,'pId'=>$pId
        );
		try{
            $recent = $db->insert($table,$insert);
            if($form->file_chk($_FILES['file'])){
                WideImage::load('file')->resize(220,162, 'fill')->saveToFile(myPath.$file);
                $db->where('id',$recent);
                $db->update($table,array('img'=>$file));
            }
            header("location:".$_SERVER['REQUEST_URI'],true); 
        } catch(Exception $e) {
            $msg=mysql_error();
        }			
	}
	if(isset($_POST["update"]))	{
	   $update=array(
            'title'=>$title,'ind'=>$ind,
            'sum'=>$sum,'content'=>$content,
            'meta_keyword'=>$meta_kw,'meta_description'=>$meta_desc,
            'active'=>$active
       );
       if($form->file_chk($_FILES['file'])){
            WideImage::load('file')->resize(220,162, 'fill')->saveToFile(myPath.$file);
            $update = array_merge($update,array('img'=>$file));
            $form->img_remove($_POST['idLoad'],$db,$table);
        }
        try{
            $db->where('id',$_POST['idLoad']);
            $db->update($table,$update);  
            header("location:".$_SERVER['REQUEST_URI'],true);   
        } catch (Exception $e){
            $msg = $e->getErrorMessage();
        }
	}
	
	if(isset($_POST["Del"])&&$_POST["Del"]==1) {
        $db->where('id',$_POST['idLoad']);
        try{
           $db->delete($table); 
           header("location:".$_SERVER['REQUEST_URI'],true);
        } catch(Exception $e) {
            $msg=mysql_error();
        }
	}
    $cate=$db->where('id',$pId)->getOne('project_cate','id,title');
    $page_head= array(
                    array('main.php?act='.$act,'Danh mục dự án'),
                    array('#',$cate['title'])
                );
	$str=$form->breadcumb($page_head);
	$str.=$form->message($msg);
    $head_title=array('Tiêu đề','Hình ảnh','Thứ tự','Hiển thị');
	$str.=$form->table_head($head_title);
	
    $page=isset($_GET["page"])?intval($_GET["page"]):1;
    $db->pageLimit=ad_lim;
    $db->where('pId',$pId);
    $db->orderBy('id');
    $list=$db->paginate($table,$page);

    if($db->count!=0){
        foreach($list as $item){
            $item_id=$item['id'];
            if($item['active']==1){
                $active = '<span class="glyphicon glyphicon-ok"></span>';
            } else {
                $active='<span class="glyphicon glyphicon-remove"></span>';
            }
            $item_content = array(
                $item['title'],
                '<img src="'.myPath.$item['img'].'" class="img-thumbnail img-admin"/>',
                $item['ind'],
                $active
            );
            if(isset($_POST['Edit'])==1&&$_POST['idLoad']==$item_id) $change=true;
            else $change=false;
            $str.=$form->table_body($item_id,$item_content,$change,$_SERVER['REQUEST_URI'],$addition);      
        }
    }                               
	$str.='					
					</tbody>
				</table>
				</div>';
    $str.=$form->del_list();
    $pg = new Pagination();
    $pg->pagenumber = $page;
    $pg->pagesize = ad_lim;
    $pg->totalrecords = $db->totalCount;
    $pg->paginationstyle = 1; // 1: advance, 0: normal
    $pg->defaultUrl = "main.php?act=$act&pId=$pId";
    $pg->paginationUrl = "main.php?act=$act&pId=$pId&page=[p]";
    $str.= $pg->process();
	$str.='			
			</div>
		</div>
		<!-- Row -->
		<form role="form" id="actionForm" name="actionForm" enctype="multipart/form-data" action="" method="post" data-toggle="validator">
		<div class="row">
		<div class="col-lg-12"><h3>Cập nhật - Thêm mới thông tin</h3></div>
        <div class="col-lg-12">
            '.$form->text('title','Tiêu đề').'
            '.$form->textarea('sum','Trích dẫn').'
            '.$form->text('meta_keyword','Keyword <code>SEO</code>').'
            '.$form->textarea('meta_description','Description <code>SEO</code>').'
            '.$form->ckeditor('content','Nội dung :').'
            '.$form->file('file','Hình ảnh <code>( 220 x 162 )</code>').'
            '.$form->number('ind','Thứ tự').'
            '.$form->checkbox('active','Hiển Thị',true).'
        </div>

		'.$form->hidden($_POST['idLoad'],$btn['name'],$btn['value']).'
	</div>
	</form>
	';	
	return $str;	
}
?>