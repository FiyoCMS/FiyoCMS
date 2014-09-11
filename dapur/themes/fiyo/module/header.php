<div class="collapse navbar-collapse navbar-ex1-collapse navbar-right">
	<!-- .nav -->
	<ul class="nav navbar">
		<li class='dropdown profile'>
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				<?php 
					echo $_SESSION['USER_NAME'];
					$autmail =	md5($_SESSION['USER_EMAIL']);
					echo " <span class='gravatar' data-gravatar-hash=\"$autmail\"></span>"; 
				?>
			</a>
			<div class="popover fade bottom in" style=""><div class="arrow" style=""></div></div>
			<ul class="dropdown-menu">
				<li><a href="?app=user&act=edit&id=<?php echo USER_ID; ?>"><i class="icon-pencil"></i> Edit Profile</a></li>
				<li class="divider"></li>
				<li><form method="post" action="">
				<button type="submit" name="fiyo_logout" value="Log Out" title="Click to logout" /><i class="icon-signout"></i> Sign Out</button></form></li>
			</ul>
		</li>
					<!--li class='dropdown notif'>
						<a class="dropdown-toggle fixed" data-toggle="dropdown">
						<i class="icon-warning-sign"></i><span class="label label-success">7</span>
						</a>
						<div class="popover fade bottom in" style=""><div class="arrow" style=""></div></div>
						
						<ul class="dropdown-menu pop-over">
							<li class='notice-title'>
							Pemberitahuan 
							</li>
							<li>
								<div class="notice">
									<ul>
										<li>
											<a href="<?php echo AdminPath; ?>/form-general.html">
											<b>3 Komentar</b> belum disetujui</a>
										</li>
										<li>
											<a href="<?php echo AdminPath; ?>/form-general.html">
											<b>2 member baru</b> mendaftar har ini</a>
										</li>
										<li>
											<a href="<?php echo AdminPath; ?>/form-general.html">
											<b>First Ryan</b> menulis artikel baru <b>Tips menginstal Fiyo 2.0</b></a>
										</li>
										<li>
											<a href="<?php echo AdminPath; ?>/form-general.html">
											<b>Kesalahan sistem</b> baru ditemukan tangal  20-Februari-2014</a>
										</li>
										<li>
											<a href="<?php echo AdminPath; ?>/form-general.html">
											<b>Anonymous</b> membalas komentar di <b>Tutorial Fiyo CMS 1.5.0</b></a>
										</li>
										<li>
											<a href="<?php echo AdminPath; ?>/form-general.html">
											<b>Rifaldo</b> menulis artikel baru <b>Ini waktunya Fiyo 2.0 dirilis</b></a>
										</li>
										<li>
											<a href="<?php echo AdminPath; ?>/form-general.html">
											<b>Anonymous</b> berkomentar di <b>Tutorial Fiyo CMS 1.8.0</b></a>
										</li>
									</ul>
								</div>
							</li>	
							<li class='notice-footer'>
							View Detail Notification 
							</li>						
						</ul>
					</li--
			<!-- /.nav -->
					
	</ul>
</div>