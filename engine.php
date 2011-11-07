<?
function shaagi_admin_styles() {
  
       wp_enqueue_style( 'shaagiStylesheet' );
       wp_enqueue_style( 'shaagiStylesheet1' );
      wp_enqueue_style( 'shaagiStylesheet2' );   
   }
function shaagi_make_upload_dir ()
{
	if(!is_dir(SHAAGI_UPLOAD_PATH))
	{
		
		 if (!is_dir(WP_UPLOAD_PATH))
		 {
			
			$dir1 = mkdir(WP_UPLOAD_PATH,0777,true);
			@chmod (WP_UPLOAD_PATH,0777);
			
		 }
		 else
		 {
			@chmod (WP_UPLOAD_PATH,0777);
		 }
		 $dir = mkdir(SHAAGI_UPLOAD_PATH,0777,true);
		
		if(!$dir)
		{
			
		}
		else
		{
			@chmod (SHAAGI_UPLOAD_PATH,0777);
			
		}
	}
	else
	{
		
		@chmod (SHAAGI_UPLOAD_PATH,0777);
		
		
	}
}   
function shaagi_admin()
{
	

	$parent = 'share-and-get-it/shareandgetit_admin.php';
	$parent_list = 'share-and-get-it/shareandgetit_admin_list.php';
	add_object_page('TweetAndGetIt', esc_attr(__('Share&Get it!', SHAAGI_TRASNLATE)), 0, $parent, '', SHAAGI_URLPATH.'/img/favicon.png');	
	add_submenu_page($parent, "Share & Get it Make your button", __("Make your button",SHAAGI_TRASNLATE), 0, $parent);
	add_submenu_page($parent, "Manage Share And Get It buttons", __("Manage your buttons",SHAAGI_TRASNLATE), 0, $parent_list);
	
	add_action( 'admin_print_styles-' . $parent, 'shaagi_admin_styles' );
	add_action( 'admin_print_styles-' . $parent_list, 'shaagi_admin_styles' );
	
}

function shaagi_admin_init() {
       
       wp_register_style( 'shaagiStylesheet', WP_PLUGIN_URL . '/share-and-get-it/css/skins/red.css' );
       wp_register_style( 'shaagiStylesheet1', WP_PLUGIN_URL . '/share-and-get-it/css/style.css' );
       wp_register_style( 'shaagiStylesheet2', WP_PLUGIN_URL . '/share-and-get-it/admin/css/style.css' );
	   
	   
   }
   

function shaagi_plugin_init () {

	add_action('admin_menu', 'shaagi_admin');
	add_action( 'admin_init', 'shaagi_admin_init' );
	
	wp_deregister_script( 'shaagi_script' );
	wp_register_script( 'shaagi_script', SHAAGI_URLPATH."/js/shaagi_redirect.js");
    wp_enqueue_script( 'shaagi_script' );
	
	
	
	
}
function shaagi_callback($ma)
{
	return "javascript:shaagiopenNewWindow('".$ma[1]."'";
	
}
function shaagi_content_hook($content)
{
	if ((strpos($content,"javascript:shaagiopenNewWindow")))
	{
		$hostPattern = "/javascript:shaagiopenNewWindow\(['\"]([^'\"]+)['\"]/";
		$cc = preg_replace_callback($hostPattern,'shaagi_callback',$content);
		return $cc;
	}
	return $content;
	
}

function shaagi_shortcode_handler( $atts ) {

	global $tbl_shareandgetit_buttons,$wpdb;
	extract( shortcode_atts( array(
		'name' => 'something',
	), $atts ) );
	
		$sql = "select * from $tbl_shareandgetit_buttons where button_name=\"".trim($name)."\"";
		$row = $wpdb->get_results($wpdb->prepare($sql));
		
		if($wpdb->num_rows == 0)
		{
			return '';
			
		}
		if(strpos($row[0]->file_path,"SHAAGE_FILE:") == 1)
		{
			
			$row[0]->file_path = str_replace(":SHAAGE_FILE:",'',$row[0]->file_path);
			
		}
		
		
		$lang = get_bloginfo( "language", "raw" );

		// dans la variable data j'ajoute en array l'itm btnpage que je recupère grâce à REQUEST_URI
		$data=array("fanpageurl"=>$row[0]->fan_page_url,"post"=>$row[0]->post, "file"=>$row[0]->file_path, "blogger"=>$row[0]->twitter_name, "domain"=>$_SERVER['HTTP_HOST'],"btnPage"=>$_SERVER['REQUEST_URI'] ,"btnname"=>$row[0]->button_name,"language"=>$lang);
		$encoded=urlencode(base64_encode(utf8_encode(serialize($data))));
		$url = "http://shareandgetit.com/process/process.php?data=$encoded";
		$content.='<div id="tweegibs"><a href="javascript:shaagiopenNewWindow(\''.$url.'\');"><span class="tweegitexts">Share&Get it !</span></a>
	    <a class="linkts" href="http://tweetandgetit.com" target="_blank"><img src="'.SHAAGI_URLPATH."/img/shareandgetit.jpg".'" alt="Get twitter followers" border="0"></a><a class="linkts" href="http://viuu.co.uk" target="_blank"><img src="'.SHAAGI_URLPATH.'/img/viuu.jpg" alt="Twitter Backgrounds" border="0"></a></div>';
		return $content;
}


function shaagi_btnslist($page,$link)
{
	global $wpdb,$tbl_shareandgetit_buttons;
	$count_per_page = 10;
		
	if( !isset($page) || empty($page) || $page <= 0)
		$page = 1;
	$lim1 = ($page-1)*$count_per_page;		
	$lim2 = $count_per_page;		

$result = $wpdb->get_row(" SELECT count( * ) as count_all FROM ".$tbl_shareandgetit_buttons);
$count_all = $result->count_all;

$last_page = ceil($count_all/$count_per_page);
$rows = $wpdb->get_results(" SELECT * FROM ".$tbl_shareandgetit_buttons." Limit $lim1,$lim2;");
$previous_page = $page - 1;
if($previous_page < 1) 
	$previous_page = 1;
$next_page = $page + 1;
if($next_page > $last_page) 
	$next_page = $last_page;	

// loop
$i = $page - 3;
if( $i < 1)
	$i = 1;
$loop_count = 1;	

if($i >1)
{
$previous_page = $i-1;

}
else
{
$previous_page = 1;


}
	echo '	<form name="shaagibtnlist"	action="" method="post">
					
						<table cellpadding="0" cellspacing="0" width="100%" class="sortable">
						
							<thead>
								<tr>
									<th width="10"><input name="shaagichkbxall" type="checkbox" class="check_all" onClick="shaagi_CheckAll(document.shaagibtnlist.shaagichkbx,document.shaagibtnlist.shaagichkbxall)"/></th>
									<th>'.__("Button name",SHAAGI_TRASNLATE).'</th>
									<th>'.__("Shortcode",SHAAGI_TRASNLATE).'</th>
									<th>'.__("File",SHAAGI_TRASNLATE).'</th>
									<th>'.__("Edit",SHAAGI_TRASNLATE).' </th>
									<th>'.__("Delete",SHAAGI_TRASNLATE).' </th>
								</tr>
							</thead>
							
							<tbody>
							';
							
							$count = $wpdb->num_rows;
							$op=explode("?",$_SERVER["HTTP_REFERER"]);						
							
							
							foreach ($rows as $row)
							{
								
								if(strpos($row->file_path,":SHAAGE_FILE:") == 0)
								{
									$row->file_path = basename(str_replace(":SHAAGE_FILE:",'',$row->file_path));
								}
								
								echo '
								<tr>
									<td><input name="shaagichkbx" type="checkbox" value="'.$row->id.'" id="'.$row->id.'"/></td>
									<td>'.$row->button_name.'</td>
									<td>'.$row->shortcode.'</td>
									<td>'.$row->file_path.'</td>
									<td class="edit"><a href="'.$op[0].'?page=share-and-get-it/shareandgetit_admin.php&bid='.$row->id.'">'.__("Edit",SHAAGI_TRASNLATE).'</a></td>
									<td class="delete"><a href="javascript:shaagi_delete_button('.$row->id.','.$page.',\''.$link.'\')">'.__("Delete",SHAAGI_TRASNLATE).'</a></td>
								</tr>';
									
							}
							$loop_count = 1;
							$i = $page -2;
							if($i < 1)
								$i = 1;
								echo '
								
							</tbody>
							
						</table>
						
						
						
						<div class="tableactions">
							<select id="selectactions">
								<option>'.__("Actions",SHAAGI_TRASNLATE).'</option>
								<option>'.__("Delete",SHAAGI_TRASNLATE).'</option>
 						    </select>
							
							<input class="submit tiny" value="'.__("Apply to selected",SHAAGI_TRASNLATE).'" onclick="shaagi_delete_buttons(document.shaagibtnlist.shaagichkbx,'.$page.',\''.$link.'\')"/>
					  </div>		<!-- .tableactions ends -->
						
						
						
						<div class="pagination right">';
							
							echo "<a href=\"javascript:shaagi_buttons_list(1,'$link');\" title=\"".__("Go to first page",SHAAGI_TRASNLATE)."[1]\"><<</a>";
							echo "<a href=\"javascript:shaagi_buttons_list($previous_page,'$link');\" title=\"".__("Go to previous page",SHAAGI_TRASNLATE)."[$previous_page]\"><</a>";
							while( $loop_count <= 5 && $i <= $last_page)
							{
								if($page != $i)
								{
									echo "<a href=\"javascript:shaagi_buttons_list($i,'$link');\" title=\"".__("Go to page",SHAAGI_TRASNLATE)."[$i]\">$i</a>";
								
								}
								else
									echo "<a title=\"".__("current page",SHAAGI_TRASNLATE)."[$i]\">$i</a>";
		
		
								$i++;
								$loop_count++;
							}
							echo "<a href=\"javascript:shaagi_buttons_list($next_page,'$link');\" title=\"".__("Go to next page",SHAAGI_TRASNLATE)."[$next_page]\">></a>";
							echo "<a href=\"javascript:shaagi_buttons_list($last_page,'$link');\" title=\"".__("Go to last page",SHAAGI_TRASNLATE)."[$last_page]\">>></a>";
							echo '
							
						</div>		<!-- .pagination ends -->
						
				  </form>
				
				';
}
function shaagi_delete_buttons()
{	
	
	if ( isset($_POST['bids']))
	{
	$url = $_POST['url'];
	$page = $_POST['page'];
	$bids = trim($_POST['bids'],",");
	global $wpdb,$tbl_shareandgetit_buttons;
	$sql = "delete from ".$tbl_shareandgetit_buttons." where id in (".$bids.")";
	if($wpdb->query($sql))
	{
		// show button list again
		shaagi_btnslist($page,$url);
		
	}
	}
	die();
}

function shaagi_buttons_list_callback($p='',$l='') {
	
	if(isset($_POST['page']))	
		$page = $_POST['page'];
	else
		$page = $p;
	if(isset($_POST['link']))	
		$link = $_POST['link'];
	else
		$link = $l;	

	
	shaagi_btnslist($page,$link);
	die();
}
function shaagi_action_callback() {
	global $wpdb,$tbl_shareandgetit_buttons; // this is how you get access to the database
	
	$tweet = $_POST['t'];
	$btn = trim($_POST['bname']);
	$tname= $_POST['tname'];
	$fan_page= $_POST['fanpage'];
	$file=$_POST['f'];
	$location=$_POST['l'];
	$mode=$_POST['mode'];
	$bid=$_POST['bid'];
	
	if ($location == "local")
	{
		$file = ":SHAAGE_FILE:".SHAAGI_UPLOAD_URL."/".basename($file);
	
	}
	
	$shortcode = '[shaagi-button name="'.$btn.'"]';
	if($mode=="add")
	{
	$sql_insert = "insert into ".$tbl_shareandgetit_buttons." values('','$fan_page','$tname','$btn','$tweet','$file','$shortcode')";
	$out=$wpdb->query($sql_insert);
	}	
	else if($mode=="edit")
	{	
		if(strlen($_POST['f'])>0)
		$update_string=",file_path='$file'";
		
		$sql_update = "update ".$tbl_shareandgetit_buttons." set fan_page_url='$fan_page', twitter_name='$tname',post='$tweet' ".$update_string." where id=$bid;";
		$out=$wpdb->query($sql_update);
	}	
	if(is_bool($out) && $out == false)
	{
		echo "<blockquote>".__("Failed to $mode button, change button name and try again",SHAAGI_TRASNLATE)."!<br></blockquote>";
	}
	else if (!$out)
	{
		echo "<blockquote>".__("Failed to $mode button, change some button attributes and try again",SHAAGI_TRASNLATE)."!<br></blockquote>";
	}
	else
	{
		echo "<blockquote>
              <p>".__("Your button is ready",SHAAGI_TRASNLATE)." !<br>
				    ".__("copy / paste this code in your posts, pages and widgets",SHAAGI_TRASNLATE)." !				    <br>
				  </p>
				  <pre>
".$shortcode.'
</pre></blockquote>';
	}
	
	
	die(); 
}

?>