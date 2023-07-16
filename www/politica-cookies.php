<?php
// Redirecció a HTTPS
if(!isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] != "on"){
  header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"], true, 301);
  exit;
}
include_once("sections/languages.php");
include_once("sections/cookies.php");
?>
<!DOCTYPE html>
<html lang="es">
    <head>
    <!-- Meta data -->
    <?php include_once("sections/meta.php") ?>

    <!-- Títol i Favicons -->
    <title>Cuantime. Política cookies</title>

    <!-- CSS Libraries -->
    <link href="//app.cuantime.com/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="//app.cuantime.com/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="//app.cuantime.com/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    
    <link href="//app.cuantime.com/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css">
    <link href="//app.cuantime.com/assets/libs/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet">
    <link href="//app.cuantime.com/assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <link href="//app.cuantime.com/assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet">
    <link href="//app.cuantime.com/assets/libs/bootstrap-editable/css/bootstrap-editable.css" rel="stylesheet">
    <!-- CSS Custom -->
    <link rel="stylesheet" type="text/css" href="css/style.css" media="screen">
    <link rel="stylesheet" type="text/css" href="css/responsive.css" media="screen">

    <!-- Scripts Libraries -->
    <!-- Scripts custom -->
</head>

<body>
    <?php include_once("sections/headerPage.php") ?>

            <div class="page-content">
                <div class="container-fluid">
                    <div class="row justify-content-center" id="legal">
                        <div class="col-lg-9">
                            <div class="row">
                                <div class="col-md-12 text-justify">
                                    <p>This cookie policy (&quot;Policy&quot;) describes what cookies are and how Website Operator (&quot;Website Operator&quot;, &quot;we&quot;, &quot;us&quot; or &quot;our&quot;) uses them on the <a target="_blank"  hreflang="<?php echo $text['Lang']; ?>" rel="nofollow" href="https://www.cuantime.com">cuantime.com</a> website and any of its products or services (collectively, &quot;Website&quot; or &quot;Services&quot;). You should read this Policy so you can understand what type of cookies we use, the information we collect using cookies and how that information is used. It also describes the choices available to you regarding accepting or declining the use of cookies.</p>
                                    <strong>What are cookies?</strong>
                                    <p>Cookies are small pieces of data stored in text files that are saved on your computer or other devices when websites are loaded in a browser. They are widely used to remember you and your preferences, either for a single visit (through a &quot;session cookie&quot;) or for multiple repeat visits (using a &quot;persistent cookie&quot;). Session cookies are temporary cookies that are used during the course of your visit to the Website, and they expire when you close the web browser. Persistent cookies are used to remember your preferences within our Website and remain on your desktop or mobile device even after you close your browser or restart your computer. They ensure a consistent and efficient experience for you while visiting our Website or using our Services. Cookies may be set by the Website (&quot;first-party cookies&quot;), or by third parties, such as those who serve content or provide advertising or analytics services on the website (&quot;third party cookies&quot;). These third parties can recognize you when you visit our website and also when you visit certain other websites.</p>
                                    <strong>What type of cookies do we use?</strong><br>
                                    <u>Necessary cookies</u>
                                    <p>Necessary cookies allow us to offer you the best possible experience when accessing and navigating through our Website and using its features. For example, these cookies let us recognize that you have created an account and have logged into that account to access the content.</p>
                                    <u>Functionality cookies</u>
                                    <p>Functionality cookies let us operate the Website and our Services in accordance with the choices you make. For example, we will recognize your username and remember how you customized the Website and Services during future visits.</p>
                                    <u>Analytical cookies</u>
                                    <p>These cookies enable us and third-party services to collect aggregated data for statistical purposes on how our visitors use the Website. These cookies do not contain personal information such as names and email addresses and are used to help us improve your user experience of the Website.</p>
                                    <strong>What are your cookie options?</strong>
                                    <p>If you don't like the idea of cookies or certain types of cookies, you can change your browser's settings to delete cookies that have already been set and to not accept new cookies. To learn more about how to do this or to learn more about cookies, visit <a target="_blank" href="https://www.internetcookies.org" hreflang="en">internetcookies.org</a>. Please note, however, that if you delete cookies or do not accept them, you might not be able to use all of the features our Website and Services offer.</p>
                                    <strong>Changes and amendments</strong>
                                    <p>We reserve the right to modify this Policy relating to the Website or Services at any time, effective upon posting of an updated version of this Policy on the Website. When we do we will revise the updated date at the bottom of this page. Continued use of the Website after any such changes shall constitute your consent to such changes. Policy was created with <a style="color:inherit" target="_blank" title="Cookie policy generator" href="https://www.websitepolicies.com/cookie-policy-generator" hreflang="en">WebsitePolicies</a>.</p>
                                    <strong>Acceptance of this policy</strong>
                                    <p>You acknowledge that you have read this Policy and agree to all its terms and conditions. By using the Website or its Services you agree to be bound by this Policy. If you do not agree to abide by the terms of this Policy, you are not authorized to use or access the Website and its Services.</p>
                                    <srong>Contacting us</strong>
                                    <p>If you would like to contact us to understand more about this Policy or wish to contact us concerning any matter relating to our use of cookies, you may send an email to hola&#64;c&#117;&#97;ntime.com.</p>
                                    <p>This document was last updated on February 23, 2021</p>
                                </div>
                            </div>
                        </div>
                    </div>




                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->


<!-- Footer -->
<?php include_once("sections/footer.php") ?>

<!-- JavaScripts basics -->
<script src="//www.aldasoro.ml/admin/assets/libs/jquery/jquery.min.js"></script>
<script src="//www.aldasoro.ml/admin/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- JavaScripts custom -->
<script src="js/script.js"></script>
<!-- Scripts custom -->

</body>
</html>