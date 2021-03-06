<?php
include_once phpLib.'PHPMailer/PHPMailerAutoload.php';
class contact{
    private $db,$view,$lang;
    private $post_result,$basic_config;
    function __construct($db,$lang='vi'){
        $this->db=$db;
        $this->db->reset();
        $this->lang=$lang;
        $db->where('id',9);
        $item=$db->getOne('menu');
        if($lang=='en'){
            $this->view=$item['e_view'];
        }else{
            $this->view=$item['view'];
        }        
        $this->basic_config=$this->db->getOne('basic_config','smtp_server, smtp_port, smtp_user, smtp_pwd, smtp_sender_email, smtp_sender_name, smtp_receiver, gmap_script');
    }
    function breadcrumb(){
        $this->db->reset();
        /*$str.='
        <div class="container">
        <ul class="breadcrumb clearfix">
        	<li><a href="'.myWeb.'"><i class="fa fa-home"></i></a></li>
            <li><a href="'.myWeb.$this->view.'">Liên Hệ</a></li>';
        $str.='
        </ul>
        </div>';*/
        $str='
        <div class="contact-background">
        
        </div>';
        return $str;
    }
    function contact_insert(){
        $this->db->reset();
        if(isset($_POST['submit'])){
            $name=htmlspecialchars($_POST['name']);
            $adds=htmlspecialchars($_POST['adds']);
            $phone=htmlspecialchars($_POST['phone']);
            $email=htmlspecialchars($_POST['email']);
            $subject=htmlspecialchars($_POST['subject']);
            $content=htmlspecialchars($_POST['content']);
            $insert=array(
                'name'=>$name,'adds'=>$adds,'phone'=>$phone,
                'email'=>$email,'fax'=>$subject,'content'=>$content,
                'dates'=>date("Y-m-d H:i:s")
            );
            try{
                $this->send_mail($insert);
                $this->db->insert('contact',$insert);
                if(!$this->post_result){
                    $this->post_result = ' <div class="alert alert-success">
                             <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                             <strong>Thành công!</strong>  Thông tin của Quý Khách đã gửi thành công. Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất!.
                           </div>';
                }
            }catch(Exception $e){
                $this->post_result .= ' <div class="alert alert-warning">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Lỗi!</strong> '. $e->errorInfo() .
                      '</div>'; 
            }
        }
    }
    function contact(){
        $this->contact_insert();
        $this->db->reset();
        $item=$this->db->where('id',3)->getOne('qtext','content');
        $str.='    
        <section id="contact-page">
            <div class="container">';
                if($this->post_result != '')
                {
                    $str.= $this->post_result;
                }
                
                $str.='<div class="text-center">        
                    <h2 class="title">LIÊN HỆ</h2>
                    <p class="lead">Hãy điền thông tin và tin nhắn quý khách, BQT sẽ trả lời sớm nhất có thể.</p>
                </div>  
                <div class="row contact-wrap"> 
                    <div class="status alert alert-success" style="display: none"></div>
                    <form data-toggle="validator" role="form" class="contact-form" name="contact-form" method="post" action="">
                        <div class="col-sm-6">
                            Cảm ơn Quý khách đã truy cập vào website. Mọi thông tin chi tiết xin vui lòng liên hệ:
                            <p>
                                <img src="'.selfPath.'contact.png" class="img-responsive" alt="" title=""/>
                            </p>    
                            <p>
                                '.common::qtext($this->db,3).'
                            </p>       
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Họ Tên *</label>
                                <input type="text" name="name" class="form-control" required/>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label>Email *</label>
                                <input type="email" name="email" class="form-control" required/>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label>Điện Thoại</label>
                                <input type="text" name="phone" class="form-control">
                            </div>   
                            <div class="form-group">
                                <label>Địa Chỉ</label>
                                <input type="text" name="adds" class="form-control">
                            </div>      
                            <div class="form-group">
                                <label>Chủ Đề *</label>
                                <input type="text" name="subject" class="form-control" required/>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label>Nội Dung Tin Nhắn *</label>
                                <textarea name="content" id="message" required class="form-control" rows="8"></textarea>
                                <div class="help-block with-errors"></div>
                            </div>                        
                            <div class="form-group">
                                <button type="submit" name="submit" class="btn btn-primary btn-lg">
                                    Gửi Tin
                                </button>
                                <button type="reset" name="reset" class="btn btn-primary btn-lg">
                                    Xóa
                                </button>
                            </div>
                        </div>
                    </form> 
                </div><!--/.row-->
            </div><!--/.container-->
        </section><!--/#contact-page-->
        <section id="contact-page">
            <div class="gmap-area">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <div class="gmap">'
                                . $this->basic_config['gmap_script']
                            .'</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>  <!--/gmap_area -->';
        return $str;
    }
    function send_mail($item){
       
        //Create a new PHPMailer instance
        //'basic_config','smtp_server, smtp_port, , , , , ,
        $mail = new PHPMailer(); // create a new object
        $mail->IsSMTP(); // enable SMTP
        //$mail->SMTPDebug = 2;
        //Ask for HTML-friendly debug output
        //$mail->Debugoutput = 'html';
        //$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for Gmail        
        //Whether to use SMTP authentication
        $mail->SMTPAuth = true;
        $mail->Host = $this->basic_config['smtp_server'];
        $mail->Port = $this->basic_config['smtp_port']; // or 587
        $mail->IsHTML(true);
        $mail->Username = $this->basic_config['smtp_user'];
        $mail->Password = $this->basic_config['smtp_pwd'];
        $mail->SetFrom($this->basic_config['smtp_user'], $this->basic_config['smtp_sender_name']);
        $mail->AddAddress($this->basic_config['smtp_receiver']);
        $mail->SMTPAutoTLS = false;
        $mail->CharSet = 'UTF-8';
        $mail->Subject =  'Khách hàng liên hệ gửi từ website';
        //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body
        //$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
        //Replace the plain text body with one created manually
        $mail->Body = '
        <html>
        <head>
        	<title>'.$mail->Subject.'</title>
        </head>
        <body>
        	<p>Full Name: '.$item['name'].'</p>
        	
        	<p>Address: '.$item['adds'].'</p>
        	<p>Phone: '.$item['phone'].'</p>        	
        	<p>Email: '.$item['email'].'</p>
                <p>Tiêu Đề: '.$item['subject'].'</p>
        	<p>Content: '.nl2br($item['content']).'</p>
        </body>
        </html>
        ';        
            
        if (!$mail->send()) {
             $this->post_result = ' <div class="alert alert-warning">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Lỗi!</strong> Mailer Error:' . $mail->ErrorInfo.
                      '</div>'; 
        }
    }
     
}
?>
