<?php   
/*
********************************************************
* @author "M Code Developer"
* @author_url 1: https://www.mcodedeveloper.com
* @author_url 2: http://codecanyon.net/user/MCodeDeveloper
* @author_email: m@mcodedeveloper.com
* @support_email: devs@mcodedeveloper.com
********************************************************
* iSocial - Social Networking Platform
* Copyright (c) 2020 "M Code Developer". All rights reserved.
********************************************************
*/
	if (!$D->_IS_LOGGED) $this->globalRedirect('login');

    if (!$K->WITH_GROUPS) $this->globalRedirect('dashboard');

	$this->loadLanguage('global.php');
	$this->loadLanguage('dashboard.php');

    $D->_IN_DASHBOARD = TRUE;
    $D->_WITH_NOTIFIER = TRUE;

	$D->isPhantom = FALSE;
	if ($this->param('phantom') && $this->param('phantom')=='yes') $D->isPhantom = TRUE;

	$D->layout_size = 'min';
	if ($this->param('lysize')) $D->layout_size = $this->param('lysize');

    $D->show_more = FALSE;
    $D->the_list_items = '';

    /****************************************************************************/

    $res = $this->db2->query("SELECT * FROM groups WHERE idcreator=".$this->user->info->iduser." ORDER BY idgroup DESC LIMIT 0, ".($K->ITEMS_PER_PAGE + 1));
    $total_items = $this->db2->num_rows();

    $count_regs = 0;
    while ($obj = $this->db2->fetch_object($res)) {

        $D->group = $obj;
        $D->group->title = stripslashes($D->group->title);
        $D->group->guname = stripslashes($D->group->guname);

        $D->group_last = FALSE;
        if ($total_items < $count_regs + 2) $D->group_last = TRUE;

        $D->the_list_items .= $this->load_template('ones/one-group.php', FALSE);

        $count_regs++;
        if ($count_regs >= $K->ITEMS_PER_PAGE) break;

    }

    if ($total_items > $K->ITEMS_PER_PAGE) $D->show_more = TRUE;

    /****************************************************************************/
    
    $this->load_extract_controller('_pre-dashboard');

    /****************************************************************************/

    $D->id_menu = 'opt_ml_yourgroups';

	if ($D->isPhantom) {

        $html = '';
        $this->load_extract_controller('_dashboard-menu-left');

		if ($D->layout_size == 'min') {
            $for_load = 'min/groups.php';
		} else {
            $for_load = 'max/groups.php';
		}

        $D->titlePhantom = $this->lang('dashboard_groups_title_your');

        $html .= $this->load_template($for_load, FALSE);
        echo $html;

	} else {

        $this->load_extract_controller('_required-dashboard');
        $this->load_extract_controller('_dashboard-bar-top');
        $this->load_extract_controller('_dashboard-menu-left');

        $D->page_title = $this->lang('dashboard_groups_title_your');

        $D->file_in_template = 'max/groups.php';
        $this->load_template('dashboard-template.php');

    }

?>