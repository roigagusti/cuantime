<header>
	<div class="row justify-content-center" style="margin-right:0px">
		<div class="col-lg-9">
			<div class="row">
				<div class="col-lg-3 headerLogo">
					<a href="//www.cuantime.com"><img src="img/cuantime_dark-lg.png" class="cuantimeLogo"></a>
				</div>
				<div class="col-lg-6 headerMenu">
					<ul class="navBar">
						<li><a href="index.php#soluciones"><?php echo $text['Soluciones'];?></a></li>
						<li><a href="index.php#precio"><?php echo $text['Precios'];?></a></li>
						<li>
							<a class="dropdown-toggle" href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true"><?php echo $text['Idioma'];?></a>
                            <div class="langMenu dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="?lang=es" hreflang="es"><?php echo $text['Espanol'];?></a>
                                <a class="dropdown-item" href="?lang=ca" hreflang="ca"><?php echo $text['Catala'];?></a>
                            </div>
						</li>
					</ul>
				</div>

                            
				<div class="col-lg-3 headerLogIn"><a href="//app.cuantime.com/"><?php echo $text['Login'];?></a></div>
			</div>

			<div class="row subheader">
				<div class="col-lg-6">
					<h1><?php echo $text['Titol'];?></h1>
					<h2><?php echo $text['Subtitol'];?></h2>
					<a href="//app.cuantime.com/register.php">Usa la versión freemium</a>
				</div>
				<div class="col-lg-6">
					<img src="img/dashboard.png">
				</div>
			</div>

		</div>
	</div>
</header>