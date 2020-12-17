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
            session_start();
            $step = $_GET['step'] ?? 0;
            $monthNum  = 3;
            $dateObj   = DateTime::createFromFormat('!m', $monthNum);
            $monthName = $dateObj->format('F');
            switch($step){
                default:
        ?>
            <form action="?step=1" method="POST">
                <input type="text" name="user" id="user" placeholder="User">
                <input type="email" name="email" id="email" placeholder="Email">
                <input type="password" name="pass" id="pass" placeholder="Senha">
                <input type="password" name="rep_pass" id="rep_pass" placeholder="Senha">
                <input type="hidden" name="passed_val" value="myb__value_1">
                <input type="submit" value="Próximo">
            </form>
        <?php
                break;
                case 1:
                    $_SESSION['REG_USR'] = $_POST['user'];
                    $_SESSION['REG_MAIL'] = $_POST['email'];
                    $_SESSION['REG_PASS'] = $_POST['pass'];
                    $_SESSION['REG_PASSED'] = $_POST['passed_val'];
        ?>
            <form action="?step=2" method="POST">
                <div>
                    <label for="">Your name:</label>
                    <input type="text" name="first_name" id="first_name" placeholder="Ex: Fulano">
                </div>
                <div>
                    <label for="">Your lastname:</label>
                    <input type="text" name="last_name" id="last_name" placeholder="Ex: De Tal">
                </div>
                <div>
                    <label for="">Birthdate</label>
                    <select name="day">
                        <option disabled selected style="display: none;">Day</option>
                        <?php for ($day = 1; $day <= 31; $day++) { ?>
                            <option value="<?php echo strlen($day)==1 ? '0'.$day : $day; ?>"><?php echo strlen($day)==1 ? '0'.$day : $day; ?></option>
                        <?php } ?>
                    </select>
                    <select name="month">
                        <option disabled selected style="display: none;">Month</option>
                        <?php for ($month = 1; $month <= 12; $month++) { ?>
                            <option value="<?php echo strlen($month)==1 ? '0'.$month : $month; ?>"><?php echo strlen($month)==1 ? '0'.$month : $month; ?></option>
                        <?php } ?>
                    </select>
                    <select name="year">
                        <option disabled selected style="display: none;">Year</option>
                        <?php for ($year = date('Y') - 3; $year > date('Y')-95; $year--) { ?>
                            <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <input type="submit" value="Signup">
            </form>
        <?php
                break;
                case 2:
                    $_SESSION['REG_FNAME'] = $_POST['first_name'];
                    $_SESSION['REG_LNAME'] = $_POST['last_name'];
                    $birthdate = new DateTime($_POST['day'].'-'.$_POST['month'].'-'.$_POST['year']);
                    $birthdate = $birthdate->format('d/m/Y');
                    $_SESSION['REG_BIRTH'] = $birthdate;
        ?>
            <form action="../libs/post/register.php" method="post">
               <input type="submit" value="Finalizar Cadastro"> 
            </form>
            <span>Logging...</span>
        <?php
                break;
            }
        ?>
    </div>
</body>
</html>