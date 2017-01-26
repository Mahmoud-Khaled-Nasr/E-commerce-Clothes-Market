<!DOCTYPE html>
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6 lt8"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7 lt8"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8 lt8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="UTF-8" />
        <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">  -->
        <title>Login and Registration Form with HTML5 and CSS3</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <meta name="description" content="Login and Registration Form with HTML5 and CSS3" />
        <meta name="keywords" content="html5, css3, form, switch, animation, :target, pseudo-class" />
        <meta name="author" content="Codrops" />
        <link rel="shortcut icon" href="images/favicon.png" />
        <link rel="stylesheet" type="text/css" href="css/demo.css" />
        <link rel="stylesheet" type="text/css" href="css/AnimateLogo.css" />
		<link rel="stylesheet" type="text/css" href="css/animate-custom.css" />

	   	<link rel="stylesheet" href="css/userlogin.css" type="text/css" media="all" />

	
    </head>
    <body>
	
        <div class="container">


			<header>

					

				 <h1><p> <a href="Sign_In.php"><img src="images/bm.png" alt="" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>ClothesShop <span>Please Login Or Sign Up </span></p> </h1>
				
				
			</header>

			<div class="codrops-top">
            <header>

			    <p align="center" align="center">	<b> <a href="Sign_In.php"  class="a-btn"> <span class="a-btn-text">Customer Login</span> </a> </b>
				<a href="Customer.php" class="a-btn"><strong><span class="a-btn-text">Create New Account</span></strong></a><a href="index.php" class="a-btn"><strong> <span class="a-btn-text">Back To Home</span></strong></a> </p>
            </header>
			 <div class="clr"></div>
			 </div> <br><br>
            <section>				
                <div id="container_demo" >
                    <!-- hidden anchor to stop jump http://www.css3create.com/Astuce-Empecher-le-scroll-avec-l-utilisation-de-target#wrap4  -->
                    <a class="hiddenanchor" id="toregister"></a>
                    <a class="hiddenanchor" id="tologin"></a>
                    <div id="wrapper">
                        <div id="registration" class="animate form">
                            <form  action="insertCustomer.php" method="post" autocomplete="on"> 
                                <h1>Customer Registration:</h1> 
                                <p> 
                                    <label for="username" class="uname" data-icon="u" > Your Username </label>
                                    <input type="text" name="magaca" required="required" type="text" placeholder="user648name"/>
                                </p>
                                <p> 
                                    <label for="password" class="youpasswd" data-icon="p"> Your Password </label>
                                    <input type="password" name='furaha' required="required" type="password" placeholder="eg. *********" /> 
                                </p>
								<p> 
                                    <label for="name" class="uname" data-icon="u" > Your Name </label>
                                    <input type="text" name="name" required="required" type="text" placeholder="Ahmad Nasr"/>
                                </p>
								<p> 
                                    <label for="age" class="uage" data-icon="u" > Your Age </label>
                                    <input type="text" name="age" required="required" type="text" placeholder="34"/>
                                </p>
								<p> 
                                    <label for="gender" class="ugender" data-icon="u" > Your Gender </label>
                                    <input type="text" name="gender" required="required" type="text" placeholder="M/F only"/>
                                </p>
								<p> 
                                    <label for="ssn" class="ussn" data-icon="u" > Your SSN </label>
                                    <input type="text" name="ssn" required="required" type="text" placeholder="14-number"/>
                                </p>
                                
                                <p class="Registration button"> 
                                    <input type="submit"  name="submit"  value =" registration">
								</p>

                            </form>
                        </div>

                    </div>
                </div>  
            </section>
        </div>
    </body>
</html
\\