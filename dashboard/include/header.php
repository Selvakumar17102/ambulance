<link rel="stylesheet" type="text/css" href="assets/css/forms/switches.css">
<style>
	#switch {
		border: 2px solid white !important;
	}
</style>
<div class="header-container fixed-top">
    <header class="header navbar navbar-expand-sm">

        <ul class="navbar-nav theme-brand flex-row  text-center">
            <li class="nav-item theme-logo">
                <a href="dashboard.php">
                    <img src="assets/img/h-logo.png" style="width: 180px;margin-top: -10px;margin-left: 15px;height: 69px;" class="navbar-logo" alt="logo">
                </a>
            </li>
            <li class="nav-item theme-text">
                <!-- <a href="dashboard.php" class="nav-link"> Multistore </a> -->
            </li>
            <li class="nav-item toggle-sidebar">
                <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3" y2="6"></line><line x1="3" y1="12" x2="3" y2="12"></line><line x1="3" y1="18" x2="3" y2="18"></line></svg></a>
            </li>
        </ul>

        <ul class="navbar-item flex-row navbar-dropdown">
            <li class="nav-item">
                <h6 class="pl-3" style="color: white;margin-bottom: 0px"><?php echo date('l, dS F Y') ?></h6>
            </li>
        </ul>
        <ul class="navbar-item flex-row search-ul navbar-dropdown">
            <li class="nav-item dropdown notification-dropdown">
				<?php
					if($control == 1){
						?>
							<label class="switch s-icons s-outline s-outline-success mr-2" style="margin-bottom: 0px !important;margin-top: 5px !important;margin-right: 0 !important;">
						<?php
						if($branch_status == 0)
						{
							$color = "red";
							$title = "Off";
							?>
								<input type="checkbox" id="switch" onclick="branch_status(<?php echo $login_id;?>,1)">
							<?php
						}else{
							$color = "green";
							$title = "Live";
							?>
								<input type="checkbox" id="switch" style="border: 1px solid green !important" onclick="branch_status(<?php echo $login_id;?>,0)" checked>
							<?php
						}
				?>
							<span class="slider round" id="zone_of" style="margin-top: 10px;border: 2px solid white;background: <?php echo $color;?>"></span>
						</label>
						<!-- <span style="font-size: 17px;color: #fff;">Current Status: <a style="font-weight: bold;color:<?php echo $color; ?>"><?php echo $title;?></a></span> -->
				<?php
					}
				?>
			</li>
            <li class="nav-item dropdown user-profile-dropdown  order-lg-0 order-1">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                </a>
                <div class="dropdown-menu position-absolute animated fadeInUp" aria-labelledby="userProfileDropdown">
                    <div class="user-profile-section">
                        <div class="media mx-auto">
                            <div class="media-body">
                                <h5>SALVO</h5>
                                <p><?php echo $name ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown-item">
                        <a href="changePassword.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shield"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                            <span>Change Password</span>
                        </a>
                    </div>
                    <div class="dropdown-item">
                        <a href="javascript:void(0);" onclick="logOut()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg> <span>Log Out</span>
                        </a>
                    </div>
                </div>
            </li>
        </ul>
    </header>
</div>
<script>
	function branch_status(login_id,status)
	{
		let text = "Are you sure!";
  		if (confirm(text) == true) {
			window.location.replace("https://instantambulance.in/dashboard/branch-status.php?branch_id="+login_id+'&status='+status);
		}else{
			if(status == 1)
			{
				document.getElementById('switch').checked = false
			}else{
				document.getElementById('switch').checked = true
			}
		}
	}
</script>