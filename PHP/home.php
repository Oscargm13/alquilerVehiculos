<!DOCTYPE html>
<html>
<head>
	<title>Autorent</title>
	<link rel="stylesheet" href="estilos/estilos.css">
	<link rel="stylesheet" href="fontawesome-free-6.4.0-web/css/fontawesome.min.css">
	<script src='js/home.js'></script>
	<style>.footer {
            background-color: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        .footer p {
            margin: 0;
        }

        .footer a {
            color: #fff;
            text-decoration: none;
        }

        .social-icons {
            margin-top: 10px;
        }

        .social-icons a {
            display: inline-block;
            margin-right: 10px;
            color: #fff;
            font-size: 20px;
        }

        .contact-info {
            margin-top: 10px;
        }
		.perfil-imagen {
    		border-radius: 50%;
			width: 50px; /* Ajusta el valor según el tamaño deseado */
    		height: 50px;
		}
    </style></style>
</head>
<body>
	<header id="inicio">
		<?php
			if(isset($registrado)){
				echo "<a href='PHP/perfil.php'><img src='imagenes/perfil.webp' alt='Perfil' class='perfil-imagen'></a>";
			}
		?>
		<h1>Autorent</h1>
		<nav>
			<?php
				if(isset($admin)){
					echo "<a href='html/panelAdmin2.html'>Panel de administrador</a>";
				}
			?>
			<a href="html/preguntasFrecuentes.html">Preguntas Frecuentes</a>
			<?php
				if(isset($noRegistrado)){
					echo "<a href='html/singin.php'>login</a>";
				}
			?>
			<a href="includes/logout.php" style="<?php if(isset($noRegistrado)){echo "display: none;";} ?>">Cerrar sesion</a>
		</nav>
	</header>
	<nav class="barra-navegacion">
		<a href="#inicio">Inicio</a>
		<a href="PHP/vehiculos.php">Catalogo</a>
		<?php
			if(isset($registrado)){
				echo "<a href='PHP/alquileres.php?perfil'>Alquileres realidados</a>";
			}
		?>
		
		<a href="PHP/contacto.php">Contactenos</a>
        <a href="#final">pie de pagina</a>
	</nav>
	<main>
		<div>
			<div class="carrusel">
                <div class="contenedor-imagenes">
                  <img src="imagenes/coche_blancoNegro.png">
                </div>
            </div>
			<div class="secciones">
				<div class="seccion" id="Moto">
                    <img src="imagenes/moto.jpeg" alt="" id="Moto">
                    <p>Motos</p>
                </div>
				<div class="seccion" id="Deportivo">
                    <img src="imagenes/deportivo.jpeg" alt="" id="Deportivo">
                    <p>Deportivos</p>
                </div>
				<div class="seccion" id="Mediano">
                    <img src="imagenes/coche.jpeg" alt="" id="Mediano">
                    <p>Mediano</p>
                </div>
                <div class="seccion" id="Furgoneta">
                    <img src="imagenes/camioneta.jpeg" alt="" id="Furgoneta">
                    <p>Furgonetas</p>
                </div>
                <div class="seccion" id="Fmiliar">
                    <img src="imagenes/patinete.png" alt="" id="Familiar">
                    <p>Familiar</p>
                </div>
                <div class="seccion" id="Pequeño">
                    <img src="imagenes/motoAgua.jpeg" alt="" id="Pequeño">
                    <p>Pequeño</p>
					
                </div>
			</div>
		</div>
	</main>
	<footer class="footer">
        <p>&copy; 2023 Autorent. Todos los derechos reservados. | Desarrollado por <a href="https://www.google.com">Autorent</a></p>
        <div class="social-icons">
            <a href="#"><i class="fa fa-facebook"></i></a>
            <a href="#"><i class="fa fa-twitter"></i></a>
            <a href="#"><i class="fa fa-instagram"></i></a>
        </div>
        <div class="contact-info">
            <p>Teléfono: +123456789</p>
            <p>Correo electrónico: info@tudominio.com</p>
        </div>
    </footer>
</body>
</html>
