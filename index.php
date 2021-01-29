<?php

session_start();

$_SESSION['name'] = (isset($_SESSION['name'])) ? $_SESSION['name'] : "";
$_SESSION['lang'] = (isset($_GET['lang'])) ? $_GET['lang'] : 'th';
if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'en') {
    include('lang.en.php');
} else {
    $_SESSION['lang'] = 'th';
    include('lang.th.php');
}
?>
<!DOCTYPE html>
<html lang="<?= $_SESSION['lang'] ?>">

<head>
    <meta charset="utf-8" />

    <title><?= $language['APP_NAME'] ?></title>
    <meta name="description" content="<?= $language['APP_NAME'] ?>" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0-beta1/css/bootstrap.min.css" integrity="sha512-thoh2veB35ojlAhyYZC0eaztTAUhxLvSZlWrNtlV01njqs/UdY3421Jg7lX0Gq9SRdGVQeL8xeBp9x1IPyL1wQ==" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0-beta1/js/bootstrap.min.js" integrity="sha512-ZvbjbJnytX9Sa03/AcbP/nh9K95tar4R0IAxTS2gh2ChiInefr1r7EpnVClpTWUEN7VarvEsH3quvkY1h0dAFg==" crossorigin="anonymous"></script>
</head>

<body>

    <div class="container">
        <!-- Content here -->
        <div class="row">
            <div class="col leftside">
                <div id="menu">
                    <h1 class="text-center"><?= $language['WELCOME'] ?></h1>
                </div>

                <div id="chatbox"><?php
                                    if (file_exists("log.html") && filesize("log.html") > 0) {

                                        $contents = file_get_contents("log.html");
                                        echo $contents;
                                    }
                                    ?>
                </div>

                <form name="message" action="">
                    <label for="name"><?= $language['SEND_NAME'] ?></label>
                    <input name="name" type="text" id="name" placeholder="<?= $language['NAME'] ?>" value="<?= $_SESSION["name"] ?>" />
                    <label for="usermsg"><?= $language['MESSAGE'] ?></label>
                    <textarea name="usermsg" id="usermsg" placeholder=""></textarea>
                    <input name="submitmsg" type="submit" id="submitmsg" value="<?= $language['SEND'] ?>" />
                </form>
            </div>
            <div class="col rightside">
                <div class="position-absolute top-0 end-0 me-5">
                    <div class="btn-group">
                        <a id="lang_en" href="?lang=en" class="btn btn-primary<?= ($_SESSION['lang'] == 'en') ? " active disabled" : ""; ?>">EN</a>
                        <a id="lang_th" href="?lang=th" class="btn btn-primary<?= ($_SESSION['lang'] == 'th') ? " active disabled" : ""; ?>">TH</a>

                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script type="text/javascript">
            // jQuery Document
            $(document).ready(function() {
                //If user submits the form
                $("#submitmsg").click(function() {
                    var clientname = $("#name").val();
                    if (clientname == "") {
                        alert('<?= $language['TYPE_NAME'] ?>');
                        return false;
                    }
                    var clientmsg = $("#usermsg").val();
                    $.post("post.php", {
                        name: clientname,
                        text: clientmsg
                    });
                    $("#usermsg").val("<?= $language['SEND_SECCESS'] ?>");
                    return false;
                });
                //Load the file containing the chat log
                function loadLog() {
                    var oldscrollHeight = $("#chatbox")[0].scrollHeight - 20; //Scroll height before the request
                    $.ajax({
                        url: "log.html",
                        cache: false,
                        success: function(html) {
                            $("#chatbox").html(html); //Insert chat log into the #chatbox div   

                            //Auto-scroll           
                            var newscrollHeight = $("#chatbox")[0].scrollHeight - 20; //Scroll height after the request
                            if (newscrollHeight > oldscrollHeight) {
                                $("#chatbox").animate({
                                    scrollTop: newscrollHeight
                                }, 'normal'); //Autoscroll to bottom of div
                            }
                        },
                    });
                }
                setInterval(loadLog, 2500); //Reload file every 2500 ms or x ms if you wish to change the second parameter
            });
        </script>
        <?php
        // }
        ?>
</body>

</html>