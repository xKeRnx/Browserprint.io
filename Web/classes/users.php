<?php
class users
{
    public $dbh;
    public $alert;
    public $send;
    public $user_agent;

    public function __construct()
    {
        $this->user_agent = $_SERVER['HTTP_USER_AGENT'];
        $this->alert = new alert();
        $this->send = new sends();
        $db = new db();
        $this->dbh = $db->connect();
    }

    public function getUserByName($name)
    {
        $sql = "SELECT * FROM users WHERE name=(:name) LIMIT 1";
        $query = $this->dbh->prepare($sql);
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) {
            $res = $query->fetchAll(PDO::FETCH_OBJ);
            return $res[0];
        }
        return false;
    }

    public function getUserByID($ID)
    {
        $sql = "SELECT * FROM users WHERE id=(:userid) LIMIT 1";
        $query = $this->dbh->prepare($sql);
        $query->bindParam(':userid', $ID, PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) {
            $res = $query->fetchAll(PDO::FETCH_OBJ);
            return $res[0];
        }
        return false;
    }

    public function getCurrencyByName($name)
    {
        $sql = "SELECT currency FROM users WHERE name=(:name) LIMIT 1";
        $query = $this->dbh->prepare($sql);
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) {
            $res = $query->fetchAll(PDO::FETCH_OBJ);
            return $res[0]->currency;
        }
        return 0;
    }

    public function updateCurrencyByName($name, $currency)
    {
        $sql = "UPDATE users SET currency=(:currency) WHERE name=(:name)";
        $query = $this->dbh->prepare($sql);
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':currency', $currency, PDO::PARAM_STR);
        if ($query->execute()) {
            return true;
        }
        return false;
    }

    public function updateProjectByID($ID, $type, $queries, $subscribe_until)
    {
        $sql = "UPDATE project SET type=(:typ), idents=(:queries), subscribe_until=(:subscribe_until) WHERE id=(:id)";
        $query = $this->dbh->prepare($sql);
        $query->bindParam(':id', $ID, PDO::PARAM_STR);
        $query->bindParam(':typ', $type, PDO::PARAM_STR);
        $query->bindParam(':queries', $queries, PDO::PARAM_STR);
        $query->bindParam(':subscribe_until', $subscribe_until, PDO::PARAM_STR);
        if ($query->execute()) {
            return true;
        }
        return false;
    }

    public function newProject($userid)
    {
        echo '<div class="col-lg-12">';
        echo '<form enctype="multipart/form-data" method="post">';
        echo '<div class="row">';

        if (isset($_POST['create'])) {
            $post_type = $_POST['type'];
            $post_website = $_POST['website'];
            $post_ip = $_POST['ip'];
            $post_saveipres = $_POST['saveipres'];
            $post_savefpints = $_POST['savefpints'];

            $save_ip_data = 0;
            if ($post_saveipres == 'on') {
                $save_ip_data = 1;
            }
            $save_fp_data = 0;
            if ($post_savefpints == 'on') {
                $save_fp_data = 1;
            }

            if(!filter_var($post_ip, FILTER_VALIDATE_IP)) {
                echo '<div class="col-sm-12"><div class="form-group">';
                $this->alert->error('No valid IP!');
                echo '</div></div>';
            }else{
                if (filter_var($post_website, FILTER_VALIDATE_URL)) {
                    $post_website = parse_url($post_website);
                    $post_website = $post_website['host'];
                }
                $post_website = str_replace("https://", "", $post_website);
                $post_website = str_replace("http://", "", $post_website);
                $post_website = str_replace("www.", "", $post_website);
                $post_website = str_replace("/", "", $post_website);
    
                $token = md5(md5($this->send->generateRandomString(32) . $userid) . $this->send->generateRandomString(32));
    
                $new_subs_date = new DateTime("+1 months");
                $new_subs_date = $new_subs_date->format("Y-m-d h:i:s");
    
                $sql = "insert into project (userid,token,website,ip,type,save_ip_data,save_fp_data,subscribe_until) values (:userid,:token,:website,:ip,:type,:save_ip_data,:save_fp_data,:subscribe_until)";
                $query = $this->dbh->prepare($sql);
                $query->bindParam(':userid', $userid, PDO::PARAM_STR);
                $query->bindParam(':token', $token, PDO::PARAM_STR);
                $query->bindParam(':website', $post_website, PDO::PARAM_STR);
                $query->bindParam(':ip', $post_ip, PDO::PARAM_STR);
                $query->bindParam(':type', $post_type, PDO::PARAM_STR);
                $query->bindParam(':save_ip_data', $save_ip_data, PDO::PARAM_STR);
                $query->bindParam(':save_fp_data', $save_fp_data, PDO::PARAM_STR);
                $query->bindParam(':subscribe_until', $new_subs_date, PDO::PARAM_STR);
                if ($query->execute()) {
                    echo '<div class="col-sm-12"><div class="form-group">';
                    $this->alert->success('Project was created successfully');
                    echo "<script type='text/javascript'> setTimeout(function(){ window.location = '" . $Web_URL . "/project'; },3000); </script>";
                    echo '</div></div>';
                } else {
                    echo '<div class="col-sm-12"><div class="form-group">';
                    $this->alert->error('Unknown error...Project could not be created');
                    echo '</div></div>';
                }
            }
        }

        echo '<div class="col-sm-12"><div class="form-group">';
        $this->alert->info('Each project is created as a test project with 100 free queries per day. <br>After creating the project you can upgrade or downgrade it.');
        echo '</div></div>';

        echo '<div class="col-sm-12"><div class="form-group"><label for="type">Project type</label>';
        echo '<select id="type" name="type" class="form-control">';
        echo '<option value="0"';if (isset($_GET['i']) && $_GET['i'] == 1) {echo 'selected';}echo '>Fingerprinting</option>';
        echo '<option value="1"';if (isset($_GET['i']) && $_GET['i'] == 3) {echo 'selected';}echo '>IP research</option>';
        echo '<option value="2"';if (isset($_GET['i']) && $_GET['i'] == 2) {echo 'selected';}echo '>Fingerprinting and IP Research</option>';
        echo '<option value="3"';if (isset($_GET['i']) && $_GET['i'] == 4) {echo 'selected';}echo '>Free API (Commercial use)</option>';
        echo '</select>';
        echo '</div></div>';

        echo '<div class="col-sm-12"><div class="form-group"><label for="website">Website</label>
                <input type="text" class="form-control mb-4" id="website" name="website" placeholder="Website (example:browserprint.io)" required></div></div>';

        echo '<div class="col-sm-12"><div class="form-group"><label for="ip">Server IP</label>
                <input type="text" class="form-control mb-4" id="ip" name="ip" placeholder="ServerIP (example:127.0.0.1)" required></div></div>';

        echo '<div class="col-sm-6"><div class="form-group">
            <label>Save IP research in Cloud?</label><br>
            <label class="switch s-icons s-outline  s-outline-primary  mb-4 mr-2">
                <input name="saveipres" type="checkbox">
                <span class="slider"></span>
            </label>
            </div></div>';

        echo '<div class="col-sm-6"><div class="form-group">
            <label>Save Fingerprints in Cloud?</label><br>
            <label class="switch s-icons s-outline  s-outline-primary  mb-4 mr-2">
                <input name="savefpints" type="checkbox">
                <span class="slider"></span>
            </label>
            </div></div>';
        echo '<input type="submit" name="create" class="btn btn-primary btn-block mt-4 mb-4" value="Create">';

        echo '</div>';
        echo '</form>';
        echo '</div>';
    }

    public function getStatisticsByID($userID, $id)
    {
        echo '<div class="col-lg-12">';
        $sql_log = "SELECT * from project where userid=(:userid) AND id=(:id)";
        $log_query = $this->dbh->prepare($sql_log);
        $log_query->bindParam(':userid', $userID, PDO::PARAM_STR);
        $log_query->bindParam(':id', $id, PDO::PARAM_STR);
        $log_query->execute();
        $log_ress = $log_query->fetchAll(PDO::FETCH_OBJ);
        if ($log_query->rowCount() == 1) {
            foreach ($log_ress as $log_res) {
                $project_id = $log_res->id;
                $token = $log_res->token;
                $website = $log_res->website;
                $type = $log_res->type;

                echo '<div class="card component-card_ks"><div class="card-body">';
                echo '<h6>Analystics</h6>';

                echo '<ul class="nav nav-tabs  mb-3 mt-3 nav-fill" id="justifyTab" role="tablist">';
                echo '<li class="nav-item">';
                echo '<a class="nav-link active" id="Last12Month-tab" data-toggle="tab" href="#Last12Month" role="tab" aria-controls="Last12Month" aria-selected="true">Last 12 months</a>';
                echo '</li>';
                echo '<li class="nav-item">';
                echo '<a class="nav-link" id="Last30Days-tab" data-toggle="tab" href="#Last30Days" role="tab" aria-controls="Last30Days" aria-selected="false">Last 30 days</a>';
                echo '</li>';
                echo '<li class="nav-item">';
                echo '<a class="nav-link" id="Last24Hours-tab" data-toggle="tab" href="#Last24Hours" role="tab" aria-controls="Last24Hours" aria-selected="false">Last 24 hours</a>';
                echo '</li>';
                echo '</ul>';

                echo '<div class="tab-content" id="justifyTabContent">';
                echo '<div class="tab-pane fade show active" id="Last12Month" role="tabpanel" aria-labelledby="Last12Month-tab">';
                echo '<div id="chart_12m" style="width: 100%; height: 500px;"></div>';
                echo '</div>';

                echo '<div class="tab-pane fade" id="Last30Days" role="tabpanel" aria-labelledby="Last30Days-tab">';
                echo '<div id="chart_30d" style="width: 100%; height: 500px;"></div>';
                echo '</div>';

                echo '<div class="tab-pane fade" id="Last24Hours" role="tabpanel" aria-labelledby="Last24Hours-tab">';
                echo '<div id="chart_24h" style="width: 100%; height: 500px;"></div>';
                echo '</div>';
                echo '</div>';

                echo '</div></div>';

                if ($type == 1 || $type == 2) {
                    echo '<div class="card component-card_ks"><div class="card-body">';
                    echo '<h6>IP research</h6>';
                    $sql_log_stat = "SELECT * from  save_ip where project_id = (:project_id) order by dDate DESC";
                    $log_query_stat = $this->dbh->prepare($sql_log_stat);
                    $log_query_stat->bindParam(':project_id', $project_id, PDO::PARAM_STR);
                    $log_query_stat->execute();
                    $log_ress_stat = $log_query_stat->fetchAll(PDO::FETCH_OBJ);
                    if ($log_query_stat->rowCount() > 0) {

                        echo '<div id="toggleAccordion">';
                        echo '<table id="zero-config" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>';
                        $i = 0;
                        foreach ($log_ress_stat as $log_res_stat) {
                            $i++;
                            $iID = 'STAT0' . $i;
                            $stat_data = unserialize($log_res_stat->data);
                            $stat_dDate = $log_res_stat->dDate;

                            $stat_dDate = date_create($stat_dDate);
                            $stat_dDate = date_format($stat_dDate, "m/d/Y H:i:s");

                            echo '<tr><td>';
                            echo '<div class="card55">';
                            echo '<div class="card-header55" id="heading' . $iID . '">';
                            echo '<section class="mb-0 mt-0">';
                            echo '<div role="menu" class="collapsed" data-toggle="collapse" data-target="#defaultAccordion' . $iID . '" aria-expanded="false" aria-controls="defaultAccordion' . $iID . '">';
                            echo 'IP research from ' . $stat_dDate . '  <div class="icons"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></div>';
                            echo '</div>';
                            echo '</section>';
                            echo '</div>';

                            echo '<div id="defaultAccordion' . $iID . '" class="collapse" aria-labelledby="heading' . $iID . '" data-parent="#toggleAccordion" style="">';
                            echo '<div class="card-body55">';
                            echo '<pre class="hljs javascript">';
                            print_r($stat_data);
                            echo '</pre>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            echo '</td></tr>';
                            echo '</div>';
                        }
                        echo '</tbody>
                     </table>';
                    } else {
                        $this->alert->error('No IP researches available.');
                    }
                    echo '</div></div>';
                }

                if ($type == 0 || $type == 2) {
                    echo '<div class="card component-card_ks"><div class="card-body">';
                    echo '<h6>Fingerprints</h6>';
                    $sql_log_stat1 = "SELECT * from  save_fp where project_id = (:project_id) order by dDate DESC";
                    $log_query_stat1 = $this->dbh->prepare($sql_log_stat1);
                    $log_query_stat1->bindParam(':project_id', $project_id, PDO::PARAM_STR);
                    $log_query_stat1->execute();
                    $log_ress_stat1 = $log_query_stat1->fetchAll(PDO::FETCH_OBJ);
                    if ($log_query_stat1->rowCount() > 0) {

                        echo '<div id="toggleAccordion">';
                        echo '<table id="zero-config1" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>';
                        $i = 0;
                        foreach ($log_ress_stat1 as $log_res_stat1) {
                            $i++;
                            $iID = 'STAT1' . $i;
                            $stat_data = json_decode($log_res_stat1->data);
                            $stat_dDate = $log_res_stat1->dDate;

                            $stat_dDate = date_create($stat_dDate);
                            $stat_dDate = date_format($stat_dDate, "m/d/Y H:i:s");

                            echo '<tr><td>';
                            echo '<div class="card55">';
                            echo '<div class="card-header55" id="heading' . $iID . '">';
                            echo '<section class="mb-0 mt-0">';
                            echo '<div role="menu" class="collapsed" data-toggle="collapse" data-target="#defaultAccordion' . $iID . '" aria-expanded="false" aria-controls="defaultAccordion' . $iID . '">';
                            echo 'Fingerprint from ' . $stat_dDate . '  <div class="icons"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></div>';
                            echo '</div>';
                            echo '</section>';
                            echo '</div>';

                            echo '<div id="defaultAccordion' . $iID . '" class="collapse" aria-labelledby="heading' . $iID . '" data-parent="#toggleAccordion" style="">';
                            echo '<div class="card-body55">';
                            echo '<pre class="hljs javascript">';
                            print_r($stat_data);
                            echo '</pre>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            echo '</td></tr>';
                        }
                        echo '</tbody>
                        </table>';
                        echo '</div>';
                    } else {
                        $this->alert->error('No Fingerprints available.');
                    }
                    echo '</div></div>';
                }

                ?>
                <script>
                document.addEventListener('DOMContentLoaded', function(event) {
                    $('#zero-config').DataTable({
                        "oLanguage": {
                            "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                            "sInfo": "Showing page _PAGE_ of _PAGES_",
                            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                            "sSearchPlaceholder": "Search...",
                        "sLengthMenu": "Results :  _MENU_",
                        },
                        "order": [[ 0, "desc" ]],
                        "stripeClasses": [],
                        "lengthMenu": [7, 10, 20, 50],
                        "pageLength": 7
                    });
                    $('#zero-config1').DataTable({
                        "oLanguage": {
                            "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                            "sInfo": "Showing page _PAGE_ of _PAGES_",
                            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                            "sSearchPlaceholder": "Search...",
                        "sLengthMenu": "Results :  _MENU_",
                        },
                        "order": [[ 0, "desc" ]],
                        "stripeClasses": [],
                        "lengthMenu": [7, 10, 20, 50],
                        "pageLength": 7
                    });
                    google.charts.load('current', {'packages':['corechart']});
                    google.charts.setOnLoadCallback(drawChart12m);
                    google.charts.setOnLoadCallback(drawChart30d);

                    function drawChart12m() {
                        var data = google.visualization.arrayToDataTable([
                        <?php
if ($type == 0) {
                    echo "['Month','Fingerprints'],";
                } elseif ($type == 1) {
                    echo "['Month', 'IP researches'],";
                } else if ($type == 2) {
                    echo "['Month', 'IP researches', 'Fingerprints'],";
                }
                if ($type == 1 || $type == 2) {
                    $sql_ip = "SELECT dDate as dat, COUNT(dDate) as cnt from save_ip WHERE dDate >= now() - INTERVAL 12 MONTH AND project_id = (:project_id) GROUP BY MONTH(dDate), YEAR(dDate) ORDER BY dDATE ASC;";
                    $log_ip = $this->dbh->prepare($sql_ip);
                    $log_ip->bindParam(':project_id', $project_id, PDO::PARAM_STR);
                    $log_ip->execute();
                    $ip_ress = $log_ip->fetchAll(PDO::FETCH_OBJ);
                    if ($log_ip->rowCount() > 0) {
                        foreach ($ip_ress as $ip_res) {
                            $datr = $ip_res->dat;
                            $datr = new DateTime($datr);
                            $datr = $datr->format('Y-m');
                            $countr = $ip_res->cnt;
                            if ($type == 1) {
                                echo "['$datr',  $countr],";
                            } else if ($type == 2) {
                                echo "['$datr',  $countr, 0],";
                            }
                        }
                    }
                }
                if ($type == 0 || $type == 2) {
                    $sql_ip = "SELECT dDate as dat, COUNT(dDate) as cnt from save_fp WHERE dDate >= now() - INTERVAL 12 MONTH AND project_id = (:project_id) GROUP BY MONTH(dDate), YEAR(dDate) ORDER BY dDATE ASC;";
                    $log_ip = $this->dbh->prepare($sql_ip);
                    $log_ip->bindParam(':project_id', $project_id, PDO::PARAM_STR);
                    $log_ip->execute();
                    $ip_ress = $log_ip->fetchAll(PDO::FETCH_OBJ);
                    if ($log_ip->rowCount() > 0) {
                        foreach ($ip_ress as $ip_res) {
                            $datr = $ip_res->dat;
                            $datr = new DateTime($datr);
                            $datr = $datr->format('Y-m');
                            $countr = $ip_res->cnt;
                            if ($type == 0) {
                                echo "['$datr',  $countr],";
                            } else if ($type == 2) {
                                echo "['$datr',  0, $countr],";
                            }
                        }
                    }
                }
                ?>
                        ]);

                        var options = {
                        <?php
if ($type == 0) {
                    echo "title: 'Fingerprints',";
                } else if ($type == 1) {
                    echo "title: 'IP researches',";
                } else if ($type == 2) {
                    echo "title: 'IP researches and Fingerprints',";
                }
                ?>
                            hAxis: {title: 'Last 12 months',  titleTextStyle: {color: '#333'}, slantedText:true, slantedTextAngle:45},
                            vAxis: {minValue: 0}
                        };

                        var chart = new google.visualization.AreaChart(document.getElementById('chart_12m'));
                        data.sort([{column: 0}]);
                        var groupData = google.visualization.data.group(
                            data,
                            [0],
                            <?php
if ($type == 0 || $type == 1) {
                    echo "[{
                                    column: 1,
                                    aggregation: google.visualization.data.sum,
                                    type: 'number'
                                    }]";
                } else if ($type == 2) {
                    echo "[{
                                    column: 1,
                                    aggregation: google.visualization.data.sum,
                                    type: 'number'
                                    }, {
                                    column: 2,
                                    aggregation: google.visualization.data.sum,
                                    type: 'number'
                                    }]";
                }
                ?>
                        );

                        chart.draw(groupData, options);
                    }

                    function drawChart30d() {
                        var data = google.visualization.arrayToDataTable([
                        <?php
if ($type == 0) {
                    echo "['Month','Fingerprints'],";
                } elseif ($type == 1) {
                    echo "['Month', 'IP researches'],";
                } else if ($type == 2) {
                    echo "['Month', 'IP researches', 'Fingerprints'],";
                }
                if ($type == 1 || $type == 2) {
                    $sql_ip = "SELECT dDate as dat, COUNT(dDate) as cnt from save_ip WHERE dDate >= now() - INTERVAL 30 DAY AND project_id = (:project_id) GROUP BY DAY(dDate), MONTH(dDate) ORDER BY dDATE ASC;";
                    $log_ip = $this->dbh->prepare($sql_ip);
                    $log_ip->bindParam(':project_id', $project_id, PDO::PARAM_STR);
                    $log_ip->execute();
                    $ip_ress = $log_ip->fetchAll(PDO::FETCH_OBJ);
                    if ($log_ip->rowCount() > 0) {
                        foreach ($ip_ress as $ip_res) {
                            $datr = $ip_res->dat;
                            $datr = new DateTime($datr);
                            $datr = $datr->format('Y-m-d');
                            $countr = $ip_res->cnt;
                            if ($type == 1) {
                                echo "['$datr',  $countr],";
                            } else if ($type == 2) {
                                echo "['$datr',  $countr, 0],";
                            }
                        }
                    }
                }
                if ($type == 0 || $type == 2) {
                    $sql_ip = "SELECT dDate as dat, COUNT(dDate) as cnt from save_fp WHERE dDate >= now() - INTERVAL 30 DAY AND project_id = (:project_id) GROUP BY DAY(dDate), MONTH(dDate) ORDER BY dDATE ASC;";
                    $log_ip = $this->dbh->prepare($sql_ip);
                    $log_ip->bindParam(':project_id', $project_id, PDO::PARAM_STR);
                    $log_ip->execute();
                    $ip_ress = $log_ip->fetchAll(PDO::FETCH_OBJ);
                    if ($log_ip->rowCount() > 0) {
                        foreach ($ip_ress as $ip_res) {
                            $datr = $ip_res->dat;
                            $datr = new DateTime($datr);
                            $datr = $datr->format('Y-m-d');
                            $countr = $ip_res->cnt;
                            if ($type == 0) {
                                echo "['$datr',  $countr],";
                            } else if ($type == 2) {
                                echo "['$datr',  0, $countr],";
                            }
                        }
                    }
                }
                ?>
                        ]);

                        var options = {
                        <?php
if ($type == 0) {
                    echo "title: 'Fingerprints',";
                } else if ($type == 1) {
                    echo "title: 'IP researches',";
                } else if ($type == 2) {
                    echo "title: 'IP researches and Fingerprints',";
                }
                ?>
                            hAxis: {title: 'Last 30 days',  titleTextStyle: {color: '#333'}, slantedText:true, slantedTextAngle:45},
                            vAxis: {minValue: 0}
                        };

                        var chart = new google.visualization.AreaChart(document.getElementById('chart_30d'));
                        data.sort([{column: 0}]);
                        var groupData = google.visualization.data.group(
                            data,
                            [0],
                            <?php
if ($type == 0 || $type == 1) {
                    echo "[{
                                    column: 1,
                                    aggregation: google.visualization.data.sum,
                                    type: 'number'
                                    }]";
                } else if ($type == 2) {
                    echo "[{
                                    column: 1,
                                    aggregation: google.visualization.data.sum,
                                    type: 'number'
                                    }, {
                                    column: 2,
                                    aggregation: google.visualization.data.sum,
                                    type: 'number'
                                    }]";
                }
                ?>
                        );

                        chart.draw(groupData, options);
                    }

                    function drawChart24h() {
                        var data = google.visualization.arrayToDataTable([
                        <?php
if ($type == 0) {
                    echo "['Month','Fingerprints'],";
                } elseif ($type == 1) {
                    echo "['Month', 'IP researches'],";
                } else if ($type == 2) {
                    echo "['Month', 'IP researches', 'Fingerprints'],";
                }
                if ($type == 1 || $type == 2) {
                    $sql_ip = "SELECT dDate as dat, COUNT(dDate) as cnt from save_ip WHERE dDate >= now() - INTERVAL 1 DAY AND project_id = (:project_id) GROUP BY DAY(dDate), HOUR(dDate) ORDER BY dDATE ASC;";
                    $log_ip = $this->dbh->prepare($sql_ip);
                    $log_ip->bindParam(':project_id', $project_id, PDO::PARAM_STR);
                    $log_ip->execute();
                    $ip_ress = $log_ip->fetchAll(PDO::FETCH_OBJ);
                    if ($log_ip->rowCount() > 0) {
                        foreach ($ip_ress as $ip_res) {
                            $datr = $ip_res->dat;
                            $datr = new DateTime($datr);
                            $datr = $datr->format('Y-m-d H:00');
                            $countr = $ip_res->cnt;
                            if ($type == 1) {
                                echo "['$datr',  $countr],";
                            } else if ($type == 2) {
                                echo "['$datr',  $countr, 0],";
                            }
                        }
                    }
                }
                if ($type == 0 || $type == 2) {
                    $sql_ip = "SELECT dDate as dat, COUNT(dDate) as cnt from save_fp WHERE dDate >= now() - INTERVAL 1 DAY AND project_id = (:project_id) GROUP BY DAY(dDate), HOUR(dDate) ORDER BY dDATE ASC;";
                    $log_ip = $this->dbh->prepare($sql_ip);
                    $log_ip->bindParam(':project_id', $project_id, PDO::PARAM_STR);
                    $log_ip->execute();
                    $ip_ress = $log_ip->fetchAll(PDO::FETCH_OBJ);
                    if ($log_ip->rowCount() > 0) {
                        foreach ($ip_ress as $ip_res) {
                            $datr = $ip_res->dat;
                            $datr = new DateTime($datr);
                            $datr = $datr->format('Y-m-d H:00');
                            $countr = $ip_res->cnt;
                            if ($type == 0) {
                                echo "['$datr',  $countr],";
                            } else if ($type == 2) {
                                echo "['$datr',  0, $countr],";
                            }
                        }
                    }
                }
                ?>
                        ]);

                        var options = {
                        <?php
if ($type == 0) {
                    echo "title: 'Fingerprints',";
                } else if ($type == 1) {
                    echo "title: 'IP researches',";
                } else if ($type == 2) {
                    echo "title: 'IP researches and Fingerprints',";
                }
                ?>
                            hAxis: {title: 'Last 24 hours',  titleTextStyle: {color: '#333'}, slantedText:true, slantedTextAngle:45},
                            vAxis: {minValue: 0}
                        };

                        var chart = new google.visualization.AreaChart(document.getElementById('chart_24h'));
                        data.sort([{column: 0}]);
                        var groupData = google.visualization.data.group(
                            data,
                            [0],
                            <?php
if ($type == 0 || $type == 1) {
                    echo "[{
                                    column: 1,
                                    aggregation: google.visualization.data.sum,
                                    type: 'number'
                                    }]";
                } else if ($type == 2) {
                    echo "[{
                                    column: 1,
                                    aggregation: google.visualization.data.sum,
                                    type: 'number'
                                    }, {
                                    column: 2,
                                    aggregation: google.visualization.data.sum,
                                    type: 'number'
                                    }]";
                }
                ?>
                        );

                        chart.draw(groupData, options);
                    }

                    $(window).resize(function(){
                        drawChart12m();
                        drawChart30d();
                    });

                    $('#Last30Days-tab').click(function(){
                        $(check_Last30Days);
                    });
                    function check_Last30Days()
                    {
                        if ($('#Last30Days').hasClass('show'))
                            drawChart30d();
                        else
                            setTimeout(check_Last30Days, 500);
                    }

                    $('#Last12Month-tab').click(function(){
                        $(check_Last12Month);
                    });
                    function check_Last12Month()
                    {
                        if ($('#Last12Month').hasClass('show'))
                            drawChart12m();
                        else
                            setTimeout(check_Last12Month, 500);
                    }

                    $('#Last24Hours-tab').click(function(){
                        $(check_Last24Hours);
                    });
                    function check_Last24Hours()
                    {
                        if ($('#Last24Hours').hasClass('show'))
                            drawChart24h();
                        else
                            setTimeout(check_Last24Hours, 500);
                    }

                })
                </script>
                <?php
}
        } else {
            $this->alert->error('This is not your Project or Project not found!');
        }
        echo '</div>';
    }

    public function editProjectByID($userID, $id)
    {
        echo '<div class="col-lg-12">';

        if (isset($_POST['send'])) {
            $post_ip = $_POST['ip'];
            $post_website = $_POST['website'];
            $post_saveipres = $_POST['saveipres'];
            $post_savefpints = $_POST['savefpints'];

            $save_ip_data = 0;
            if ($post_saveipres == 'on') {
                $save_ip_data = 1;
            }
            $save_fp_data = 0;
            if ($post_savefpints == 'on') {
                $save_fp_data = 1;
            }

            if(!filter_var($post_ip, FILTER_VALIDATE_IP)) {
                $this->alert->error('No valid IP!');
            }else{
                if (filter_var($post_website, FILTER_VALIDATE_URL)) {
                    $post_website = parse_url($post_website);
                    $post_website = $post_website['host'];
                }
                $post_website = str_replace("https://", "", $post_website);
                $post_website = str_replace("http://", "", $post_website);
                $post_website = str_replace("www.", "", $post_website);
                $post_website = str_replace("/", "", $post_website);
    
                $sqlactiv = "UPDATE project SET website=(:website), ip=(:ip), save_ip_data=(:save_ip_data), save_fp_data=(:save_fp_data) WHERE userid=(:userid) AND id=(:id)";
                $queryactiv = $this->dbh->prepare($sqlactiv);
                $queryactiv->bindParam(':website', $post_website, PDO::PARAM_STR);
                $queryactiv->bindParam(':ip', $post_ip, PDO::PARAM_STR);
                $queryactiv->bindParam(':save_ip_data', $save_ip_data, PDO::PARAM_STR);
                $queryactiv->bindParam(':save_fp_data', $save_fp_data, PDO::PARAM_STR);
                $queryactiv->bindParam(':userid', $userID, PDO::PARAM_STR);
                $queryactiv->bindParam(':id', $id, PDO::PARAM_STR);
    
                if ($queryactiv->execute()) {
                    $this->send->log('Has edited his project [ID:' . $id . ']', 'Admin', $username);
                    $this->alert->success('Project was successfully updated');
                } else {
                    $this->alert->error('Project could not be updated');
                }
            }

        }

        $sql_log = "SELECT * from project where userid=(:userid) AND id=(:id)";
        $log_query = $this->dbh->prepare($sql_log);
        $log_query->bindParam(':userid', $userID, PDO::PARAM_STR);
        $log_query->bindParam(':id', $id, PDO::PARAM_STR);
        $log_query->execute();
        $log_ress = $log_query->fetchAll(PDO::FETCH_OBJ);
        if ($log_query->rowCount() == 1) {
            foreach ($log_ress as $log_res) {
                $project_id = $log_res->id;
                $token = $log_res->token;
                $website = $log_res->website;
                $ip = $log_res->ip;
                $type = $log_res->type;

                $sql_idents_ip = 0;
                $sql_ids_ip = "SELECT COUNT(id) as ct FROM save_ip WHERE YEAR(dDate) = YEAR(CURRENT_DATE()) AND MONTH(dDate) = MONTH(CURRENT_DATE()) AND project_id = (:project_id)";
                $query_ids_ip = $this->dbh->prepare($sql_ids_ip);
                $query_ids_ip->bindParam(':project_id', $project_id, PDO::PARAM_STR);
                $query_ids_ip->execute();
                if ($query_ids_ip->rowCount() > 0) {
                    $res_ids_ip = $query_ids_ip->fetchAll(PDO::FETCH_OBJ);
                    $sql_idents_ip = $res_ids_ip[0]->ct;
                }

                $sql_idents_fp = 0;
                $sql_ids_fp = "SELECT COUNT(id) as ct FROM save_fp WHERE YEAR(dDate) = YEAR(CURRENT_DATE()) AND MONTH(dDate) = MONTH(CURRENT_DATE()) AND project_id = (:project_id)";
                $query_ids_fp = $this->dbh->prepare($sql_ids_fp);
                $query_ids_fp->bindParam(':project_id', $project_id, PDO::PARAM_STR);
                $query_ids_fp->execute();
                if ($query_ids_fp->rowCount() > 0) {
                    $res_ids_fp = $query_ids_fp->fetchAll(PDO::FETCH_OBJ);
                    $sql_idents_fp = $res_ids_fp[0]->ct;
                }

                if ($type == 0) {
                    $t_desc = 'Fingerprinting';
                } else if ($type == 1) {
                    $t_desc = 'IP Research';
                } else if ($type == 2) {
                    $t_desc = 'Fingerprinting and IP Research';
                } else if ($type == 3) {
                    $t_desc = 'Free API (Commercial use)';
                }

                $idents = $log_res->idents;
                $save_ip_data = $log_res->save_ip_data;
                $save_fp_data = $log_res->save_fp_data;

                $ip_dat = '';
                if ($save_ip_data) {
                    $ip_dat = 'checked=""';
                }

                $fp_dat = '';
                if ($save_fp_data) {
                    $fp_dat = 'checked=""';
                }

                $subscribe_until = $log_res->subscribe_until;
                $subscribe_until = date_create($subscribe_until);
                $subscribe_until = date_format($subscribe_until, "m/d/Y H:i:s");

                $dDate = $log_res->dDate;
                $dDate = date_create($dDate);
                $dDate = date_format($dDate, "m/d/Y H:i:s");

                echo '<form enctype="multipart/form-data" method="post">';
                echo '<div class="row">';

                echo '<div class="col-sm-6"><div class="form-group"><label for="token">Token</label>
                    <input type="text" class="form-control mb-4" id="token" name="token" value="' . $token . '" readonly></div></div>';

                echo '<div class="col-sm-6"><div class="form-group"><label for="subscribe_until">Subscribe until</label>
                    <input type="text" class="form-control mb-4" id="subscribe_until" name="subscribe_until" value="' . $subscribe_until . '" readonly></div></div>';

                echo '<div class="col-sm-12"><div class="form-group"><label for="website">Website</label>
                    <input type="text" class="form-control mb-4" id="website" name="website" placeholder="Website" value="' . $website . '"></div></div>';

                echo '<div class="col-sm-12"><div class="form-group"><label for="ip">ServerIP</label>
                    <input type="text" class="form-control mb-4" id="ip" name="ip" placeholder="ServerIP" value="' . $ip . '"></div></div>';

                echo '<div class="col-sm-6"><div class="form-group">
                <label>Save IP research in Cloud?</label><br>
                <label class="switch s-icons s-outline  s-outline-primary  mb-4 mr-2">
                    <input name="saveipres" type="checkbox" ' . $ip_dat . '>
                    <span class="slider"></span>
                </label>
                </div></div>';

                echo '<div class="col-sm-6"><div class="form-group">
                <label>Save Fingerprints in Cloud?</label><br>
                <label class="switch s-icons s-outline  s-outline-primary  mb-4 mr-2">
                    <input name="savefpints" type="checkbox" ' . $fp_dat . '>
                    <span class="slider"></span>
                </label>
                </div></div>';
                echo '<input type="submit" name="send" class="btn btn-primary btn-block mt-4 mb-4" value="Save">';

                echo '</div>';
                echo '</form>';
            }
        } else {
            $this->alert->error('This is not your Project or Project not found!');
        }
        echo '</div>';
    }

    public function upgradeProjectByID($userID, $id)
    {
        echo '<div class="col-lg-12">';

        $sql_log = "SELECT * from project where userid=(:userid) AND id=(:id)";
        $log_query = $this->dbh->prepare($sql_log);
        $log_query->bindParam(':userid', $userID, PDO::PARAM_STR);
        $log_query->bindParam(':id', $id, PDO::PARAM_STR);
        $log_query->execute();
        $log_ress = $log_query->fetchAll(PDO::FETCH_OBJ);
        if ($log_query->rowCount() == 1) {
            foreach ($log_ress as $log_res) {
                $project_id = $log_res->id;
                $token = $log_res->token;
                $website = $log_res->website;
                $type = $log_res->type;

                $sql_idents_ip = 0;
                $sql_ids_ip = "SELECT COUNT(id) as ct FROM save_ip WHERE YEAR(dDate) = YEAR(CURRENT_DATE()) AND MONTH(dDate) = MONTH(CURRENT_DATE()) AND project_id = (:project_id)";
                $query_ids_ip = $this->dbh->prepare($sql_ids_ip);
                $query_ids_ip->bindParam(':project_id', $project_id, PDO::PARAM_STR);
                $query_ids_ip->execute();
                if ($query_ids_ip->rowCount() > 0) {
                    $res_ids_ip = $query_ids_ip->fetchAll(PDO::FETCH_OBJ);
                    $sql_idents_ip = $res_ids_ip[0]->ct;
                }

                $sql_idents_fp = 0;
                $sql_ids_fp = "SELECT COUNT(id) as ct FROM save_fp WHERE YEAR(dDate) = YEAR(CURRENT_DATE()) AND MONTH(dDate) = MONTH(CURRENT_DATE()) AND project_id = (:project_id)";
                $query_ids_fp = $this->dbh->prepare($sql_ids_fp);
                $query_ids_fp->bindParam(':project_id', $project_id, PDO::PARAM_STR);
                $query_ids_fp->execute();
                if ($query_ids_fp->rowCount() > 0) {
                    $res_ids_fp = $query_ids_fp->fetchAll(PDO::FETCH_OBJ);
                    $sql_idents_fp = $res_ids_fp[0]->ct;
                }

                if ($type == 0) {
                    $t_desc = 'Fingerprinting';
                } else if ($type == 1) {
                    $t_desc = 'IP Research';
                } else if ($type == 2) {
                    $t_desc = 'Fingerprinting and IP Research';
                } else if ($type == 3) {
                    $t_desc = 'Free API (Commercial use)';
                }

                $idents = $log_res->idents;
                $save_ip_data = $log_res->save_ip_data;
                $save_fp_data = $log_res->save_fp_data;

                $ip_dat = '';
                if ($save_ip_data) {
                    $ip_dat = 'checked=""';
                }

                $fp_dat = '';
                if ($save_fp_data) {
                    $fp_dat = 'checked=""';
                }

                $subscribe_until = $log_res->subscribe_until;
                $subscribe_until = date_create($subscribe_until);
                $subscribe_until = date_format($subscribe_until, "m/d/Y H:i:s");

                $dDate = $log_res->dDate;
                $dDate = date_create($dDate);
                $dDate = date_format($dDate, "m/d/Y H:i:s");

                echo '<form enctype="multipart/form-data" method="post">';
                echo '<div class="row">';

                echo '<div class="col-sm-6"><div class="form-group"><label for="token">Token</label>
                    <input type="text" class="form-control mb-4" id="token" name="token" value="' . $token . '" readonly></div></div>';

                echo '<div class="col-sm-6"><div class="form-group"><label for="subscribe_until">Subscribe until</label>
                    <input type="text" class="form-control mb-4" id="subscribe_until" name="subscribe_until" value="' . $subscribe_until . '" readonly></div></div>';

                $peri1 = '';
                $peri2 = '';
                $peri6 = '';
                $peri12 = '';
                $peri24 = '';

                $idn100k = '';
                $idn200k = '';
                $idn500k = '';
                $idn1m = '';
                $idn2m = '';
                if ($idents == "100000") {
                    $c_quers = '100k';
                    $idn100k = 'selected';
                } elseif ($idents == "200000") {
                    $c_quers = '200k';
                    $idn200k = 'selected';
                } elseif ($idents == "500000") {
                    $c_quers = '500k';
                    $idn500k = 'selected';
                } elseif ($idents == "1000000") {
                    $c_quers = '1M';
                    $idn1m = 'selected';
                } elseif ($idents == "2000000") {
                    $c_quers = '2M';
                    $idn2m = 'selected';
                } else {
                    $c_quers = $idents;
                }

                $seltype0 = '';
                $seltype1 = '';
                $seltype2 = '';
                $seltype3 = '';
                if ($type == 0) {
                    $seltype0 = 'selected';
                } elseif ($type == 1) {
                    $seltype1 = 'selected';
                } elseif ($type == 2) {
                    $seltype2 = 'selected';
                }elseif ($type == 3) {
                    $seltype3 = 'selected';
                }

                //CALCULATE
                if (isset($_POST['calculate'])) {
                    $idn100k = '';
                    $idn200k = '';
                    $idn500k = '';
                    $idn1m = '';
                    $idn2m = '';

                    if ($_POST['queries'] == 0) {
                        $p_quers = '100k';
                        $n_quers = '100000';
                        $idn100k = 'selected';
                    } elseif ($_POST['queries'] == 1) {
                        $p_quers = '200k';
                        $n_quers = '200000';
                        $idn200k = 'selected';
                    } elseif ($_POST['queries'] == 2) {
                        $p_quers = '500k';
                        $n_quers = '500000';
                        $idn500k = 'selected';
                    } elseif ($_POST['queries'] == 3) {
                        $p_quers = '1M';
                        $n_quers = '1000000';
                        $idn1m = 'selected';
                    } elseif ($_POST['queries'] == 4) {
                        $p_quers = '2M';
                        $n_quers = '2000000';
                        $idn2m = 'selected';
                    } else {
                        $p_quers = 'ERROR';
                    }

                    if ($_POST['peroid'] == 1) {
                        $peri1 = 'selected';
                    } elseif ($_POST['peroid'] == 2) {
                        $peri2 = 'selected';
                    } elseif ($_POST['peroid'] == 6) {
                        $peri6 = 'selected';
                    } elseif ($_POST['peroid'] == 12) {
                        $peri12 = 'selected';
                    } elseif ($_POST['peroid'] == 24) {
                        $peri24 = 'selected';
                    }

                    $price100_0 = price100_0;
                    $price100_1 = price100_1;
                    $price100_2 = price100_2;

                    $price200_0 = price200_0;
                    $price200_1 = price200_1;
                    $price200_2 = price200_2;

                    $price500_0 = price500_0;
                    $price500_1 = price500_1;
                    $price500_2 = price500_2;

                    $price1000_0 = price1000_0;
                    $price1000_1 = price1000_1;
                    $price1000_2 = price1000_2;

                    $price2000_0 = price2000_0;
                    $price2000_1 = price2000_1;
                    $price2000_2 = price2000_2;

                    $seltype0 = '';
                    $seltype1 = '';
                    $seltype2 = '';
                    $seltype3 = '';
                    $new_type = $type;
                    if ($_POST['type'] == 0) {
                        $new_type = 0;
                        $seltype0 = 'selected';
                        $new_type_desc = 'Fingerprinting';
                    } elseif ($_POST['type'] == 1) {
                        $new_type = 1;
                        $seltype1 = 'selected';
                        $new_type_desc = 'IP Research';
                    } elseif ($_POST['type'] == 2) {
                        $new_type = 2;
                        $seltype2 = 'selected';
                        $new_type_desc = 'Fingerprinting and IP Research';
                    } elseif ($_POST['type'] == 3) {
                        $new_type = 3;
                        $seltype3 = 'selected';
                        $new_type_desc = 'Free API (Commercial use)';
                    }

                    if ($new_type == 0) {
                        if ($n_quers == '100000') {
                            $price = $price100_0;
                        } elseif ($n_quers == '200000') {
                            $price = $price200_0;
                        } elseif ($n_quers == '500000') {
                            $price = $price500_0;
                        } elseif ($n_quers == '1000000') {
                            $price = $price1000_0;
                        } elseif ($n_quers == '2000000') {
                            $price = $price2000_0;
                        }
                    } elseif ($new_type == 1) {
                        if ($n_quers == '100000') {
                            $price = $price100_1;
                        } elseif ($n_quers == '200000') {
                            $price = $price200_1;
                        } elseif ($n_quers == '500000') {
                            $price = $price500_1;
                        } elseif ($n_quers == '1000000') {
                            $price = $price1000_1;
                        } elseif ($n_quers == '2000000') {
                            $price = $price2000_1;
                        }
                    } elseif ($new_type == 2) {
                        if ($n_quers == '100000') {
                            $price = $price100_2;
                        } elseif ($n_quers == '200000') {
                            $price = $price200_2;
                        } elseif ($n_quers == '500000') {
                            $price = $price500_2;
                        } elseif ($n_quers == '1000000') {
                            $price = $price1000_2;
                        } elseif ($n_quers == '2000000') {
                            $price = $price2000_2;
                        }
                    }elseif ($new_type == 3) {
                        $price = "4";
                        $n_quers = '999999999';
                        $p_quers = "unlimited";
                    }
                }

                echo '<div class="col-sm-12"><div class="form-group"><label for="type">Project type</label>';
                echo '<select id="type" name="type" class="form-control">';
                echo '<option value="0" ' . $seltype0 . '>Fingerprinting</option>';
                echo '<option value="1" ' . $seltype1 . '>IP research</option>';
                echo '<option value="2" ' . $seltype2 . '>Fingerprinting and IP Research</option>';
                echo '<option value="3" ' . $seltype3 . '>Free API (Commercial use)</option>';
                echo '</select>';
                echo '</div></div>';

                echo '<div class="col-sm-6"><div class="form-group"><label for="queries">Queries</label>';
                echo '<select id="queries" name="queries" class="form-control">';
                echo '<option value="0" ' . $idn100k . '>100k</option>';
                echo '<option value="1" ' . $idn200k . '>200k</option>';
                echo '<option value="2" ' . $idn500k . '>500k</option>';
                echo '<option value="3" ' . $idn1m . '>1M</option>';
                echo '<option value="4" ' . $idn2m . '>2M</option>';
                echo '</select>';
                echo '</div></div>';

                echo '<div class="col-sm-6"><div class="form-group"><label for="peroid">Peroid</label>';
                echo '<select id="peroid" name="peroid" class="form-control">';
                echo '<option value="1" ' . $peri1 . '>1 Month</option>';
                echo '<option value="2" ' . $peri2 . '>2 Month</option>';
                echo '<option value="6" ' . $peri6 . '>6 Month</option>';
                echo '<option value="12" ' . $peri12 . '>1 Year</option>';
                echo '<option value="24" ' . $peri24 . '>2 Year</option>';
                echo '</select>';
                echo '</div></div>';

                //BUY
                if (isset($_POST['buy']) && isset($_POST['queries']) && isset($_POST['peroid']) && $_POST['buy'] == 'Buy') {
                    $n_quers = 0;
                    $price = 0;
                    $idn100k = '';
                    $idn200k = '';
                    $idn500k = '';
                    $idn1m = '';
                    $idn2m = '';

                    if ($_POST['queries'] == 0) {
                        $p_quers = '100k';
                        $n_quers = '100000';
                        $idn100k = 'selected';
                    } elseif ($_POST['queries'] == 1) {
                        $p_quers = '200k';
                        $n_quers = '200000';
                        $idn200k = 'selected';
                    } elseif ($_POST['queries'] == 2) {
                        $p_quers = '500k';
                        $n_quers = '500000';
                        $idn500k = 'selected';
                    } elseif ($_POST['queries'] == 3) {
                        $p_quers = '1M';
                        $n_quers = '1000000';
                        $idn1m = 'selected';
                    } elseif ($_POST['queries'] == 4) {
                        $p_quers = '2M';
                        $n_quers = '2000000';
                        $idn2m = 'selected';
                    } else {
                        $p_quers = 'ERROR';
                    }

                    if ($_POST['peroid'] == 1) {
                        $peri1 = 'selected';
                    } elseif ($_POST['peroid'] == 2) {
                        $peri2 = 'selected';
                    } elseif ($_POST['peroid'] == 6) {
                        $peri6 = 'selected';
                    } elseif ($_POST['peroid'] == 12) {
                        $peri12 = 'selected';
                    } elseif ($_POST['peroid'] == 24) {
                        $peri24 = 'selected';
                    }

                    $price100_0 = price100_0;
                    $price100_1 = price100_1;
                    $price100_2 = price100_2;

                    $price200_0 = price200_0;
                    $price200_1 = price200_1;
                    $price200_2 = price200_2;

                    $price500_0 = price500_0;
                    $price500_1 = price500_1;
                    $price500_2 = price500_2;

                    $price1000_0 = price1000_0;
                    $price1000_1 = price1000_1;
                    $price1000_2 = price1000_2;

                    $price2000_0 = price2000_0;
                    $price2000_1 = price2000_1;
                    $price2000_2 = price2000_2;

                    $seltype0 = '';
                    $seltype1 = '';
                    $seltype2 = '';
                    $new_type = $type;
                    if ($_POST['type'] == 0) {
                        $new_type = 0;
                        $seltype0 = 'selected';
                        $new_type_desc = 'Fingerprinting';
                    } elseif ($_POST['type'] == 1) {
                        $new_type = 1;
                        $seltype1 = 'selected';
                        $new_type_desc = 'IP Research';
                    } elseif ($_POST['type'] == 2) {
                        $new_type = 2;
                        $seltype2 = 'selected';
                        $new_type_desc = 'Fingerprinting and IP Research';
                    }elseif ($_POST['type'] == 3) {
                        $new_type = 3;
                        $seltype3 = 'selected';
                        $new_type_desc = 'Free API (Commercial use)';
                    }

                    if ($new_type == 0) {
                        if ($n_quers == '100000') {
                            $price = $price100_0;
                        } elseif ($n_quers == '200000') {
                            $price = $price200_0;
                        } elseif ($n_quers == '500000') {
                            $price = $price500_0;
                        } elseif ($n_quers == '1000000') {
                            $price = $price1000_0;
                        } elseif ($n_quers == '2000000') {
                            $price = $price2000_0;
                        }
                    } elseif ($new_type == 1) {
                        if ($n_quers == '100000') {
                            $price = $price100_1;
                        } elseif ($n_quers == '200000') {
                            $price = $price200_1;
                        } elseif ($n_quers == '500000') {
                            $price = $price500_1;
                        } elseif ($n_quers == '1000000') {
                            $price = $price1000_1;
                        } elseif ($n_quers == '2000000') {
                            $price = $price2000_1;
                        }
                    } elseif ($new_type == 2) {
                        if ($n_quers == '100000') {
                            $price = $price100_2;
                        } elseif ($n_quers == '200000') {
                            $price = $price200_2;
                        } elseif ($n_quers == '500000') {
                            $price = $price500_2;
                        } elseif ($n_quers == '1000000') {
                            $price = $price1000_2;
                        } elseif ($n_quers == '2000000') {
                            $price = $price2000_2;
                        }
                    }elseif ($new_type == 3) {
                        $price = "4";
                        $n_quers = '999999999';
                        $p_quers = "unlimited";
                    }

                    if ($idents == $n_quers && $type == $new_type) {
                        $new_subs_date = date("m/d/Y", strtotime("+" . $_POST['peroid'] . " months", strtotime($subscribe_until)));
                        $new_subs_date_mysql = date("Y-m-d h:i:s", strtotime("+" . $_POST['peroid'] . " months", strtotime($subscribe_until)));
                    } else {
                        $new_subs_date = new DateTime("+" . $_POST['peroid'] . " months");
                        $new_subs_date_mysql = $new_subs_date->format("Y-m-d h:i:s"); 
                        $new_subs_date = $new_subs_date->format("m/d/Y");
                    }

                    $totalprice = $price;
                    $discount = '';
                    if ($_POST['peroid'] == 12) {
                        $totalprice = $totalprice * 0.90;
                    }
                    if ($_POST['peroid'] == 24) {
                        $totalprice = $totalprice * 0.80;
                    }
                    $totalprice = $totalprice * $_POST['peroid'];
                    $yourBalance = $this->getCurrencyByName($_SESSION['ulogin']);
                    $newBalance = $yourBalance-$totalprice;

                    if ($totalprice <= $yourBalance) {
                        if ($p_quers != 'ERROR' && $price > 3 && $_POST['peroid'] > 0 && $_POST['peroid'] <= 24 && $_POST['queries'] >= 0 && $_POST['queries'] <= 4) {
                            if($this->updateCurrencyByName($_SESSION['ulogin'], $newBalance)){
                                if($this->updateProjectByID($id, $new_type, $n_quers, $new_subs_date_mysql)){
                                    echo '<div class="col-sm-12"><div class="form-group">';
                                    $this->alert->success('The purchase was successful.');
                                    echo '</div></div>';
                                }else{
                                    $this->updateCurrencyByName($_SESSION['ulogin'], $yourBalance);
                                    echo '<div class="col-sm-12"><div class="form-group">';
                                    $this->alert->error('The purchase could not be made, please contact support. PURERR#2');
                                    echo '</div></div>';
                                }
                            }else{
                                echo '<div class="col-sm-12"><div class="form-group">';
                                $this->alert->error('The purchase could not be made, please contact support. PURERR#1');
                                echo '</div></div>';
                            }   
                        }
                    } else {
                        echo '<div class="col-sm-12"><div class="form-group">';
                        $this->alert->error('You do not have enough credits to buy this package.');
                        echo '</div></div>';
                    }

                }

                //CALCULATE #2
                if (isset($_POST['calculate'])) {
                    if ($idents < $n_quers && $type != 3) {
                        echo '<div class="col-sm-12"><div class="form-group">';
                        $this->alert->info('Your current queries are smaller than the selected ones. <br>Your subscription time will be lost.');
                        echo '</div></div>';
                    }

                    if ($type != $new_type) {
                        echo '<div class="col-sm-12"><div class="form-group">';
                        $this->alert->info('Project type has been changed. <br>Your subscription time will be lost.');
                        echo '</div></div>';
                    }

                    echo '<div class="col-sm-12"><div class="form-group">';
                    echo '<p>Current type: ' . $t_desc . '</p>';
                    echo '</div></div>';

                    echo '<div class="col-sm-12"><div class="form-group">';
                    echo '<p>New type: ' . $new_type_desc . '</p>';
                    echo '</div></div>';

                    echo '<div class="col-sm-12"><div class="form-group">';
                    echo '<p>Current queries: ' . $c_quers . '</p>';
                    echo '</div></div>';

                    echo '<div class="col-sm-12"><div class="form-group">';
                    echo '<p>Selected queries: ' . $p_quers . '</p>';
                    echo '</div></div>';

                    echo '<div class="col-sm-12"><div class="form-group">';
                    echo '<p>Selected period: ' . $_POST['peroid'] . ' months</p>';
                    echo '</div></div>';

                    if ($idents == $n_quers && $type == $new_type) {
                        $new_subs_date = date("m/d/Y", strtotime("+" . $_POST['peroid'] . " months", strtotime($subscribe_until)));
                    } else {
                        $new_subs_date = new DateTime("+" . $_POST['peroid'] . " months");
                        $new_subs_date = $new_subs_date->format("m/d/Y");
                    }

                    echo '<div class="col-sm-12"><div class="form-group">';
                    echo '<p>New Subscribe until: ' . $new_subs_date . '</p>';
                    echo '</div></div>';

                    echo '<div class="col-sm-12"><div class="form-group">';
                    echo '<p>Price per month: ' . $price . '€</p>';
                    echo '</div></div>';

                    $totalprice = $price;
                    $discount = '';
                    if ($_POST['peroid'] == 12) {
                        $discount = '(includes 10% discount)';
                        $totalprice = $totalprice * 0.90;
                    }
                    if ($_POST['peroid'] == 24) {
                        $discount = '(includes 20% discount)';
                        $totalprice = $totalprice * 0.80;
                    }
                    $totalprice = $totalprice * $_POST['peroid'];
                    $yourBalance = $this->getCurrencyByName($_SESSION['ulogin']);
                    echo '<div class="col-sm-12"><div class="form-group">';
                    echo '<p>Total price: ' . $totalprice . '€ ' . $discount . '</p>';
                    echo '</div></div>';

                    echo '<div class="col-sm-12"><div class="form-group">';
                    echo '<p>Balance after purchase: ' . ($yourBalance - $totalprice) . '€ </p>';
                    echo '</div></div>';

                    if ($totalprice > $yourBalance) {
                        echo '<div class="col-sm-12"><div class="form-group">';
                        $this->alert->error('You do not have enough credits to buy this package.');
                        echo '</div></div>';
                    }

                    echo '<div class="col-sm-6"><div class="form-group">';
                    echo '<input type="submit" name="calculate" class="btn btn-primary btn-block mt-4 mb-4" value="Calculate">';
                    echo '</div></div>';
                    if ($totalprice <= $yourBalance) {
                        echo '<div class="col-sm-6"><div class="form-group">';
                        echo '<input type="submit" name="buy" class="btn btn-primary btn-block mt-4 mb-4" value="Buy">';
                        echo '</div></div>';
                    }
                } else {
                    echo '<input type="submit" name="calculate" class="btn btn-primary btn-block mt-4 mb-4" value="Calculate">';
                }

                echo '</div>';
                echo '</form>';
            }
        } else {
            $this->alert->error('This is not your Project or Project not found!');
        }
        echo '</div>';
    }

    public function getProjectByUserID($userID)
    {
        $sql_log = "SELECT * from project where userid = (:userid) order by dDate DESC";
        $log_query = $this->dbh->prepare($sql_log);
        $log_query->bindParam(':userid', $userID, PDO::PARAM_STR);
        $log_query->execute();
        $log_ress = $log_query->fetchAll(PDO::FETCH_OBJ);
        if ($log_query->rowCount() > 0) {
            $count = $log_query->rowCount();
            foreach ($log_ress as $log_res) {
                $project_id = $log_res->id;
                $token = $log_res->token;
                $website = $log_res->website;
                $ip = $log_res->ip;
                $type = $log_res->type;

                $sql_idents_ip = 0;
                $sql_ids_ip = "SELECT COUNT(id) as ct FROM save_ip WHERE YEAR(dDate) = YEAR(CURRENT_DATE()) AND MONTH(dDate) = MONTH(CURRENT_DATE()) AND DAY(dDate) = DAY(CURRENT_DATE()) AND project_id = (:project_id)";
                $query_ids_ip = $this->dbh->prepare($sql_ids_ip);
                $query_ids_ip->bindParam(':project_id', $project_id, PDO::PARAM_STR);
                $query_ids_ip->execute();
                if ($query_ids_ip->rowCount() > 0) {
                    $res_ids_ip = $query_ids_ip->fetchAll(PDO::FETCH_OBJ);
                    $sql_idents_ip = $res_ids_ip[0]->ct;
                }

                $sql_idents_fp = 0;
                $sql_ids_fp = "SELECT COUNT(id) as ct FROM save_fp WHERE YEAR(dDate) = YEAR(CURRENT_DATE()) AND MONTH(dDate) = MONTH(CURRENT_DATE()) AND DAY(dDate) = DAY(CURRENT_DATE()) AND project_id = (:project_id)";
                $query_ids_fp = $this->dbh->prepare($sql_ids_fp);
                $query_ids_fp->bindParam(':project_id', $project_id, PDO::PARAM_STR);
                $query_ids_fp->execute();
                if ($query_ids_fp->rowCount() > 0) {
                    $res_ids_fp = $query_ids_fp->fetchAll(PDO::FETCH_OBJ);
                    $sql_idents_fp = $res_ids_fp[0]->ct;
                }

                if ($type == 0) {
                    $t_desc = 'Fingerprinting';
                } else if ($type == 1) {
                    $t_desc = 'IP Research';
                } else if ($type == 2) {
                    $t_desc = 'Fingerprinting and IP Research';
                } else if ($type == 3) {
                    $t_desc = 'Free API (Commercial use)';
                }

                $idents = $log_res->idents;
                $save_ip_data = $log_res->save_ip_data ? 'Yes' : 'No';
                $save_fp_data = $log_res->save_fp_data ? 'Yes' : 'No';

                $subscribe_until = $log_res->subscribe_until;
                $subscribe_until = date_create($subscribe_until);
                $subscribe_until = date_format($subscribe_until, "m/d/Y H:i:s");

                $dDate = $log_res->dDate;
                $dDate = date_create($dDate);
                $dDate = date_format($dDate, "m/d/Y H:i:s");

                $colnam = 'col-xl-5';
                if ($count == 1) {
                    $colnam = 'col-xl-12';
                }

                echo '<div class="card component-card_sp ' . $colnam . '">';
                echo '<div class="card-body">';
                echo '<p class="meta-date">' . $dDate . '</p>';

                echo '<a title="Edit" href="' . $Web_URL . 'project/' . $project_id . '/edit">';
                echo '<p class="meta-date cright"><i class="fas fa-pencil-alt"></i></p>';
                echo '</a>';
                echo '<a title="Upgrade" href="' . $Web_URL . 'project/' . $project_id . '/upgrade">';
                echo '<p class="meta-date cright1"><i class="fas fa-redo"></i></p>';
                echo '</a>';
                if ($type != 3) {
                echo '<a title="Statistics" href="' . $Web_URL . 'project/' . $project_id . '/statistics">';
                echo '<p class="meta-date cright2"><i class="fas fa-chart-pie"></i></p>';
                }
                echo '</a>';

                echo '<h5 class="card-title">' . $t_desc . '</h5>';
                echo '<p class="card-text">Token: ' . $token . '</p>';

                if ($type == 0) {
                    echo '<p class="card-text">Save Fingerprints: ' . $save_fp_data . '</p>';
                    echo '<p class="card-text">Fingerprints: ' . number_format($sql_idents_fp) . ' / ' . number_format($idents) . '</p>';
                } else if ($type == 1) {
                    echo '<p class="card-text">Save IP research: ' . $save_ip_data . '</p>';
                    echo '<p class="card-text">IP researches: ' . number_format($sql_idents_ip) . ' / ' . number_format($idents) . '</p>';
                } else if ($type == 2) {
                    echo '<p class="card-text">Save IP research: ' . $save_ip_data . '</p>';
                    echo '<p class="card-text">Save Fingerprints: ' . $save_fp_data . '</p>';
                    echo '<p class="card-text">Fingerprints: ' . number_format($sql_idents_fp) . ' / ' . number_format($idents) . '</p>';
                    echo '<p class="card-text">IP researches: ' . number_format($sql_idents_ip) . ' / ' . number_format($idents) . '</p>';
                }

                $date_now = date("Y-m-d H:i:s");
                $db_date = new DateTime($subscribe_until);
                $db_date = $db_date->format("Y-m-d H:i:s");
                if ($date_now > $db_date) {
                    echo '<p class="card-text colred">Expired on: ' . $subscribe_until . '</p>';
                } else {
                    echo '<p class="card-text">Expires on: ' . $subscribe_until . '</p>';
                }

                echo '<div class="meta-info">';

                echo '<div class="meta-user">';
                echo '<div class="user-name">' . $website . '</div>';
                echo '</div>';
                echo '<div class="meta-user">';
                echo '<div class="user-name">' . $ip . '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';

            }
        } else {
            $this->alert->info('No projects available');
        }
    }

    public function getOS()
    {
        $os_platform = "Unknown OS Platform";

        $os_array = array(
            '/windows nt 10/i' => 'Windows 10',
            '/windows nt 6.3/i' => 'Windows 8.1',
            '/windows nt 6.2/i' => 'Windows 8',
            '/windows nt 6.1/i' => 'Windows 7',
            '/windows nt 6.0/i' => 'Windows Vista',
            '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
            '/windows nt 5.1/i' => 'Windows XP',
            '/windows xp/i' => 'Windows XP',
            '/windows nt 5.0/i' => 'Windows 2000',
            '/windows me/i' => 'Windows ME',
            '/win98/i' => 'Windows 98',
            '/win95/i' => 'Windows 95',
            '/win16/i' => 'Windows 3.11',
            '/macintosh|mac os x/i' => 'Mac OS X',
            '/mac_powerpc/i' => 'Mac OS 9',
            '/linux/i' => 'Linux',
            '/ubuntu/i' => 'Ubuntu',
            '/iphone/i' => 'iPhone',
            '/ipod/i' => 'iPod',
            '/ipad/i' => 'iPad',
            '/android/i' => 'Android',
            '/blackberry/i' => 'BlackBerry',
            '/webos/i' => 'Mobile',
        );

        foreach ($os_array as $regex => $value) {
            if (preg_match($regex, $this->user_agent)) {
                $os_platform = $value;
            }
        }

        return $os_platform;
    }

    public function getBrowser()
    {
        $browser = "Unknown Browser";

        $browser_array = array(
            '/msie/i' => 'Internet Explorer',
            '/firefox/i' => 'Firefox',
            '/safari/i' => 'Safari',
            '/chrome/i' => 'Chrome',
            '/edge/i' => 'Edge',
            '/opera/i' => 'Opera',
            '/netscape/i' => 'Netscape',
            '/maxthon/i' => 'Maxthon',
            '/konqueror/i' => 'Konqueror',
            '/mobile/i' => 'Handheld Browser',
        );

        foreach ($browser_array as $regex => $value) {
            if (preg_match($regex, $this->user_agent)) {
                $browser = $value;
            }
        }

        return $browser;
    }

}
