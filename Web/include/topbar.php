<?php
if ($__TOKEN == "hardcodeshitbykernstudios") {
?>
	<div class="topbar-nav header navbar" role="banner">
		<nav id="topbar">
			<ul class="navbar-nav theme-brand flex-row  text-center">
				<li class="nav-item theme-text">
					<a href="<?php echo $Web_URL; ?>" class="nav-link"> <?php echo SERVENAME; ?> </a>
				</li>
			</ul>

			<ul class="list-unstyled menu-categories" id="topAccordion">
				<?php
				$sql_cat = "SELECT * from tbar_cate WHERE visible=1 ORDER BY sort ASC";
				$cat_query = $dbh->prepare($sql_cat);
				$cat_query->execute();
				$cat_ress = $cat_query->fetchAll(PDO::FETCH_OBJ);
				if ($cat_query->rowCount() > 0) {
					foreach ($cat_ress as $cat_res) {
						$id = $cat_res->id;
						$name = $cat_res->name;
						$sname = $cat_res->sname;
						$icon = $cat_res->icon;
						$url = $cat_res->url;
						$needlogin = $cat_res->needlogin;

						$newURL = $Web_URL . $url;

						$sql_subcat = "SELECT * from tbar_subcate WHERE cate=(:cate) AND visible=1 ORDER BY sort ASC";
						$subcat_query = $dbh->prepare($sql_subcat);
						$subcat_query->bindParam(':cate', $id, PDO::PARAM_STR);
						$subcat_query->execute();
						$cat_subress = $subcat_query->fetchAll(PDO::FETCH_OBJ);

						$hassubs = '';


						$actcate = '';
						if (@$activesite == $sname) {
							$actcate = 'active';
						}

						$showcate = true;
						if ($needlogin == true) {
							if (!isset($_SESSION['ulogin'])) {
								$showcate = false;
							}
						}
						if ($showcate == true) {
							echo '<li class="menu single-menu ' . $actcate . '">';
							echo '<a href="' . $newURL . '" ' . $hassubs . ' class="dropdown-toggle autodroprown">';
							echo '<div class="">';
							echo $icon;
							echo '<span>' . $name . '</span>';
							echo '</div>';
							echo '</a>';

							if ($subcat_query->rowCount() > 0 or $subcat_query->rowCount() > 0 and isset($_SESSION['ulogin'])) {
								echo '<ul class="collapse submenu list-unstyled" id="' . $sname . '" data-parent="#topAccordion">';
								foreach ($cat_subress as $cat_subres) {
									$sub_id = $cat_subres->id;
									$sub_subsideid = $cat_subres->subsideid;
									$sub_name = $cat_subres->name;
									$sub_url = $cat_subres->url;
									$sub_needlogin = $cat_subres->needlogin;

									$showsubcate = true;
									if ($sub_needlogin == true) {
										if (!isset($_SESSION['ulogin'])) {
											$showsubcate = false;
										}
									}
									if ($showsubcate == true) {
										$subcateisactive = '';
										if (@$activesite == $sname and $activeid == $sub_subsideid) {
											$subcateisactive = 'class="active"';
										}
										echo '<li ' . $subcateisactive . '>';
										echo '<a href="' . $Web_URL . $sub_url . '"> ' . $sub_name . ' </a>';
										echo '</li>';
									}
								}
								echo '</ul>';
							}
							echo '</li>';
						}
					}
				}
				?>
			</ul>
		</nav>
	</div>
<?php
}
?>