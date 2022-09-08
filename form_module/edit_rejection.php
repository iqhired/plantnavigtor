<?php
include("../config.php");
$chicagotime = date("Y-m-d H:i:s");
$temp = "";
if (!isset($_SESSION['user'])) {
    if($_SESSION['is_tab_user'] || $_SESSION['is_cell_login']){
        header($redirect_tab_logout_path);
    }else{
        header($redirect_logout_path);
    }
}
//Set the session duration for 10800 seconds - 3 hours
$duration = $auto_logout_duration;
//Read the request time of the user
$time = $_SERVER['REQUEST_TIME'];
//Check the user's session exist or not
if (isset($_SESSION['LAST_ACTIVITY']) && ($time - $_SESSION['LAST_ACTIVITY']) > $duration) {
    //Unset the session variables
    session_unset();
    //Destroy the session
    session_destroy();
    if($_SESSION['is_tab_user'] || $_SESSION['is_cell_login']){
        header($redirect_tab_logout_path);
    }else{
        header($redirect_logout_path);
    }

//	header('location: ../logout.php');
    exit;
}
//Set the time of the user's last activity
$_SESSION['LAST_ACTIVITY'] = $time;
$i = $_SESSION["role_id"];
if ($i != "super" && $i != "admin" && $i != "pn_user" && $_SESSION['is_tab_user'] != 1 && $_SESSION['is_cell_login'] != 1 ) {
    header('location: ../dashboard.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?php echo $sitename; ?> |Edit Rejection Form</title>
    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet"
          type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/core.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/components.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/colors.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/style_main.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->
    <!-- Core JS files -->

    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/libs/jquery-3.6.0.min.js"> </script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->
    <!-- Theme JS files -->
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/core/libraries/jquery_ui/interactions.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/media/fancybox.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/datatables_basic.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/form_select2.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/gallery.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="index.js" ></script>
    <script type="text/javascript" src="constants.js" ></script>
    <script type="text/javascript" src="speech.js" ></script>
    <script>
        const synth = window.speechSynthesis;

        const textToSpeech = (string) => {
            let voice = new SpeechSynthesisUtterance(string);
            voice.text = string;
            voice.lang = "en-US";
            voice.volume = 1;
            voice.rate = 1;
            voice.pitch = 1; // Can be 0, 1, or 2
            synth.speak(voice);
        }
    </script>
    <style>
        body {
            font: 15px arial, sans-serif;
            background-color: #d9d9d9;
            padding-top: 15px;
            padding-bottom: 15px;
        }

        #bodybox {
            margin: auto;
            max-width: 550px;
            max-height: 350px;
            font: 15px arial, sans-serif;
            background-color: white;
            border-style: solid;
            border-width: 1px;
            padding-top: 20px;
            padding-bottom: 25px;
            padding-right: 25px;
            padding-left: 25px;
            box-shadow: 5px 5px 5px grey;
            border-radius: 15px;
        }

        #chatborder {
            border-style: solid;
            background-color: #f6f9f6;
            border-width: 3px;
            margin-top: 20px;
            margin-bottom: 20px;
            margin-left: 20px;
            margin-right: 20px;
            padding-top: 10px;
            padding-bottom: 15px;
            padding-right: 20px;
            padding-left: 15px;
            border-radius: 15px;
        }

        .chatlog {
            font: 15px arial, sans-serif;
        }

        #chatbox {
            font: 17px arial, sans-serif;
            height: 22px;
            width: 100%;
        }

        h1 {
            margin: auto;
        }

        pre {
            background-color: #f0f0f0;
            margin-left: 20px;
        }
    </style>
    <script>

        var messages = [], //array that hold the record of each string in chat
            lastUserMessage = "", //keeps track of the most recent input string from the user
            botMessage = "", //var keeps track of what the chatbot is going to say
            botName = '', //name of the chatbot
            talking = true; //when false the speach function doesn't work
        //edit this function to change what the chatbot says
        function chatbotResponse() {
            talking = true;
            //botMessage = "I'm confused"; //the default message

            //if (lastUserMessage === 'hi' || lastUserMessage =='hello') {
            //const hi = ['hi','howdy','hello']
            //botMessage = hi[Math.floor(Math.random()*(hi.length))];;
            // }

            //if (lastUserMessage === 'name') {
            //  botMessage = 'My name is ' + botName;
            // }
        }
        //this runs each time enter is pressed.
        //It controls the overall input and output
        function newEntry() {
            //if the message from the user isn't empty then run
            if (document.getElementById("chatbox").value != "") {
                //pulls the value from the chatbox ands sets it to lastUserMessage
                lastUserMessage = document.getElementById("chatbox").value;
                //sets the chat box to be clear
                document.getElementById("chatbox").value = "";
                //adds the value of the chatbox to the array messages
                messages.push(lastUserMessage);
                //Speech(lastUserMessage);  //says what the user typed outloud
                //sets the variable botMessage in response to lastUserMessage
                chatbotResponse();
                //add the chatbot's name and message to the array messages
                messages.push("<b>" + botName + "</b> " + botMessage);
                // says the message using the text to speech function written below
                Speech(botMessage);
                //outputs the last few array elements of messages to html
                for (var i = 1; i < 8; i++) {
                    if (messages[messages.length - i])
                        document.getElementById("chatlog" + i).innerHTML = messages[messages.length - i];
                }
            }
        }

        //text to Speech
        //https://developers.google.com/web/updates/2014/01/Web-apps-that-talk-Introduction-to-the-Speech-Synthesis-API
        function Speech(say) {
            if ('speechSynthesis' in window && talking) {
                var utterance = new SpeechSynthesisUtterance(say);
                //msg.voice = voices[10]; // Note: some voices don't support altering params
                //msg.voiceURI = 'native';
                //utterance.volume = 1; // 0 to 1
                //utterance.rate = 0.1; // 0.1 to 10
                //utterance.pitch = 1; //0 to 2
                //utterance.text = 'Hello World';
                //utterance.lang = 'en-US';
                speechSynthesis.speak(utterance);
            }
        }

        //runs the keypress() function when a key is pressed
        document.onkeypress = keyPress;
        //if the key pressed is 'enter' runs the function newEntry()
        function keyPress(e) {
            var x = e || window.event;
            var key = (x.keyCode || x.which);
            if (key == 13 || key == 3) {
                //runs this function when enter is pressed
                newEntry();
            }
            if (key == 38) {
                console.log('hi')
                //document.getElementById("chatbox").value = lastUserMessage;
            }
        }

        //clears the placeholder text ion the chatbox
        //this function is set to run when the users brings focus to the chatbox, by clicking on it
        function placeHolder() {
            document.getElementById("chatbox").placeholder = "Enter the comments";
        }
    </script>
    <script>
        function save() {
            var msg = document.getElementById('msg');
            msg.innerHTML = 'Data submitted and the button disabled ☺';
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=WindSong&display=swap');

        .signature {

            font-family: 'WindSong', swap;
            font-size: 25px;
            font-weight: 600;
        }

        #form_save_btn {
            background-color: #1e73be;
            margin-left: 35px;
            padding: 12px 22px 10px 18px;
            margin-bottom: 10px;
        }

        .pn_none {
            pointer-events: none;
            color: #050505;
        }
        .tooltip {
            position: relative;
            display: inline-block;
            /*border-bottom: 1px dotted black;*/
            opacity: 1!important;
            overflow: inherit;
        }

        .tooltip .tooltiptext {
            visibility: hidden;
            width: 120px;
            background-color: #26a69a;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px 0;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            margin-left: -60px;
            opacity: 0;
            transition: opacity 0.3s;

        }

        .tooltip .tooltiptext::after {
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: #555 transparent transparent transparent;

        }

        .tooltip:hover .tooltiptext {
            visibility: visible;
            opacity: 1;

        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #191e3a!important;
            line-height: 20px!important;
        }
        .select2-container--disabled .select2-selection--single:not([class*=bg-]) {
            color: #060818!important;
            border-block-start: none;
            border-bottom-color: #191e3a!important;
        }
        .select2-container--disabled .select2-selection--single:not([class*=bg-]) {
            color: #999;
            border-bottom-style: inset;
        }
        #check {
            background-color: #90A4AE;
        }

    </style>
</head>
<!-- Main navbar -->
<?php
$cust_cam_page_header = "Edit Form";
include("../header.php");
include("../admin_menu.php");
include("../heading_banner.php");
?>
<body class="alt-menu sidebar-noneoverflow">
<!-- /main navbar -->
<!-- Page container -->
<div class="page-container">

    <!-- Content area -->
    <div class="content">
        <?php
        $id = $_GET['id'];
        $fill_op_data = $_GET['optional'];

        $querymain = sprintf("SELECT * FROM `form_user_data` where form_user_data_id = '$id' ");
        $qurmain = mysqli_query($db, $querymain);

        while ($rowcmain = mysqli_fetch_array($qurmain)) {
        $formname = $rowcmain['form_name'];
        $form_user_data_id = $rowcmain['form_user_data_id'];

        ?>

        <div class="panel panel-flat">
            <!--                <h5 style="text-align: left;margin-right: 120px;"> <b>Submitted on : </b>--><?php //echo date('d-M-Y h:m'); ?><!--</h5>-->
            <div class="panel-heading">
                <h5 class="panel-title form_panel_title"><?php echo $rowcmain['form_name']; ?>  </h5>
                <div class="row ">
                    <div class="col-md-12">
                        <form action="update_user_form_backend.php" id="form_update" enctype="multipart/form-data"
                              class="form-horizontal" method="post" autocomplete="off">
                            <input type="hidden" name="name" id="name"
                                   value="<?php echo $rowcmain['form_name']; ?>">
                            <input type="hidden" name="formcreateid" id="formcreateid"
                                   value="<?php echo $rowcmain['form_create_id']; ?>">
                            <input type="hidden" name="form_user_data_id" id="form_user_data_id"
                                   value="<?php echo $id; ?>">
                            <br/>
                            <input type="text" name="comment" id="comment">
                            <input type='submit' value='Submit' id='btClickMe'
                                   onclick='save(); this.disabled = true;'/>
                            <br/>
                            <div class="form_row row">
                                <label class="col-lg-2 control-label">link : </label>
                                <div class="col-md-6">
                                    <?php
                                    //$form_user_data_id = $rowcmain['form_user_data_id'];
                                    $qurt = mysqli_query($db, "SELECT comments FROM  form_comments where form_user_data_id = '$id' ");
                                    $rowct = mysqli_fetch_array($qurt);

                                    ?>
                                    <input type="text" name="comment" class="form-control" id="comment"
                                           value="<?php echo $rowct["comments"]; ?>" disabled>
                                </div>
                            </div>
                            <div class="form_row row">
                                <label class="col-lg-2 control-label">Form link : </label>
                                <div class="col-md-6">
                                    <a href="view_rejetion.php?id=<?php echo $rowcmain['form_user_data_id'];?>">
                                            <u>Link for view the form</u>
                                    </a>
                                </div>
                            </div>
                            <br/>
                            <div class="form_row row">
                                <label class="col-lg-2 control-label">Form Type : </label>
                                <div class="col-md-6">
                                    <?php
                                    $get_form_type = $rowcmain['form_type'];
                                    if ($get_form_type != '') {
                                        $disabled = 'disabled';
                                    } else {
                                        $disabled = '';
                                    }
                                    ?>
                                    <input type="hidden" name="form_type" id="form_type"
                                           value="<?php echo $get_form_type; ?>">
                                    <select name="form_type1" id="form_type"
                                            class="select-border-color" <?php echo $disabled; ?>>
                                        <option value="" selected disabled>--- Select Form Type ---</option>
                                        <?php

                                        $sql1 = "SELECT * FROM `form_type` ";
                                        $result1 = $mysqli->query($sql1);
                                        // $entry = 'selected';
                                        while ($row1 = $result1->fetch_assoc()) {
                                            if ($get_form_type == $row1['form_type_id']) {
                                                $entry = 'selected';
                                            } else {
                                                $entry = '';
                                            }
                                            echo "<option value='" . $row1['form_type_id'] . "'  $entry>" . $row1['form_type_name'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <br/>
                            <div class="form_row row">
                                <label class="col-lg-2 control-label">Station : </label>
                                <div class="col-md-6">

                                    <?php
                                    $get_station = $rowcmain['station'];
                                    if ($get_station != '') {
                                        $disabled = 'disabled';
                                    } else {
                                        $disabled = '';
                                    }
                                    ?>

                                    <input type="hidden" name="station" id="station"
                                           value="<?php echo $get_station; ?>">
                                    <select name="station1" id="station1"
                                            class="select-border-color" <?php echo $disabled; ?>>
                                        <option value="" selected disabled>--- Select Station ---</option>
                                        <?php
                                        $sql1 = "SELECT * FROM `cam_line` where enabled = '1' ORDER BY `line_name` ASC ";
                                        $result1 = $mysqli->query($sql1);
                                        //                                            $entry = 'selected';
                                        while ($row1 = $result1->fetch_assoc()) {
                                            if ($get_station == $row1['line_id']) {
                                                $entry = 'selected';
                                            } else {
                                                $entry = '';
                                            }
                                            echo "<option value='" . $row1['line_id'] . "' $entry >" . $row1['line_name'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <br/>
                            <div class="form_row row">
                                <label class="col-lg-2 control-label">Part Family : </label>
                                <div class="col-md-6">

                                    <?php
                                    $get_part_family = $rowcmain['part_family'];
                                    if ($get_part_family != '') {
                                        $disabled = 'disabled';
                                    } else {
                                        $disabled = '';
                                    }
                                    ?>

                                    <input type="hidden" name="part_family" id="part_family"
                                           value="<?php echo $get_part_family; ?>">
                                    <select name="part_family1" id="part_family1"
                                            class="select-border-color" <?php echo $disabled; ?>>
                                        <option value="" selected disabled>--- Select Part Family ---</option>
                                        <?php
                                        $sql1 = "SELECT * FROM `pm_part_family` ";
                                        $result1 = $mysqli->query($sql1);
                                        //                                            $entry = 'selected';
                                        while ($row1 = $result1->fetch_assoc()) {
                                            if ($get_part_family == $row1['pm_part_family_id']) {
                                                $entry = 'selected';
                                            } else {
                                                $entry = '';
                                            }
                                            echo "<option value='" . $row1['pm_part_family_id'] . "' $entry >" . $row1['part_family_name'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <br/>
                            <div class="form_row row">
                                <label class="col-lg-2 control-label">Part Number : </label>
                                <div class="col-md-6">

                                    <?php
                                    $get_part_number = $rowcmain['part_number'];
                                    if ($get_part_number != '') {
                                        $disabled = 'disabled';
                                    } else {
                                        $disabled = '';
                                    }
                                    ?>

                                    <input type="hidden" name="part_number" id="part_number"
                                           value="<?php echo $get_part_number; ?>">
                                    <select name="part_number1" id="part_number1"
                                            class="select-border-color" <?php echo $disabled; ?>>
                                        <option value="" selected disabled>--- Select Part Number ---</option>
                                        <?php
                                        $sql1 = "SELECT * FROM `pm_part_number` ";
                                        $result1 = $mysqli->query($sql1);
                                        //                                            $entry = 'selected';
                                        while ($row1 = $result1->fetch_assoc()) {
                                            if ($get_part_number == $row1['pm_part_number_id']) {
                                                $entry = 'selected';
                                            } else {
                                                $entry = '';
                                            }
                                            echo "<option value='" . $row1['pm_part_number_id'] . "' $entry >" . $row1['part_number'] . " - " . $row1['part_name'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <br/>

                            <div class="form_row row">
                                <label class="col-lg-2 control-label">Operator : </label>
                                <div class="col-md-6">

                                    <?php
                                    $createdby = $rowcmain['created_by'];
                                    $datetime = $rowcmain["created_at"];
                                    $create_date = strtotime($datetime);
                                    $qur04 = mysqli_query($db, "SELECT firstname,lastname,pin FROM  cam_users where users_id = '$createdby' ");
                                    $rowc04 = mysqli_fetch_array($qur04);
                                    $fullnnm = $rowc04["firstname"] . " " . $rowc04["lastname"];
                                    $pin = $rowc04["pin"];

                                    ?>

                                    <input type="text" name="createdby" class="form-control" id="createdby"
                                           value="<?php echo $fullnnm; ?>" disabled>
                                </div>
                            </div>

                            <div class="form_row row">
                                <label class="col-lg-2 control-label">Submitted Time : </label>
                                <div class="col-md-6">
                                    <input type="text" name="createdby" class="form-control" id="createdby"
                                           value="<?php echo date('d-M-Y h:i:s', $create_date); ?>" disabled>
                                </div>
                            </div>
                            <br/>
<!--
                            <div class="form_row row">
                                <label class="col-lg-2 control-label">Comments : </label>
                                <div class="col-md-6">
                                    <textarea id="comment" name="comment" rows="4" placeholder="Enter comments..." class="form-control"></textarea>
                                </div>
                            </div>
                            <br/>-->
                            <div class="form_row row">
                                <label class="col-lg-2 control-label">Attachments : </label>
                                <div class="col-md-6">
                                    <input type="file" name="file">
                                </div>
                            </div>
                            <br/>
                            <!--<div class="form_row row">
                                <label class="col-lg-2 control-label">Pin : </label>
                                <div class="col-md-2">
                                    <input type="password" name="pin2" id="pin2" class="form-control">
                                </div>
                            </div>
                            <br/>-->
                                <div class="row">
                                    <div class="col-md-2" style="padding-left: 950px;">
                                        <button type="submit" name="submit" id="submit" class="btn btn-primary"
                                                style="background-color:#1e73be;">
                                            Submit
                                        </button>
                                    </div>
                                </div>

                            <div>
                                <hr class="form_hr"/>

                            </div>

                            <div class="form_row row" id="check">
                                <label class="col-lg-2 control-label" style="padding-top: 5px">To close form : </label>
                                <div class="col-md-3">
                                        <div style="font-size: small !important;">
                                            <select class="select-border-color"
                                                    name="approval_initials"
                                                    id="approval_initials"
                                                    class="select" data-style="bg-slate">
                                                <option value="" selected disabled>--- Select Approver
                                                    ---
                                                </option>
                                                <?php
                                                    $qurtemp = mysqli_query($db, "SELECT firstname,lastname FROM `cam_users` where pin_flag = '1' ");
                                                    $rowctemp = mysqli_fetch_array($qurtemp);
                                                    if ($rowctemp != NULL) {
                                                        $fullnn = $rowctemp["firstname"] . " " . $rowctemp["lastname"];

                                                        echo "<option value='" . $fullnn . "' >" . $fullnn . "</option>";
                                                    }
                                                    $fullnm = "";

                                                ?>
                                            </select>
                                            <span style="font-size: x-small;color: darkred;display: none;" id="user">Select User.</span>
                                        </div>

                                </div>
                                <div class="col-md-3">
                                            <span class="form_tab_td" id="approve_msg" style="float: left !important;width: 40% !important; padding-top: 5px;">
                                                            <input type="password" name="pin[]" id="pin"
                                                                   class="form-control" style=" margin-bottom: 5px;width: auto !important;"
                                                                   placeholder="Enter Pin..."  autocomplete="off" >
                                                            <span style="font-size: x-small;color: darkred; display: none;" id="pin_error">Invalid Pin.</span>
                                                        </span>
                                </div>
                                <div class="col-md-2" style="padding-top: 5px;">
                                    <button type="submit" name="save" id="save" class="btn btn-primary"
                                            style="background-color:#1e73be;">
                                        Save
                                    </button>
                                </div>

                            </div>


                            </form>

                    </div>
                </div>
            </div>
        </div>


        <?php } ?>

<!-- /main charts -->
<!-- edit modal -->
<!-- Dashboard content -->
<!-- /dashboard content -->
</div>
<!-- /content area -->
</div>
<!-- /page container -->
<script>
    $("#commit").click(function (e) {
        if ($("#form_settings")[0].checkValidity()){
            var data = $("#form_update").serialize();
            $.ajax({
                type: 'POST',
                url: 'edit_rejection.php',
                dataType: "json",
                // context: this,
                async: false,
                data: data,
                success: function (data) {
                    $('#commit').attr('disabled', 'disabled');

                    $('#success_msg').text('Form submitted Successfully').css('background-color','#0080004f');
                    $("form :input").prop("disabled", true);
                    window.scrollTo(0, 0);

                }
            });
        }
        // e.preventDefault();
    });

</script>
<?php
$comment = $_POST['comment'];
$sqlt = "UPDATE `form_rejection_data` SET `comments`='$comment' where form_user_data_id = '$form_user_data_id'";
$qurmaint = mysqli_query($db, $sqlt);
if($qurmaint)
{
    echo 'success';
}else{
    echo 'fail';
}
?>
<script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/core/app.js"></script>
</body>

</html>