<?

 function add_my_stylesheet2() {
        $myStyleUrl = WP_PLUGIN_URL . '/share-and-get-it/admin/css/style.css';
        $myStyleFile = WP_PLUGIN_DIR . '/share-and-get-it/admin/css/style.css';
        if ( file_exists($myStyleFile) ) {
		
            wp_register_style('myStyleSheets', $myStyleUrl);
            wp_enqueue_style( 'myStyleSheets');
        }
		
    }

$myurl = "http://".$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];

?>

	<!--[if lt IE 8]><style type="text/css" media="all">@import url("<?echo SHAAGI_URLPATH."/admin/"?>css/ie.css");</style><![endif]-->
	<!--[if IE]><script type="text/javascript" src="<?echo SHAAGI_URLPATH."/admin/"?>js/excanvas.js"></script><![endif]-->
		
	<script type="text/javascript" src="<?echo SHAAGI_URLPATH."/admin/"?>js/jquery.js"></script>
	<script type="text/javascript" src="<?echo SHAAGI_URLPATH."/admin/"?>js/jquery.img.preload.js"></script>
	<script type="text/javascript" src="<?echo SHAAGI_URLPATH."/admin/"?>js/jquery.tablesorter.min.js"></script>
	<script type="text/javascript" src="<?echo SHAAGI_URLPATH."/admin/"?>js/ajaxupload.js"></script>
	<script type="text/javascript" src="<?echo SHAAGI_URLPATH."/admin/"?>js/jquery.pngfix.js"></script>
	<script type="text/javascript" src="<?echo SHAAGI_URLPATH."/admin/"?>js/custom.js"></script>
<script type="text/javascript">
function shaagi_buttons_list(page,url)
{
	
	var block_content ="";
	block_content = document.getElementById('btns_lst');
	jQuery.post(
   ajaxurl, 
   {
      'action':'shaagi_buttonlist',
      'page': page,
      'link': url
   }, 
   function(response){
    
	  block_content.innerHTML=response;
	  
   }
);

}

function shaagi_delete_button(bid,page,url)
{
	
	var delete_div ="";
	delete_div = document.getElementById('btns_lst');
	jQuery.post(
   ajaxurl, 
   {
      'action':'shaagi_delete_buttons',
      'bids': bid,
	  'page': page,
	  'onlyone': 1,
	  'url' : url
   }, 
   function(response){
    
	  delete_div.innerHTML=response;
	  
   }
);

}
function shaagi_delete_buttons(chk,page,url)
{
	
	var select ="";
	var delete_div ="";
	select = document.getElementById('selectactions');
	//alert(select.value);
	if(select.value == "Delete")
	{
	delete_div = document.getElementById('btns_lst');
	var len = chk.length;
	var bids="";
	for (i = 0; i < len ; i++)
{
if(chk[i].checked == true)
{

bids+=chk[i].value + ",";

}
}
shaagi_delete_button(bids,page,url);
}
}

function shaagi_CheckAll(chk,chkall)
{
if(chkall.checked == true)

{

for (i = 0; i < chk.length; i++)
chk[i].checked = true ;
chkall.checked=true;

}
else
{
for (i = 0; i < chk.length; i++)
chk[i].checked = false ;
chkall.checked=false;
}

}
</script>

<div id="hld">
    <div id="header_container">
				<div class="hdrl"></div>
				<h1><a href="http://www.shareandgetit.com"><img src="<?echo SHAAGI_URLPATH."/admin/"?>images/logo-shareandgetit.png" width="200" height="172" alt="Tweet &amp; Get it" /></a></h1>
		  
          </div>
	  <div class="wrapper">		<!-- wrapper begins -->
	
			<div class="block">
			
				<div class="block_head">
					
					<div class="bheadr"></div>
					
					<h2><?php echo __("Manage your buttons",SHAAGI_TRASNLATE);?></h2>
					<div id="delete_div" class="bheadl"></div>
					<ul>
						<li class="block_head"><a href="<?echo $_SERVER['PHP_SELF']."?page=share-and-get-it/shareandgetit_admin.php"?>"><?php echo __("Create a new button",SHAAGI_TRASNLATE);?></a></li>
						<li></li>
					</ul>
				</div>		<!-- .block_head ends -->
				
				
				
				<div class="block_content" id='btns_lst'>
				<script>
				javascript:shaagi_buttons_list(1,'<?echo $myurl?>');
				</script>
				</div>		<!-- .block_content ends -->
				
				
		  </div>
				
				
						<!-- .block_content ends -->
				
			 
	  </div>		<!-- .block ends --><!-- .block.small.left ends --><!-- .block.small.right ends -->

		<div>
			
		
			  <p class="right"><?php echo __("powered by",SHAAGI_TRASNLATE);?> <a href="http://viuu.co.uk" target="_blank"><img src="<?echo SHAAGI_URLPATH."/admin/"?>images/logo-viuu.png" alt="Logo Viuu" width="103" height="36" border="0" /></a></p>
				
			</div>	
		  
		
		
		</div>						<!-- wrapper ends -->
		
	
<!-- end wrapper -->