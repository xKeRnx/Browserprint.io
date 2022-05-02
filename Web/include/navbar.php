<?php
if ($__TOKEN == "hardcodeshitbykernstudios") {
?>
    <div class="header-container">
        <header class="header navbar navbar-expand-sm">

            <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg></a>

            <div class="nav-logo align-self-center">
                <a class="navbar-brand" href="<?php echo $Web_URL; ?>"><img src="<?php echo $Web_URL; ?>assets/img/logo.png"> <span class="navbar-brand-name"><?php echo $_SERVERNAME; ?></span></a>
            </div>

            <ul class="navbar-item flex-row mr-auto">
                <!-- <li class="nav-item align-self-center search-animated">
                    <form class="form-inline search-full form-inline search" role="search">
                        <div class="search-bar">
                            <input type="text" class="form-control search-form-control  ml-lg-auto" placeholder="Search...">
                        </div>
                    </form>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search toggle-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                </li>-->
            </ul>

            <ul class="navbar-item flex-row nav-dropdowns">
                <?php
                if (!isset($_SESSION['ulogin'])) {
                ?>
                    <li class="nav-item dropdown user-profile-dropdown order-lg-0 order-1 show">
                        <a href="<?php echo $Web_URL; ?>login" class="nav-link dropdown-toggle user">
                            <div class="media">
                                <div class="align-self-center">
                                    <h6><span>Login/</span>Register</h6>
                                </div>
                            </div>
                        </a>
                    </li>
                <?php
                } else if (isset($_SESSION['ulogin'])) {
                ?>

                    <li class="nav-item dropdown notification-dropdown">
                        <a href="<?php echo $Web_URL; ?>new_project" class="nav-link dropdown-toggle" id="notificationDropdown">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="<feather feather-plus <?php if($activesite == 'new_project'){ echo 'custsel';}?>">
                                <line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                        </a>
                    </li>

                    <li class="nav-item dropdown notification-dropdown">
                        <a href="<?php echo $Web_URL; ?>project" class="nav-link dropdown-toggle" id="notificationDropdown">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="<feather feather-database <?php if($activesite == 'project'){ echo 'custsel';}?>">
                                <ellipse cx="12" cy="5" rx="9" ry="3"></ellipse>
                                <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path>
                                <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path>
                            </svg>
                        </a>
                    </li>
                
                    <li class="nav-item dropdown notification-dropdown">
                        <a href="<?php echo $Web_URL; ?>notification" class="nav-link dropdown-toggle" id="notificationDropdown">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell <?php if($activesite == 'notification'){ echo 'custsel';}?>">
                                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                            </svg>
                        </a>
                    </li>

                    <li class="nav-item dropdown user-profile-dropdown order-lg-0 order-1">
                        <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="user-profile-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="media">
                                <div class="media-body align-self-center">
                                    <h6><span>Hi,</span> <?php echo $_SESSION['ulogin']; ?></h6>
                                </div>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </a>
                        <div class="dropdown-menu position-absolute animated fadeInUp" aria-labelledby="user-profile-dropdown">
                            <div class="">
                                <div class="dropdown-item">
                                <a class="disable-select"><i class="fas fa-euro-sign"></i><?php echo $users->getCurrencyByName($_SESSION['ulogin']); ?></a>
                                </div>
                                <div class="dropdown-item">
                                    <a class="" href="<?php echo $Web_URL; ?>topup"><i class="fas fa-dollar-sign"></i> TopUP</a>
                                </div>
                                <div class="dropdown-item">
                                    <a class="" href="<?php echo $Web_URL; ?>blog"><i class="fas fa-align-left"></i> Buy Log</a>
                                </div>
                                <div class="dropdown-item">
                                    <a class="" href="<?php echo $Web_URL; ?>settings"><i class="fas fa-cogs"></i> Settings</a>
                                </div>
                                <div class="dropdown-item">
                                    <a class="" href="<?php echo $Web_URL; ?>bugreport"><i class="fas fa-bug"></i> Bugreport</a>
                                </div>
                                <div class="dropdown-item">
                                    <a class="" href="<?php echo $Web_URL; ?>logout"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out">
                                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                            <polyline points="16 17 21 12 16 7"></polyline>
                                            <line x1="21" y1="12" x2="9" y2="12"></line>
                                        </svg> Sign Out</a>
                                </div>
                            </div>
                        </div>

                    </li>
                <?php
                }
                ?>

            </ul>
        </header>
    </div>
<?php
}
?>