<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern HTML Email Template</title>

    <style type="text/css">
    	body {
    		margin: 0;
    		background-color: #cccccc;
    	}
    	table {
    		border-spacing: 0;
    	}
    	td {
    		padding: 0;
    	}
    	img {
    		border: 0;
    	}

    	.preguntas {
    		margin-left: 10px; 
    		font-family: Sansation; 
    		font-size: 18px; 
    		font-weight: 700; 
    		line-height: 12.24px; 
    		text-align: right; 
    		color: #E04403;
    	}
    	.solicita {
    		font-family: Sansation; 
    		font-size: 18px; 
    		font-weight: 700; 
    		line-height: 12.24px; 
    		text-align: right; 
    		color: #E04403;
    	}

    	.lineas {
			
			left: calc(50% - 627px/2 + 10.5px);
			color: black;
			font-family: 'Sansation';
			font-style: italic;
			font-weight: 700;
			font-size: 12px;
			line-height: 102%;
			/* or 11px */
			text-align: center;	
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
			font-size: 15px;
			font-weight: 400;
			line-height: 12.24px;
			text-align: center;

		}

    	.wrapper {
    		width: 100%;
    		table-layout: fixed;
    		background-color: #cccccc;
    		padding-bottom: 60px;
    	}
    	.main {
    		background-color: #ffffff;
    		margin: 0 auto;
    		width: 100%;
    		max-width: 600px;
    		border-spacing: 0;
    		font-family: Sansation;
    		color: #171a1b;
    	}

    	.two-columns {
    		text-align: center;
    		font-size: 0;

    	}
    	.two-columns .column {
    		width: 100%;
    		max-width: 300px;
    		display: inline-block;
    		vertical-align: top;
    		text-align: center;
    	}
    	.three-columns {
    		text-align: center;
    		font-size: 0;
    		padding: 15px 0 25px;
    	}
    	.three-columns .column {
    		width: 100%;
    		max-width: 200px;
    		display: inline-block;
    		vertical-align: top;
    		text-align: center;
    	}
    	.three-columns .padding {
    		padding: 15px;
    	}
    	.three-columns .content {
    		font-size: 15px;
    		line-height: 20px;
    		padding: 0 5px;
    	}
    	.button {
			color: #E04403;
			text-decoration: none;
			padding: 20px 38px;
			border-radius: 5px;
			border: 1px solid #E04403;
			font-weight: bold;
			font-size: 12px;
			margin-left: 40px;
		}

		.buttonr {
			background-color: rgba(255, 255, 255, 1);
			color: black;
			text-decoration: none;
			padding: 20px 38px;
			border-radius: 5px;
			border: 1px solid black;
			font-weight: bold;
			font-size: 12px;
		}

    </style>


</head>

<body>
	<center class="wrapper">
	
		<table class="main" width="100%">
		
			<!-- TOP BORDER -->

			<!-- LOGO SECTION -->
				
			<!-- BANNER IMAGE -->
				<tr>
					<td>
						<a href=""><img src="{{url('img/imgs.png')}}" alt="" width="600" style="max-width: 100%;"></a>
					</td>
				</tr>

			<!-- THREE COLUMN SECTION -->
			<tr>
				<td>
					<table width="100%">
						<tr>
							<td>
								<p class="names">Sr(a) Maria Fernanda</p>
							</td>
						</tr>
						<tr>
							<td>
								<p class="names">Cotización N*2420</p>
							</td>
						</tr>
						
						<tr>
							<td>
								<p class="asunto">TRASLADOS 16 AL 20 NOVIEMBRE, VAN 15 PAX.</p>
							</td>
						</tr>
						<br>

						<tr>
							<td>
								<table width="100%">
									<tr>
										<td style="text-align: center; padding: 30px 35px; color: #ffffff">
											<a href="https://www.upnetweb.com/auth/login?aprobada=true&cotizacion=1" class="button">Aceptar Cotización</a>
										</td>
										<td style="text-align: center; padding: 30px 35px; color: #ffffff">
											<a href="https://www.upnetweb.com/auth/login?aprobada=true&cotizacion=1" style="color: black; text-color: black" class="buttonr">Rechazar Cotización</a>
										</td>
									</tr>
								</table>
							</td>
						</tr>

						<tr>
							<td>
								<table width="100%">
									<tr>
										<td>
											<hr>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						
						<tr>
							<td>
								<table width="100%">
									<tr>
										<td style="text-align: center; padding: 15px 20px; color: #ffffff">
											<a style="color: #E04403; text-color: #E04403" class="preguntas" href="https://wa.me/573046075207?text=Hola,%20Tengo%20una%20duda%20sobre%20la%20cotización%20N°%202420!">¿Tienes Preguntas?</a>
										</td>
										<td style="text-align: center; padding: 15px 20px; color: #ffffff">
											<a style="color: #E04403; text-color: #E04403" class="solicita" href="https://www.upnetweb.com/auth/zoom?cotizacion=1&zoom=true">Solicita una Reunión</a>
										</td>
									</tr>
								</table>
							</td>
						</tr>

					</table>
				</td>
			</tr>
			<!-- TITTLE, TEXT & BUTTON -->

			<!-- FOOTER SECTION -->
			<tr>
				<td>
					<table width="100%">
						<tr>
							<td style="text-align: center; padding: 15px 20px; color: #ffffff">
								<p class="lineas"><b style="color: #E04403;">LÍNEAS DE ATENCIÓN:</b> Bogotá: (601)358 5555 - Barranquilla: (605)3582555 - Nacional: 314 780 6060</p>
							</td>
						</tr>
					</table>
				</td>
			</tr>
	 </table>

	</center>

</body>
</html>