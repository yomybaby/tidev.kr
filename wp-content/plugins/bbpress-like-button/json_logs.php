<?php
//Load wordpress core
include('../../../wp-load.php');

extract($_POST);

//Defaults
if(!isset($sortname)){
    $sortname = 'time';
}
if(!isset($sortorder)){
    $sortorder = 'desc';
}
if(!isset($rp)){
    $rp = '1000';
}
if(!isset($page)){
    $page = 1;
}
$sortorder = strtoupper($sortorder);
$offset = ((Integer)$page - 1) * $rp;

//Get the data
global $wpdb;
$table_name = $wpdb->prefix.'bbplike';
$results = $wpdb->get_results("SELECT * FROM $table_name ORDER BY $sortname $sortorder LIMIT $rp OFFSET $offset",ARRAY_A);

if(!empty($results)){
    //Get Wordpress defined formats
    $date_format = get_option('date_format');
    $time_format = get_option('time_format');
    
    $data = array();
    
    foreach($results as $like){
        //Preprocess
        $user = get_userdata($like['user_id']);
        $post = get_post($like['post_id']);
        if($post->post_type=='reply'){
            $parent_id = $post->post_parent;
            $extra_link = '#post-'.$post->ID;
        }else{
            $parent_id = $like['post_id'];
            $extra_link = '';
        }
        $link = get_permalink($parent_id).$extra_link;

        //Output
        $data[]['cell'] = array(
            $like['id'],
            date($date_format.' '.$time_format, strtotime($like['time'])),
            $user->user_login,
            $post->post_name,
            '<a href="post.php?post='.$like['post_id'].'&action=edit" target="_blank" >'.__('Edit','bbpl').'</a> | <a href="'.$link.'" target="_blank" >'.__('View','bbpl').'</a>'
        );
    }
    echo json_encode(array('page' => 1, 'total' => count($results), 'rows' => $data));
}
die;