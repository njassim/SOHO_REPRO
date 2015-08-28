<html>
    <head>
        <title>PHPMailer - Mail() advanced test</title>
    </head>
    <body>

        <?php
        require_once './mailer1/class.phpmailer.php';
        include './admin/config.php';

        function SentInvoice($id) {
            $select_company = "SELECT email_id FROM sohorepro_email_invoice_sent WHERE email_id = '" . $id . "'";
            $company = mysql_query($select_company);
            $object = mysql_fetch_assoc($company);
            $catg = $object['email_id'];
            return $catg;
        }

        function SendMailIndividual($mail_id) {
            $mail = new PHPMailer(true); //defaults to using php "mail()"; the true param means it will throw exceptions on errors, which we need to catch
            $mail->AddAddress($mail_id, $mail_id);
            $mail->SetFrom('noreply@sohorepro.com', 'Soho Repro');
            $mail->Subject = 'Test Order Invoice- JASSIM';
            $mail->MsgHTML(file_get_contents('./mailer1/examples/invoice_82.html'));
            $sent_result = $mail->Send();
            if ($sent_result) {
                return '1';
            } else {
                return '0';
            }
        }

//$my_file = 'cart_invoice_tmpl/invoice.html';
//$handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file); //implicitly creates file
//
//
//exit;

        $mail_ids = array('mohamedjassim5@outlook.com', 'jassim.colan@gmail.com');


//echo '<pre>';
//print_r($mail_ids);
//echo '</pre>';
//
//foreach ($mail_ids as $mails){
//    echo 'Mail ID :' .$mails.'<br>';
//}
//
//
//for ($x = 0; $x <= count($mail_ids); $x++) 
//{
//   echo "Mail ID : $mail_ids[$x] <br>";
//}
//
//foreach ($mail_ids as $name){      
//    echo 'Mohame:'.SentInvoice($name).'<br>';
//    if(SentInvoice($name) != $name){
//    echo 'Jassim:'.$name.'<br>';
//    }
//    
//}
//exit;
        foreach ($mail_ids as $name) {

            $result = SendMailIndividual($name);
//            $sql_mail = "INSERT INTO sohorepro_email_invoice_sent
//			SET     email_id = '" . $name . "' ";
//            mysql_query($sql_mail);
        }

        if ($result == TRUE) {
            echo 'Mail Sent';
        } else {
            echo 'Mail Not Sent';
        }
        ?>
    </body>
</html>
