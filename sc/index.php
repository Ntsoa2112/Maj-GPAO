<?php
include_once './PHPMailer-master/class.phpmailer.php';
$message = '';
if (isset($_POST['q5'])) {
    $q1 = "";
    $q2 = "";
    $q3 = "";
    $q4 = "";
    $q5 = "";
    $recommendation = "";
    $suggestion = "";

    if (isset($_POST['q1'])) {
        $q1 = $_POST['q1'];
    }
    if (isset($_POST['q2'])) {
        $q2 = $_POST['q2'];
    }
    if (isset($_POST['q3'])) {
        $q3 = $_POST['q3'];
    }
    if (isset($_POST['q4'])) {
        $q4 = $_POST['q4'];
    }
    if (isset($_POST['q5'])) {
        $q5 = $_POST['q5'];
    }
    if (isset($_POST['recommendation'])) {
        $recommendation = $_POST['recommendation'];
    }
    if (isset($_POST['suggestion'])) {
        $suggestion = $_POST['suggestion'];
    }

	// Test fonction mail();

 

   // *** A configurer

 

   $to    = "stg.dev.jack@et.in";/*florin.freelance@gmail*/

 

   // adresse MAIL OVH li�e � l�h�bergement.

   $from  = "dev@inovcom.fr";

 

   ini_set("SMTP", "ns0.ovh.net");   // Pour les h�bergements mutualis�s Windows de OVH

 

   // *** Laisser tel quel

 

   $JOUR  = date("Y-m-d");

   $HEURE = date("H:i");

 

   $Subject = "Test Mail - $JOUR $HEURE";

 

   $mail_Data = "";

   $mail_Data .= "<html> \n";

   $mail_Data .= "<head> \n";

   $mail_Data .= "<title> Subject </title> \n";

   $mail_Data .= "</head> \n";

   $mail_Data .= "<body> \n";

 

   $mail_Data .= "Mail HTML simple  : <b>$Subject </b> <br> \n";

   $mail_Data .= "<br> \n";

   $mail_Data .= "bla bla <font color=red> bla </font> bla <br> \n";

   $mail_Data .= "Etc.<br> \n";

   $mail_Data .= "</body> \n";

   $mail_Data .= "</HTML> \n";

 

   $headers  = "MIME-Version: 1.0 \n";

   $headers .= "Content-type: text/html; charset=iso-8859-1 \n";

   $headers .= "From: $from  \n";

   $headers .= "Disposition-Notification-To: $from  \n";

 

   // Message de Priorit� haute

   // -------------------------

   $headers .= "X-Priority: 1  \n";

   $headers .= "X-MSMail-Priority: High \n";

 

   $CR_Mail = TRUE;

 

   $CR_Mail = @mail($to, $Subject, $mail_Data, $headers);

 

   if ($CR_Mail === FALSE)

      {

      echo " ### CR_Mail=$CR_Mail - Erreur envoi mail <br> \n";

      }

   else

      {

      echo " *** CR_Mail=$CR_Mail - Mail envoy�<br> \n";

      }
	
	
	
	
	
	
   // echo "$q1.$q2.$q3.$q4.$q5.$recommendation.$suggestion";
	/*require_once('./PHPMailer-master/class.phpmailer.php');
	$mail = new PHPMailer();
	 echo "php mailer check";
	$mail->IsSMTP();
	echo "is smtp check";
	$mail->SMTPAuth = true;
	echo "is SMTPAuth check";
	
	//$mail->Host = "ns0.ovh.net";
	$mail->Host = "10.128.1.3";
	echo "is Host check";
	$mail->Port = 26;
	echo "is Port check";
	$mail->Username = "";
	echo "is Username check";
	$mail->Password = "";
	echo "is Password check";
	$mail->SetFrom('stg.dev.jack@et.in', 'Web App');
	$mail->Subject = 'Suggestion';
	$mail->MsgHTML($suggestion);
	$mail->AddAddress('stg.dev.jack@et.in', 'jack');
	echo "is MsgHTML check";
	if($mail->Send()) {
	  echo "Message sent!";
	} else {
	  echo "Mailer Error: " . $mail->ErrorInfo;
	}*/
	
	//echo "is send check";
//initialisation de l'envoi mail
	//ini_set("SMTP","ns0.ovh.net");
   // ini_set("SMTP", "10.128.1.3");
   // mail('vololoniaina@et.in', 'Suggestion', $suggestion, null, 'vololoniaina@et.in');
//mail('dev@inovcom.fr', 'Suggestion', $suggestion, null,'dev@inovcom.fr');
//mail('stg.dev.jack@et.in', 'Suggestion', $suggestion, null,'stg.dev.jack@et.in');
	/*mail('florin.freelance@gmail.com', 'Suggestion', $suggestion, null,'florin.freelance@gmail.com');*/
   /* $message = "votre message a �t� envoy�";
	ini_set('sendmail_from', 'dev@inovcom.fr'); 
	
	$Name = "DEV Externe"; //senders name
	$email = "dev@inovcom.fr"; //senders e-mail adress
	$recipient = "stg.dev.jack@et.in"; //recipient
	$mail_body = $suggestion; //mail body
	$subject = 'Suggestion'; //subject
	$header = "From: ". $Name . " <" . $email . ">\r\n"; //optional headerfields

	mail($recipient, $subject, $mail_body, $header); //mail command :) */
	
}
?>

<!DOCTYPE html>
<html style="" class=" js no-touch cssanimations csstransforms csstransforms3d csstransitions cssfilters mobile-false js csstransitions js_active  vc_desktop  vc_transform " prefix="og: http://ogp.me/ns#" lang="fr-FR"><!--<![endif]--><head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <title>Satisfaction Client | Inovcom</title>
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <link rel="pingback" href="http://inovcom.fr/xmlrpc.php">
        <!--[if IE]>
        <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <!-- icon -->
        <link rel="icon" href="http://inovcom.fr/wp-content/uploads/2015/04/favicon16-01.png" type="image/png">
        <link rel="shortcut icon" href="http://inovcom.fr/wp-content/uploads/2015/04/favicon16-01.png" type="image/png">
        <link rel="apple-touch-icon" href="http://inovcom.fr/wp-content/uploads/2015/04/iconoldiphone-01.png"><link rel="apple-touch-icon" sizes="76x76" href="http://inovcom.fr/wp-content/uploads/2015/04/favicon76-01.png"><link rel="apple-touch-icon" sizes="120x120" href="http://inovcom.fr/wp-content/uploads/2015/04/icon120-01.png"><link rel="apple-touch-icon" sizes="152x152" href="http://inovcom.fr/wp-content/uploads/2015/04/icon156-01.png">	
        <!-- This site is optimized with the Yoast WordPress SEO plugin v2.1.1 - https://yoast.com/wordpress/plugins/seo/ -->
        <meta name="description" content="Inovcom intervient dans tous les domaines relatifs à l'ingénierie documentaire. Notre gamme de services et solutions nous permet de couvrir tout type de...">
        <link rel="canonical" href="http://inovcom.fr/qui-sommes-nous/">
        <meta property="og:locale" content="fr_FR">
        <meta property="og:type" content="article">
        <meta property="og:title" content="Qui sommes nous | Inovcom">
        <meta property="og:description" content="Inovcom intervient dans tous les domaines relatifs à l'ingénierie documentaire. Notre gamme de services et solutions nous permet de couvrir tout type de...">
        <meta property="og:url" content="http://inovcom.fr/qui-sommes-nous/">
        <meta property="og:site_name" content="Inovcom">
        <!-- / Yoast WordPress SEO plugin. -->

        <link rel="alternate" type="application/rss+xml" title="Inovcom » Flux" href="http://inovcom.fr/feed/">
        <link rel="alternate" type="application/rss+xml" title="Inovcom » Flux des commentaires" href="http://inovcom.fr/comments/feed/">
        <link rel="alternate" type="application/rss+xml" title="Inovcom » Qui sommes nous Flux des commentaires" href="http://inovcom.fr/qui-sommes-nous/feed/">
        <style type="text/css">
            img.wp-smiley,
            img.emoji {
                display: inline !important;
                border: none !important;
                box-shadow: none !important;
                height: 1em !important;
                width: 1em !important;
                margin: 0 .07em !important;
                vertical-align: -0.1em !important;
                background: none !important;
                padding: 0 !important;
            }
        </style>

        <link rel="stylesheet" id="rs-plugin-settings-css" href="css/settings.css" type="text/css" media="all">
        <link rel="stylesheet" id="layerslider-css" href="css/new-style.css" type="text/css" media="all">
        <style id="rs-plugin-settings-inline-css" type="text/css">
            .tp-caption a{color:#ff7302;text-shadow:none;-webkit-transition:all 0.2s ease-out;-moz-transition:all 0.2s ease-out;-o-transition:all 0.2s ease-out;-ms-transition:all 0.2s ease-out}.tp-caption a:hover{color:#ffa902}
        </style>
        <link rel="stylesheet" id="dt-main-css" href="css/main.css" type="text/css" media="all">

        <link rel="stylesheet" id="dt-awsome-fonts-css" href="css/font-awesome.css" type="text/css" media="all">
        <link rel="stylesheet" id="dt-fontello-css" href="css/fontello.css" type="text/css" media="all">
        <link rel="stylesheet" id="dt-main.less-css" href="css/main-a427b5f049.css" type="text/css" media="all">
        <link rel="stylesheet" id="dt-custom.less-css" href="css/custom-a427b5f049.css" type="text/css" media="all">
        <link rel="alternate" hreflang="en" href="http://inovcom.fr/qui-sommes-nous/?lang=en">		
        <style>/** Ultimate: Media Responsive **/ @media (max-width: 1199px) { }@media (max-width: 991px)  { }@media (max-width: 767px)  { }@media (max-width: 479px)  { }/** Ultimate: Media Responsive - **/</style></head>

    <body class="page page-id-6 page-template-default rollover-show-icon boxed-layout accent-gradient srcset-enabled btn-flat style-ios phantom-fade wpb-js-composer js-comp-ver-4.4.2 vc_responsive no-mobile not-webkit"><svg id="svg-source" height="0" version="1.1" xmlns="http://www.w3.org/2000/svg" style="position:absolute; margin-left: -100%" xlink="http://www.w3.org/1999/xlink"><g id="social-500px"><path d="M11.969 13.544c1.137 1.3 2.5 2.5 4.3 2.467c2.364 0 3.775-1.795 3.775-4.08 c0-2.279-1.438-3.973-3.756-3.973c-1.848 0-3.059 1.202-4.232 2.621c-1.201-1.44-2.393-2.621-4.279-2.621 C5.477 8 4 9.7 4 12.005c0 2.3 1.6 4 3.8 4.037c1.93-0.08 2.977-1.325 4.117-2.498H11.969z M5.715 12 c0-1.011 0.656-2.114 1.865-2.114c1.233 0 2.5 1.3 3.4 2.137c-0.82 0.957-2.015 1.99-3.265 2 c-1.285-0.021-1.974-0.842-1.974-2.013H5.715z M13.146 12.099c0.867-0.94 1.941-2.123 3.219-2.123c1.246 0 2 0.9 2 2.1 c0 1.104-0.645 2.025-1.876 1.973c-1.333 0.049-2.469-0.879-3.282-1.898L13.146 12.099z"></path></g>,<g id="vk"><path d="M12.235 16.191c0.372 0 0.524-0.248 0.516-0.56c-0.017-1.17 0.438-1.797 1.258-0.978 c0.908 0.9 1.1 1.5 2.1 1.502c0.418 0 1.5 0 1.9 0c1.528 0 0.166-1.54-0.916-2.54c-1.024-0.952-1.071-0.979-0.189-2.123 c1.102-1.425 2.535-3.26 1.266-3.26c-0.246 0-0.072 0-2.428 0c-0.471 0-0.501 0.277-0.672 0.7 c-0.604 1.429-1.758 3.28-2.195 3.001c-0.46-0.295-0.248-1.3-0.213-3.038c0.014-0.459 0.01-0.774-0.694-0.94 c-1.92-0.447-3.578 0.431-2.9 0.537c0.954 0.2 0.9 2 0.6 2.98c-0.387 1.558-1.851-1.235-2.457-2.623 C7.25 8.5 7.2 8.3 6.7 8.277c-0.29 0-1.558 0-1.986 0c-0.382 0-0.569 0.177-0.434 0.531c0.133 0.3 1.7 3.8 3.4 5.8 c1.718 1.7 3.4 1.6 4.6 1.597H12.235L12.235 16.191z"></path></g>,<g id="tripedvisor"><path fill="none" d="M15.825 9.215c-1.584 0-2.873 1.291-2.873 2.874c0 1.6 1.3 2.9 2.9 2.876s2.873-1.292 2.873-2.876 C18.698 10.5 17.4 9.2 15.8 9.215z M15.879 13.729c-0.423 0-0.82-0.164-1.118-0.464c-0.299-0.301-0.465-0.697-0.465-1.121 c0-0.421 0.166-0.818 0.465-1.119c0.298-0.298 0.695-0.461 1.118-0.461c0.873 0 1.6 0.7 1.6 1.6 C17.464 13 16.8 13.7 15.9 13.729z"></path><path fill="none" d="M8.26 9.251c-1.592 0-2.887 1.296-2.887 2.888c0 1.6 1.3 2.9 2.9 2.9 c1.591 0 2.886-1.299 2.886-2.887C11.146 10.5 9.9 9.3 8.3 9.251z M8.253 13.706c-0.421 0-0.816-0.163-1.113-0.461 c-0.3-0.296-0.462-0.691-0.462-1.114c0-0.419 0.164-0.814 0.462-1.113c0.297-0.296 0.693-0.457 1.113-0.462 c0.87 0 1.6 0.7 1.6 1.574S9.123 13.7 8.3 13.706z"></path><path d="M8.253 10.556c-0.42 0.005-0.816 0.166-1.113 0.463c-0.299 0.299-0.462 0.694-0.462 1.113c0 0.4 0.2 0.8 0.5 1.1 c0.297 0.3 0.7 0.5 1.1 0.461c0.87 0 1.576-0.708 1.576-1.577S9.123 10.6 8.3 10.556z"></path><path d="M15.879 10.563c-0.423 0-0.82 0.163-1.118 0.461c-0.299 0.301-0.465 0.698-0.465 1.119c0 0.4 0.2 0.8 0.5 1.1 c0.298 0.3 0.7 0.5 1.1 0.464c0.873 0 1.585-0.708 1.585-1.582S16.752 10.6 15.9 10.563z"></path><path d="M20.172 8.047l-3.177 0.365c-0.042-0.013-0.085-0.021-0.127-0.034c-0.138-0.216-1.087-1.44-4.881-1.44 c-4.164 0-4.9 1.475-4.9 1.475l-3.165-0.35c0.339 0.3 1 1.3 1.1 1.733c-0.49 0.649-0.867 1.475-0.859 2.4 c0.016 1.8 0.7 3.9 3.7 4.338c1.375-0.019 2.048-0.344 3.064-1.133l1.109 2.461l1.169-2.439 c0.776 0.6 1.2 1 2.6 1.096c3.047-0.125 3.981-2.578 4.029-4.321c0.002-0.933-0.238-1.729-0.781-2.396 C19.256 9.3 19.9 8.4 20.2 8.047z M8.26 15.025c-1.592 0-2.887-1.299-2.887-2.887c0-1.592 1.295-2.888 2.887-2.888 c1.591 0 2.9 1.3 2.9 2.888C11.146 13.7 9.9 15 8.3 15.025z M15.825 14.965c-1.584 0-2.873-1.29-2.873-2.876 c0-1.583 1.289-2.874 2.873-2.874c1.586 0 2.9 1.3 2.9 2.874C18.698 13.7 17.4 15 15.8 14.965z"></path></g>,<g id="foursquare"><path d="M18.511 13.164l-5.351 5.353c-0.643 0.641-1.688 0.641-2.326 0L5.48 13.164c-0.639-0.645-0.639-1.688 0-2.329l5.354-5.354 c0.638-0.638 1.685-0.638 2.3 0l2.417 2.418l-3.631 3.631l-1.707-1.712c-0.239-0.24-0.57-0.377-0.907-0.377 c-0.339 0-0.667 0.137-0.907 0.375l-1.096 1.094c-0.243 0.243-0.378 0.565-0.378 0.909c0 0.3 0.1 0.7 0.4 0.906l3.707 3.7 c0.167 0.2 0.4 0.3 0.6 0.34l0.053 0.035l0.25 0.002c0.341 0 0.666-0.134 0.905-0.376l5.636-5.635h0.023 c0.689 0.7 0.7 1.6 0.1 2.333L18.511 13.164L18.511 13.164z"></path><path d="M18.571 9.409l-6.367 6.373c-0.085 0.079-0.196 0.129-0.315 0.129l0 0c-0.002 0-0.002 0-0.004 0 c-0.017 0-0.034-0.002-0.048-0.005c-0.101-0.012-0.192-0.057-0.262-0.124l-3.547-3.558c-0.173-0.171-0.171-0.452 0-0.622 l1.049-1.048c0.083-0.081 0.195-0.128 0.311-0.129c0.117 0 0.2 0.1 0.3 0.131l2.191 2.195l5.009-5.009 c0.083-0.084 0.193-0.13 0.312-0.13c0.117 0 0.2 0 0.3 0.13l1.045 1.049c0.221 0.1 0.2 0.4 0.1 0.619L18.571 9.4 L18.571 9.409z"></path></g>,<g id="website"><path d="M8.639 10.095c0.251-0.252 0.53-0.46 0.827-0.625c1.654-0.912 3.778-0.425 4.8 1.187l-1.287 1.3 c-0.371-0.844-1.288-1.323-2.198-1.118c-0.342 0.077-0.67 0.249-0.936 0.512l-2.468 2.467c-0.75 0.748-0.75 2 0 2.7 c0.75 0.8 2 0.8 2.7 0l0.762-0.76c0.689 0.2 1.4 0.3 2.2 0.324l-1.679 1.682c-1.439 1.438-3.771 1.438-5.211 0 c-1.439-1.438-1.439-3.771 0-5.211L8.639 10.095z M12.557 6.177l-1.681 1.677c0.732-0.054 1.4 0.1 2.2 0.331l0.764-0.761 c0.75-0.749 1.97-0.749 2.7 0c0.75 0.8 0.8 2 0 2.717l-2.465 2.466c-0.753 0.752-1.974 0.744-2.719 0 c-0.173-0.174-0.323-0.393-0.417-0.604l-1.287 1.284c0.136 0.2 0.3 0.4 0.4 0.562c0.465 0.4 1.1 0.8 1.8 1 c0.882 0.2 1.9 0.1 2.644-0.354c0.298-0.16 0.577-0.369 0.828-0.621l2.47-2.465c1.437-1.439 1.437-3.773 0-5.21 c-1.479-1.438-3.761-1.438-5.292-0.008L12.557 6.177L12.557 6.177z"></path></g>,<g id="mail"><path d="M5 6.984v10.031h0.012h13.954H19V6.984H5z M17.414 8.134l-5.416 4.012L6.586 8.134H17.414 z M6.188 9.289l2.902 2.151L6.188 14.25V9.289z M6.2 15.864l3.842-3.719l1.957 1.45l1.946-1.442l3.834 3.712L6.2 15.864L6.2 15.864z M17.812 14.271l-2.916-2.824l2.916-2.159V14.271z"></path></g>,<g id="behance"><path d="M11.429 8.664c0.27 0.4 0.4 0.8 0.4 1.385c0 0.554-0.138 0.999-0.407 1.3 c-0.152 0.188-0.374 0.36-0.671 0.499c0.45 0.2 0.8 0.4 1 0.804c0.229 0.4 0.3 0.8 0.3 1.3 c0 0.535-0.133 1.021-0.39 1.397c-0.164 0.282-0.374 0.522-0.62 0.722c-0.282 0.217-0.61 0.363-0.992 0.5 c-0.381 0.076-0.794 0.128-1.236 0.128H4.836V7.694H9.07c1.156-0.03 1.9 0.4 2.4 0.97H11.429z M6.686 9.345v2.015h2.145 c0.382 0 0.694-0.078 0.931-0.227c0.241-0.149 0.36-0.417 0.36-0.804c0-0.422-0.159-0.707-0.475-0.841 C9.374 9.4 9 9.3 8.6 9.345l-1.92 0.017V9.345z M6.686 12.874v2.438h2.142c0.385 0 0.682-0.055 0.894-0.164 c0.387-0.201 0.581-0.573 0.581-1.137c0-0.479-0.188-0.812-0.563-0.984c-0.209-0.098-0.501-0.146-0.883-0.152L6.686 12.9 L6.686 12.874z M17.494 10.061c0.445 0.2 0.8 0.5 1.1 0.979c0.262 0.4 0.4 0.9 0.5 1.4 c0.041 0.3 0.1 0.7 0.1 1.312h-4.637c0.023 0.7 0.3 1.1 0.7 1.396c0.248 0.2 0.6 0.2 0.9 0.2 c0.383 0 0.688-0.104 0.924-0.309c0.133-0.104 0.188-0.164 0.289-0.354h1.734c-0.041 0.396-0.232 0.688-0.598 1.1 c-0.568 0.646-1.363 0.97-2.396 0.999c-0.848 0-1.596-0.271-2.236-0.812c-0.652-0.543-0.835-1.439-0.835-2.659 c0-1.144 0.147-2.012 0.735-2.621c0.584-0.611 1.344-0.916 2.275-0.916c0.559-0.023 1.1 0.1 1.5 0.293L17.494 10.061z M14.811 11.632c-0.232 0.256-0.328 0.775-0.391 1.198l3.064 0.034c-0.033-0.468-0.074-0.964-0.412-1.413 c-0.271-0.244-0.752-0.295-1.156-0.295c-0.438 0.003-0.818 0.203-1.113 0.477L14.811 11.632L14.811 11.632z M18.586 7.207h-4.707 v1.584h4.707V7.207z"></path></g>,<g id="stumbleupon"><path d="M12.719 10.35l0.917 0.499l1.456-0.477v-0.96c0-1.656-1.422-2.944-3.11-2.944 c-1.687 0-3.116 1.205-3.116 2.949c0 1.7 0 4.4 0 4.384c0 0.401-0.332 0.723-0.738 0.723c-0.409 0-0.74-0.318-0.74-0.723v-1.855 H5v1.896c0 1.7 1.4 3.1 3.2 3.034c1.71 0 3.096-1.336 3.121-2.991V9.517c0-0.396 0.331-0.718 0.74-0.718 c0.407 0 0.7 0.3 0.7 0.718v0.833H12.719z M16.573 11.918v1.943c0 0.396-0.33 0.719-0.738 0.7 c-0.41 0-0.737-0.32-0.737-0.723v-1.906l-1.459 0.478l-0.916-0.499v1.891c0.02 1.7 1.4 3.1 3.2 3.1 c1.719 0 3.117-1.362 3.117-3.032c0-0.025 0-1.887 0-1.887L16.573 11.918L16.573 11.918z"></path></g>,<g id="instagram"><rect x="3" y="3" display="none" opacity="0.7" fill="#27AAE1" enable-background="new    " width="16" height="16"></rect><path d="M15.121 11.582l3.023-0.032v4.181c0 1.334-1.095 2.42-2.437 2.42H8.283c-1.344 0-2.434-1.086-2.434-2.42v-4.173h3.097 c-0.08 0.677-0.096 0.745-0.056 1.052c0.233 1.8 1.8 2.6 3.2 2.652c1.672 0.1 2.703-0.996 3.123-2.927 c-0.045-0.729-0.017 0.085-0.017-0.752L15.121 11.582L15.121 11.582z M8.226 5.851C8.246 5.8 8.3 5.8 8.3 5.85h0.393 M8.279 5.85h7.431c1.343 0 2.4 1.1 2.4 2.421l0.002 2.33h-3.375c-0.527-0.672-1.499-1.71-2.784-1.674 c-1.755 0.048-2.28 1.089-2.663 1.727L5.85 10.56V8.271c0-0.816 0.317-2.02 1.821-2.419 M16.739 7.5 c0-0.191-0.155-0.342-0.345-0.342h-1.166c-0.19 0-0.34 0.15-0.34 0.342v1.181c0 0.2 0.1 0.3 0.3 0.343h1.164 c0.188 0 0.345-0.155 0.345-0.343V7.5l0.037 0.039V7.5z M10.207 12.054c0 1 0.8 1.8 1.8 1.9 c0.986 0 1.788-0.891 1.788-1.88c0-0.983-0.802-1.779-1.789-1.779c-1.029 0.011-1.867 0.823-1.867 1.779H10.207z"></path></g>,<g id="github"><path d="M15.604 5.666c-0.662 0.286-1.369 0.442-2.124 0.472C13 5.9 12.4 5.7 11.8 5.666c-1.562 0-3.112 1.052-3.177 2.8 c-0.047 1.3 0.5 2.2 1.6 2.788c-0.475 0.219-0.664 0.723-0.664 1.217c0 0.5 0.3 1 0.6 1.2 C9.041 14.2 8.4 14.9 8.4 15.889c0 3.2 7 3.3 7.004-0.136c0-1.271-0.875-2.188-3.03-2.538 c-0.852-0.118-1.304-1.413-0.046-1.647c1.803-0.296 3.015-1.998 2.38-3.867c0.269-0.04 0.537-0.105 0.801-0.196l0.097-1.818V5.666 H15.604z M12.002 14.818c0.982-0.02 1.6 0.3 1.6 0.951c0.014 0.674-0.539 0.979-1.482 0.9 c-1.049-0.003-1.643-0.292-1.664-0.986c0.004-0.549 0.484-0.861 1.631-0.902H12.002L12.002 14.818z M11.856 10 c-0.831 0.012-1.212-0.445-1.213-1.329c0-0.806 0.369-1.309 1.194-1.314c0.738-0.003 1.1 0.5 1.1 1.4 C13.041 9.5 12.6 10 11.8 9.98L11.856 9.96z"></path></g>,<g id="skype"><path d="M18.412 12.034c0-3.541-2.889-6.412-6.447-6.412c-0.353 0-0.7 0.028-1.038 0.083c-0.604-0.394-1.323-0.623-2.101-0.623 c-2.124 0-3.846 1.723-3.846 3.847c0 0.8 0.2 1.5 0.6 2.094c-0.053 0.33-0.079 0.667-0.079 1 c0 3.5 2.9 6.4 6.4 6.414c0.402 0 0.795-0.041 1.176-0.107c0.589 0.4 1.3 0.6 2 0.6 c2.126 0 3.849-1.725 3.849-3.848c0-0.803-0.246-1.551-0.668-2.167C18.391 12.6 18.4 12.3 18.4 12.034z M12.568 16.8 c-2.049 0.105-3.007-0.348-3.886-1.172c-0.98-0.918-0.587-1.969 0.213-2.021c0.798-0.053 1.3 0.9 1.7 1.2 c0.427 0.3 2 0.9 2.901-0.104c0.933-1.062-0.621-1.614-1.758-1.782C10.121 12.6 8.1 11.7 8.2 10 c0.159-1.729 1.468-2.617 2.847-2.742c1.757-0.159 2.9 0.3 3.8 1.037c1.046 0.9 0.5 1.89-0.187 2 c-0.664 0.079-1.411-1.468-2.874-1.49c-1.509-0.022-2.528 1.571-0.665 2.024c1.861 0.5 3.9 0.6 4.6 2.3 C16.455 14.8 14.6 16.7 12.6 16.76z"></path></g>,<g id="devian"><path d="M11.747 10.649c2.892-0.069 5.2 1.4 5.6 3.778l-2.893 0.058l-0.02-1.923c-0.629-0.337-0.83-0.45-1.492-0.523 l-0.035 3.913H20c-0.374-3.838-3.814-6.841-8.001-6.841c-0.073 0-0.146 0-0.216 0.001L11.8 7.1 c-0.66-0.056-1.126 0.276-1.757 0.629l-0.012 1.624C6.868 10.1 4.3 12.8 4 15.95h7.785v-5.301H11.747z M10.072 14.4 l-3.359 0.086c0.262-1.62 1.974-3.136 3.333-3.597L10.072 14.37z"></path></g>,<g id="pinterest"><path d="M8.317 13.361c0.703-1.242-0.227-1.515-0.372-2.416c-0.596-3.68 4.244-6.193 6.779-3.622 c1.754 1.8 0.6 7.256-2.229 6.687c-2.71-0.545 1.325-4.901-0.836-5.756c-1.757-0.696-2.689 2.126-1.856 3.5 c-0.489 2.411-1.541 4.682-1.114 7.708c1.381-1.002 1.847-2.924 2.228-4.924c0.695 0.4 1.1 0.9 2 0.9 c3.264 0.3 5.089-3.258 4.641-6.5c-0.396-2.872-3.259-4.335-6.313-3.992c-2.415 0.27-4.822 2.222-4.922 5 C6.211 11.7 6.7 13 8.3 13.361z"></path></g>,<g id="tumbler"><path d="M10.493 5.792c-0.073 0.618-0.211 1.126-0.41 1.526C9.884 7.7 9.6 8.1 9.3 8.35c-0.328 0.289-0.72 0.507-1.18 0.7 v1.71h1.285v4.198c0 0.5 0.1 0.9 0.2 1.252c0.111 0.3 0.3 0.5 0.6 0.828c0.289 0.2 0.6 0.4 1 0.6 c0.412 0.1 0.9 0.2 1.4 0.205c0.47 0 0.911-0.049 1.313-0.146c0.401-0.097 0.858-0.266 1.358-0.508v-1.896 c-0.586 0.396-1.176 0.589-1.771 0.589c-0.335 0-0.63-0.078-0.89-0.235c-0.195-0.117-0.331-0.281-0.405-0.479 c-0.068-0.196-0.106-0.641-0.106-1.336v-3.073h2.784V8.824H12.21V5.792H10.493z"></path></g>,<g id="vimeo"><path d="M17.732 9.417c-0.051 1.179-0.83 2.796-2.342 4.85c-1.561 2.144-2.878 3.215-3.959 3.258c-0.668 0-1.235-0.65-1.697-1.959 c-0.306-1.195-0.617-2.396-0.925-3.587c-0.34-1.373-0.678-1.984-1.085-1.984c-0.086 0-0.386 0.192-0.899 0.571L6.268 9.8 c0.565-0.526 1.15-1.036 1.66-1.576c0.754-0.688 1.321-1.053 1.7-1.088c0.893-0.091 1.4 0.5 1.6 1.9 c0.225 1.5 0.4 2.4 0.5 2.779c0.256 1.2 0.5 1.8 0.8 1.834c0.24 0 0.601-0.402 1.082-1.206 c0.481-0.802 0.739-1.413 0.772-1.834c0.066-0.689-0.188-1.037-0.772-1.037c-0.276 0-0.561 0.065-0.85 0.2 c0.565-1.953 1.645-2.901 3.232-2.846c1.198 0.1 1.8 0.9 1.7 2.447H17.732z"></path></g>,<g id="linkedin"><path d="M9.269 7.02c0 0.714-0.586 1.293-1.307 1.293c-0.722 0-1.307-0.579-1.307-1.293 c0-0.712 0.585-1.291 1.307-1.291C8.683 5.7 9.3 6.3 9.3 7.02H9.269z M9.061 9.279H6.873v7.392h2.188V9.279z M12.91 9.3 h-1.795l-0.027 7.392h2.044c0 0 0-2.742 0-3.879c0-1.04 0.775-1.79 1.7-1.665c0.824 0.1 1.1 0.6 1.1 1.7 c0 1.028-0.021 3.915-0.021 3.89h2.025c0 0 0.025-2.729 0.025-4.708c0-1.981-1.006-2.78-2.604-2.78 c-1.599 0-2.248 1.096-2.248 1.096v-1H12.91z"></path></g>,<g id="lastfm"><path d="M11.217 15.157l-0.538-1.458c0 0-0.87 0.972-2.177 0.972c-1.159 0-1.979-1.009-1.979-2.621c0-2.064 1.04-2.807 2.063-2.807 c1.475 0 1.9 1 2.3 2.185l0.538 1.678c0.535 1.6 1.5 2.9 4.4 2.938c2.082 0 3.488-0.638 3.488-2.318 c0-1.357-0.771-2.063-2.216-2.4l-1.071-0.233c-0.739-0.17-0.953-0.472-0.953-0.973c0-0.572 0.453-0.907 1.188-0.907 c0.808 0 1.2 0.3 1.3 1.023l1.681-0.201c-0.088-1.521-1.174-2.125-2.884-2.135c-1.512 0-2.987 0.571-2.987 2.4 c0 1.1 0.5 1.9 1.9 2.203l1.141 0.27c0.854 0.2 1.1 0.6 1.1 1.042c0 0.624-0.603 0.877-1.739 0.9 c-1.697 0-2.399-0.893-2.802-2.116l-0.555-1.677c-0.702-2.184-1.826-2.99-4.058-2.99c-2.467 0-3.771 1.562-3.771 4.2 c0 2.5 1.3 3.9 3.6 3.93c2.041-0.041 2.903-0.947 2.903-0.94h0.042V15.157z"></path></g>,<g id="forrst"><polygon points="11.404,15.574 9.438,13.961 10.031,13.381 11.404,14.055 11.404,10.815 12.492,10.815 12.492,12.521 14.07,12.043 14.365,12.904 12.596,13.67 12.596,14.715 15.158,13.766 15.548,14.625 12.596,16.053 12.596,17.771 17.913,17.771 12,4.229 6.087,17.771 11.404,17.771 "></polygon></g>,<g id="flickr"><circle cx="8.3" cy="12" r="2.8"></circle><circle cx="15.7" cy="12" r="2.8"></circle></g>,<g id="delicious"><path d="M16.553 6H7.457C6.652 6 6 6.7 6 7.454v9.089c0 0.9 0.6 1.5 1.4 1.455h9.095c0.806 0 1.458-0.651 1.458-1.455 V7.454C18.014 6.7 17.4 6 16.6 6H16.553z M16.906 16.327c0 0.252-0.344 0.605-0.594 0.582H12V12H7.219L7.188 7.8 c0-0.251 0.407-0.646 0.656-0.646H12v4.844h4.938L16.906 16.327L16.906 16.327z"></path></g>,<g id="rss"><path d="M9.258 16.374c0 0.894-0.728 1.62-1.625 1.62s-1.625-0.729-1.625-1.62c0-0.896 0.729-1.618 1.625-1.618 c0.898-0.027 1.7 0.7 1.7 1.618H9.258z M6.007 10.099v2.4c3.026 0 5.4 2.5 5.6 5.496h2.408 c-0.075-4.356-3.594-7.841-7.949-7.896H6.007z M6.007 8.419c2.556 0 5 1 6.8 2.812c1.812 1.9 2.8 4.2 2.8 6.751H18 C17.982 11.4 12.6 6 6 6.005L6.007 8.419L6.007 8.419z"></path></g>,<g id="you-tube"><path d="M18.877 9.35c-0.22-1.924-0.96-2.189-2.438-2.292c-2.101-0.147-6.781-0.147-8.88 0C6.084 7.2 5.3 7.4 5.1 9.3 c-0.163 1.429-0.164 3.9 0 5.298c0.22 1.9 1 2.2 2.4 2.294c2.099 0.1 6.8 0.1 8.9 0 c1.477-0.104 2.217-0.369 2.437-2.294C19.041 13.2 19 10.8 18.9 9.35z M9.69 15.335v-6.65l5.623 3.324L9.69 15.335z"></path></g>,<g id="dribbble"><path d="M12.012 5C8.139 5 5 8.1 5 12c0 3.8 3.1 7 7 7C15.861 19 19 15.9 19 12c0.025-3.857-3.075-7-7.012-7H12.012 z M17.787 11.674c-1.506-0.246-2.889-0.259-4.15-0.043c-0.145-0.329-0.291-0.656-0.447-0.979c1.352-0.583 2.438-1.376 3.244-2.378 c0.787 1 1.3 2.1 1.4 3.401L17.787 11.674L17.787 11.674z M15.54 7.456c-0.701 0.907-1.671 1.624-2.91 2.1 c-0.595-1.086-1.273-2.143-2.038-3.173c0.455-0.115 0.928-0.185 1.42-0.185c1.331-0.066 2.5 0.4 3.5 1.18L15.54 7.456z M9.398 6.847c0.779 1 1.5 2.1 2.1 3.138c-1.419 0.418-3.115 0.631-5.073 0.688c0.405-1.743 1.56-3.118 3.037-3.826H9.398 z M6.217 12c0-0.052 0.007-0.1 0.01-0.151c2.247-0.004 4.187-0.263 5.812-0.771c0.136 0.3 0.3 0.6 0.4 0.8 c-1.975 0.615-3.603 1.877-4.868 3.781C6.725 14.7 6.2 13.4 6.2 12H6.217z M8.458 16.6 c1.15-1.799 2.619-2.971 4.437-3.512c0.543 1.4 1 2.8 1.2 4.354c-0.646 0.246-1.348 0.39-2.077 0.4 c-1.329-0.055-2.571-0.546-3.555-1.273L8.458 16.593z M15.229 16.807c-0.258-1.371-0.636-2.716-1.121-4.021 c1.094-0.157 2.305-0.112 3.6 0.112c-0.273 1.634-1.23 3.009-2.516 3.908H15.229L15.229 16.807z"></path></g>,<g id="google"><path d="M19.02 10.145h-1.953l0.021 1.958h-1.344l-0.021-1.937l-1.854-0.019l-0.023-1.258l1.896-0.008V6.864h1.343V8.86 l1.938 0.042v1.243H19.02z M13.254 15.303c0 1.217-1.107 2.698-3.899 2.698c-2.043 0-3.748-0.884-3.748-2.364 c0-1.146 0.725-2.624 4.107-2.624c-0.5-0.412-0.625-0.985-0.318-1.604c-1.98 0-2.995-1.166-2.995-2.645 c0-1.447 1.076-2.762 3.271-2.762c0.557 0 3.5 0 3.5 0l-0.809 0.823h-0.923c0.651 0.4 1 1.1 1 2 c0 0.778-0.427 1.407-1.036 1.874c-1.085 0.838-0.807 1.4 0.3 2.133c1.091 0.8 1.5 1.5 1.5 2.48L13.254 15.3 L13.254 15.303z M10.863 8.771C10.712 7.8 10 7.1 9.1 7.068c-0.872-0.021-1.457 0.687-1.307 1.6 c0.151 0.9 0.9 1.6 1.9 1.562c0.848 0.1 1.305-0.531 1.201-1.458L10.863 8.771z M11.544 15.5 c0-0.707-0.78-1.379-2.087-1.379c-1.178-0.017-2.179 0.615-2.179 1.354c0 0.7 0.8 1.4 2 1.4 c1.56-0.031 2.338-0.553 2.338-1.334H11.544z"></path></g>,<g id="twitter"><path d="M18.614 6.604c-0.556 0.325-1.171 0.561-1.822 0.688c-0.526-0.551-1.271-0.896-2.099-0.896 c-1.586 0-2.875 1.269-2.875 2.83c0 0.2 0 0.4 0.1 0.646c-2.385-0.119-4.5-1.247-5.916-2.959 C5.729 7.3 5.6 7.8 5.6 8.336c0 1 0.5 1.9 1.3 2.354c-0.47-0.014-0.912-0.141-1.3-0.354c0 0 0 0 0 0 c0 1.4 1 2.5 2.3 2.774c-0.241 0.062-0.495 0.102-0.756 0.102c-0.186 0-0.365-0.02-0.541-0.055 c0.365 1.1 1.4 1.9 2.7 1.971c-0.982 0.756-2.222 1.208-3.567 1.208c-0.232 0-0.461-0.016-0.686-0.04 c1.271 0.8 2.8 1.3 4.4 1.272c5.286 0 8.171-4.312 8.171-8.055c0-0.123-0.003-0.246-0.009-0.367 C18.127 8.8 18.6 8.3 19 7.72c-0.516 0.225-1.068 0.378-1.648 0.446C17.943 7.8 18.4 7.3 18.6 6.604z"></path></g>,<g id="facebook"><path d="M14.545 11.521l-1.74 0.002l0.052 6.648h-2.453l0.014-6.648H8.824V9.421h1.592l-0.001-1.236 c0-1.713 0.485-2.756 2.592-2.756h1.758V7.53h-1.098c-0.824 0-0.863 0.293-0.863 0.84l-0.004 1.051h1.975L14.545 11.521z"></path></g>,<g id="xing"><polygon points="18.2,5 15.3,5 10.6,13.4 13.7,19 16.6,19 13.4,13.4"></polygon><polygon points="9.5,7.6 6.6,7.6 8.2,10.3 5.8,14.6 8.7,14.6 11.2,10.3"></polygon></g>,<g id="odnoklassniki"><path d="M12.001 12.212c1.819 0 3.299-1.542 3.299-3.442c0-1.897-1.479-3.442-3.299-3.442c-1.822 0-3.302 1.544-3.302 3.4 C8.699 10.7 10.2 12.2 12 12.212z M12.001 7.346c0.753 0 1.4 0.6 1.4 1.424c0 0.788-0.612 1.426-1.365 1.4 s-1.367-0.638-1.367-1.426C10.634 8 11.2 7.3 12 7.346z"></path><path d="M15.557 12.802c-0.285-0.47-0.883-0.613-1.334-0.315c-1.353 0.888-3.094 0.886-4.444 0 c-0.454-0.298-1.049-0.155-1.333 0.315c-0.286 0.473-0.149 1.1 0.3 1.393c0.597 0.4 1.2 0.7 1.9 0.826l-1.847 1.9 c-0.376 0.393-0.376 1 0 1.426c0.19 0.2 0.4 0.3 0.7 0.295c0.25 0 0.498-0.101 0.685-0.295l1.815-1.894l1.812 1.9 c0.377 0.4 1 0.4 1.4 0c0.379-0.396 0.379-1.033 0-1.426l-1.849-1.929c0.675-0.156 1.319-0.437 1.918-0.826 C15.704 13.9 15.8 13.3 15.6 12.802z"></path></g>,<g id="weibo"><path fill="none" d="M10.852 10.982c-0.188 0.001-0.379 0.012-0.571 0.03c-2.466 0.231-4.341 1.763-4.188 3.4 c0.153 1.7 2.3 2.8 4.7 2.582c2.469-0.23 4.344-1.766 4.188-3.42C14.884 12.1 13.1 11 10.9 10.982z M11.108 16.211c-1.224 0.528-2.753 0.096-3.123-0.938c-0.37-1.034 0.026-2.414 1.641-2.95c0.216-0.071 0.472-0.111 0.736-0.112 c0.795 0 1.7 0.3 2.1 1.232C12.883 14.4 12.3 15.7 11.1 16.211z"></path><path fill="none" d="M10.749 13.609c-0.063 0-0.129 0.016-0.192 0.048c-0.169 0.091-0.25 0.274-0.181 0.4 c0.067 0.1 0.3 0.2 0.4 0.086c0.169-0.092 0.251-0.274 0.182-0.41C10.943 13.7 10.9 13.6 10.7 13.609z"></path><path fill="none" d="M9.57 13.982c-0.158 0-0.328 0.043-0.494 0.14c-0.443 0.257-0.518 0.696-0.329 1.1 c0.133 0.3 0.7 0.4 1.1 0.14c0.443-0.258 0.483-0.799 0.309-1.08C10.059 14.1 9.8 14 9.6 13.982z"></path><path d="M16.672 10.558c0.605 0.2 0.823-0.293 0.791-1.008c-0.023-0.497-0.229-0.817-0.35-1.026 c-0.319-0.541-0.963-0.885-1.555-0.893c-0.109-0.001-0.218 0.008-0.32 0.031c-0.283 0.061-0.624 0.182-0.494 0.7 c0.143 0.5 0.9 0.2 1.3 0.427s0.374 0.4 0.4 0.714C16.499 9.9 16.2 10.4 16.7 10.558z"></path><path d="M19.473 9.129c-0.088-1.024-0.719-2.061-1.505-2.708c-0.653-0.54-1.608-0.859-2.464-0.864 c-0.122 0-0.242 0.006-0.359 0.019c-0.463 0.049-0.938 0.153-0.945 0.692c-0.012 0.5 0.4 0.6 0.6 0.6 c0.859-0.037 1.621-0.222 2.6 0.649c0.574 0.5 1 1.5 0.9 2.076c-0.168 1.098-0.326 1.5 0.2 1.7 C19.574 11.6 19.5 9.9 19.5 9.129z"></path><path d="M10.362 12.211c-0.266 0.001-0.52 0.04-0.736 0.112c-1.615 0.536-2.011 1.916-1.641 3 c0.37 1 1.9 1.5 3.1 0.938c1.223-0.529 1.774-1.787 1.344-2.768C12.063 12.6 11.2 12.2 10.4 12.211z M9.858 15.354c-0.442 0.256-0.979 0.144-1.111-0.14c-0.189-0.396-0.112-0.835 0.329-1.092c0.165-0.097 0.336-0.14 0.493-0.14 c0.263 0 0.5 0.1 0.6 0.291C10.34 14.6 10.3 15.1 9.9 15.354z"></path><path d="M15.493 11.402c-0.163-0.054 0.651-1.638-0.241-2.087c-1.504-0.756-3.555 0.668-3.464 0.3 c0.168-0.719 0.526-2.196-0.743-2.264c-0.087-0.009-0.176-0.013-0.265-0.012c-2.777 0.022-6.688 4.516-6.246 6.9 c0.479 2.6 3.6 3.8 6.7 3.658c2.804 0 6.714-2.161 6.292-4.678C17.516 12.4 16.6 11.8 15.5 11.402z M10.837 17.016c-2.466 0.23-4.589-0.927-4.743-2.582c-0.153-1.657 1.72-3.188 4.188-3.419c0.193-0.019 0.383-0.029 0.571-0.03 c2.212-0.018 4 1.1 4.2 2.615C15.18 15.3 13.3 16.8 10.8 17.016z"></path></g>,<g id="research-gate"><path d="M11.338,16.022c-0.048-0.261-0.078-0.633-0.087-1.129c-0.007-0.49-0.033-0.906-0.07-1.242c-0.039-0.34-0.111-0.614-0.216-0.842c-0.104-0.221-0.252-0.387-0.44-0.501c-0.194-0.119-0.45-0.196-0.772-0.239v-0.027c0.531-0.114,0.922-0.365,1.174-0.758c0.252-0.394,0.377-0.901,0.377-1.522c0-0.808-0.215-1.404-0.651-1.8c-0.435-0.396-1.039-0.591-1.825-0.591H5.358v9.262h1.879v-3.916h0.994c0.384,0,0.66,0.101,0.821,0.312c0.165,0.209,0.253,0.494,0.271,0.856l0.053,1.774c0.007,0.188,0.024,0.357,0.051,0.523c0.024,0.17,0.089,0.318,0.185,0.449h2.057V16.56C11.495,16.463,11.386,16.28,11.338,16.022z M9.062,11.142c-0.244,0.214-0.592,0.317-1.041,0.317H7.237V8.787h0.887c0.869,0,1.302,0.428,1.302,1.285C9.426,10.574,9.306,10.932,9.062,11.142z"></path><path d="M15.606,11.641v1.374h1.235v0.947c0,0.247-0.036,0.467-0.114,0.654c-0.08,0.188-0.177,0.338-0.295,0.458c-0.115,0.125-0.242,0.214-0.38,0.271c-0.131,0.066-0.256,0.096-0.368,0.096c-0.269,0-0.486-0.09-0.656-0.25c-0.174-0.17-0.299-0.414-0.396-0.73c-0.092-0.314-0.155-0.693-0.188-1.141c-0.033-0.446-0.051-0.95-0.051-1.509c0-1.162,0.1-1.991,0.305-2.491c0.193-0.502,0.521-0.753,0.973-0.753c0.193,0,0.357,0.05,0.49,0.147c0.133,0.102,0.246,0.225,0.332,0.376c0.088,0.152,0.148,0.319,0.189,0.506s0.057,0.361,0.057,0.525h1.801c0-0.943-0.225-1.666-0.678-2.172c-0.451-0.507-1.189-0.761-2.217-0.761c-0.601,0-1.103,0.101-1.5,0.302c-0.398,0.196-0.724,0.494-0.965,0.887c-0.242,0.394-0.416,0.885-0.513,1.473c-0.104,0.588-0.151,1.271-0.151,2.047c0,0.808,0.032,1.512,0.104,2.122c0.065,0.606,0.205,1.123,0.409,1.537c0.199,0.413,0.486,0.729,0.847,0.938c0.358,0.214,0.834,0.317,1.403,0.317c0.439,0,0.822-0.078,1.142-0.244c0.313-0.162,0.588-0.426,0.812-0.791h0.029v0.855h1.379v-4.991H15.606z"></path></g></svg><div style="position: absolute; top: 0px; left: -7000px;">Download Free Designs <a target="_blank" rel="dofollow" href="http://bigtheme.net/">http://bigtheme.net/</a> Free Websites Templates</div>
        <div style="display: none;" id="load"><div class="pace pace-active"><div class="pace-activity"></div></div></div>
        <div id="page" class="boxed">
            <!-- !Header -->
            <header id="header" class="show-device-logo show-mobile-logo dt-parent-menu-clickable line-decoration logo-left" role="banner"><!-- class="overlap"; class="logo-left", class="logo-center", class="logo-classic" -->
                <!-- !Top-bar -->
                <div style="margin-top: 0px;" id="top-bar" role="complementary" class="text-normal line-mobile full-width-line top-bar-hide">
                    <div class="wf-wrap">
                        <div class="wf-container-top">
                            <div class="wf-table wf-mobile-collapsed">


                                <div class=" wf-td"><span class="mini-contacts email">commercial@inovcom.fr</span><span class="mini-contacts phone"> 01 48 93 26 23</span></div>
                                <div class="right-block wf-td"><div class="soc-ico custom-bg hover-accent-bg"><a style="visibility: visible;" title="Facebook" target="_blank" href="https://www.facebook.com/inovcom.easytech?fref=ts" class="facebook"><svg class="icon" viewBox="0 0 24 24"><use xlink:href="#facebook"></use></svg></a><a style="visibility: visible;" title="Twitter" target="_blank" href="https://twitter.com/Inovcom_ET" class="twitter"><svg class="icon" viewBox="0 0 24 24"><use xlink:href="#twitter"></use></svg></a></div><div class="mini-search top-text-near-menu">
                                        <form class="searchform" role="search" method="get" action="http://inovcom.fr/">
                                            <input style="display: none; visibility: visible;" class="field searchform-s" name="s" placeholder="Type and hit enter …" type="text">
                                            <input class="assistive-text searchsubmit" value="Go!" type="submit">
                                            <a href="#go" id="trigger-overlay" class="submit text-disable">&nbsp;</a>
                                        </form>
                                    </div></div>
                            </div><!-- .wf-table -->
                        </div><!-- .wf-container-top -->
                    </div><!-- .wf-wrap -->
                    <span class="act top-bar-arrow"></span></div><!-- #top-bar -->
                <div class="wf-wrap gradient-hover">

                    <div class="wf-table">

                        <!-- !- Branding -->
                        <div id="branding" class="wf-td">

                            <a href="http://inovcom.fr/"><img src="img/LogoHeader-01.png" class="preload-me retinized"  alt="Inovcom" height="100" width="300"><img src="img/logoInovcomWeb.png" class="mobile-logo preload-me retinized" alt="Inovcom" height="70" width="200"></a>
                            <div id="site-title" class="assistive-text">Inovcom</div>
                            <div id="site-description" class="assistive-text">Ingénierie documentaire</div>
                        </div>
                        <!-- !- Navigation -->
                        <nav style="" id="navigation" class="wf-td">

                            <div id="dl-menu" class="dl-menuwrapper wf-mobile-visible"><a href="#show-menu" rel="nofollow" id="mobile-menu" class="accent-bg"><div class="lines-button x"><span class="lines"></span>
                                        <span class="menu-open">Menu</span>
                                        <span class="menu-back">back</span>
                                        <span class="wf-phone-visible">&nbsp;</span>
                                    </div></a><div class="dl-container"><ul class="dl-menu">
                                        <li class=" menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-6 current_page_item menu-item-has-children menu-item-22 act first has-children"><a href="http://inovcom.fr/qui-sommes-nous/"><span>Qui sommes nous</span></a><i class="next-level"></i><div class="dl-submenu"><ul><li class="dl-back"><a href="#"><span>back</span></a></li>
                                                    <li class=" menu-item menu-item-type-post_type menu-item-object-page menu-item-382 first level-arrows-on"><a href="http://inovcom.fr/engagement-qualite/"><span>Engagement qualité</span></a></li> </ul></div></li> 
                                        <li class=" menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-20 has-children"><a href="http://inovcom.fr/nos-services/"><span>Nos services</span></a><i class="next-level"></i><div class="dl-submenu"><ul><li class="dl-back"><a href="#"><span>back</span></a></li>
                                                    <li class=" menu-item menu-item-type-post_type menu-item-object-page menu-item-152 first level-arrows-on"><a href="http://inovcom.fr/nos-services/traitement-de-donnees/"><span>Traitement de données</span></a></li> 
                                                    <li class=" menu-item menu-item-type-post_type menu-item-object-page menu-item-151 level-arrows-on"><a href="http://inovcom.fr/nos-services/numerisation-patrimoniale/"><span>Numérisation Patrimoniale</span></a></li> 
                                                    <li class=" menu-item menu-item-type-post_type menu-item-object-page menu-item-150 level-arrows-on"><a href="http://inovcom.fr/nos-services/service-editorial/"><span>Service Éditorial</span></a></li> 
                                                    <li class=" menu-item menu-item-type-post_type menu-item-object-page menu-item-149 level-arrows-on"><a href="http://inovcom.fr/nos-services/services-web/"><span>Services Web</span></a></li> 
                                                    <li class=" menu-item menu-item-type-post_type menu-item-object-page menu-item-148 level-arrows-on"><a href="http://inovcom.fr/nos-services/centre-de-contact/"><span>Centre de contact</span></a></li> 
                                                    <li class=" menu-item menu-item-type-post_type menu-item-object-page menu-item-147 level-arrows-on"><a href="http://inovcom.fr/e-pub/"><span>E-pub</span></a></li> </ul></div></li> 
                                        <li class=" menu-item menu-item-type-post_type menu-item-object-page menu-item-18"><a href="http://inovcom.fr/implantations/"><span>Implantations</span></a></li> 
                                        <li class=" menu-item menu-item-type-post_type menu-item-object-page menu-item-19"><a href="http://inovcom.fr/references/"><span>Références</span></a></li> 
                                        <li class=" menu-item menu-item-type-post_type menu-item-object-page menu-item-21"><a href="http://inovcom.fr/contact/"><span>Contact / Devis</span></a></li> 
                                    </ul></div></div>
                            <ul id="main-nav" class="fancy-rollovers wf-mobile-hidden gradient-decor">
                                <li class=" menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-6 current_page_item menu-item-has-children menu-item-22 act first has-children"><a href="http://inovcom.fr/qui-sommes-nous/"><span>Qui sommes nous</span></a><i class="next-level-button"></i><div class="sub-nav"><ul>
                                            <li class=" menu-item menu-item-type-post_type menu-item-object-page menu-item-382 first level-arrows-on"><a href="http://inovcom.fr/engagement-qualite/"><span>Engagement qualité</span></a></li> </ul></div></li> 
                                <li class=" menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-20 has-children"><a href="http://inovcom.fr/nos-services/"><span>Nos services</span></a><i class="next-level-button"></i><div class="sub-nav"><ul>
                                            <li class=" menu-item menu-item-type-post_type menu-item-object-page menu-item-152 first level-arrows-on"><a href="http://inovcom.fr/nos-services/traitement-de-donnees/"><span>Traitement de données</span></a></li> 
                                            <li class=" menu-item menu-item-type-post_type menu-item-object-page menu-item-151 level-arrows-on"><a href="http://inovcom.fr/nos-services/numerisation-patrimoniale/"><span>Numérisation Patrimoniale</span></a></li> 
                                            <li class=" menu-item menu-item-type-post_type menu-item-object-page menu-item-150 level-arrows-on"><a href="http://inovcom.fr/nos-services/service-editorial/"><span>Service Éditorial</span></a></li> 
                                            <li class=" menu-item menu-item-type-post_type menu-item-object-page menu-item-149 level-arrows-on"><a href="http://inovcom.fr/nos-services/services-web/"><span>Services Web</span></a></li> 
                                            <li class=" menu-item menu-item-type-post_type menu-item-object-page menu-item-148 level-arrows-on"><a href="http://inovcom.fr/nos-services/centre-de-contact/"><span>Centre de contact</span></a></li> 
                                            <li class=" menu-item menu-item-type-post_type menu-item-object-page menu-item-147 level-arrows-on"><a href="http://inovcom.fr/e-pub/"><span>E-pub</span></a></li> </ul></div></li> 
                                <li class=" menu-item menu-item-type-post_type menu-item-object-page menu-item-18"><a href="http://inovcom.fr/implantations/"><span>Implantations</span></a></li> 
                                <li class=" menu-item menu-item-type-post_type menu-item-object-page menu-item-19"><a href="http://inovcom.fr/references/"><span>Références</span></a></li> 
                                <li class=" menu-item menu-item-type-post_type menu-item-object-page menu-item-21"><a href="http://inovcom.fr/contact/"><span>Contact / Devis</span></a></li> 
                            </ul><div class="right-block text-near-menu "><div class="mini-search">
                                    <form class="searchform" role="search" method="get" action="http://inovcom.fr/">
                                        <input style="visibility: visible; display: none;" class="field searchform-s" name="s" placeholder="Type and hit enter …" type="text">
                                        <input class="assistive-text searchsubmit" value="Go!" type="submit">
                                        <a href="#go" id="trigger-overlay" class="submit text-disable">&nbsp;</a>
                                    </form>
                                </div></div>
                        </nav>
                    </div><!-- .wf-table -->
                </div><!-- .wf-wrap -->

            </header><!-- #masthead -->
            <div class="page-title title-left solid-bg" style="min-height: 45px;">
                <div class="wf-wrap">
                    <div class="wf-container-title">
                        <div class="wf-table" style="height: 45px;">

                            <div class="wf-td hgroup"><h1 class="h4-size">Qui sommes nous</h1></div><div class="wf-td"><div class="assistive-text">You are here:</div><ol class="breadcrumbs text-normal"><li typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="http://inovcom.fr/" title="">Home</a></li><li class="current">Qui sommes nous</li></ol></div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="main" class="sidebar-right"><!-- class="sidebar-none", class="sidebar-left", class="sidebar-right" -->
                <div class="main-gradient"></div>
                <div class="wf-wrap">
                    <div class="wf-container-main">

                        <?php
                        echo $message;
                        ?>
                        <div class="page-title">
                            <center>
                            <h3 class="text-center wf-wrap">Dans le but d'am&eacute;liorer la qualit&eacute; et l'efficacit&eacute; de nos services, nous vous remercions de bien vouloir consacrer quelques instants &acirc; compl&eacute;ter et &agrave; nous retourner ce formulaire.</h3>
                            </center>
                        </div>
                        <br/>
                        <div class="row questionnaire container-fluid">
                            <form action="" method="post">

                                <div class="divTableau  container-fluid">
                                    <table class="tableauForm table borderless table-condensed container-fluid">
                                        <tr  class="stylingTitle">

                                            <th class="radio1 "><h3 class="stylingTitle">QUESTIONS/BAREMES</h3></th>
                                            <th class="radio1 "><h3 class="stylingTitle">Faible</h3></th>
                                            <th class="radio1 "><h3 class="stylingTitle">Passable</h3></th>
                                            <th class="radio1 "><h3 class="stylingTitle">Moyen</h3></th>
                                            <th class="radio1 "><h3 class="stylingTitle">Bien</h3></th>
                                            <th class="radio1 "><h3 class="stylingTitle ">Très bien </h3></th>
                                        </tr>
                                        <tr>
                                            <td class="tdQuestion">
                                                1. De manière globale, comment évaluez-vous la qualité de nos prestations ?
                                            </td>
                                            <td class="text-center center"><input type="radio" name="q1" value="1"/></td>
                                            <td><input type="radio" name="q1" value="2" /></td>
                                            <td><input type="radio" name="q1" value="3"/></td>
                                            <td><input type="radio" name="q1" value="4"/></td>
                                            <td><input type="radio" name="q1" value="5"/></td>
                                        </tr>
                                        <tr>
                                            <td class="tdQuestion">
                                                2. Avons-nous répondu à vos attentes ?
                                            </td>
                                            <td><input type="radio" name="q2" value="1" /></td>
                                            <td><input type="radio" name="q2" value="2"  /></td>
                                            <td><input type="radio" name="q2" value="3" /></td>
                                            <td><input type="radio" name="q2" value="4"  /></td>
                                            <td><input type="radio" name="q2" value="5" /></td>
                                        </tr>
                                        <tr>
                                            <td class="tdQuestion">
                                                3. Avons-nous respecté les délais convenus? 
                                            </td>
                                            <td><input type="radio" name="q3" value="1" /></td>
                                            <td><input type="radio" name="q3" value="2" /></td>
                                            <td><input type="radio" name="q3" value="3" /></td>
                                            <td><input type="radio" name="q3" value="4" /></td>
                                            <td><input type="radio" name="q3" value="5" /></td>
                                        </tr>
                                        <tr>
                                            <td class="tdQuestion">
                                                4. Sommes-nous réactifs vis-à-vis de vos besoins et réclamations ? 
                                            </td>
                                            <td><input type="radio" name="q4" value="1" /></td>
                                            <td><input type="radio" name="q4" value="2" /></td>
                                            <td><input type="radio" name="q4" value="3" /></td>
                                            <td><input type="radio" name="q4" value="4" /></td>
                                            <td><input type="radio" name="q4" value="5" /></td>
                                        </tr>
                                        <tr>
                                            <td class="tdQuestion">
                                                5. Etes-vous satisfait de vos interlocuteurs Inovcom ? (équipe production)
                                            </td>
                                            <td><input type="radio" name="q5" value="1" /></td>
                                            <td><input type="radio" name="q5" value="2" /></td>
                                            <td><input type="radio" name="q5" value="3" /></td>
                                            <td><input type="radio" name="q5" value="4" /></td>
                                            <td><input type="radio" name="q5" value="5" /></td>
                                        </tr>

                                    </table>
                                </div>
                                <div class="lastQuestion container-fluid">
                                    <h3  class="stylingTitle"> Recommanderiez-vous nos services à vos relations professionnelles ?</h3><br />
                                    <p>
                                        <input type="radio" class="qcm" name="recommendation" value="Oui" id="Oui" /><label for="Oui" class="tdQuestion">Oui</label></p>
                                    <p> <input type="radio" class="qcm" name="recommendation" value="Non" id="Non" /><label for="Non" class="tdQuestion">Non</label></p>
                                    <p>   <input type="radio" class="qcm" name="recommendation" value="PeutEtre" id="PeutEtre" /><label for="PeutEtre" class="tdQuestion">Peut-&ecirc;tre</label><br/>
                                    </p>
                                    <br />
                                    <h3  class="stylingTitle">Quelles seraient vos suggestions dans une démarche d’amélioration de nos services ?</h3><br />
                                    <textarea name="suggestion" cols="80" rows="3"></textarea>
                                </div>
                                <div class="envoyer">

                                    <input type="submit" id="envoyer" value="Envoyer"/>
                                </div>
                            </form>
                        </div>
                        <div id="content" class="content" role="main">
                            <div class="wpb_row wf-container" style="margin-top: 0px; margin-bottom: 0px; min-height: 0px;">
                                <div class="vc_col-sm-12 wpb_column column_container ">
                                    <div class="wpb_wrapper">

                                        <div class="wpb_text_column wpb_content_element  ">
                                            <div class="wpb_wrapper">
                                                <div id="top2"></div>
                                                <div id="wrapper"></div>
                                            </div><!-- #content -->
                                        </div><!-- .wf-container -->
                                    </div><!-- .wf-wrap -->
                                </div><!-- #main -->
                                <!-- !Footer -->
                                <footer id="footer" class="footer transparent-bg">
                                    <div class="wf-wrap">
                                    </div><!-- .wf-wrap -->
                                </footer><!-- #footer -->
                                <a href="#" class="scroll-top off"></a>
                            </div><!-- #page -->
                            <!-- We need this for debugging themes using Speed Booster Pack Plugin v2.6 -->
                            <div style="display: none;" class="pace pace-active">
                                <div class="pace-activity"></div>

                            </div>
                            <div style="opacity: 0;" id="phantom" class="show-device-logo show-mobile-logo dt-parent-menu-clickable line-decoration logo-left boxed gradient-hover">
                                <div class="ph-wrap boxed gradient-hover with-logo"><div class="ph-wrap-content">
                                        <div class="ph-wrap-inner"><div class="logo-box">
                                                <a href="http://inovcom.fr/"><img src="img/logoInovcomWeb.png" height="70" width="200"></a></div>
                                            <div style="height: 60px;" class="menu-box"></div></div></div></div></div><div style="display:none;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script language="javascript" type="text/javascript" src="js/jquery.js"></script>
    <script language="javascript" type="text/javascript" charset="utf-8">
        $("#envoyer").click(function () {
            alert("ato mtrav");
            $("#envoyer").attr('disabled', 'disabled');
            var idpers = $("#idsess").val();
            var reveil = $("input:radio[name='1']:checked").val();
            var coucher = $("input:radio[name='2']:checked").val();
            var trajet = $("input:radio[name='3']:checked").val();
            var distance = $("input:radio[name='4']:checked").val();
            var transport = $("input:radio[name='5']:checked").val();
            if (reveil !== undefined && coucher !== undefined && trajet !== undefined && distance !== undefined && transport !== undefined)
                InsertSurvey(idpers, reveil, coucher, trajet, distance, transport);
            else
            {
                alert('Vous devez remplir tout les champs');
                $('#survey').removeAttr('disabled');
                return;
            }
        });

        function checkMatricule(matricule) {
            alert(matricule);
        }
        function InsertSurvey(idpers, reveil, coucher, trajet, distance, transport)
        {
            $.ajax({
                type: 'GET',
                url: "php/link.php?action=InsertSurvey&idpers=" + idpers + "&reveil=" + reveil + "&coucher=" + coucher + "&trajet=" + trajet + "&distance=" + distance + "&transport=" + transport,
                success: function () {
                    alert("Merci pour votre réponse!");
                    window.location = "index.php";
                }
            });
        }
    </script>

</html>