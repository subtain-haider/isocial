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
    $this->loadLanguage('activity.php');

    $D->_IN_DASHBOARD = TRUE;
    $D->_WITH_NOTIFIER = TRUE;

	$D->isPhantom = FALSE;
	if ($this->param('phantom') && $this->param('phantom')=='yes') $D->isPhantom = TRUE;

	$D->layout_size = 'min';
	if ($this->param('lysize')) $D->layout_size = $this->param('lysize');

    /***********************************************/

    $D->show_more = '';
    $D->the_list_activities = '';

    $numrelations = $this->db2->fetch_field('SELECT count(id) FROM relations WHERE type_leader=2 AND follower='.$this->user->id);

    if ($numrelations > 0) {

        $sqlPostsHiddens = 'SELECT iditem FROM hiddens WHERE typeitem=0 AND iduser='.$this->user->id;

        $idsPosts = $this->db2->fetch_all('
        SELECT DISTINCT idpost 
        FROM posts, relations 
        WHERE 
        posts.idpost NOT IN ('.$sqlPostsHiddens.') 
        AND follower='.$this->user->id.' 
        AND leader = id_wall 
        AND type_leader = posted_in 
        AND type_leader = 2 
        OR (posts.posted_in=2 AND posts.idwriter = '.$this->user->id.' AND posts.type_writer=0)
        ORDER BY post_date DESC
        LIMIT 0,'.($K->ACTIVITIES_PER_PAGE + 1)
        );

        $theposts = new stdClass;
        $arrIdsPosts = array();
        foreach($idsPosts as $oneidp) $arrIdsPosts[] = $oneidp->idpost;

        $total_posts = 0;

        if (count($arrIdsPosts) > 0) {
            $theposts = $this->db2->query('
            SELECT * 
            FROM posts 
            WHERE idpost in ('.implode($arrIdsPosts,',').') 
            ORDER BY post_date DESC');

            $total_posts = $this->db2->num_rows();
        }

        $D->the_place = 7; // 5:dashboard  6:pages feed  7:groups feed  8:saved  9: hashtag
        $D->type_items = 1; // 1: timeline   2: videos   3: audios
        $D->codeprofile = $user->info->code;

        if ($total_posts>0) {
            $count_regs = 0;
            while ($obj = $this->db2->fetch_object($theposts)) {

                $the_post = new post(FALSE, $obj);
                $D->the_list_activities .= $the_post->draw();

                $count_regs++;
                if ($count_regs >= $K->ACTIVITIES_PER_PAGE) break;

            }

            if ($total_posts > $K->ACTIVITIES_PER_PAGE) {

                $D->show_more = $this->load_template('_showmore.php',FALSE);

            }

        }    

    }

    /****************************************************************************/
    
    $this->load_extract_controller('_pre-dashboard');

    /****************************************************************************/

    $D->id_menu = 'opt_ml_groupsfeed';

	if ($D->isPhantom) {

        $html = '';
        $this->load_extract_controller('_dashboard-menu-left');

		if ($D->layout_size == 'min') {
            $for_load = 'min/groups-feed.php';
		} else {
            $for_load = 'max/groups-feed.php';
		}

        $D->titlePhantom = $this->lang('dashboard_groups_feed_title');

        $html .= $this->load_template($for_load, FALSE);
        echo $html;

	} else {

        $this->load_extract_controller('_required-dashboard');
        $this->load_extract_controller('_dashboard-bar-top');
        $this->load_extract_controller('_dashboard-menu-left');

        $D->page_title = $this->lang('dashboard_groups_feed_title');

        $D->file_in_template = 'max/groups-feed.php';
        $this->load_template('dashboard-template.php');

    }

?>