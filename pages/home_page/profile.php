<?php
    session_start();
    include('db_connection_profile.php');  

    /*ensure the user is logged in*/
    if (!isset($_SESSION['username'])) {
        header('Location: login.php');
        exit();
    }

    /*get the username*/
    $username = $_SESSION['username'];

    $sql = "SELECT username, role FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username); 
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['username']; 
        $role = $row['role'];    
    } else {
        $name = "Unknown";  
        $role = "Unknown";
    }

    $stmt->close();
    $conn->close();
?>

<html>
    <head>
        <title>Profile Page</title>
        <style>
            html, body {
                height:100%; /*for the body to take the full height of viewpoint*/
                margin:0; /*remove default margin*/
                padding:0; /*remove default padding*/
                display:flex;
                flex-direction:column; /*stack the elements vertically*/
            }
            header {
                position:-webkit-sticky; /*Safari browser support*/
                position:sticky; /*fixed positioning*/
                top:0; /*header will stick to the top, when it reaches the top of the viewpoint*/
                z-index:1000; /*overlaps the header on top when scrolling the other content*/
                background-color:white;
                display:flex; /*good alignment and distribution of space inside the conatiner*/
                justify-content:space-between; /*aligns items on both ends*/
                align-items:center; 
            }
            .logo{
                margin-top:0.36vw;
                width:7.99vw;
                height:6.39vw;
                margin-right:2.52vw; 
            }
            .navi{
                background-color:#f3b16b;
                display:flex;
                align-items:center;
                width:155.99vw;
                margin-top:0.16vw;
            }
            .navi a{
                float:left;
                display:block; /*makes the element behave like a block element instead of inline*/
                color:rgb(29, 14, 1);
                text-align:center;
                padding:1.15vw 6.98vw;       /*changed*/
                cursor:pointer;
                font-size:1.25vw;
                text-decoration:none;
                font-family:'sfprodisplay-regular', 'Helvetica', 'Arial', sans-serif;
            }
            .navi a:hover{
                background-color:#f3a846;
                color:black;
            }
            #lout :hover{                   /*changed*/
                background-color:red;
                color:black;
            }
            .navi a.active{
                background-color:#ca8c3b;
                color:black;
            }
            .grid-container2{
                flex:1; /*to push the footer to the bottom while taking the available space*/
                display:flex;
                grid-template-columns:auto auto; /*divide the container into 2 columns*/
                flex-wrap:wrap; /*wrap the items onto multiple lines*/
                justify-content:center; /*center items in horizontal way*/
                align-items:flex-start; /*align items to the top*/
                padding:3vw 4.09vw;
                gap:2.32vw;
                margin-top:2vw;
                margin-left:8.58vw;
                margin-right:8.58vw;
                background-color:#f09b4d;
                font-family:'sfprodisplay-regular', 'Helvetica', 'Arial', sans-serif;;
            }
            .grid-item2 {
                flex:1 1 40%; /*grow and shrink the items maintaining the layout*/
                max-width:100%; /*items don't exceed the container width*/
                padding:0 1rem;
                text-align:center;
            }
            .grid-item2 img{
                width:15vw; 
                height:15vw;
                float:right;
                max-width:100%;
                padding-top:2.6vw;
            }
            .grid-item2 h3{
                padding-top:1.6vw;
                font-size:2.56vw;
                margin-bottom:1rem;
                text-align:justify;
            }
            .grid-item2 p{
                font-size:1.18vw;
                line-height: 1.5;
                text-align:justify;
            }
            footer{
                margin-top:1.46vw;
                margin-bottom:-5.85vw;
                width:100%; /*for the footer to have the full length*/
                background-color:rgb(31, 21, 3);
            }
            .grid-container1{
                display:grid; /*creates a grid layout*/
                grid-template-columns:auto auto auto; /*divide the container into 3 columns*/
                gap:1.2vw;
                padding:4.8vw;
                background-color:rgb(31, 21, 3);
                margin-top:1.2vw;
                margin-bottom:0vw;
                margin-left:0vw;
                margin-right:0vw;
                padding-bottom:1vw;
                padding-top:0.6vw;
                font-family:'sfprodisplay-regular', 'Helvetica', 'Arial', sans-serif;
            }
            .grid-item1{
                padding-top:1.2vw;                
                color:white;
                font-size:0.98vw;
            }
            #foot{
                font-weight:bold;
                font-size:1.18vw;                   	
            }
            .contact-info img.rounded-icon{
                border-radius:50%;
                width:1.56vw;
                height:1.56vw;
                margin-top:0.6vw;
                margin-right:0.6vw;
                overflow:hidden; /*if the icon is larger, it will be clipped to fit inside the circle*/
            }
            .social-media-container{
                display:flex;
                align-items:center;
                justify-content:center; /*flex items horizontaly within container*/
                padding-top:0;
                color:white;
            }
            .social-icons{
                list-style:none;
                padding:0vw;
                margin:0.52vw;
                display:flex;
                justify-content:center;
                align-items:center;
                border-radius:0.52vw;
                padding:0vw;
            }
            .social-icons li{
                margin:0.26vw;
            }
            .social-icons a{
                display:inline-block; /*<a> elements stay in a block, doesn;t start in a new line*/
                width:2.08vw;
                height:2.08vw;
                border-radius:50%;
                overflow:hidden; /*if the icon is larger, it will be clipped to fit inside the circle*/
                border:0.16vw solid white;
            }
            .social-icons img{
                width:100%;
                height:100%;
                object-fit:cover; /*fully covers the space of the container(circle)*/
            }
        </style>
    </head>

    <body>
        <header>
			<img class="logo" src="../../assets/images/logo.png" alt="Your Logo">
            <div class="navi">
                <a href="home.php">Home</a>
                <a class="active" href="profile.php">Profile</a>
                <a href="subscription.php">Subscribe</a>
                <a href="help.html">Help</a>                
                <span id="lout"><a href="../../logout.php">Logout</a></span>
            </div>
		</header>

        <div class="grid-container2">
            <div class="grid-item2"><img src="../../assets/images/profilePic.png" alt ="Profile photo"></div>
            <div class="grid-item2">
                <!--this displays the user name and role-->
                <h3>Name: <?php echo htmlspecialchars($name); ?></h3>  
                <p>Role: <?php echo htmlspecialchars($role); ?></p>  
            </div>
        </div>

        <footer>
            <div class="grid-container1">
                <div class="grid-item1">
                    <span id="foot">THE DAILY LEDGER</span><br><br>The Daily Ledger is your trusted source for timely,<br> accurate, and insightful news. 
                    We deliver the<br> latest headlines across a wide range of topics,<br> including world events, technology, business, and lifestyle,<br> ensuring you stay informed and 
                    ahead of<br> the curve. Our mission is to provide balanced<br> and credible reporting, giving you the facts that<br> matter. At The Daily Ledger, we believe in the<br> 
                    power of knowledge, and we're committed to bringing<br> you the stories that shape our world. Stay connected<br> with us for real-time updates and in-depth 
                    analysis.
                </div>
                <div class="grid-item1">
                    <span id="foot">CONTACT US</span><br><br>
                    <div class="contact-info">
                        <img src="../../assets/images/location.png" alt="Location" class="rounded-icon">31, Cross Road, Colombo 07, Sri Lanka<br>
                        <img src="../../assets/images/phone.png" alt="Phone" class="rounded-icon">+94 118416952<br>
                        <img src="../../assets/images/phone.png" alt="Phone" class="rounded-icon">+94 783631024<br>
                        <img src="../../assets/images/mail.png" alt="Mail" class="rounded-icon">dailyledger@gmail.com
                    </div>
                </div>
                <div class="social-media-container">
                    <div class="grid-item3"><span id="foot">SOCIAL MEDIA</span></div>        
                    <ul class="social-icons">
                        <li><a href="https://web.facebook.com/profile.php?id=61565900249007&is_tour_dismissed" target="_blank"><img src="../../assets/images/fb.jpg" alt="Facebook"></a></li>
                        <li><a href="https://x.com/LodgerDaily" target="_blank"><img src="../../assets/images/x.jpg" alt="Twitter"></a></li>
                        <li><a href="" target="_blank"><img src="../../assets/images/insta.jpg" alt="Instagram"></a></li>
                        <li><a href="" target="_blank"><img src="../../assets/images/tiktok.jpg" alt="Tik tok"></a></li>
                    </ul>
                </div>
            </div>
        </footer>
    </body>
</html>