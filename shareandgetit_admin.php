<?php
if(isset($_GET['bid']))
{	
	$id=trim($_GET['bid']);
	$b_name=__("Update your button",SHAAGI_TRASNLATE);
	$editmode=true;
	$editmodestr="edit";
	global $wpdb,$tbl_shareandgetit_buttons;
	$row = $wpdb->get_row(" SELECT  *  FROM ".$tbl_shareandgetit_buttons." where id=$id");
	if(isset($row))
	{
		$db_btnname=$row->button_name;
		$db_usernames=$row->twitter_name;
		$db_fan_page_url=$row->fan_page_url;
		$db_tweet=$row->post;
		if(strpos($row->file_path,"SHAAGE_FILE:") == 1)
		{
			$row->file_path =  basename(str_replace(":SHAAGE_FILE:",'',$row->file_path));
		}
		$db_file=$row->file_path;
	}
	
}
else
{
	$b_name=__("Create your button",SHAAGI_TRASNLATE);
	$editmodestr="add";
}
	$destination_path = $_GET['path'];
	if(isset($destination_path))
	{

   $result = 0;
   
   $target_path = $destination_path . basename( $_FILES['File_sharing']['name']);
   if(@move_uploaded_file($_FILES['File_sharing']['tmp_name'], $target_path)) {
      $result = 1;
   }
   

?>


<script language="javascript" type="text/javascript">window.top.window.shaagi_stopUpload(<?php echo $result; ?>,'<?echo $target_path?>','<? echo basename( $_FILES['File_sharing']['name'])?>');</script>  <?
die();
}
if(!isset($_POST['promotional_tweet']))
	{
	if(isset($_GET['bid']))
		$TWEET=$db_tweet;
	else
		$TWEET= __("ex: Just downloaded my twitter background for free from http://viuu.co.uk @pointofviuu. Check it out!",SHAAGI_TRASNLATE);
	}
else
	$TWEET=$_POST['promotional_tweet'];
if(isset($_POST['twittername']))	
	$twtname=$_POST['twittername'];
	else if(isset($_GET['bid']))
		$twtname=$db_usernames;
if(isset($_POST['btn_name']))	
	$btnname=$_POST['btn_name'];
	else if(isset($_GET['bid']))
	$btnname=$db_btnname;
if(isset($_POST['fan_page_url']))	
	$fan_page_url=$_POST['fan_page_url'];
	else if(isset($_GET['bid']))
	$fan_page_url=$db_fan_page_url;	
if(isset($_POST['urlfile']))
	$urlname=$_POST['urlfile'];
	else if(isset($_GET['bid']))
	{	
		$urlname = $db_file;

	}
 $destination_path = SHAAGI_UPLOAD_PATH.DIRECTORY_SEPARATOR;
 shaagi_make_upload_dir();

?>

<!-- Javascripts -->
<script type="text/javascript" src="<?echo SHAAGI_URLPATH."/"?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?echo SHAAGI_URLPATH."/"?>js/jquery.superfish.min.js"></script>
<script type="text/javascript" src="<?echo SHAAGI_URLPATH."/"?>js/jquery.tools.min.js"></script>
<script type="text/javascript" src="<?echo SHAAGI_URLPATH."/"?>js/shaagi.js"></script>
<script type="text/javascript" src="<?echo SHAAGI_URLPATH."/"?>js/bootstrap-twipsy.js"></script>
<script type="text/javascript" src="<?echo SHAAGI_URLPATH."/"?>js/bootstrap-popover.js"></script>

<script type="text/javascript">
function shaagi_startUpload(){

      document.getElementById('f1_upload_process').style.display = 'block';
      document.getElementById('upload_result').style.display = 'none';
      return true;
}

function shaagi_stopUpload(success,file,filename){
      var result = '';
      if (success == 1){
         result = "<?php echo __('File ',SHAAGI_TRASNLATE)?>";
         result = result + '<b><font color="red">' +  filename + "</font></b>" + "<?php echo __(' was uploaded successfully!',SHAAGI_TRASNLATE)?>";
		 document.getElementById('submit').disabled=true;
		 document.getElementById('urlfile').disabled=true;
		 document.getElementById('urlfile').value="";
		 document.getElementById('uploaded').value=file;
		 
      }
      else {
         result = "<?php echo  __('There was an error during file upload',SHAAGI_TRASNLATE)?>";
      }
      document.getElementById('f1_upload_process').style.display = 'none';
      document.getElementById('upload_result').innerHTML = result;
      document.getElementById('upload_result').style.display = 'block';      
      return true;   
}

function shaagi_twname_change()
{
	var fanpage = document.getElementById('fan_page_url');
	var twname = document.getElementById('twittername');
	if(twname.value.length<=0)
	{
		fanpage.disabled=false;
		//update error label here
	}
	else
		fanpage.disabled=true;
}
function shaagi_fanpage_change()
{
	var fanpage = document.getElementById('fan_page_url');
	var twname = document.getElementById('twittername');
	if(fanpage.value.length<=0)
	{
		twname.disabled=false;
		//update error label here
	}	
	else
		twname.disabled=true;
}
function shaagi_tweet_counter()
{
	
	var counter = document.getElementById('twtlbl');
	var myform = document.getElementById('contact_form');
	var tweet = myform.promotional_tweet.value;
	var count=140 - tweet.length;
	if ( count<0 ) 
	{
		counter.innerHTML = '<font color="red">'+count+'</font>';
	}
	else
		counter.innerHTML = '<font color="green">'+count+'</font>';
	
	
}

function shaagi_myalert()
{
	
	var nameReg = /^([a-zA-Z0-9 ]+[a-zA-Z0-9, _]*)$/;
	var nameReg2 = /^(@+.*)$/;
	var btnReg = /^([a-zA-Z]+[a-zA-Z0-9]*)$/;
	var myform = document.getElementById('contact_form');
	var iserror = 0;
	var error_msg = "";
	var formmode = myform.mode.value;
	var id = myform.bid.value;
	var btnname = myform.btn_name.value;
	var fanpageurl = myform.fan_page_url.value;
	var twittername = myform.twittername.value;
	var tweet = myform.promotional_tweet.value;
	
	var upload_path = "";
	var file_location = "";
	//var post_type = "";
	var span1="";
	var blkqut="";
	if(twittername.length > 0)
	{
		
		//upload_path = myform.twittername.value;
		if(nameReg2.test(twittername))
		{
			
		
			iserror =1;
		
			error_msg+="&quot;<?php echo __("Type your Twitter username without the",SHAAGI_TRASNLATE)?> @ &quot;<br>";

		}
		else if(!nameReg.test(twittername))
		{
			
			
			iserror =1;
			
			error_msg+="&quot;<?php echo __("Twitter username can't contain @ # -",SHAAGI_TRASNLATE)?> &quot;<br>";

		}
		
	}
	if((btnname.length <=0))
	{
		iserror =1;
		error_msg+="&quot;<?php echo __("Name of your button shouldn't be empty",SHAAGI_TRASNLATE);?>&quot; <br>";

	}
	/////////////////////////////
	/*if(fanpageurl.length > 0)
	{
		//upload_path = fanpageurl;
		// add check of valid url here
		post_type = "fb";
	}
	
	
	
	if((twittername.length <= 0)&&(fanpageurl.length <= 0))
	{
		iserror =1;
		error_msg+="&quot;<?php echo __("Twitter user to follow or Fan page url",SHAAGI_TRASNLATE)?>&quot; <br>";
	}
	*/
	
	////////////////
	if(myform.urlfile.value.length > 0)
	{
		upload_path = myform.urlfile.value;
		file_location = "url";
	}
	
	if(myform.uploaded.value.length > 0)
	{
		
		upload_path = myform.uploaded.value;
		file_location = "local";
	}
	
	if((myform.urlfile.value.length <= 0)&&(myform.uploaded.value.length <= 0)&&(formmode=="add"))
	{
		iserror =1;
		error_msg+="&quot;<?php echo __("Location of your file",SHAAGI_TRASNLATE)?>&quot; <br>";
	}
	if(tweet.length > 140)
	{
		iserror =1;
		error_msg+="&quot;<?php echo __("Share",SHAAGI_TRASNLATE)?>&quot;<br>";
	}
	
	if(iserror ==1)
	{	
		span1 = document.getElementById('span1');
		span1.style.display = 'block';
		span1.innerHTML="<?php echo __("Following fields are required",SHAAGI_TRASNLATE)?> !<br>"+error_msg;
		//
	}else if(iserror ==0)
	
	{
		span1 = document.getElementById('span1');
		span1.style.display = 'none';
		
		blkqut = document.getElementById('blkqut');
		blkqut.style.display = 'block';
	
jQuery(document).ready(function($) {

	var data = {
		action: 'shaagi_createbutton_action',
		type: "POST",
		bname: btnname, 
		fanpage: fanpageurl, 
		tname: twittername,
		t: tweet,
		f: upload_path,
		l: file_location,
		mode: formmode,
		bid: id,
	};

	jQuery.post(ajaxurl, data, function(response) {
		blkqut.innerHTML=response;
		
	});
});
		
	}
}
</script>
<div id="hld">
		<div id="header_container">
				<div class="hdrl"></div>
				<h1><a href="http://www.shareandgetit.com"><img src="<?echo SHAAGI_URLPATH."/admin/"?>images/logo-shareandgetit.png" width="200" height="172" alt="Share &amp; Get it" /></a></h1>
		  
          </div>
		<!-- end header (940px width) --> 
	
	<!-- end header container (100% width) -->
	
	<div id="body_content">
		<div id="content" class="has_sidebar left">
        <h1><?php echo $b_name ; ?></h1>
		
			<form method="post" id="contact_form" enctype="multipart/form-data" target="upload_target" onload="shaagi_tweet_counter()"  action="<?php echo "http://".$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"]."&path=$destination_path"; ?>"  onsubmit="shaagi_startUpload();" >
			
			<ol>
		  <li>
                    
                    <label for="twittername"><?php echo __("<b>Your Twitter username </b>(Optional)",SHAAGI_TRASNLATE);?></label>
					<input type="text" name="twittername" class="text_field medium " id="twittername" value="<?=$twtname?>"/>
                    		<ul class="unordered-arrow">
                                    <li><?php echo __("Ex: <span class='eximportant'>pointofviuu </span> <br />Enter the twitter account you want the user to follow in exchange of downloading your file. At the completion of the Share&Get it! process your visitor becomes follower of the Twitter account you defined.",SHAAGI_TRASNLATE)?>.</li>
							</ul>
					</li>
                    <li>
                    
                    <label for="fan_page_url"><?php echo __("<b>Your Fan Page</b> (Optional)",SHAAGI_TRASNLATE);?></label>
					<input type="text" name="fan_page_url" class="text_field medium " id="fan_page_url" value="<?=$fan_page_url?>"/>
                    		<ul class="unordered-arrow">
								<li><?php echo __("Ex: <span class='eximportant'>http://facebook.com/pointofviuu </span> <br />
								Enter the Facebook Fan Page URL for user to be fan of in exchange of downloading your file. At the completion of the Share&Get it! process your visitor becomes fan of the Fan Page you defined. ",SHAAGI_TRASNLATE)?>.</li>
							</ul>
					</li>
                    
					<li>
                    <label  class="auto_clear"><?php echo __("<b>Your Share </b> (Required)",SHAAGI_TRASNLATE)?></label>
                    <li>
					<label id="twtlbl"><?$c = 140 - strlen ($TWEET); 
					if ( $c<0 ) 	
						echo '<font color="red">'.$c.'</font>';
					else
						echo '<font color="green">'.$c.'</font>';
						?>
						</label>
                    <textarea cols="30" rows="5" class="large" name="promotional_tweet" id="promotional_tweet" onchange="shaagi_tweet_counter();" onfocus="shaagi_tweet_counter();" onblur="shaagi_tweet_counter();" onmousemove="shaagi_tweet_counter();" onkeyup="shaagi_tweet_counter();" onload="shaagi_tweet_counter();" onkeypress="shaagi_tweet_counter();" onkeydown="shaagi_tweet_counter();"><?=$TWEET?></textarea>
                    </li>
                      	<ul class="unordered-arrow">
							<li><?php echo __("Write the tweet or Facebook Wall you want the user to send in exchange of downloading your file. This Post will be sent automatically each time a visitor completes the Share&Get it! process.",SHAAGI_TRASNLATE)?>.</li>
						</ul>
                    </li>
					<?php if($editmode) echo '<ul class="unordered-arrow"><li><b>'.__("Old file",SHAAGI_TRASNLATE).': <font color="red">'.$urlname.' </font></b></li></ul>';?>
                    <div id="myFile">
                    <li>
                        		
                        <input type="hidden" name="mode" id="mode" value="<?=$editmodestr?>"/>
					 <input type="hidden" name="uploaded" id="uploaded" value="<?=$file?>"/>
					 <input type="hidden" name="bid" id="bid" value="<?=$id?>"/>
						<label for="File_sharing" class="small"><?php echo __("<b>Your file</b>",SHAAGI_TRASNLATE);?></label>
						<input id="File_sharing"  type="file" name="File_sharing" class="text_field medium required" <?if (isset($file)) echo "disabled=\"disabled\"";?>/>
                        <ul class="unordered-arrow">
					<li>.doc .pdf .xls .ppt .jpg .psd .ai .gif .png .tif .exe .dmg  etc.</li>
						</ul>
					</li>
					<li><input type="submit" class="submit" id="submit" value="<?php echo __("Upload your file",SHAAGI_TRASNLATE);?>" 
					<?//if (isset($file)) echo " disabled=\"disabled\" ";?>/>
					<p> <?=$filemsg?> </p>
					 <label id="upload_result" style="display:none" ></label>
                    <iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
					<p id="f1_upload_process"style="display:none" ><?php echo __("Loading",SHAAGI_TRASNLATE);?>...<br/><img src="<?echo SHAAGI_URLPATH."/img/"?>ajax-loader.gif" /><br/></p>
                 
                    <span class='labelWarning'> <?php echo __("OR ...",SHAAGI_TRASNLATE);?></span>
					</li>
                    
					
                    <li>
                    
                    <label for="urlfile"><?php echo __("<b>The URL of your file</b> (Required if you don't want to upload your file)",SHAAGI_TRASNLATE);?> </label>
					<input type="text"  name="url" class="text_field medium" id="urlfile" value="" <?//if (isset($file)) echo "disabled=\"disabled\"";?> />
                    		<ul class="unordered-arrow">
								<li><?php echo __("Enter the path of your file. ",SHAAGI_TRASNLATE)?>.</li>
							</ul>
					</li>
                    <li>
                    </div>
					<label for="btn_name"><?php echo __("<b>Name of your button</b> (Required)",SHAAGI_TRASNLATE);?> </label>
					<input type="text" <?php if($editmode) echo 'disabled="disabled"';?> name="btn_name" id="btn_name" class="text_field medium required" value="<?=$btnname?>" />
                    		<ul class="unordered-arrow">
								<li><!--(a-zA-Z0-9)--></li>
							</ul>
					</li>
					
				
				<li><input type="button" class="submit" id="submit2" value="<?php echo $b_name;?> !" onclick="shaagi_myalert()" /></li>
				
				</ol>
				
				<div id="blkqut" style="display:none">
				
			  </div>
				<p><span id="span1" class="error_notice" style="display: none;">
                </span></p>
            </form>
		</div>
		<!-- end content -->
		
		<div id="sidebar" class="right">
		  <!-- end widget -->
			
		  <div class="tabbed_widget">
				<ul class="widget_tabs">
					<li><a href="#tab1"><span><?php echo __("About",SHAAGI_TRASNLATE);?> Share&amp;Get it!</span></a></li>
					<li><a href="#tab2"><span><?php echo __("Help",SHAAGI_TRASNLATE);?></span></a></li>
				</ul>
				<div class="widget_tabs_content">
					<div class="tab_content"><p><?php echo __("Share&Get it! is an automatic process to get Twitter followers and Facebook Fans in exchange of a downloadable file. Get your shortcodes by setting up your Share&Get it! button.
Copy/paste the shortcode into posts, pages and widgets. 
Your Share&Get it! button will be immediately available to your visitors.",SHAAGI_TRASNLATE);?></p>
<p><?php echo __("Share&Get it! is fully recommended to share content such as: music, ebooks, photos, wallpapers, promotional codes, coupons, typography, CMS themes, videos, software, tutorials, web ressources, icons, PSD brushes...",SHAAGI_TRASNLATE);?>.</p>
<p><?php echo __("Get a new Twitter follower or a Facebook fan with each download !",SHAAGI_TRASNLATE);?>!</p></div>
					<div class="tab_content">
				    <h3><?php echo __("HELP",SHAAGI_TRASNLATE);?></h3>
						<ul>
							<li><a href="http://tweetandgetit.com/contactus" target="_blank" ><?php echo __("Contact us",SHAAGI_TRASNLATE);?></a></li>
							
							<li><a href="http://tweetandgetit.com/faq" target="_blank" ><?php echo __("FAQ",SHAAGI_TRASNLATE);?></a></li>
						</ul>
					</div>
				</div>
			</div>
			<!-- end widget --> 
			
		</div>
		<!-- end sidebar -->
	</div>
	</div>
	
	<!-- end body content -->
	<!-- end footer container -->

<!-- end wrapper -->