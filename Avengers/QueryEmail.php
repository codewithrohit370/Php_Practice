<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    $config = require __DIR__ . '/config.php';

    require 'vendor/autoload.php';

    if(isset($_POST['submit-btn'])){

    $name = trim($_POST['member_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $query = trim($_POST['Query'] ?? '');

    if (empty($name) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($query)) {
        echo "Please enter valid details.";
    exit;
    }

    $mail = new PHPMailer(true);

try {
    // $mail->SMTPDebug = 2;                                       
    $mail->isSMTP();                                            
    $mail->Host       = $config['smtp_host'];                    
    $mail->SMTPAuth   = true;                             
    $mail->Username   = $config['smtp_username'];                 
    $mail->Password   = $config['smtp_password'];                        
    $mail->SMTPSecure = 'tls';                              
    $mail->Port       = 587;  

    $mail->setFrom('rohitbgmi370@gmail.com', 'Guild Avangers');           
    $mail->addAddress($email, $name);
     
    $mail->isHTML(true);                                  
    $mail->Subject = 'We Received Your Query | Avengers Guild';

    $mail->Body = '
        <div style="margin:0;padding:30px 10px;background:#f1f3f6;font-family:Arial,sans-serif;">

            <div style="max-width:600px;margin:auto;background:#ffffff;border-radius:12px;overflow:hidden;">

                <div style="background:#171717;padding:30px;text-align:center;border-bottom:4px solid #d4a72c;">

                    <h1 style="color:#f5c542;margin:0;letter-spacing:3px;">
                        AVENGERS
                    </h1>

                    <p style="color:#d1d5db;font-size:13px;">
                        GUILD SUPPORT CENTER
                    </p>

                </div>

                <div style="padding:35px 30px;color:#333;">

                    <h2 style="color:#222;">Query Received!</h2>

                    <p>Hello <strong>'.$name.'</strong>,</p>

                    <p style="line-height:1.8;">
                        Thank you for contacting
                        <strong style="color:#b8860b;">Avengers Guild</strong>.
                    </p>

                    <p style="line-height:1.8;">
                        We have successfully received your query.
                        Our team will review your message and get back
                        to you as soon as possible.
                    </p>

                    <div style="background:#fff9e8;border:1px solid #f0d98b;
                    padding:20px;border-radius:8px;margin:25px 0;">

                        <h3 style="color:#8a6508;margin-top:0;">
                            WHAT HAPPENS NEXT?
                        </h3>

                        <h2 style="color:#222;margin-bottom:10px;">
                            4–6 Hours
                        </h2>

                        <p style="line-height:1.7;margin-bottom:0;">
                            Our team will review your query and reply
                            to your email within 4–6 hours.
                        </p>

                    </div>

                    <p style="line-height:1.8;">
                        Please keep an eye on your inbox for our response.
                    </p>

                    <p style="margin-top:25px;line-height:1.8;">
                        Best regards,<br>
                        <strong style="color:#b8860b;">
                            Avengers Guild Support Team
                        </strong>
                    </p>

                </div>

                <div style="background:#171717;padding:20px;text-align:center;">

                    <p style="color:#f5c542;font-weight:bold;">
                        AVENGERS GUILD
                    </p>

                    <p style="color:#b0b0b0;font-size:12px;">
                        United as one. Stronger together.
                    </p>

                </div>

            </div>
        </div>';

    $mail->AltBody = "Hello $name,

        Thank you for contacting Avengers Guild.

        We have successfully received your query.

        Our team will review your message and reply within 4-6 hours.

        Best regards,
        Avengers Guild Support Team";
    $mail->send();
    // Send notification to Admin
    $adminMail = new PHPMailer(true);

    try {

    $adminMail->isSMTP();
    $adminMail->Host       = $config['smtp_host'];
    $adminMail->SMTPAuth   = true;
    $adminMail->Username   = $config['smtp_username'];
    $adminMail->Password   = $config['smtp_password'];
    $adminMail->SMTPSecure = 'tls';
    $adminMail->Port       = 587;

    $adminMail->setFrom('rohitbgmi370@gmail.com', 'Avengers Guild');
    $adminMail->addAddress('rohitbgmi370@gmail.com', 'Guild Admin');

    $adminMail->isHTML(true);
    $adminMail->Subject = 'New Query Received | Avengers Guild';

    $adminMail->Body = '
    <div style="font-family:Arial;background:#f1f3f6;padding:30px;">

        <div style="max-width:600px;margin:auto;background:white;border-radius:10px;overflow:hidden;">

            <div style="background:#171717;padding:25px;text-align:center;">
                <h1 style="color:#f5c542;">AVENGERS GUILD</h1>
                <p style="color:white;">New Query Notification</p>
            </div>

            <div style="padding:30px;">

                <h2>New Contact Form Submission</h2>

                <p><strong>User Name:</strong> '.htmlspecialchars($name, ENT_QUOTES, 'UTF-8').'</p>

                <p><strong>User Email:</strong> '.htmlspecialchars($email, ENT_QUOTES, 'UTF-8').'</p>

                <hr>

                <h3>User Query:</h3>

                <div style="background:#f5f5f5;padding:20px;border-radius:8px;line-height:1.7;">
                    '.nl2br(htmlspecialchars($query, ENT_QUOTES, 'UTF-8')).'
                </div>

                <p style="margin-top:25px;color:#777;">
                    This email was automatically generated by the Avengers Guild website.
                </p>

            </div>

        </div>

    </div>';

    $adminMail->AltBody = "New Query Received

    User Name: $name
    User Email: $email

    User Query:
    $query";

    $adminMail->send();

    } catch (Exception $e) {
        error_log("Admin notification failed: " . $adminMail->ErrorInfo);
    }

    echo "Mail has been sent successfully!";
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
}
?>