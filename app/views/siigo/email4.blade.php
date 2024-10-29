<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
   <html lang="en" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml">
<head>
<title></title>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>

    <!-- CSS Reset : BEGIN -->
    <style>

        /* What it does: Remove spaces around the email design added by some email clients. */
        /* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */
        html,
body {
    margin: 0 auto !important;
    padding: 0 !important;
    height: 100% !important;
    width: 100% !important;
    background: #f1f1f1;
}

/* What it does: Stops email clients resizing small text. */
* {
    -ms-text-size-adjust: 100%;
    -webkit-text-size-adjust: 100%;
}

/* What it does: Centers email on Android 4.4 */
div[style*="margin: 16px 0"] {
    margin: 0 !important;
}

/* What it does: Stops Outlook from adding extra spacing to tables. */
table,
td {
    mso-table-lspace: 0pt !important;
    mso-table-rspace: 0pt !important;
}

/* What it does: Fixes webkit padding issue. */
table {
    border-spacing: 0 !important;
    border-collapse: collapse !important;
    table-layout: fixed !important;
    margin: 0 auto !important;
}

/* What it does: Uses a better rendering method when resizing images in IE. */
img {
    -ms-interpolation-mode:bicubic;
}

/* What it does: Prevents Windows 10 Mail from underlining links despite inline CSS. Styles for underlined links should be inline. */
a {
    text-decoration: none;
}

/* What it does: A work-around for email clients meddling in triggered links. */
*[x-apple-data-detectors],  /* iOS */
.unstyle-auto-detected-links *,
.aBn {
    border-bottom: 0 !important;
    cursor: default !important;
    color: inherit !important;
    text-decoration: none !important;
    font-size: inherit !important;
    font-family: inherit !important;
    font-weight: inherit !important;
    line-height: inherit !important;
}

/* What it does: Prevents Gmail from displaying a download button on large, non-linked images. */
.a6S {
    display: none !important;
    opacity: 0.01 !important;
}

/* What it does: Prevents Gmail from changing the text color in conversation threads. */
.im {
    color: inherit !important;
}

/* If the above doesn't work, add a .g-img class to any image in question. */
img.g-img + div {
    display: none !important;
}

/* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */
/* Create one of these media queries for each additional viewport size you'd like to fix */

/* iPhone 4, 4S, 5, 5S, 5C, and 5SE */
@media only screen and (min-device-width: 320px) and (max-device-width: 374px) {
    u ~ div .email-container {
        min-width: 320px !important;
    }
}
/* iPhone 6, 6S, 7, 8, and X */
@media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
    u ~ div .email-container {
        min-width: 375px !important;
    }
}
/* iPhone 6+, 7+, and 8+ */
@media only screen and (min-device-width: 414px) {
    u ~ div .email-container {
        min-width: 414px !important;
    }
}

    </style>

    <!-- CSS Reset : END -->

    <!-- Progressive Enhancements : BEGIN -->
    <style>

	    .primary{
	background: #ffc0d0;
}
.bg_white{
	background: #ffffff;
}
.bg_light{
	background: #fafafa;
}
.bg_black{
	background: #000000;
}
.bg_dark{
	background: rgba(0,0,0,.8);
}
.email-section{
	padding:2.5em;
}

/*BUTTON*/
.btn{
	padding: 5px 20px;
	display: inline-block;
}

.btn.btn-secondary{
	border-radius: 5px;
	background: #42B30C;
	color: #ffffff;
}
.btn.btn-primary{
	border-radius: 5px;
	background: #D50139;
	color: #ffffff;
}
.btn.btn-white{
	border-radius: 5px;
	background: #ffffff;
	color: #000000;
}
.btn.btn-white-outline{
	border-radius: 5px;
	background: transparent;
	border: 1px solid #fff;
	color: #fff;
}
.btn.btn-black{
	border-radius: 0px;
	background: #000;
	color: #fff;
}
.btn.btn-black-outline{
	border-radius: 0px;
	background: transparent;
	border: 2px solid #000;
	color: #000;
	font-weight: 700;
}

h1,h2,h3,h4,h5,h6{
	font-family: 'Playfair Display', sans-serif;
	color: #000000;
	margin-top: 0;
	font-weight: 400;
}

body{
	font-family: 'Lato', sans-serif;
	font-weight: 400;
	font-size: 15px;
	line-height: 1.8;
	color: rgba(0,0,0,.5);
}

a{
	color: #ffc0d0;
}

table{
}
/*LOGO*/

.logo h1{
	margin: 0;
}
.logo h1 a{
	color: #000000;
	font-size: 30px;
	font-weight: 700;
	/*text-transform: uppercase;*/
	font-family: 'Playfair Display', sans-serif;
	font-style: italic;
}

.navigation{
	padding: 0;
	padding: 1em 0;
	/*background: rgba(0,0,0,1);*/
	border-top: 1px solid rgba(0,0,0,.05);
	border-bottom: 1px solid rgba(0,0,0,.05);
	margin-bottom: 0;
}
.navigation li{
	list-style: none;
	display: inline-block;;
	margin-left: 5px;
	margin-right: 5px;
	font-size: 13px;
	font-weight: 500;
	text-transform: uppercase;
	letter-spacing: 2px;
}
.navigation li a{
	color: rgba(0,0,0,1);
}

/*HERO*/
.hero{
	position: relative;
	z-index: 0;
}
.hero .overlay{
	position: absolute;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	content: '';
	width: 100%;
	background: #000000;
	z-index: -1;
	opacity: .2;
}
.hero .text{
	color: rgba(255,255,255,.9);
	max-width: 50%;
	margin: 0 auto 0;
}
.hero .text h2{
	color: #fff;
	font-size: 30px;
	margin-bottom: 0;
	font-weight: 300;
	line-height: 1.4;
}
.hero .text h2 span{
	font-weight: 600;
	color: #ffc0d0;
}

/*INTRO*/
.intro{
	position: relative;
	z-index: 0;
}

.intro .text{
	color: rgba(0,0,0,.3);
}
.intro .text h2{
	color: #000;
	font-size: 34px;
	margin-bottom: 0;
	font-weight: 300;
}
.intro .text h2 span{
	font-weight: 600;
	color: #ffc0d0;
}


/*PRODUCT*/
.text-product{
}
.text-product .price{
	font-size: 20px;
	color: #fff;
	display: inline-block;;
	margin-bottom: 1em;
	border: 2px solid #fff;
	padding: 0 10px;
}
.text-product h2{
	font-family: 'Lato', sans-serif;
}

/*HEADING SECTION*/
.heading-section{
}
.heading-section h2{
	color: #000000;
	font-size: 28px;
	margin-top: 0;
	line-height: 1.4;
	font-weight: 400;
}
.heading-section .subheading{
	margin-bottom: 20px !important;
	display: inline-block;
	font-size: 13px;
	text-transform: uppercase;
	letter-spacing: 2px;
	color: rgba(0,0,0,.4);
	position: relative;
}
.heading-section .subheading::after{
	position: absolute;
	left: 0;
	right: 0;
	bottom: -10px;
	content: '';
	width: 100%;
	height: 2px;
	background: #ffc0d0;
	margin: 0 auto;
}

.heading-section-white{
	color: rgba(255,255,255,.8);
}
.heading-section-white h2{
	font-family: 
	line-height: 1;
	padding-bottom: 0;
}
.heading-section-white h2{
	color: #ffffff;
}
.heading-section-white .subheading{
	margin-bottom: 0;
	display: inline-block;
	font-size: 13px;
	text-transform: uppercase;
	letter-spacing: 2px;
	color: rgba(255,255,255,.4);
}


ul.social{
	padding: 0;
}
ul.social li{
	display: inline-block;
	margin-right: 10px;
}

/*FOOTER*/

.footer{
	border-top: 1px solid rgba(0,0,0,.05);
	color: rgba(0,0,0,.5);
}
.footer .heading{
	color: #000;
	font-size: 20px;
}
.footer ul{
	margin: 0;
	padding: 0;
}
.footer ul li{
	list-style: none;
	margin-bottom: 10px;
}
.footer ul li a{
	color: rgba(0,0,0,1);
}


@media screen and (max-width: 500px) {


}

	.rectangle {
		position: absolute;
		width: 612px;
		height: 158px;
		left: calc(50% - 612px/2);
		top: 0px;

		background: #E04403;
		border-radius: 0px 0px 90px 90px;
	}

	.group-3 {
		position: absolute;
		width: 278.18px;
		height: 79.79px;
		left: calc(50% - 278.18px/2 + 0.09px);
		top: 39px;
	}

	.calendar {
		position: absolute;
		left: 31.82%;
		right: 60.49%;
		top: 25.66%;
		bottom: 69.4%;
	}

	.clipboard {

		position: absolute;
		left: 43.5%;
		right: 39.62%;
		top: 22.98%;
		bottom: 55.83%;

	}

	.char1 {
		position: absolute;
		left: 29.54%;
		right: 57.52%;
		top: 35.69%;
		bottom: 48.72%;
	}

	.char2 {
		position: absolute;
		left: 33.33%;
		right: 30.04%;
		top: 32.29%;
		bottom: 46.01%;
	}

	.symbols {
		position: absolute;
		left: 34.54%;
		right: 34.42%;
		top: 26.39%;
		bottom: 65.9%;
	}

	.names {
		font-family: Sansation;
		font-size: 24px;
		font-weight: 700;
		line-height: 24.48px;
		text-align: center;
		color: #E04403;

	}

	.asunto {
		font-family: Sansation;
		font-size: 12px;
		font-weight: 400;
		line-height: 12.24px;
		text-align: center;

	}

	.aceptar {
		/* Rectangle 14 */

		position: absolute;
		width: 217px;
		height: 32px;
		left: 700px;
		top: 664px;

		background: #E04403;
		border-radius: 100px;
		font-family: Sansation;
		font-size: 13px;
		
		
		text-align: center;

	}

	.rechazar {
		position: absolute;
		width: 217px;
		height: 32px;
		left: 1000px;
		top: 664px;

		
		border-radius: 100px;
		border: 1px solid black;

		font-family: Sansation;
		font-size: 13px;
		text-align: center;
		color: black;

	}

	.lineas {
		font-family: Sansation;
		font-size: 9px;
		font-style: italic;
		font-weight: 700;
		line-height: 9.18px;
		text-align: center;
		color: rgba(255, 255, 255, 1);
		
	}

	.tops {
		height: 33px;
		top: 53px;
		left: 161px;
		gap: 0px;
		border-radius: 6px 6px 6px 6px;
		opacity: 0px;
		background: rgba(192, 57, 0, 1);
	}

	.respu {
		font-family: Sansation;
		font-size: 24px;
		font-weight: 700;
		line-height: 31.48px;
		text-align: center;
		color: rgba(255, 255, 255, 1);

	}

	.gracias {
		font-family: Futura Hv BT;
		font-size: 35px;
		font-weight: 400;
		line-height: 41.4px;
		text-align: center;
		color: rgba(255, 255, 255, 1);
	}

	.ide {
		font-family: Sansation;
		font-size: 16px;
		font-weight: 400;
		line-height: 16.32px;
		text-align: center;
		color: white;
	}

	.status {
		font-family: Sansation;
		font-size: 17px;
		font-weight: 700;
		line-height: 15.3px;
		text-align: center;
		margin-top: 30px;
		color: white;
	}

	.elegir {
		font-family: Sansation;
		font-size: 15px;
		font-weight: 400;
		line-height: 11.22px;
		text-align: center;
		color: white;
	}

	.happys {
		font-family: Sansation;
		font-size: 15px;
		font-weight: 700;
		line-height: 48.96px;
		text-align: center;
		color: rgba(255, 255, 255, 1);
	}

	.logos {
		width: 1109.9px;
		height: 289.6px;
		top: 265px;
		left: 404.86px;
		gap: 0px;
		opacity: 0px;

	}

	.cards {
		
		height: 43px;
		top: 1434px;
		left: 431px;
		gap: 0px;
		border-radius: 33px 33px 33px 33px;
		opacity: 0px;
		background-color: rgba(30, 30, 30, 1);

	}

	.adjuntar {
		font-family: Sansation;
		font-size: 22px;
		font-weight: 700;
		line-height: 40.96px;
		text-align: center;
		color: rgba(255, 255, 255, 1);
	}

	.data {
		font-family: Sansation;
		font-size: 16px;
		font-weight: 700;
		line-height: 40.8px;
		text-align: left;
		color: rgba(255, 255, 255, 1);
	}
    </style>


</head>

<body width="100%" style="margin: 0; padding: 0 !important; mso-line-height-rule: exactly; ">


    <div style="max-width: 600px; margin: 0 auto;" class="email-container">
    	<!-- BEGIN BODY -->
      <table>
      	<tr>
        
	      </tr><!-- end tr -->
	      <tr>
          
	      </tr><!-- end tr -->
	      <tr>
          <td >

            
          </td>
	      </tr><!-- end tr -->
				<tr>
          <td valign="middle" class="intro bg_white" style="background-color: rgba(224, 68, 3, 1);">
            <table>
            	<tr>

            		

            		<td>
            			

            			<div class="text" style="padding: 0 2.5em; text-align: center;">

            				<div>
            					
            				</div>

            				<p class="gracias">¡GRACIAS POR LEERNOS!</p>
            				<span class="ide">Somos AOTOUR una empresa de transporte que ofrece soluciones rápidas de movilidad. Vive con nosotros una experiencia única de transporte, tecnología y seguridad.</span>

            				<div class="cards">
            					<p class="adjuntar">Adjuntamos nuestro protafolio de servicios</p>
            				</div>
            				<h4 class="status">¿Cómo contactarnos?</h4>

            				<span class="happys">Contáctanos para conocer más sobre la experiencia AOTOUR. <br>Estas son las personas que te pueden asesorar.</span>
            				<br>
            				<img src="{{url('img/userc.png')}}" height="150px" align="left" style="margin-left: 170px; margin-bottom: 35px; margin-top: 25px;">
            				
            				<span class="data"><b>Barranquilla</b><br>Jhonnys Ojeda<br>comercial@aotour.com.co<br>Cel. +57 304 607 5607</span>

            				<br><br><br>

            				<hr style="width: 522px; height: 0px; top: 2266.5px; left: 199px; gap: 0px; border: 5px 0px 0px 0px; opacity: 0px;">

							<table>
					      	<tr>
					          <td>
					            <a href="https://wa.me/573046075207?text=Hola,%20Tengo%20una%20duda%20sobre%20el%20portafolio%20de%20servicios..."><p style="font-family: Sansation; font-size: 18px; font-weight: 700; line-height: 12.24px; text-align: left; color: rgba(255, 255, 255, 1);">¿Tienes Preguntas?</p></a>
					          </td>
					          <td>
					            <a href="https://app.aotour.com.co/autonet"><p style="margin-left: 100px; font-family: Sansation; font-size: 18px; font-weight: 700; line-height: 12.24px; text-align: right; color: rgba(255, 255, 255, 1);">Solicita una reunión por Zoom</p></a>
					          </td>
					        </tr>
				     	</table>
				     	<br><br>
				     	<img width="9px" height="18px" src="{{url('img/facebook.png')}}" style="margin-right: 20px">
				     	<img width="12px" height="18px" src="{{url('img/x.png')}}">
				     	<img width="12px" height="18px" src="{{url('img/linkedin.png')}}" style="margin-left: 20px">
            			</div>
            			<br>
            		</td>
            	</tr>
            </table>
          </td>

      <!-- 1 Column Text + Button : END -->
      </table>


    </div>
  </center>
</body>
</html>