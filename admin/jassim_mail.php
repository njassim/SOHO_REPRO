<?php
include '../mailer1/class.phpmailer.php';
include './mail_test.php';
$order_id_final = $_SESSION['final_ord_id'];




if (isset($_POST['final_usr_id'])) {
    
    
    function SendMailIndividual($mail_id) {
            $order_id_final = $_SESSION['final_ord_id'];
            $reference_val = ReferenceForInvoice($order_id_final);
            $mail = new PHPMailer(true); //defaults to using php "mail()"; the true param means it will throw exceptions on errors, which we need to catch
            $mail->AddAddress($mail_id, $mail_id);
            $mail->SetFrom('noreply@sohorepro.com', 'Soho Repro');
            $mail->Subject = 'Soho Repro Order ' .$reference_val;
            $mail->MsgHTML(file_get_contents('./cart_invoice_tmpl/invoice_'.$order_id_final.'.html'));
            $sent_result = $mail->Send();
            if ($sent_result) {
                return '1';
            } else {
                return '0';
            }
        }
    
    
    
    $final_html     =       $primary_mail_var;
    $final_comp_id  =       $_POST['final_order_id'];
    $final_usr_id   =       $_POST['final_usr_id'];
    $company_name   =       getCompName($_SESSION['sohorepro_companyid']);
    $mail_id        =       getActiveEmailOrder();
    
    $my_file = 'cart_invoice_tmpl/invoice_'.$order_id_final.'.html';
    $handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file); //implicitly creates file
    
    $my_file_open = 'cart_invoice_tmpl/invoice_'.$order_id_final.'.html';
    $handle_new = fopen($my_file_open, 'w') or die('Cannot open file:  '.$my_file);    
    fwrite($handle_new, $final_html);


    $user_mail              = array('email_id' => UserMail($final_usr_id));
//$customer_email = CompanyMail($company_id);
    $customer_email = array('email_id' => CompanyMail($final_comp_id));
    array_push($mail_id, $user_mail, $customer_email);


    foreach ($mail_id as $mails_sent) {
        $pre_filt[] = $mails_sent['email_id'];
    }

    $final_list = array_unique($pre_filt);

    foreach ($final_list as $to) {
        $subject = "Soho Repro Order " . $company_name;
        $headers = 'From: "SohoRepro" <noreply@sohorepro.com>' . "\r\n";
        $headers .= 'MIME-Version: 1.0' . "\n";
        $headers .= 'Content-Type: text/html; charset=utf-8\r\n' . "X-Mailer: PHP";
        $headers .= 'Content-Transfer-Encoding: 8bit\r\n\r\n';
        $result = mail($to, stripslashes($subject), stripslashes($final_html), $headers);
    }

//     foreach ($final_list as $to) {
//            $result = SendMailIndividual($to);
//        }
    
//mail($user_mail, $subject, $message, $headers);
//mail($customer_email, $subject, $message, $headers);
    if ($result == TRUE) {
        echo '1';
    } else {
        echo '0';
    }
}