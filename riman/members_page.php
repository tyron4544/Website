<?php
    session_start(); 

    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit();
    }

    if ($_SESSION['user_level'] === 1) {
        header('Location: admin_page.php'); 
        exit();
    }
    ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Website ni Riman</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/style.css?v=1.0">
</head>
<body>
    <div id="container">
        <?php include('header.php'); ?>
    </div>

    <?php include('members_nav.php'); ?>

    <div id='content'>
        <br><br><br>
        <img src="http://d.gr-assets.com/authors/1397426898p5/203714.jpg" align="left">
        <p>Henry Ford was an American industrialist and the founder of the Ford Motor Company, who revolutionized the automobile industry with his introduction of assembly line production techniques. His vision was to make cars affordable for the average American, fundamentally changing transportation and society. Ford believed in the power of innovation and efficiency, famously stating, "Whether you think you can, or you think you can't—you're right." This quote encapsulates his belief in the importance of mindset in achieving success, highlighting how self-perception can influence one's ability to accomplish goals.</p>
        <br>
        <p>Henry Ford transformed the automotive industry with his pioneering methods and vision for mass production. By introducing the moving assembly line in 1913, he drastically reduced the time it took to build a car, making vehicles affordable for the average American. His innovative spirit not only changed manufacturing but also had a profound impact on labor practices and the economy. Ford famously said, "Coming together is a beginning; keeping together is progress; working together is success." This quote reflects his belief in teamwork and collaboration as essential components of any successful enterprise.</p>
        <br><br>
        <p>“I invented nothing new. I simply assembled the discoveries of other men behind whom were centuries of work. Had I worked fifty or ten or even five years before, I would have failed. So it is with every new thing. Progress happens when all the factors that make for it are ready, and then it is inevitable. To teach that a comparatively few men are responsible for the greatest forward steps of mankind is the worst sort of nonsense.”<br>- Henry Ford</p>
    </div>

    <?php include('footer.php'); ?>
</body>
</html>
