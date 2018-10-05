<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Briefcase</title>
        <link href="css/style.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        
        <div id="container">
            <h1>Whats the password?</h1>
            
            <?php 
                $imgClosed = "<img id='briefcase' src='images/closed.jpg'>";
                $imgOpened = "<img id='briefcase' src='images/opened.jpg'>";                
                                
                //generate random lock combination, init vars; only runs on first load or reset
                if($_SERVER['REQUEST_METHOD'] == "GET" || isset($_REQUEST['reset']) ){
                    session_reset();
                    //initialize 
                    $_SESSION['input1'] = $_SESSION['input2'] = $_SESSION['input3'] = 0;
                    $_SESSION['disable1'] = $_SESSION['disable2'] = $_SESSION['disable3'] = "";
                    $_SESSION['disableReset'] = "disabled";
                    //random number generator
                    $_SESSION['code1'] = $code1 = mt_rand(0, 9);
                    $_SESSION['code2'] = $code2 = mt_rand(0, 9);
                    $_SESSION['code3'] = $code3 = mt_rand(0, 9);
                    $_SESSION['disableReset'] = "disabled";
                    $_SESSION['reset'] = $_SESSION['disableSubmit'] = "";
                    $reset = FALSE;
                    $_SESSION['correct1'] = $_SESSION['correct2'] = $_SESSION['correct3'] = 0;
                }
                
                //control structore for disabling fields & preserving previous inputs
                if ($_SERVER['REQUEST_METHOD'] == "POST"){  
                    //input1 disable
                    if ($_REQUEST['input1'] == $_SESSION['code1'] || $_SESSION['input1'] == $_SESSION['code1']){     
                        $_SESSION['disable1'] = "disabled";
                        $_SESSION['input1'] = $_SESSION['code1'];
                        $_SESSION['unlocked1'] = TRUE;
                        $_SESSION['correct1'] = 1;
                    } else {
                        $_SESSION['input1'] = $_REQUEST['input1'];
                        $_SESSION['unlocked1'] = FALSE;
                    }
                    
                    //input2 disable
                    if ($_REQUEST['input2'] == $_SESSION['code2'] || $_SESSION['input2'] == $_SESSION['code2']){     
                        $_SESSION['disable2'] = "disabled";
                        $_SESSION['input2'] = $_SESSION['code2'];
                        $_SESSION['unlocked2'] = TRUE;
                        $_SESSION['correct2'] = 1;
                    } else {
                        $_SESSION['input2'] = $_REQUEST['input2'];
                        $_SESSION['unlocked2'] = FALSE;
                    }
                    
                    //input3 disable
                    if ($_REQUEST['input3'] == $_SESSION['code3'] || $_SESSION['input3'] == $_SESSION['code3']){     
                        $_SESSION['disable3'] = "disabled";
                        $_SESSION['input3'] = $_SESSION['code3'];
                        $_SESSION['unlocked3'] = TRUE;
                        $_SESSION['correct3'] = 1;
                        
                    } else {
                        $_SESSION['input3'] = $_REQUEST['input3'];
                        $_SESSION['unlocked3'] = FALSE;
                    }
                    
                    //if combo is correct enable/disable buttons
                    if($_SESSION['unlocked1'] && $_SESSION['unlocked2'] && $_SESSION['unlocked3']) {
                        $_SESSION['disableReset'] = "";
                        $_SESSION['disableSubmit'] = "disabled";
                    } else {
                        $_SESSION['disableReset'] = "disabled";
                        $_SESSION['disableSubmit'] = "";
                    }
                    
                    if ($_REQUEST['reset'] != NULL){
                        unset($_SESSION['reset']);
                        unset($_REQUEST['reset']);
                        $reset = TRUE;
                    }
                    
                    echo ($_SESSION['correct1'] + $_SESSION['correct2'] + $_SESSION['correct3'] ) . " digits matched.";
                }
                
                //display image based on lock status
                if($_SESSION['unlocked1'] && $_SESSION['unlocked2'] && $_SESSION['unlocked3']) {
                    echo $imgOpened;
                    echo "<p id='center'>Congratulations, you win nothing!</p>";
                } else {
                    echo $imgClosed;
                }
            ?>
            
            <br><br>
            <div id="formContainer">
                <form action="" method="post">
                    <input type="number" name="input1" min="0" max="9" value="<?php echo $_SESSION['input1'] ?>" 
                        <?php echo $_SESSION['disable1'] ?>>
                    <input type="number" name="input2" min="0" max="9" value="<?php echo $_SESSION['input2'] ?>" 
                        <?php echo $_SESSION['disable2'] ?>>
                    <input type="number" name="input3" min="0" max="9" value="<?php echo $_SESSION['input3'] ?>" 
                        <?php echo $_SESSION['disable3'] ?>><br>
                    <input type="submit" value="Open sesame!" <?php echo $_SESSION['disableSubmit'] ?>> <br>
                    
                    <!--page reset-->
                    <input type='submit' value='Reset!' name="reset" <?php echo $_SESSION['disableReset'] ?>><br>
                    
                    
                </form>
            </div>
            
            <!--combination-->
            <?php echo "Combination: " . $_SESSION['code1'] . $_SESSION['code2'] . $_SESSION['code3'] . "<br>"; ?>
        </div>
    </body>
</html>
