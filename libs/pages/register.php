<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="dash/css/login.css">
</head>
<body>
    <div class="box">
        <?php 
            $step = isset($_GET['step']);
            session_start();
            switch($step){
                default:
        ?>
            <form action="?step=1" method="POST">
                <input type="text" name="user" id="user" placeholder="User">
                <input type="email" name="email" id="email" placeholder="Email">
                <input type="password" name="pass" id="pass" placeholder="Senha">
                <input type="submit" value="Próximo">
            </form>
        <?php
                break;
                case 1:
        ?>
            <form action="?step=2" method="POST">
                <div>
                    <label for="">Your name:</label>
                    <input type="text" name="" id="" placeholder="Ex: Fulano">
                </div>
                <div>
                    <label for="">Your lastname:</label>
                    <input type="text" name="" id="" placeholder="Ex: De Tal">
                </div>
                <div>
                    <label for="">Birthdate</label>
                    <select name="day">
                        <option value="">Day</option>
                        <?php for ($day = 1; $day <= 31; $day++) { ?>
                            <option value="<?php echo strlen($day)==1 ? '0'.$day : $day; ?>"><?php echo strlen($day)==1 ? '0'.$day : $day; ?></option>
                        <?php } ?>
                    </select>
                    <select name="month">
                        <option value="">Month</option>
                        <?php for ($month = 1; $month <= 12; $month++) { ?>
                            <option value="<?php echo strlen($month)==1 ? '0'.$month : $month; ?>"><?php echo strlen($month)==1 ? '0'.$month : $month; ?></option>
                        <?php } ?>
                    </select>
                    <select name="year">
                        <option value="">Year</option>
                        <?php for ($year = date('Y'); $year > date('Y')-100; $year--) { ?>
                            <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <input type="submit" value="Signup">
            </form>
        <?php
                break;
                case 2:
        ?>
            <span>Logging...</span>
        <?php
                break;
            }
        ?>
    </div>
</body>
</html>