<?php
/**
 * @author Lucas Burg
 * @since 18/02/2015
 *
 * @var $title 
 * @var $signin_url
 * @var $signout_url
 */
 

//inicio das variaveis
$title = 'osTicket :: '.__('Support Ticket System');
$lang  = ''; 


//adiciona o titulo e idioma 
if ( $cfg && is_object($cfg) ) {
	if ( $cfg->getTitle() ) {
		$title = $cfg->getTitle();
	}
	if ( $cfg->config['system_language']['value'] ) {
		$lang = strtolower($cfg->config['system_language']['value']);
		$lang = str_replace('_', '-', $lang);
	}
} 
  
//logout e headers extras
if ( $ost && is_object($ost) ) {
	$signout_url = ROOT_PATH . "logout.php?auth=".$ost->getLinkToken();
	$headers     = implode("\n",$ost->getExtraHeaders());
}

//login logout cental do usuario
$signin_url = ROOT_PATH."login.php".($thisclient?"?e=".urlencode($thisclient->getEmail()):"");


//flags de idiomas
$all_langs = Internationalization::getConfiguredSystemLanguages();

//menus, navbar
$nav = $nav->getNavLinks();
$navs = array();
if(!empty($nav)){
	foreach ($nav as $key => $value) {
		$navs[$key]['class'] = trim($key.' '.($value['active']?'active':''));
		$navs[$key]['href']  = ROOT_PATH.$value['href'];
		$navs[$key]['desc']  = $value['desc'];
	}
}

//pages to type other
$otherPages = Page::getActivePages()->filter(array('type'=>'other'));

//header("Content-Type: text/html; charset=UTF-8\r\n");
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="description" content="customer support platform">
    <meta name="keywords" content="osTicket, Customer support system, support ticket system">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<?php echo $headers; ?>
	<title><?php echo Format::htmlchars($title); ?></title>
	
	<!--
	<link type="text/css" href="<?php echo ROOT_PATH; ?>css/osticket.css" rel="stylesheet">
    <link type="text/css" href="<?php echo ASSETS_PATH; ?>css/theme.css" rel="stylesheet">
    <link type="text/css" href="<?php echo ASSETS_PATH; ?>css/print.css" rel="stylesheet" media="print">
    <link type="text/css" href="<?php echo ROOT_PATH; ?>scp/css/typeahead.css" rel="stylesheet">
    <link type="text/css" href="<?php echo ROOT_PATH; ?>css/ui-lightness/jquery-ui-1.10.3.custom.min.css" rel="stylesheet">
    <link type="text/css" href="<?php echo ROOT_PATH; ?>css/thread.css" rel="stylesheet">
    <link type="text/css" href="<?php echo ROOT_PATH; ?>css/redactor.css" rel="stylesheet">
    <link type="text/css" href="<?php echo ROOT_PATH; ?>css/font-awesome.min.css" rel="stylesheet">
    <link type="text/css" href="<?php echo ROOT_PATH; ?>css/flags.css" rel="stylesheet">
    <link type="text/css" href="<?php echo ROOT_PATH; ?>css/rtl.css" rel="stylesheet">
    <link type="text/css" href="<?php echo ROOT_PATH; ?>css/chosen.min.css" rel="stylesheet">
    
    
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/jquery-ui-1.10.3.custom.min.js"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/osticket.js"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/filedrop.field.js"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>scp/js/bootstrap-typeahead.js"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/redactor.min.js"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/redactor-plugins.js"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/redactor-osticket.js"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/redactor-fonts.js"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/chosen.jquery.min.js"></script>
	-->
	
	<link rel="stylesheet" href="<?php echo ASSETS_ROOT.'bootstrap/css/bootstrap.min.css';?>" type="text/css">
	<link rel="stylesheet" href="<?php echo ASSETS_ROOT.'jquery-ui/jquery-ui.min.css';?>" type="text/css">
	<link type="text/css" href="<?php echo ROOT_PATH; ?>css/flags.css" rel="stylesheet">
	
	<script type="text/javascript" src="<?php echo ASSETS_ROOT.'jquery/jquery-1.11.2.min.js'?>"></script>
	<script type="text/javascript" src="<?php echo ASSETS_ROOT.'jquery-ui/jquery-ui.min.js'?>"></script>
	<script type="text/javascript" src="<?php echo ASSETS_ROOT.'bootstrap/js/bootstrap.min.js'?>"></script>
	<script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/redactor.min.js"></script>
	<script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/osticket.js"></script>
	
</head>
<body>
    <div class="container-fluid">
        <div class="row">
        	
        	<div class="col-md-6">
            	
            	<!-- logo -->
            	<a class="" id="logo" href="<?php echo ROOT_PATH; ?>index.php" title="<?php echo __('Support Center'); ?>">
	                <span class="valign-helper"></span>
	                <img class="img-responsive" src="<?php echo ROOT_PATH; ?>logo.php" alt="<?php echo $ost->getConfig()->getTitle(); ?>">
	            </a>	
	            <!-- // -->
	            
            </div>
        	
        	
        	
            <div class="col-md-6">
            
            
	            <!-- flags de idiomas -->
	            <p>
	            	<?php if ($all_langs) : ?> 	
		            	<?php foreach ($all_langs as $code => $info) : ?>
					    	<a class="pull-right" href="?lang=<?php echo $info['code']; ?>" title="<?php echo $info['nativeName']; ?>">
					    		<i class="flag flag-<?php echo $info['flag']; ?>"></i>
					    	</a>
						<?php endforeach; ?>
					<?php endif; ?>
				</p>
                <!-- // -->

            	<br>
            	
            	<!-- dados do usuario logado -->
            	<p class="pull-right">
            		<?php if ($thisclient && is_object($thisclient) && $thisclient->isValid() && !$thisclient->isGuest()) : ?>
             			<?php echo Format::htmlchars($thisclient->getName()).'&nbsp;'; ?> |
             			<a href="<?php echo ROOT_PATH; ?>profile.php"><?php echo __('Profile'); ?></a> |
                		<a href="<?php echo ROOT_PATH; ?>tickets.php"><?php echo sprintf(__('Tickets <b>(%d)</b>'), $thisclient->getNumTickets()); ?></a> |
                		<a href="<?php echo $signout_url; ?>"><?php echo __('Sign Out');?></a>
            		<?php elseif($nav) : ?>
				 		<?php if ($cfg->getClientRegistrationMode() == 'public') : ?>
                    		<?php echo __('Guest User'); ?> |  
                		<?php endif; ?>
                		<?php if ($thisclient && $thisclient->isValid() && $thisclient->isGuest()) : ?>
                			<a href="<?php echo $signout_url; ?>"><?php echo __('Sign Out'); ?></a>
                  		<?php elseif ($cfg->getClientRegistrationMode() != 'disabled') : ?>
                    		<a href="<?php echo $signin_url; ?>"><?php echo __('Sign In'); ?></a>
            			<?php endif; ?>
            		<?php endif; ?>
            	</p>
            	<!-- // -->
            	
                        
            </div>
            
        </div>
        <!-- fim row  -->
        
        <?php if($navs) : ?>
        	<nav class="navbar navbar-default">
			  	<div class="container-fluid">
			    	<!-- modo responsivo -->
			    	<div class="navbar-header">
			    		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#nav-usuario">
					        <span class="sr-only">Toggle navigation</span>
					        <span class="icon-bar"></span>
					        <span class="icon-bar"></span>
					        <span class="icon-bar"></span>
					    </button>
			    	</div>
					<!-- // -->

					<!-- links -->
		        	<div class="collapse navbar-collapse" id="nav-usuario">
  						<ul class="nav navbar-nav">
  							<?php foreach($navs as $name => $nav) : ?>   
			             		<li>
				             		<a class="<?php echo $nav['class']; ?>" href="<?php echo $nav['href']?>">
				             			<?php echo $nav['desc']; ?>
				             		</a>
			             		</li> 
			             	<?php endforeach; ?>
			             	
			             	<!-- btn othes -->
			             	<?php if ($otherPages->all()) : ?>
				             	<li>
					        		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
										<?php echo __('Other'); ?>
									</a>
									  
									<ul class="dropdown-menu" role="menu">
									    <?php foreach ($otherPages as $page) : ?>
											<li>
												<a href="<?php echo ROOT_PATH; ?>pages/<?php echo $page -> getNameAsSlug(); ?>">
													<?php echo $page -> getLocalName(); ?>
												</a>
											</li>
										<?php endforeach; ?> 
									</ul>
						  
						
				             	</li>	
			             	<?php endif; ?>
			             	<!-- // -->
  						</ul>
  						
  						
  						
  						
  						
  						
  					</div>
  					<!-- // -->
  					
  					
  					
  					
		        </div>
			</nav>
		<?php endif; ?>
    
        
        
        <div class="container-fluid">

         <?php if($errors['err']) : ?>
            <div class="alert alert-danger" role="alert">
            	<p>
            		<?php echo $errors['err']; ?>
            	</p>
            </div>
         <?php elseif($msg) : ?>
            <div class="alert alert-info" role="alert">
            	<p>
            		<?php echo $msg; ?>
            	</p>
            </div>
         <?php elseif($warn) : ?>
            <div class="alert alert-warning" role="alert">
            	<p>
            		<?php echo $warn; ?>
            	</p>	
            </div>
         <?php endif; ?>
