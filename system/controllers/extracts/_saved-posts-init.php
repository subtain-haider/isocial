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

    $D->show_more = '';
    $D->the_list_activities = '';

	$sqlPostsHiddens = 'SELECT iditem FROM hiddens WHERE typeitem=0 AND iduser='.$this->user->id;
	
	$idsPosts = $this->db2->fetch_all('
	SELECT idpost  
	FROM posts_saved 
	WHERE 
	idpost NOT IN ('.$sqlPostsHiddens.') 
	AND iduser='.$this->user->id.' AND type_save=1 
	ORDER BY whendate DESC
	LIMIT 0,'.($K->ACTIVITIES_PER_PAGE + 1)
	);
	
    $D->the_place = 8; // 5:dashboard  6:pages feed  7:groups feed  8:saved  9: hashtag
    $D->type_items = 1; // 1: timeline   2: videos   3: audios
    $D->codeprofile = $this->user->info->code;
	
	$total_posts = count($idsPosts);
	
	if ($total_posts > 0) {
		
		$count_regs = 0;
		foreach ($idsPosts as $oneidp) {
			
            $the_post = new post($oneidp->idpost, FALSE);
            $D->the_list_activities .= $the_post->draw();
			
            $count_regs++;
            if ($count_regs >= $K->ACTIVITIES_PER_PAGE) break;

		}
		
        if ($total_posts > $K->ACTIVITIES_PER_PAGE) {

            $D->show_more = $this->load_template('_showmore.php',FALSE);

        }
		
	} else {

		$D->message_text_empty = $this->lang('dashboard_saved_no_items_saved');
        $D->the_list_activities .= $this->load_template('_box-no-items.php',FALSE);

    }

    $D->the_list_activities = '<div id="list-activities">'. $D->the_list_activities . '</div>';
