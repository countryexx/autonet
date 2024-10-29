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

	.contacto {
		font-family: Sansation;
		font-size: 16px;
		font-weight: 700;
		line-height: 16.32px;
		text-align: center;
		color: white;
	}

	.ide {
		font-family: Sansation;
		font-size: 16px;
		font-weight: 400;
		line-height: 16.32px;
		text-align: center;
		margin-top: 10px;
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

	.happy {
		font-family: Sansation;
		font-size: 15px;
		font-weight: 700;
		line-height: 11.22px;
		text-align: center;
		color: white;
	}

	.logos {
		width: 196.41px;
		height: 56.33px;
		top: 657px;
		left: 208px;
		gap: 0px;
		opacity: 0px;

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
          <td valign="middle" class="intro bg_white" style="padding: 2em 0 4em 0; background-color: rgba(35, 35, 35, 1);">
            <table>
            	<tr>
            		<td>
            			

            			<div class="text" style="padding: 0 2.5em; text-align: center;">

            				<div class="tops">
								<p class="respu">Respuesta Cotización</p>
	        				</div>

            				<p class="contacto">Maria Fernanda Puche Donado</p>
            				<span class="ide">Cotización N° 3430</span>

            				<h4 class="status">¡Ha sido Rechazada!</h4>

            				<span class="happy">Esperamos contar contigo en otra oportunidad.</span>
            				
            				<br><br>
							
							<svg width="431" height="423" viewBox="0 0 431 423" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M385.132 263.48C385.132 263.48 431.517 211.358 416.772 120.655C402.022 29.9465 326.288 -3.46656 276.036 13.996C225.779 31.4586 214.475 61.8337 173.423 79.2138C132.376 96.5985 54.4429 84.6482 15.458 143.016C-23.527 201.383 26.2398 298.094 89.5972 358.739C152.955 419.379 314.691 381.407 385.132 263.48Z" fill="#333333"/>
								<path d="M33.3662 187.815V198.405" stroke="white" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M38.6633 193.108H28.0693" stroke="white" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M394.761 97.0659V107.66" stroke="white" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M400.057 102.363H389.463" stroke="white" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M244.312 15.0774V25.6668" stroke="white" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M249.605 20.3744H239.016" stroke="white" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M69.9834 306.42V317.014" stroke="white" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M75.2798 311.717H64.6904" stroke="white" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M390.017 58.8919C390.017 63.7261 386.095 67.6484 381.26 67.6484C376.426 67.6484 372.504 63.7261 372.504 58.8919C372.504 54.0578 376.426 50.1355 381.26 50.1355C386.095 50.1355 390.017 54.0578 390.017 58.8919Z" stroke="white" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M15.2606 269.176C19.7286 267.325 21.8503 262.203 19.9996 257.735C18.1489 253.267 13.0266 251.145 8.55869 252.996C4.09074 254.847 1.96903 259.969 3.81971 264.437C5.6704 268.905 10.7927 271.027 15.2606 269.176Z" stroke="white" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M429.823 148.446C429.823 149.545 428.934 150.434 427.834 150.434C426.735 150.434 425.846 149.545 425.846 148.446C425.846 147.346 426.735 146.457 427.834 146.457C428.934 146.457 429.823 147.346 429.823 148.446Z" stroke="white" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M126.136 119.789C126.136 120.888 125.248 121.777 124.148 121.777C123.048 121.777 122.159 120.888 122.159 119.789C122.159 118.689 123.048 117.8 124.148 117.8C125.248 117.8 126.136 118.689 126.136 119.789Z" stroke="white" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M32.5771 422H395.841" stroke="white" stroke-miterlimit="10"/>
								<path d="M101.032 280.173L115.448 417.968" stroke="white" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M112.893 389.696L106.482 382.928" stroke="white" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M108.43 384.953C108.43 384.953 108.613 381.961 105.878 379.519C104.233 378.048 95.5772 374.41 94.757 377.457C93.8635 380.774 102.725 387.286 108.43 384.953Z" fill="#E04403" stroke="#222323" stroke-miterlimit="10"/>
								<path d="M108.431 384.953L100.192 379.821" stroke="white" stroke-width="0.5" stroke-miterlimit="10"/>
								<path d="M114.501 405.101L108.091 398.329" stroke="white" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M110.039 400.358C110.039 400.358 110.222 397.366 107.486 394.924C105.841 393.453 97.1856 389.815 96.3654 392.862C95.4719 396.18 104.334 402.691 110.039 400.358Z" fill="#E04403" stroke="#222323" stroke-miterlimit="10"/>
								<path d="M110.038 400.358L101.795 395.222" stroke="white" stroke-width="0.5" stroke-miterlimit="10"/>
								<path d="M108.968 352.108L102.558 345.341" stroke="white" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M104.506 347.366C104.506 347.366 104.69 344.374 101.954 341.931C100.309 340.461 91.6534 336.822 90.8332 339.87C89.9397 343.187 98.8015 349.698 104.506 347.366Z" fill="#E04403" stroke="#222323" stroke-miterlimit="10"/>
								<path d="M104.506 347.366L96.2627 342.229" stroke="white" stroke-width="0.5" stroke-miterlimit="10"/>
								<path d="M110.574 367.509L104.168 360.741" stroke="white" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M106.116 362.771C106.116 362.771 106.299 359.779 103.563 357.337C101.918 355.866 93.2628 352.228 92.4426 355.275C91.549 358.592 100.411 365.103 106.116 362.771Z" fill="#E04403" stroke="#222323" stroke-miterlimit="10"/>
								<path d="M106.115 362.771L97.8721 357.634" stroke="white" stroke-width="0.5" stroke-miterlimit="10"/>
								<path d="M106.358 327.085L99.9473 320.318" stroke="white" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M101.895 322.343C101.895 322.343 102.078 319.351 99.3427 316.908C97.6978 315.438 89.0421 311.799 88.2219 314.846C87.3283 318.164 96.1902 324.675 101.895 322.343Z" fill="#E04403" stroke="#222323" stroke-miterlimit="10"/>
								<path d="M101.896 322.343L93.6572 317.206" stroke="white" stroke-width="0.5" stroke-miterlimit="10"/>
								<path d="M103.733 301.952L97.3271 295.184" stroke="white" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M99.2749 297.214C99.2749 297.214 99.4582 294.222 96.7226 291.78C95.0776 290.309 86.4219 286.671 85.6017 289.718C84.7082 293.035 93.5701 299.547 99.2749 297.214Z" fill="#E04403" stroke="#222323" stroke-miterlimit="10"/>
								<path d="M99.2745 297.214L91.0312 292.078" stroke="white" stroke-width="0.5" stroke-miterlimit="10"/>
								<path d="M111.815 380.582L116.686 372.636" stroke="white" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M115.201 375.024C115.201 375.024 114.404 372.132 116.576 369.177C117.882 367.399 125.598 362.047 127.033 364.865C128.591 367.926 121.268 376.128 115.201 375.024Z" fill="#E04403" stroke="#222323" stroke-miterlimit="10"/>
								<path d="M115.202 375.024L122.621 367.931" stroke="white" stroke-width="0.5" stroke-miterlimit="10"/>
								<path d="M107.58 340.044L112.455 332.098" stroke="white" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M110.966 334.485C110.966 334.485 110.169 331.594 112.341 328.639C113.647 326.861 121.363 321.509 122.797 324.327C124.355 327.388 117.033 335.59 110.966 334.485Z" fill="#E04403" stroke="#222323" stroke-miterlimit="10"/>
								<path d="M110.968 334.485L118.391 327.392" stroke="white" stroke-width="0.5" stroke-miterlimit="10"/>
								<path d="M105.725 322.233L110.595 314.287" stroke="white" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M109.111 316.67C109.111 316.67 108.313 313.779 110.485 310.823C111.791 309.045 119.508 303.698 120.942 306.511C122.5 309.572 115.177 317.774 109.111 316.67Z" fill="#E04403" stroke="#222323" stroke-miterlimit="10"/>
								<path d="M109.111 316.67L116.53 309.581" stroke="white" stroke-width="0.5" stroke-miterlimit="10"/>
								<path d="M103 296.115L107.871 288.169" stroke="white" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M106.386 290.556C106.386 290.556 105.589 287.665 107.761 284.71C109.067 282.932 116.783 277.584 118.217 280.398C119.775 283.459 112.453 291.661 106.386 290.556Z" fill="#E04403" stroke="#222323" stroke-miterlimit="10"/>
								<path d="M106.386 290.556L113.804 283.463" stroke="white" stroke-width="0.5" stroke-miterlimit="10"/>
								<path d="M100.915 279.417C100.915 279.417 100.118 276.526 102.29 273.57C103.596 271.792 111.312 266.441 112.746 269.259C114.304 272.319 106.982 280.521 100.915 279.417Z" fill="#E04403" stroke="#222323" stroke-miterlimit="10"/>
								<path d="M100.916 279.417L108.339 272.329" stroke="white" stroke-width="0.5" stroke-miterlimit="10"/>
								<path d="M101.346 279.724C101.346 279.724 98.3858 280.215 95.6777 277.745C94.0465 276.26 89.5376 268.021 92.484 266.894C95.6915 265.666 103.078 273.809 101.346 279.724Z" fill="#E04403" stroke="#222323" stroke-miterlimit="10"/>
								<path d="M101.347 279.724L95.0693 271.6" stroke="white" stroke-width="0.5" stroke-miterlimit="10"/>
								<path d="M138.311 298.823L126.389 417.968" stroke="white" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M127.365 408.441L122.489 400.5" stroke="white" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M123.974 402.883C123.974 402.883 124.771 399.992 122.599 397.041C121.293 395.263 113.572 389.92 112.138 392.734C110.58 395.795 117.911 403.992 123.974 402.888V402.883Z" fill="#E04403" stroke="#222323" stroke-miterlimit="10"/>
								<path d="M123.974 402.883L116.968 396.161" stroke="white" stroke-width="0.5" stroke-miterlimit="10"/>
								<path d="M131.265 370.854L126.39 362.909" stroke="white" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M127.878 365.296C127.878 365.296 128.675 362.405 126.503 359.454C125.197 357.676 117.476 352.333 116.042 355.146C114.484 358.207 121.816 366.405 127.878 365.3V365.296Z" fill="#E04403" stroke="#222323" stroke-miterlimit="10"/>
								<path d="M127.877 365.296L120.866 358.574" stroke="white" stroke-width="0.5" stroke-miterlimit="10"/>
								<path d="M129.669 386.255L124.789 378.314" stroke="white" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M126.278 380.701C126.278 380.701 127.076 377.81 124.904 374.859C123.598 373.081 115.877 367.738 114.443 370.552C112.885 373.612 120.216 381.81 126.278 380.706V380.701Z" fill="#E04403" stroke="#222323" stroke-miterlimit="10"/>
								<path d="M126.279 380.701L119.272 373.979" stroke="white" stroke-width="0.5" stroke-miterlimit="10"/>
								<path d="M133.864 345.826L128.988 337.886" stroke="white" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M130.473 340.273C130.473 340.273 131.27 337.381 129.098 334.431C127.792 332.653 120.071 327.31 118.637 330.123C117.079 333.184 124.411 341.382 130.473 340.277V340.273Z" fill="#E04403" stroke="#222323" stroke-miterlimit="10"/>
								<path d="M130.473 340.273L123.467 333.546" stroke="white" stroke-width="0.5" stroke-miterlimit="10"/>
								<path d="M136.469 320.693L131.594 312.752" stroke="white" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M133.082 315.135C133.082 315.135 133.879 312.244 131.707 309.293C130.401 307.515 122.681 302.172 121.246 304.986C119.688 308.046 127.02 316.244 133.082 315.14V315.135Z" fill="#E04403" stroke="#222323" stroke-miterlimit="10"/>
								<path d="M133.083 315.135L126.072 308.413" stroke="white" stroke-width="0.5" stroke-miterlimit="10"/>
								<path d="M128.19 399.3L134.592 392.532" stroke="white" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M132.649 394.558C132.649 394.558 132.466 391.565 135.197 389.118C136.842 387.648 145.493 384 146.318 387.052C147.211 390.369 138.358 396.885 132.649 394.558Z" fill="#E04403" stroke="#222323" stroke-miterlimit="10"/>
								<path d="M132.648 394.558L141.368 389.146" stroke="white" stroke-width="0.5" stroke-miterlimit="10"/>
								<path d="M132.396 358.762L138.798 351.994" stroke="white" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M136.854 354.019C136.854 354.019 136.671 351.027 139.402 348.58C141.047 347.109 149.698 343.462 150.523 346.514C151.416 349.831 142.563 356.347 136.854 354.019Z" fill="#E04403" stroke="#222323" stroke-miterlimit="10"/>
								<path d="M136.854 354.019L145.574 348.608" stroke="white" stroke-width="0.5" stroke-miterlimit="10"/>
								<path d="M134.244 340.951L140.65 334.178" stroke="white" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M138.703 336.204C138.703 336.204 138.519 333.212 141.25 330.765C142.895 329.294 151.547 325.646 152.371 328.698C153.265 332.016 144.412 338.531 138.703 336.204Z" fill="#E04403" stroke="#222323" stroke-miterlimit="10"/>
								<path d="M138.702 336.204L147.427 330.792" stroke="white" stroke-width="0.5" stroke-miterlimit="10"/>
								<path d="M136.955 314.833L143.356 308.06" stroke="white" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M141.413 310.09C141.413 310.09 141.229 307.098 143.96 304.651C145.605 303.18 154.256 299.533 155.081 302.585C155.975 305.902 147.122 312.418 141.413 310.09Z" fill="#E04403" stroke="#222323" stroke-miterlimit="10"/>
								<path d="M141.413 310.09L150.133 304.679" stroke="white" stroke-width="0.5" stroke-miterlimit="10"/>
								<path d="M138.352 298.062C138.352 298.062 138.169 295.07 140.9 292.623C142.545 291.152 151.196 287.505 152.021 290.556C152.914 293.874 144.062 300.39 138.352 298.062Z" fill="#E04403" stroke="#222323" stroke-miterlimit="10"/>
								<path d="M138.353 298.062L147.072 292.65" stroke="white" stroke-width="0.5" stroke-miterlimit="10"/>
								<path d="M138.71 298.451C138.71 298.451 135.713 298.323 133.569 295.349C132.281 293.562 129.56 284.572 132.68 284.073C136.071 283.532 141.624 293.022 138.71 298.451Z" fill="#E04403" stroke="#222323" stroke-miterlimit="10"/>
								<path d="M138.71 298.451L134.242 289.209" stroke="white" stroke-width="0.5" stroke-miterlimit="10"/>
								<path d="M122.205 243.667L121.325 418.169" stroke="white" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M122.343 389.201L116.67 381.805" stroke="white" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M118.397 384.023C118.397 384.023 118.892 381.063 116.427 378.35C114.942 376.719 106.713 372.197 105.576 375.143C104.344 378.35 112.482 385.746 118.397 384.018V384.023Z" fill="#E04403" stroke="#222323" stroke-miterlimit="10"/>
								<path d="M118.397 384.023L110.735 378.062" stroke="white" stroke-width="0.5" stroke-miterlimit="10"/>
								<path d="M122.343 357.011L116.67 349.616" stroke="white" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M118.397 351.833C118.397 351.833 118.892 348.873 116.427 346.161C114.942 344.53 106.713 340.007 105.576 342.953C104.344 346.161 112.482 353.556 118.397 351.829V351.833Z" fill="#E04403" stroke="#222323" stroke-miterlimit="10"/>
								<path d="M118.397 351.833L110.735 345.872" stroke="white" stroke-width="0.5" stroke-miterlimit="10"/>
								<path d="M122.343 319.218L116.67 311.822" stroke="white" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M118.397 314.04C118.397 314.04 118.892 311.08 116.427 308.367C114.942 306.736 106.713 302.213 105.576 305.16C104.344 308.367 112.482 315.763 118.397 314.035V314.04Z" fill="#E04403" stroke="#222323" stroke-miterlimit="10"/>
								<path d="M118.397 314.04L110.735 308.078" stroke="white" stroke-width="0.5" stroke-miterlimit="10"/>
								<path d="M122.343 294.062L116.67 286.666" stroke="white" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M118.397 288.884C118.397 288.884 118.892 285.924 116.427 283.211C114.942 281.58 106.713 277.057 105.576 280.004C104.344 283.211 112.482 290.607 118.397 288.879V288.884Z" fill="#E04403" stroke="#222323" stroke-miterlimit="10"/>
								<path d="M118.397 288.884L110.735 282.918" stroke="white" stroke-width="0.5" stroke-miterlimit="10"/>
								<path d="M122.343 268.791L116.67 261.396" stroke="white" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M118.397 263.613C118.397 263.613 118.892 260.653 116.427 257.941C114.942 256.309 106.713 251.787 105.576 254.733C104.344 257.941 112.482 265.336 118.397 263.609V263.613Z" fill="#E04403" stroke="#222323" stroke-miterlimit="10"/>
								<path d="M118.397 263.613L110.735 257.652" stroke="white" stroke-width="0.5" stroke-miterlimit="10"/>
								<path d="M122.219 399.03L127.887 391.634" stroke="white" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M126.163 393.852C126.163 393.852 125.668 390.892 128.133 388.179C129.618 386.548 137.847 382.025 138.984 384.972C140.216 388.179 132.078 395.575 126.163 393.847V393.852Z" fill="#E04403" stroke="#222323" stroke-miterlimit="10"/>
								<path d="M126.164 393.852L134.279 387.57" stroke="white" stroke-width="0.5" stroke-miterlimit="10"/>
								<path d="M122.219 347.833L127.887 340.438" stroke="white" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M126.163 342.655C126.163 342.655 125.668 339.695 128.133 336.983C129.618 335.351 137.847 330.829 138.984 333.775C140.216 336.983 132.078 344.378 126.163 342.651V342.655Z" fill="#E04403" stroke="#222323" stroke-miterlimit="10"/>
								<path d="M126.164 342.655L134.279 336.373" stroke="white" stroke-width="0.5" stroke-miterlimit="10"/>
								<path d="M122.219 322.567L127.887 315.172" stroke="white" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M126.163 317.389C126.163 317.389 125.668 314.429 128.133 311.717C129.618 310.085 137.847 305.563 138.984 308.509C140.216 311.717 132.078 319.112 126.163 317.385V317.389Z" fill="#E04403" stroke="#222323" stroke-miterlimit="10"/>
								<path d="M126.164 317.389L134.279 311.103" stroke="white" stroke-width="0.5" stroke-miterlimit="10"/>
								<path d="M122.219 289.168L127.887 281.772" stroke="white" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M126.163 283.99C126.163 283.99 125.668 281.03 128.133 278.317C129.618 276.686 137.847 272.164 138.984 275.11C140.216 278.317 132.078 285.713 126.163 283.986V283.99Z" fill="#E04403" stroke="#222323" stroke-miterlimit="10"/>
								<path d="M126.164 283.99L134.279 277.708" stroke="white" stroke-width="0.5" stroke-miterlimit="10"/>
								<path d="M122.221 262.912L127.889 255.517" stroke="white" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M126.166 257.734C126.166 257.734 125.671 254.774 128.136 252.062C129.621 250.43 137.85 245.908 138.986 248.854C140.219 252.062 132.081 259.457 126.166 257.73V257.734Z" fill="#E04403" stroke="#222323" stroke-miterlimit="10"/>
								<path d="M126.166 257.734L134.281 251.448" stroke="white" stroke-width="0.5" stroke-miterlimit="10"/>
								<path d="M121.881 246.087C121.881 246.087 121.387 243.126 123.852 240.414C125.336 238.783 133.566 234.26 134.702 237.206C135.935 240.414 127.797 247.809 121.881 246.082V246.087Z" fill="#E04403" stroke="#222323" stroke-miterlimit="10"/>
								<path d="M121.882 246.087L129.997 239.804" stroke="white" stroke-width="0.5" stroke-miterlimit="10"/>
								<path d="M122.275 246.439C122.275 246.439 119.283 246.618 116.841 243.883C115.375 242.238 111.741 233.577 114.793 232.757C118.11 231.868 124.612 240.735 122.275 246.439Z" fill="#E04403" stroke="#222323" stroke-miterlimit="10"/>
								<path d="M122.275 246.439L116.877 237.706" stroke="white" stroke-width="0.5" stroke-miterlimit="10"/>
								<path d="M352.826 418.146L347.579 357.662H223.343L216.488 418.146H352.826Z" fill="#222323"/>
								<path d="M276.73 174.33C276.73 174.33 240.394 184.31 224.53 196.334C208.667 208.362 197.665 220.642 200.222 243.928C202.779 267.215 219.412 330.925 219.412 330.925C219.412 330.925 217.107 356.768 217.107 358.303C217.107 359.839 216.85 364.187 222.482 364.444C228.113 364.7 295.663 367.514 310.757 367.77C325.855 368.027 345.811 366.492 348.115 364.7C350.42 362.909 351.699 360.095 351.955 357.025C352.212 353.955 354.769 316.34 354.769 316.34L355.025 299.45C355.025 299.45 371.658 244.18 372.68 226.269C373.702 208.357 367.049 202.474 359.63 196.842C352.212 191.211 329.122 181.684 316.645 177.909C304.168 174.133 276.73 174.325 276.73 174.325V174.33Z" fill="#E04403" stroke="#222323" stroke-miterlimit="10"/>
								<path d="M285.692 260.2C283.846 285.122 280.56 331.053 280.854 338.916C281.257 349.808 276.821 353.034 276.821 357.066" stroke="#1E2E34" stroke-miterlimit="10"/>
								<path d="M286.903 244.125C286.903 244.125 286.577 248.368 286.073 255.077" stroke="#1E2E34" stroke-miterlimit="10"/>
								<path d="M303.118 276.141L305.441 303.556L318.455 302.626L303.118 276.141Z" fill="#222323"/>
								<path d="M290.792 323.947C290.792 323.947 322.588 318.952 324.952 319.479C327.316 320.006 343.61 327.887 345.975 328.414C348.339 328.941 350.442 329.99 350.442 329.99L354.007 332.973L352.807 323.947C352.807 323.947 348.078 318.164 337.567 313.962C327.055 309.756 321.799 312.125 319.435 312.913C317.071 313.701 290.792 323.951 290.792 323.951V323.947Z" fill="#222323"/>
								<path d="M241.933 299.964L324.581 299.707C324.581 299.707 351.195 297.15 352.216 296.893C353.238 296.637 363.731 299.45 364.753 300.22C365.775 300.99 365.775 303.29 365.266 305.595L364.753 307.9C364.753 307.9 365.523 311.992 365.523 313.783C365.523 315.575 363.475 316.088 363.218 316.853C362.962 317.623 364.753 320.437 362.705 322.228L360.657 324.02C360.657 324.02 360.4 328.881 359.378 330.16C358.356 331.438 355.286 333.743 354.003 332.973C352.72 332.204 353.234 330.16 353.234 328.882C353.234 327.603 352.72 326.325 351.185 326.325C349.65 326.325 349.394 327.603 341.462 325.555C333.53 323.507 324.829 316.601 324.064 316.345C323.294 316.088 253.952 334.77 233.484 337.326C213.015 339.883 211.224 337.07 210.454 333.743C209.684 330.417 208.406 322.485 208.406 322.485L204.822 306.878L241.924 299.968L241.933 299.964Z" fill="white" stroke="#1E2E34" stroke-miterlimit="10"/>
								<path d="M295.649 204.316C295.649 204.316 299.92 199.821 302.614 201.846C305.308 203.867 307.783 214.653 311.151 213.755C314.519 212.857 321.259 191.962 321.259 183.65C321.259 175.338 315.417 170.394 314.07 169.945C312.722 169.496 278.347 169.047 274.306 170.619C270.26 172.19 268.688 186.344 267.116 194.881C265.545 203.418 269.137 205.438 271.387 204.316C273.632 203.193 282.393 199.596 284.418 199.596C286.444 199.596 295.649 204.316 295.649 204.316Z" fill="#E04403" stroke="#222323" stroke-miterlimit="10"/>
								<path d="M318.656 156.964C318.656 156.964 315.435 172.882 314.184 176.818C312.933 180.754 303.81 192.737 301.482 195.243C299.159 197.749 292.359 210.089 290.572 210.447C288.785 210.804 283.777 193.992 283.777 193.992C283.777 193.992 277.339 182.903 276.084 180.039C274.833 177.176 272.862 168.772 272.862 168.772C272.862 168.772 283.415 177.895 294.683 175.925C305.95 173.959 311.673 162.687 311.673 162.687L318.647 156.964H318.656Z" fill="white" stroke="#1E2E34" stroke-miterlimit="10"/>
								<path d="M274.98 125.237C274.98 125.237 271.837 121.869 270.036 127.033C268.24 132.202 271.832 141.412 271.832 141.412L274.976 125.237H274.98Z" fill="white" stroke="#1E2E34" stroke-miterlimit="10"/>
								<path d="M275.546 114.748C275.546 114.748 270.359 151.598 270.359 153.742C270.359 155.887 268.93 163.044 271.074 167.695C273.219 172.346 279.661 178.069 284.848 178.784C290.035 179.499 300.23 178.427 305.954 173.954C311.677 169.482 318.298 159.823 318.298 159.823C318.298 159.823 325.451 158.751 330.101 156.78C334.752 154.815 338.331 150.343 338.152 145.692C337.974 141.041 335.11 137.462 335.11 137.462L332.425 132.454L339.577 119.037C339.577 119.037 335.463 111.344 322.225 104.012C308.987 96.6809 297.183 94.3532 291.639 94.3532C286.095 94.3532 279.116 96.6764 277.15 101.149C275.184 105.621 275.542 114.744 275.542 114.744L275.546 114.748Z" fill="white" stroke="#1E2E34" stroke-miterlimit="10"/>
								<path d="M292.543 96.6855C292.543 96.6855 302.738 113.497 310.432 112.783C318.125 112.068 320.448 108.489 320.448 108.489L325.635 115.463C325.635 115.463 320.091 117.786 321.163 120.65C322.235 123.514 327.065 129.952 327.065 129.952L323.129 146.764C323.129 146.764 326.171 147.3 326.708 146.228C327.244 145.156 329.929 138.534 329.929 138.534C329.929 138.534 331.001 137.819 332.252 137.462C333.503 137.105 335.116 137.462 335.116 137.462C335.116 137.462 337.082 130.845 337.801 130.667C338.516 130.488 345.673 128.522 348.354 121.544C351.039 114.57 346.924 103.476 337.622 94.7152C328.32 85.9495 308.645 83.6264 307.572 82.0135C306.5 80.4051 312.581 82.7283 311.33 79.1496C310.079 75.571 302.207 70.9201 292.19 75.9284C282.174 80.9367 283.603 86.4811 284.675 88.2727L285.748 90.0597C285.748 90.0597 277.339 87.1959 271.438 90.7745C265.536 94.3532 262.672 101.506 265.357 102.221C268.042 102.936 271.438 101.327 271.438 101.327C271.438 101.327 267.859 107.229 268.931 108.48C270.003 109.731 275.548 114.739 275.548 114.739C275.548 114.739 277.692 102.216 282.164 100.429C286.637 98.6421 292.538 96.6718 292.538 96.6718L292.543 96.6855Z" fill="#222323"/>
								<path d="M289.322 120.833L290.935 126.02L281.812 143.19L291.471 146.947" stroke="#1E2E34" stroke-miterlimit="10"/>
								<path d="M287.534 118.863C287.534 118.863 283.241 115.463 279.662 116.357C276.083 117.25 278.232 117.786 280.734 118.68C283.241 119.573 288.249 121.901 287.529 118.859L287.534 118.863Z" fill="#222323"/>
								<path d="M300.772 118.148C300.772 118.148 296.658 119.221 298.628 120.114C300.598 121.008 306.5 119.221 308.823 120.114C311.146 121.008 314.189 124.05 314.01 122.62C313.831 121.191 312.402 118.327 309.181 117.255C305.959 116.183 300.772 118.148 300.772 118.148Z" fill="#222323"/>
								<path d="M285.171 126.804C284.859 128.101 283.979 128.999 283.214 128.816C282.444 128.628 282.078 127.427 282.389 126.13C282.701 124.834 283.581 123.936 284.346 124.119C285.111 124.302 285.482 125.507 285.171 126.804Z" fill="#222323"/>
								<path d="M304.667 131.899C304.355 133.196 303.475 134.094 302.71 133.911C301.94 133.723 301.574 132.523 301.885 131.226C302.197 129.929 303.077 129.031 303.842 129.214C304.612 129.402 304.978 130.603 304.667 131.899Z" fill="#222323"/>
								<path d="M276.268 149.096L283.599 153.921" stroke="#1E2E34" stroke-miterlimit="10"/>
								<path d="M351.704 192.498C351.704 192.498 377.034 202.222 381.896 216.807C386.757 231.392 380.617 249.816 378.056 257.492C375.499 265.167 359.631 295.106 357.074 302.268C354.517 309.435 350.678 318.132 350.678 318.132C350.678 318.132 347.094 296.637 337.371 283.335C327.648 270.028 325.343 258.005 325.343 258.005C325.343 258.005 342.998 226.787 347.603 217.063" fill="#E04403"/>
								<path d="M351.704 192.498C351.704 192.498 377.034 202.222 381.896 216.807C386.757 231.392 380.617 249.816 378.056 257.492C375.499 265.167 359.631 295.106 357.074 302.268C354.517 309.435 350.678 318.132 350.678 318.132C350.678 318.132 347.094 296.637 337.371 283.335C327.648 270.028 325.343 258.005 325.343 258.005C325.343 258.005 342.998 226.787 347.603 217.063" stroke="#222323" stroke-miterlimit="10"/>
								<path d="M328.033 252.593C328.033 252.593 333.216 250 334.943 250.866C336.67 251.732 358.844 263.535 361.721 277.067C364.599 290.602 360.282 302.117 357.689 307.011C355.095 311.905 350.202 321.408 346.458 322.558C342.714 323.708 339.548 292.898 331.772 276.773C323.996 260.649 328.029 252.584 328.029 252.584L328.033 252.593Z" fill="#E04403" stroke="#222323" stroke-miterlimit="10"/>
								<path d="M336.605 237.788C336.605 237.788 341.211 222.182 343.002 216.037" stroke="#1E2E34" stroke-miterlimit="10"/>
								<path d="M290.395 182.363C290.395 182.363 283.242 172.346 277.693 165.729C272.149 159.113 266.426 155.177 264.455 155.713C262.489 156.249 261.77 158.219 263.026 160.542C264.281 162.866 270.178 168.057 271.255 169.487C272.327 170.916 273.94 176.103 273.94 176.103C273.94 176.103 268.753 176.461 267.86 177.533C266.966 178.605 265.715 181.469 265.715 181.469C265.715 181.469 263.928 182.363 263.03 183.792C262.137 185.222 262.137 185.579 261.958 186.299C261.779 187.013 259.273 188.264 259.451 191.486C259.63 194.707 262.673 199.358 263.745 201.502C264.817 203.647 272.689 213.127 274.119 214.74C275.549 216.353 283.778 230.658 285.923 235.488C288.067 240.318 308.82 296.302 314.9 304.711C320.981 313.119 332.253 321.165 338.333 324.029C344.414 326.893 348.707 322.063 351.571 315.978C354.435 309.898 356.937 297.732 351.392 283.779C345.848 269.827 334.938 257.844 326.53 250.687C318.121 243.534 302.382 225.646 300.595 222.424C298.808 219.203 296.48 212.05 296.48 212.05C296.48 212.05 301.131 198.455 301.488 195.238C301.846 192.017 300.059 186.294 300.595 183.792C301.131 181.286 303.28 176.278 304.173 174.133C305.067 171.989 308.109 168.41 306.496 166.802C304.888 165.193 298.267 167.159 295.944 170.916C293.621 174.674 290.399 182.363 290.399 182.363H290.395Z" fill="white" stroke="#1E2E34" stroke-miterlimit="10"/>
								<path d="M235.11 221.1C235.651 218.259 236.05 216.293 236.05 216.293L235.11 221.1Z" fill="#232323"/>
								<path d="M235.11 221.1C235.651 218.259 236.05 216.293 236.05 216.293" stroke="#1E2E34" stroke-miterlimit="10"/>
								<path d="M233.488 191.729C233.488 191.729 219.925 193.52 205.853 208.618C191.781 223.717 197.921 259.535 199.2 266.958C200.478 274.377 202.527 297.15 202.527 297.15L238.606 285.122C238.606 285.122 232.723 244.95 232.21 241.367C231.953 239.557 232.934 233.17 233.969 227.3" fill="#E04403"/>
								<path d="M233.488 191.729C233.488 191.729 219.925 193.52 205.853 208.618C191.781 223.717 197.921 259.535 199.2 266.958C200.478 274.377 202.527 297.15 202.527 297.15L238.606 285.122C238.606 285.122 232.723 244.95 232.21 241.367C231.953 239.557 232.934 233.17 233.969 227.3" stroke="#222323" stroke-miterlimit="10"/>
								<path d="M198.947 289.218C198.947 289.218 202.53 308.408 204.321 309.43C206.113 310.452 234.005 302.777 237.075 302.264C240.145 301.751 241.936 302.52 241.936 299.959C241.936 297.398 239.379 285.374 237.844 283.326C236.309 281.277 203.048 285.631 200.23 286.396C197.416 287.166 198.951 289.209 198.951 289.209L198.947 289.218Z" fill="#E04403" stroke="#222323" stroke-miterlimit="10"/>
								<path d="M219.38 274.386C229.731 278.505 237.841 283.335 237.841 283.335C237.841 283.335 229.14 266.958 225.561 263.632" stroke="#1E2E34" stroke-miterlimit="10"/>
								<path d="M214.555 272.585C215.581 272.943 216.598 273.314 217.597 273.689" stroke="#1E2E34" stroke-miterlimit="10"/>
								<path d="M298.472 356.351C305.088 353.992 311.183 351.394 314.857 348.837" stroke="#1E2E34" stroke-miterlimit="10"/>
								<path d="M267.263 365.47C267.263 365.47 281.399 362.116 294.815 357.616" stroke="#1E2E34" stroke-miterlimit="10"/>
								<path d="M326.72 347.774C319.769 351.238 308.754 356.31 299.759 358.56" stroke="#1E2E34" stroke-miterlimit="10"/>
								<path d="M333.536 344.232C333.536 344.232 332.11 345.02 329.746 346.239" stroke="#1E2E34" stroke-miterlimit="10"/>
								<path d="M94.1733 19.5175C33.2857 48.8479 21.7341 134.969 60.3524 186.729C68.4262 197.548 78.9789 206.671 91.4744 211.968C134.162 230.067 168.34 194.084 189.138 161.028C222.345 108.251 226.497 95.2055 225.906 104.099C225.314 112.993 240.729 122.483 249.627 75.6351C260.996 15.7556 177.156 2.13741 134.716 7.77346C120.489 9.66589 106.705 13.4782 94.1733 19.5129V19.5175Z" fill="#222323"/>
								<path d="M230.464 120.682C226.895 127.129 227.133 134.09 231.005 136.234C234.872 138.374 240.902 134.887 244.472 128.44C248.041 121.993 247.803 115.032 243.931 112.888C240.064 110.748 234.034 114.235 230.464 120.682Z" fill="#222323"/>
								<path d="M250.836 129.759C248.728 133.567 248.871 137.682 251.152 138.951C253.439 140.216 256.999 138.154 259.112 134.346C261.219 130.538 261.077 126.424 258.795 125.154C256.509 123.89 252.949 125.952 250.836 129.759Z" fill="#222323"/>
								<path d="M97.68 13.909C36.7924 43.2393 25.2408 129.361 63.8638 181.121C71.9375 191.939 82.4902 201.062 94.9857 206.359C137.673 224.459 171.851 188.475 192.65 155.42C225.857 102.642 230.008 89.5969 229.417 98.4909C228.826 107.385 244.24 116.875 253.139 70.0266C264.502 10.147 180.663 -3.47572 138.223 2.16491C123.995 4.05734 110.212 7.86969 97.68 13.9044V13.909Z" fill="white" stroke="#1E2E34" stroke-miterlimit="10"/>
								<path d="M233.972 115.074C230.402 121.521 230.645 128.481 234.512 130.626C238.38 132.765 244.41 129.278 247.979 122.831C251.549 116.384 251.31 109.424 247.438 107.279C243.571 105.14 237.541 108.627 233.972 115.074Z" fill="white" stroke="#1E2E34" stroke-miterlimit="10"/>
								<path d="M254.343 124.151C252.235 127.959 252.377 132.073 254.659 133.343C256.946 134.607 260.506 132.545 262.618 128.738C264.726 124.93 264.584 120.815 262.302 119.546C260.016 118.281 256.455 120.343 254.343 124.151Z" fill="white" stroke="#1E2E34" stroke-miterlimit="10"/>
								<path d="M88.5077 64.5463C82.473 73.2799 78.9355 83.8738 78.9355 95.2926C78.9355 125.196 103.175 149.435 133.078 149.435C162.981 149.435 187.221 125.196 187.221 95.2926C187.221 65.3894 162.981 41.1499 133.078 41.1499C129.697 41.1499 126.388 41.4614 123.181 42.0525" stroke="#222323" stroke-miterlimit="10"/>
								<path d="M97.6981 54.3052C95.8744 55.8815 94.1561 57.5769 92.5615 59.3777" stroke="#222323" stroke-miterlimit="10"/>
								<path d="M165.566 127.775C183.507 109.834 183.507 80.7463 165.566 62.8053C147.625 44.8644 118.537 44.8644 100.596 62.8053C82.6553 80.7463 82.6553 109.834 100.596 127.775C118.537 145.716 147.625 145.716 165.566 127.775Z" fill="#222323"/>
								<path d="M110.35 79.3879C121.623 90.66 132.899 101.937 144.171 113.209C145.775 114.812 147.379 116.416 148.987 118.025C152.117 121.154 156.978 116.297 153.849 113.163C142.577 101.891 131.3 90.6142 120.028 79.3421C118.424 77.7383 116.82 76.1346 115.212 74.5262C112.083 71.3966 107.221 76.2537 110.35 79.3879Z" fill="#CF5024"/>
								<path d="M113.554 119.674C125.797 107.431 138.036 95.1917 150.279 82.9482C152.021 81.207 153.757 79.4704 155.499 77.7292C158.628 74.5995 153.771 69.7379 150.637 72.8675C138.393 85.111 126.154 97.3499 113.911 109.593C112.17 111.335 110.433 113.071 108.692 114.813C105.562 117.942 110.419 122.804 113.554 119.674Z" fill="#CF5024"/>
								</svg>

								<br>
								<br><br>
							<svg width="196" height="56" viewBox="0 0 196 56" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M191.181 20.8621C191.181 19.7103 192.078 18.7889 193.214 18.7889C194.351 18.7889 195.248 19.7134 195.248 20.8621C195.248 22.0108 194.345 22.9262 193.214 22.9262C192.084 22.9262 191.181 22.0017 191.181 20.8621ZM194.763 20.8621C194.763 19.9346 194.087 19.2769 193.214 19.2769C192.342 19.2769 191.666 19.9346 191.666 20.8621C191.666 21.7896 192.326 22.4352 193.214 22.4352C194.102 22.4352 194.763 21.7774 194.763 20.8621ZM194.187 21.9108H193.675L193.205 21.0045H192.878V21.9108H192.405V19.7618H193.433C193.921 19.7618 194.257 19.8497 194.257 20.4196C194.257 20.8136 194.057 20.9773 193.681 21.0015L194.193 21.9078L194.187 21.9108ZM193.442 20.6802C193.675 20.6802 193.812 20.6287 193.812 20.3589C193.812 20.1407 193.539 20.1407 193.333 20.1407H192.875V20.6802H193.439H193.442Z" fill="white"/>
								<path d="M101.725 16.6915C101.725 24.3931 96.2027 29.8216 88.5647 29.8216C80.9267 29.8216 75.4043 24.3931 75.4043 16.6915C75.4043 9.49598 81.7178 4.44943 88.5647 4.44943C95.4117 4.44943 101.725 9.49598 101.725 16.6915ZM81.8451 16.7218C81.8451 20.8227 84.873 23.8233 88.5677 23.8233C92.2625 23.8233 95.2874 20.8227 95.2874 16.7218C95.2874 13.4393 92.2595 10.4447 88.5677 10.4447C84.876 10.4447 81.8451 13.4423 81.8451 16.7218Z" fill="#E04403"/>
								<path d="M114.055 29.0275H107.875V10.472H102.759V5.23749H119.168V10.472H114.055V29.0275Z" fill="white"/>
								<path d="M146.53 16.6915C146.53 24.3931 141.007 29.8216 133.369 29.8216C125.731 29.8216 120.212 24.3931 120.212 16.6915C120.212 9.49598 126.525 4.44943 133.369 4.44943C140.213 4.44943 146.53 9.49598 146.53 16.6915ZM126.65 16.7218C126.65 20.8227 129.678 23.8233 133.369 23.8233C137.061 23.8233 140.092 20.8227 140.092 16.7218C140.092 13.4393 137.058 10.4447 133.369 10.4447C129.681 10.4447 126.65 13.4423 126.65 16.7218Z" fill="white"/>
								<path d="M170.037 5.23749V18.6161C170.037 21.6774 169.909 24.7084 167.545 27.0089C165.554 28.9669 162.432 29.661 159.656 29.661C156.879 29.661 153.754 28.9669 151.766 27.0089C149.402 24.7053 149.271 21.6744 149.271 18.6161V5.23749H155.458V17.7644C155.458 20.856 155.679 24.2325 159.656 24.2325C163.632 24.2325 163.853 20.856 163.853 17.7644V5.23749H170.04H170.037Z" fill="white"/>
								<path d="M193.378 29.0305H185.679L179.778 19.8801V29.0305H173.592V5.23447H183.218C184.543 5.23447 185.7 5.42845 186.689 5.81944C187.677 6.2074 188.492 6.74085 189.135 7.41373C189.777 8.0866 190.259 8.86556 190.586 9.74756C190.914 10.6326 191.074 11.5783 191.074 12.5876C191.074 14.3971 190.638 15.864 189.765 16.9885C188.892 18.113 187.604 18.8768 185.901 19.2769L193.381 29.0275L193.378 29.0305ZM179.775 15.8701H180.942C182.16 15.8701 183.097 15.6185 183.752 15.1124C184.403 14.6062 184.731 13.8818 184.731 12.9361C184.731 11.9905 184.403 11.263 183.752 10.7599C183.1 10.2537 182.163 10.0022 180.942 10.0022H179.775V15.8731V15.8701Z" fill="white"/>
								<path d="M48.1016 29.8186H56.5519L61.7318 6.7954H62.2531L67.3997 29.8186H75.8833L65.4174 4.44641H58.6038L48.1016 29.8186Z" fill="#E04403"/>
								<path d="M48.8047 41.188V34.923H51.478C52.6692 34.923 53.2663 35.408 53.2663 36.3809C53.2663 37.0932 52.8328 37.6024 51.969 37.9116C52.8874 38.0661 53.3451 38.5541 53.3451 39.3785C53.3451 40.5849 52.6934 41.188 51.3871 41.188H48.8077H48.8047ZM51.3355 40.794C52.3448 40.794 52.851 40.3272 52.851 39.3907C52.851 38.5632 52.2175 38.151 50.9536 38.151H50.602V37.8388C52.063 37.7085 52.7934 37.2326 52.7934 36.4112C52.7934 35.6808 52.3448 35.3171 51.4447 35.3171H49.2624V40.794H51.3355Z" fill="white"/>
								<path d="M58.4225 36.5867V41.1877H58.0861L58.0345 40.5997C57.5041 40.9907 56.9161 41.1877 56.2644 41.1877C55.1763 41.1877 54.6338 40.6179 54.6338 39.4752V36.5867H55.0945V39.4873C55.0945 40.3451 55.4915 40.7755 56.2857 40.7755C56.8676 40.7755 57.4253 40.5815 57.9648 40.1935V36.5867H58.4255H58.4225Z" fill="white"/>
								<path d="M59.7374 40.9695V40.53C60.2496 40.7058 60.7497 40.7937 61.2438 40.7937C62.2106 40.7937 62.6956 40.4876 62.6956 39.8723C62.6956 39.3752 62.3379 39.1267 61.6226 39.1267H61.0346C60.0708 39.1267 59.5889 38.7175 59.5889 37.8991C59.5889 37.0232 60.2284 36.5837 61.5044 36.5837C61.9954 36.5837 62.4956 36.6564 63.0078 36.8019V37.2414C62.4956 37.0656 61.9954 36.9777 61.5044 36.9777C60.5345 36.9777 60.0496 37.2838 60.0496 37.8991C60.0496 38.4235 60.3769 38.6872 61.0346 38.6872H61.6226C62.6441 38.6872 63.1563 39.0812 63.1563 39.8692C63.1563 40.7452 62.5198 41.1847 61.2468 41.1847C60.7528 41.1847 60.2496 41.1119 59.7404 40.9664L59.7374 40.9695Z" fill="white"/>
								<path d="M64.9295 34.9227V35.4501H64.3809V34.9227H64.9295ZM64.884 36.5867V41.1877H64.4233V36.5867H64.884Z" fill="white"/>
								<path d="M66.375 41.1877V36.5867H66.7023L66.7599 37.1747C67.3479 36.7837 67.9238 36.5867 68.4876 36.5867C69.606 36.5867 70.1667 37.0686 70.1667 38.0385V41.1877H69.706V38.0234C69.706 37.3414 69.2938 36.9989 68.4664 36.9989C67.9147 36.9989 67.3722 37.1929 66.8357 37.5809V41.1877H66.375Z" fill="white"/>
								<path d="M73.4218 36.5867C74.6797 36.5867 75.3101 37.2838 75.3101 38.6781C75.3101 38.7781 75.3101 38.8811 75.301 38.9903H71.8093C71.8093 40.1935 72.4458 40.7967 73.7188 40.7967C74.2432 40.7967 74.7069 40.724 75.1131 40.5785V40.9725C74.7069 41.118 74.2432 41.1907 73.7188 41.1907C72.1397 41.1907 71.3486 40.4057 71.3486 38.8387C71.3486 37.2717 72.0397 36.5897 73.4218 36.5897V36.5867ZM71.8093 38.578H74.8676C74.8494 37.5081 74.3675 36.9747 73.4218 36.9747C72.4004 36.9747 71.8609 37.5081 71.8093 38.578Z" fill="white"/>
								<path d="M76.4044 40.9695V40.53C76.9166 40.7058 77.4167 40.7937 77.9108 40.7937C78.8776 40.7937 79.3626 40.4876 79.3626 39.8723C79.3626 39.3752 79.0049 39.1267 78.2896 39.1267H77.7016C76.7378 39.1267 76.2559 38.7175 76.2559 37.8991C76.2559 37.0232 76.8954 36.5837 78.1714 36.5837C78.6624 36.5837 79.1625 36.6564 79.6748 36.8019V37.2414C79.1625 37.0656 78.6624 36.9777 78.1714 36.9777C77.2015 36.9777 76.7166 37.2838 76.7166 37.8991C76.7166 38.4235 77.0439 38.6872 77.7016 38.6872H78.2896C79.3111 38.6872 79.8233 39.0812 79.8233 39.8692C79.8233 40.7452 79.1868 41.1847 77.9138 41.1847C77.4197 41.1847 76.9166 41.1119 76.4074 40.9664L76.4044 40.9695Z" fill="white"/>
								<path d="M80.9171 40.9695V40.53C81.4293 40.7058 81.9294 40.7937 82.4235 40.7937C83.3903 40.7937 83.8753 40.4876 83.8753 39.8723C83.8753 39.3752 83.5176 39.1267 82.8023 39.1267H82.2143C81.2505 39.1267 80.7686 38.7175 80.7686 37.8991C80.7686 37.0232 81.4081 36.5837 82.6841 36.5837C83.1751 36.5837 83.6752 36.6564 84.1875 36.8019V37.2414C83.6752 37.0656 83.1751 36.9777 82.6841 36.9777C81.7142 36.9777 81.2293 37.2838 81.2293 37.8991C81.2293 38.4235 81.5566 38.6872 82.2143 38.6872H82.8023C83.8238 38.6872 84.336 39.0812 84.336 39.8692C84.336 40.7452 83.6995 41.1847 82.4265 41.1847C81.9324 41.1847 81.4293 41.1119 80.9201 40.9664L80.9171 40.9695Z" fill="white"/>
								<path d="M87.4464 39.8874C87.4464 38.9721 88.0526 38.5174 89.268 38.5174C89.6984 38.5174 90.1561 38.5478 90.6441 38.6053V38.0386C90.6441 37.3354 90.2015 36.9838 89.3165 36.9838C88.8134 36.9838 88.3132 37.0565 87.8192 37.202V36.808C88.3163 36.6625 88.8164 36.5898 89.3165 36.5898C90.5077 36.5898 91.1048 37.0656 91.1048 38.0173V41.1907H90.8229L90.7168 40.7361C90.1409 41.0392 89.5832 41.1907 89.0437 41.1907C87.9768 41.1907 87.4434 40.7573 87.4434 39.8905L87.4464 39.8874ZM89.271 38.9084C88.3617 38.9084 87.9071 39.2297 87.9071 39.8723C87.9071 40.5148 88.286 40.7937 89.0467 40.7937C89.6075 40.7937 90.1409 40.6452 90.6471 40.3481V38.9994C90.1591 38.9418 89.7014 38.9115 89.271 38.9115V38.9084Z" fill="white"/>
								<path d="M92.5078 41.1877V36.5867H92.8352L92.8928 37.1747C93.4808 36.7837 94.0566 36.5867 94.6204 36.5867C95.7388 36.5867 96.2995 37.0686 96.2995 38.0385V41.1877H95.8388V38.0234C95.8388 37.3414 95.4266 36.9989 94.5992 36.9989C94.0475 36.9989 93.505 37.1929 92.9685 37.5809V41.1877H92.5078Z" fill="white"/>
								<path d="M101.514 40.9119C101.013 41.0968 100.386 41.1877 99.6253 41.1877C98.1977 41.1877 97.4824 40.3906 97.4824 38.7963C97.4824 37.3232 98.2099 36.5867 99.6647 36.5867C100.119 36.5867 100.583 36.6594 101.053 36.8049V34.9197H101.514V40.9089V40.9119ZM101.053 37.2171C100.607 37.0595 100.147 36.9807 99.6677 36.9807C98.5372 36.9807 97.9734 37.5748 97.9734 38.7629C97.9734 40.1026 98.5372 40.7755 99.6677 40.7755C100.147 40.7755 100.607 40.7179 101.053 40.6058V37.2202V37.2171Z" fill="white"/>
								<path d="M109.16 34.9227V35.3167H107.014V41.1877H106.554V35.3167H104.45V34.9227H109.16Z" fill="white"/>
								<path d="M109.248 41.1877V36.5867H109.575L109.633 37.3505C110.094 36.8413 110.609 36.5867 111.176 36.5867V36.9534C110.627 36.9534 110.136 37.2202 109.709 37.7567V41.1877H109.248Z" fill="white"/>
								<path d="M111.767 39.8874C111.767 38.9721 112.373 38.5174 113.588 38.5174C114.019 38.5174 114.476 38.5478 114.964 38.6053V38.0386C114.964 37.3354 114.522 36.9838 113.637 36.9838C113.134 36.9838 112.634 37.0565 112.14 37.202V36.808C112.637 36.6625 113.137 36.5898 113.637 36.5898C114.828 36.5898 115.425 37.0656 115.425 38.0173V41.1907H115.143L115.037 40.7361C114.461 41.0392 113.904 41.1907 113.364 41.1907C112.297 41.1907 111.764 40.7573 111.764 39.8905L111.767 39.8874ZM113.588 38.9084C112.679 38.9084 112.224 39.2297 112.224 39.8723C112.224 40.5148 112.603 40.7937 113.364 40.7937C113.925 40.7937 114.458 40.6452 114.964 40.3481V38.9994C114.476 38.9418 114.019 38.9115 113.588 38.9115V38.9084Z" fill="white"/>
								<path d="M116.828 41.1877V36.5867H117.155L117.213 37.1747C117.801 36.7837 118.377 36.5867 118.941 36.5867C120.059 36.5867 120.62 37.0686 120.62 38.0385V41.1877H120.159V38.0234C120.159 37.3414 119.747 36.9989 118.919 36.9989C118.368 36.9989 117.825 37.1929 117.289 37.5809V41.1877H116.828Z" fill="white"/>
								<path d="M121.933 40.9695V40.53C122.445 40.7058 122.945 40.7937 123.439 40.7937C124.406 40.7937 124.891 40.4876 124.891 39.8723C124.891 39.3752 124.533 39.1267 123.818 39.1267H123.23C122.266 39.1267 121.784 38.7175 121.784 37.8991C121.784 37.0232 122.424 36.5837 123.7 36.5837C124.191 36.5837 124.691 36.6564 125.203 36.8019V37.2414C124.691 37.0656 124.191 36.9777 123.7 36.9777C122.73 36.9777 122.245 37.2838 122.245 37.8991C122.245 38.4235 122.572 38.6872 123.23 38.6872H123.818C124.839 38.6872 125.352 39.0812 125.352 39.8692C125.352 40.7452 124.715 41.1847 123.442 41.1847C122.948 41.1847 122.445 41.1119 121.936 40.9664L121.933 40.9695Z" fill="white"/>
								<path d="M126.533 36.7746C127.055 36.6504 127.643 36.5867 128.294 36.5867C129.77 36.5867 130.507 37.3141 130.507 38.772C130.507 40.3815 129.764 41.1877 128.282 41.1877C127.915 41.1877 127.485 41.115 126.994 40.9695V42.8547H126.533V36.7777V36.7746ZM126.994 40.5118C127.458 40.6694 127.885 40.7482 128.279 40.7482C129.467 40.7482 130.061 40.0875 130.061 38.7629C130.061 37.5869 129.47 36.9959 128.285 36.9959C127.876 36.9959 127.446 37.0323 126.994 37.102V40.5118Z" fill="white"/>
								<path d="M131.472 38.8872C131.472 37.3232 132.187 36.5443 133.618 36.5443C135.048 36.5443 135.764 37.3263 135.764 38.8872C135.764 40.4482 135.048 41.2271 133.618 41.2271C132.187 41.2271 131.478 40.4482 131.472 38.8872ZM133.618 40.8392C134.742 40.8392 135.306 40.1845 135.306 38.8721C135.306 37.5597 134.742 36.9383 133.618 36.9383C132.493 36.9383 131.929 37.5809 131.929 38.8721C131.929 40.1632 132.493 40.8392 133.618 40.8392Z" fill="white"/>
								<path d="M136.948 41.1877V36.5867H137.276L137.333 37.3505C137.794 36.8413 138.309 36.5867 138.876 36.5867V36.9534C138.327 36.9534 137.836 37.2202 137.409 37.7567V41.1877H136.948Z" fill="white"/>
								<path d="M139.716 35.8411H140.04L140.122 36.5867H141.501V36.9807H140.161V39.8844C140.161 40.4906 140.383 40.7906 140.828 40.7906H141.504V41.1847H140.837C140.089 41.1847 139.716 40.7724 139.716 39.945V35.838V35.8411Z" fill="white"/>
								<path d="M148.723 34.9227V35.3167H146.577V41.1877H146.116V35.3167H144.013V34.9227H148.723Z" fill="white"/>
								<path d="M148.812 41.1877V36.5867H149.139L149.196 37.3505C149.657 36.8413 150.172 36.5867 150.739 36.5867V36.9534C150.191 36.9534 149.7 37.2202 149.272 37.7567V41.1877H148.812Z" fill="white"/>
								<path d="M151.33 39.8874C151.33 38.9721 151.936 38.5174 153.152 38.5174C153.582 38.5174 154.04 38.5478 154.528 38.6053V38.0386C154.528 37.3354 154.085 36.9838 153.2 36.9838C152.697 36.9838 152.197 37.0565 151.703 37.202V36.808C152.2 36.6625 152.7 36.5898 153.2 36.5898C154.391 36.5898 154.989 37.0656 154.989 38.0173V41.1907H154.707L154.601 40.7361C154.025 41.0392 153.467 41.1907 152.927 41.1907C151.861 41.1907 151.327 40.7573 151.327 39.8905L151.33 39.8874ZM153.155 38.9084C152.246 38.9084 151.791 39.2297 151.791 39.8723C151.791 40.5148 152.17 40.7937 152.931 40.7937C153.491 40.7937 154.025 40.6452 154.531 40.3481V38.9994C154.043 38.9418 153.585 38.9115 153.155 38.9115V38.9084Z" fill="white"/>
								<path d="M155.733 36.5867H156.261L157.943 40.7876L159.634 36.5867H160.159L158.201 41.1877H157.667L155.733 36.5867Z" fill="white"/>
								<path d="M162.76 36.5867C164.018 36.5867 164.648 37.2838 164.648 38.6781C164.648 38.7781 164.648 38.8811 164.639 38.9903H161.147C161.147 40.1935 161.784 40.7967 163.057 40.7967C163.581 40.7967 164.045 40.724 164.451 40.5785V40.9725C164.045 41.118 163.581 41.1907 163.057 41.1907C161.478 41.1907 160.687 40.4057 160.687 38.8387C160.687 37.2717 161.378 36.5897 162.76 36.5897V36.5867ZM161.147 38.578H164.205C164.187 37.5081 163.705 36.9747 162.76 36.9747C161.738 36.9747 161.199 37.5081 161.147 38.578Z" fill="white"/>
								<path d="M166.379 34.9227V41.1877H165.918V34.9227H166.379Z" fill="white"/>
								<path d="M48.8047 49.8532V43.5882H49.2654L52.0933 49.3167L54.7454 43.5882H55.1606V49.8532H54.7454V44.4339L52.2569 49.8532H51.8811L49.226 44.3884V49.8532H48.8107H48.8047Z" fill="white"/>
								<path d="M56.298 48.5499C56.298 47.6346 56.9041 47.1799 58.1196 47.1799C58.55 47.1799 59.0076 47.2102 59.4956 47.2678V46.701C59.4956 45.9978 59.0531 45.6463 58.1681 45.6463C57.6649 45.6463 57.1648 45.719 56.6708 45.8645V45.4705C57.1678 45.325 57.6679 45.2522 58.1681 45.2522C59.3592 45.2522 59.9563 45.7281 59.9563 46.6798V49.8532H59.6744L59.5684 49.3986C58.9925 49.7017 58.4348 49.8532 57.8953 49.8532C56.8284 49.8532 56.2949 49.4198 56.2949 48.5529L56.298 48.5499ZM58.1196 47.5739C57.2103 47.5739 56.7556 47.8952 56.7556 48.5378C56.7556 49.1803 57.1345 49.4592 57.8953 49.4592C58.456 49.4592 58.9894 49.3107 59.4956 49.0136V47.6649C59.0076 47.6073 58.55 47.577 58.1196 47.577V47.5739Z" fill="white"/>
								<path d="M61.3555 49.8532V45.2522H61.6828L61.7404 45.8402C62.3284 45.4492 62.9043 45.2522 63.468 45.2522C64.5865 45.2522 65.1472 45.7341 65.1472 46.7041V49.8532H64.6865V46.6889C64.6865 46.0069 64.2743 45.6644 63.4468 45.6644C62.8952 45.6644 62.3527 45.8584 61.8162 46.2464V49.8532H61.3555Z" fill="white"/>
								<path d="M66.2872 48.5499C66.2872 47.6346 66.8934 47.1799 68.1088 47.1799C68.5392 47.1799 68.9969 47.2102 69.4849 47.2678V46.701C69.4849 45.9978 69.0424 45.6463 68.1573 45.6463C67.6542 45.6463 67.1541 45.719 66.66 45.8645V45.4705C67.1571 45.325 67.6572 45.2522 68.1573 45.2522C69.3485 45.2522 69.9456 45.7281 69.9456 46.6798V49.8532H69.6637L69.5576 49.3986C68.9817 49.7017 68.424 49.8532 67.8845 49.8532C66.8176 49.8532 66.2842 49.4198 66.2842 48.5529L66.2872 48.5499ZM68.1088 47.5739C67.1995 47.5739 66.7449 47.8952 66.7449 48.5378C66.7449 49.1803 67.1238 49.4592 67.8845 49.4592C68.4453 49.4592 68.9787 49.3107 69.4849 49.0136V47.6649C68.9969 47.6073 68.5392 47.577 68.1088 47.577V47.5739Z" fill="white"/>
								<path d="M75.1469 49.8532C75.1469 50.9626 74.471 51.5172 73.1192 51.5172C72.5524 51.5172 72.0492 51.4445 71.6128 51.299V50.905C72.0583 51.0505 72.5645 51.1232 73.1283 51.1232C74.1679 51.1232 74.6892 50.6989 74.6892 49.8532V49.635C74.1709 49.7805 73.7102 49.8532 73.3132 49.8532C71.8583 49.8532 71.1309 49.0773 71.1309 47.5254C71.1309 45.9736 71.9128 45.2522 73.4768 45.2522C74.0709 45.2522 74.6286 45.3159 75.1499 45.4401V49.8532H75.1469ZM74.6862 45.7675C74.2618 45.6978 73.8466 45.6614 73.4374 45.6614C72.1947 45.6614 71.5764 46.2797 71.5764 47.5164C71.5764 48.753 72.1553 49.4137 73.3162 49.4137C73.7375 49.4137 74.1952 49.3349 74.6862 49.1773V45.7675Z" fill="white"/>
								<path d="M78.4013 45.2522C79.6592 45.2522 80.2896 45.9493 80.2896 47.3436C80.2896 47.4436 80.2896 47.5467 80.2805 47.6558H76.7888C76.7888 48.8591 77.4253 49.4622 78.6983 49.4622C79.2227 49.4622 79.6864 49.3895 80.0926 49.244V49.638C79.6864 49.7835 79.2227 49.8563 78.6983 49.8563C77.1192 49.8563 76.3281 49.0712 76.3281 47.5042C76.3281 45.9372 77.0192 45.2553 78.4013 45.2553V45.2522ZM76.7888 47.2405H79.8471C79.8289 46.1706 79.347 45.6372 78.4013 45.6372C77.3799 45.6372 76.8404 46.1706 76.7888 47.2405Z" fill="white"/>
								<path d="M81.4757 49.8532V45.2522H81.803L81.8515 45.8311C82.3213 45.4462 82.8305 45.2522 83.3791 45.2522C84.1035 45.2522 84.5733 45.4614 84.7855 45.8827C85.3129 45.4614 85.8494 45.2522 86.3949 45.2522C87.4224 45.2522 87.9377 45.7614 87.9377 46.7798V49.8502H87.477V46.7798C87.477 46.0342 87.1133 45.6614 86.3919 45.6614C85.813 45.6614 85.3371 45.8614 84.9583 46.2585V49.8502H84.4976V46.7041C84.4976 46.01 84.1247 45.6614 83.3761 45.6614C82.8336 45.6614 82.3516 45.8614 81.9334 46.2585V49.8502H81.4727L81.4757 49.8532Z" fill="white"/>
								<path d="M91.1923 45.2522C92.4502 45.2522 93.0806 45.9493 93.0806 47.3436C93.0806 47.4436 93.0806 47.5467 93.0715 47.6558H89.5798C89.5798 48.8591 90.2164 49.4622 91.4894 49.4622C92.0137 49.4622 92.4774 49.3895 92.8836 49.244V49.638C92.4774 49.7835 92.0137 49.8563 91.4894 49.8563C89.9102 49.8563 89.1191 49.0712 89.1191 47.5042C89.1191 45.9372 89.8102 45.2553 91.1923 45.2553V45.2522ZM89.5798 47.2405H92.6381C92.6199 46.1706 92.138 45.6372 91.1923 45.6372C90.1709 45.6372 89.6314 46.1706 89.5798 47.2405Z" fill="white"/>
								<path d="M94.2656 49.8532V45.2522H94.593L94.6506 45.8402C95.2386 45.4492 95.8144 45.2522 96.3782 45.2522C97.4966 45.2522 98.0573 45.7341 98.0573 46.7041V49.8532H97.5966V46.6889C97.5966 46.0069 97.1844 45.6644 96.357 45.6644C95.8054 45.6644 95.2628 45.8584 94.7263 46.2464V49.8532H94.2656Z" fill="white"/>
								<path d="M99.4404 44.5066H99.7647L99.8466 45.2522H101.226V45.6462H99.886V48.5499C99.886 49.1561 100.107 49.4562 100.553 49.4562H101.229V49.8502H100.562C99.8132 49.8502 99.4404 49.438 99.4404 48.6105V44.5036V44.5066Z" fill="white"/>
								<path d="M109.215 49.635C108.645 49.8108 108.06 49.8987 107.463 49.8987C105.272 49.8987 104.178 48.8106 104.178 46.6343C104.178 44.5763 105.272 43.5458 107.463 43.5458C108.063 43.5458 108.645 43.6337 109.215 43.8095V44.2035C108.645 44.0277 108.091 43.9398 107.551 43.9398C105.608 43.9398 104.638 44.837 104.638 46.6343C104.638 48.5469 105.608 49.5046 107.551 49.5046C108.091 49.5046 108.645 49.4167 109.215 49.241V49.635Z" fill="white"/>
								<path d="M110.333 47.5527C110.333 45.9887 111.048 45.2098 112.479 45.2098C113.91 45.2098 114.625 45.9918 114.625 47.5527C114.625 49.1137 113.91 49.8926 112.479 49.8926C111.048 49.8926 110.339 49.1137 110.333 47.5527ZM112.479 49.5016C113.603 49.5016 114.167 48.8469 114.167 47.5345C114.167 46.2221 113.603 45.6008 112.479 45.6008C111.354 45.6008 110.791 46.2433 110.791 47.5345C110.791 48.8257 111.354 49.5016 112.479 49.5016Z" fill="white"/>
								<path d="M115.81 49.8532V45.2522H116.137L116.186 45.8311C116.655 45.4462 117.165 45.2522 117.713 45.2522C118.438 45.2522 118.907 45.4614 119.119 45.8827C119.647 45.4614 120.183 45.2522 120.729 45.2522C121.756 45.2522 122.272 45.7614 122.272 46.7798V49.8502H121.811V46.7798C121.811 46.0342 121.447 45.6614 120.726 45.6614C120.147 45.6614 119.671 45.8614 119.292 46.2585V49.8502H118.832V46.7041C118.832 46.01 118.459 45.6614 117.71 45.6614C117.168 45.6614 116.686 45.8614 116.267 46.2585V49.8502H115.807L115.81 49.8532Z" fill="white"/>
								<path d="M123.676 45.4401C124.197 45.3159 124.785 45.2522 125.437 45.2522C126.913 45.2522 127.649 45.9797 127.649 47.4375C127.649 49.047 126.907 49.8532 125.425 49.8532C125.058 49.8532 124.627 49.7805 124.136 49.635V51.5202H123.676V45.4432V45.4401ZM124.136 49.1773C124.6 49.3349 125.028 49.4137 125.422 49.4137C126.61 49.4137 127.204 48.753 127.204 47.4285C127.204 46.2524 126.613 45.6614 125.428 45.6614C125.018 45.6614 124.588 45.6978 124.136 45.7675V49.1773Z" fill="white"/>
								<path d="M128.57 48.5499C128.57 47.6346 129.177 47.1799 130.392 47.1799C130.822 47.1799 131.28 47.2102 131.768 47.2678V46.701C131.768 45.9978 131.326 45.6463 130.441 45.6463C129.937 45.6463 129.437 45.719 128.943 45.8645V45.4705C129.44 45.325 129.94 45.2522 130.441 45.2522C131.632 45.2522 132.229 45.7281 132.229 46.6798V49.8532H131.947L131.841 49.3986C131.265 49.7017 130.707 49.8532 130.168 49.8532C129.101 49.8532 128.567 49.4198 128.567 48.5529L128.57 48.5499ZM130.395 47.5739C129.486 47.5739 129.031 47.8952 129.031 48.5378C129.031 49.1803 129.41 49.4592 130.171 49.4592C130.731 49.4592 131.265 49.3107 131.771 49.0136V47.6649C131.283 47.6073 130.825 47.577 130.395 47.577V47.5739Z" fill="white"/>
								<path d="M133.633 49.8532V45.2522H133.96L134.018 45.8402C134.606 45.4492 135.182 45.2522 135.745 45.2522C136.864 45.2522 137.425 45.7341 137.425 46.7041V49.8532H136.964V46.6889C136.964 46.0069 136.552 45.6644 135.724 45.6644C135.173 45.6644 134.63 45.8584 134.094 46.2464V49.8532H133.633Z" fill="white"/>
								<path d="M138.275 45.2522H138.806L140.515 49.4077L142.197 45.2522H142.707L140.709 49.9896C140.37 50.8262 139.864 51.3475 139.185 51.5536L139.048 51.1868C139.579 50.9929 139.985 50.5746 140.267 49.926L138.278 45.2553L138.275 45.2522Z" fill="white"/>
								<path d="M24.217 8.99285L24.1352 8.79584H18.146L9.30469 30.158H16.9336L21.1254 11.5298L25.29 30.158H32.9492L24.217 8.99285Z" fill="white"/>
								<path d="M21.1288 0C9.45962 0 0 9.45962 0 21.1258C0 25.7419 1.48214 30.0126 3.9948 33.4891L19.7588 55.2998C20.065 55.7242 20.5651 56 21.1288 56C21.1349 56 21.1409 56 21.147 56C21.7017 55.9939 22.1927 55.7181 22.4958 55.2998L38.2598 33.4891C40.7725 30.0126 42.2546 25.7419 42.2546 21.1258C42.2546 9.45962 32.795 0 21.1288 0ZM21.1258 36.9777C12.3724 36.9777 5.2769 29.8822 5.2769 21.1288C5.2769 12.3754 12.3724 5.27993 21.1258 5.27993C29.8792 5.27993 36.9747 12.3754 36.9747 21.1288C36.9747 29.8822 29.8792 36.9777 21.1258 36.9777Z" fill="#E04403"/>
								</svg>


							<p class="lineas">LÍNEAS DE ATENCIÓN: Bogotá: (601) 358 5555 - Barranquilla: (605) 3582555 - Nacional: 314 780 6060</p>

            			</div>
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