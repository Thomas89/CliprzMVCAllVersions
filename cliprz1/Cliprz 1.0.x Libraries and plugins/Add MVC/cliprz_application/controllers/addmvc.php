<?php

class addmvc
{

    public function insert ()
    {
    	if(isset($_POST['add_mvc'])) {
    		if($_POST['page_name'] !='' & $_POST['controllers_class'] !='') {
    			$page_name 			= $_POST['page_name'];
    			$controllers_class 	= $_POST['controllers_class'];
    			$router_method		= $_POST['router_method'];
    		echo '<div style="text-align:right"> <font style="color:red">views inne i mappen</font> '.$page_name.'.page.php varit etablerad<br />
			 <font style="color:red">controllers بداخل المجلد</font> '.$_POST['controllers_class'].'.php filen skapades
    				</div>';
## Add router
    		$router = 'cliprz_application/config/router.php';
    		$router_handle = fopen($router, 'r');
    		$router_data = fread($router_handle,filesize($router));
    		
    		

    		$router_data = str_replace('?>', '', $router_data);
    		$router_handle_w = fopen($router, 'w') or die('Cannot open file:  '.$router);
    		
    		fwrite($router_handle_w, $router_data);
    		$router_new_data = "\n".'cliprz::system(router)->rule(array(
"regex"    => "'.$page_name.'",
"class"    => "'.$page_name.'",
"function" => "'.$controllers_class.'",
"method"   => "'.$router_method.'"
));

?>';
    		
    		fwrite($router_handle_w, $router_new_data);
## End Add router    		

    		
## Create a File.page.php in views 		
    		$my_file = 'cliprz_application/views/'.$page_name.'.page.php';
    		$handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
    		$new_data = '<!DOCTYPE HTML>
<html>
<head>
<meta charset="<?php echo C_CHARSET; ?>" />
<title>Cliprz | '.$page_name.'</title>
<link rel="icon" type="image/png" href="<?php echo c_image(\'favicon.png\') ;?>" />
<link rel="stylesheet" href="<?php echo c_style("styles.css",false); ?>" type="text/css" />
<script type="text/javascript" src="<?php echo c_javascript("jquery.js"); ?>"></script>
</head>
<body>

<div class="logo">
    <img src="<?php echo c_image("logo.png"); ?>" alt="Cliprz" />
</div>

<div class="content">
<h1>Create Page '.$page_name.' Automatic</h1>
<br />
<h2>Information</h2>
<pre>
Version : <?=cliprz::get_framework("version"); ?> <?=cliprz::get_framework("stability"); ?>
</pre>
</div>

<div class="under">
<?php echo cliprz::get_framework("under"); ?>
</div>

</body>
</html>';
fwrite($handle, $new_data);


## End Create a File.page.php in views


## End Create a File.php in controllers
$controllers_file = 'cliprz_application/controllers/'.$page_name.'.php';
$controllers_handle = fopen($controllers_file, 'w') or die('Cannot open file:  '.$controllers_file);
$controllers_new_data = '<?php

class '.$page_name.'
{

    public function '.$controllers_class.' ()
    {
        cliprz::system(view)->display("'.$page_name.'");
    }

	public function info ()
	{
		cliprzinfo();
	}
	
}

?>';
fwrite($controllers_handle, $controllers_new_data);

## End Create a File.page.php in controllers
    		exit();
    		} else {
    		echo 'Alla fält är obligatoriska.<br /> <a href="'.c_url('addmvc').'">tillbaka</a>';
    		exit();
    		
    	}
    	} 
        cliprz::system(view)->display("addmvc");

    }

}


?>
