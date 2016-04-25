<?php
	defined( '_JEXEC' ) or die;
	$app = JFactory::getApplication();
	$doc = JFactory::getDocument();
	$menu = $app->getMenu();
	$active = $app->getMenu()->getActive();
	$params = $app->getParams();
	$pageclass = $params->get('pageclass_sfx');
	$tpath = $this->baseurl.'/templates/'.$this->template;
	$sitename = $app->getCfg('sitename');

	// Add JavaScript Frameworks
	JHtml::_('bootstrap.framework');
	JHtml::_('bootstrap.loadCss');

	$doc->addStyleSheet($tpath.'/css/template.css');
	$doc->addStyleSheet($tpath.'/css/error.css');
	$doc->addStyleSheet($tpath.'/css/editor.css');
	$doc->addStyleSheet($tpath.'/css/print.css');

	// Adjusting content width
	if ($this->countModules('left') && $this->countModules('right'))
	{
		$span = "span6";
	}
	elseif ($this->countModules('left') && !$this->countModules('right'))
	{
		$span = "span9";
	}
	elseif (!$this->countModules('left') && $this->countModules('right'))
	{
		$span = "span9";
	}
	else
	{
		$span = "span12";
	}

	// Logo file or site title param
	if ($this->params->get('logoFile'))
	{
		$logo = '<img src="' . JUri::root() . $this->params->get('logoFile') . '" alt="' . $sitename . '" />';
	}
	elseif ($this->params->get('sitetitle'))
	{
		$logo = '<span class="site-title" title="' . $sitename . '">' . htmlspecialchars($this->params->get('sitetitle')) . '</span>';
	}
	else
	{
		$logo = '<span class="site-title" title="' . $sitename . '">' . $sitename . '</span>';
	}
?>

<!doctype html>

<html lang="<?php echo $this->language; ?>">

<head>
	<jdoc:include type="head" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
	<?php // Use of Google Font ?>
	<?php if ($this->params->get('googleFont')) : ?>
		<link href='//fonts.googleapis.com/css?family=<?php echo $this->params->get('googleFontName'); ?>' rel='stylesheet' type='text/css' />
		<style type="text/css">
			h1,h2,h3,h4,h5,h6,.site-title{
				font-family: '<?php echo str_replace('+', ' ', $this->params->get('googleFontName')); ?>', sans-serif;
			}
		</style>
	<?php endif; ?>
	<?php // Template color ?>
	<?php if ($this->params->get('templateColor')) : ?>
	<style type="text/css">
		body.site
		{
			border-top: 3px solid <?php echo $this->params->get('templateColor'); ?>;
			background-color: <?php echo $this->params->get('templateBackgroundColor'); ?>
		}
		a
		{
			color: <?php echo $this->params->get('templateColor'); ?>;
		}
		.nav-list > .active > a, .nav-list > .active > a:hover, .dropdown-menu li > a:hover, .dropdown-menu .active > a, .dropdown-menu .active > a:hover, .nav-pills > .active > a, .nav-pills > .active > a:hover,
		.btn-primary
		{
			background: <?php echo $this->params->get('templateColor'); ?>;
		}
	</style>
	<?php endif; ?>
	<!--[if lt IE 9]>
		<script src="<?php echo JUri::root(true); ?>/media/jui/js/html5.js"></script>
	<![endif]-->
	<link rel="apple-touch-icon-precomposed" href="<?php echo $tpath; ?>/images/apple-touch-icon-57x57-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $tpath; ?>/images/apple-touch-icon-72x72-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $tpath; ?>/images/apple-touch-icon-114x114-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $tpath; ?>/images/apple-touch-icon-144x144-precomposed.png">
</head>
  
<body class="<?php echo (($menu->getActive() == $menu->getDefault()) ? ('front') : ('site')).' '.$active->alias.' '.$pageclass; ?>">
  
<div class="body">
	<div class="container<?php echo ($params->get('fluidContainer') ? '-fluid' : ''); ?>">
		<!-- Header -->
		<header class="header" role="banner">
			<div class="row-fluid clearfix">
				<a class="brand span6" href="<?php echo $this->baseurl; ?>/">
					<?php echo $logo; ?>
					<?php if ($this->params->get('sitedescription')) : ?>
						<?php echo '<div class="site-description">' . htmlspecialchars($this->params->get('sitedescription')) . '</div>'; ?>
					<?php endif; ?>
				</a>
				<?php if ($this->countModules('header')) : ?>
					<div class="header-search span6">
						<jdoc:include type="modules" name="header" style="xhtml" />
					</div>
				<?php endif; ?>
			</div>
		</header>
		<?php if ($this->countModules('navigation')) : ?>
			<nav class="navigation" role="navigation">
				<div class="navbar pull-left">
					<a class="btn btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</a>
				</div>
				<div class="nav-collapse">
					<jdoc:include type="modules" name="navigation" style="xhtml" />
				</div>
			</nav>
		<?php endif; ?>
		<?php if ($this->countModules('showcase')) : ?>
			<jdoc:include type="modules" name="showcase" style="none" />
		<?php endif; ?>
		<div class="row-fluid">
			<?php if ($this->countModules('left')) : ?>
				<aside id="left" class="span3">
					<jdoc:include type="modules" name="left" style="xhtml" />
				</aside>
			<?php endif; ?>
			<main id="content" role="main" class="<?php echo $span; ?>">
				<!-- Begin Content -->
				<jdoc:include type="modules" name="above_content" style="xhtml" />
				<jdoc:include type="message" />
				<jdoc:include type="component" />
				<jdoc:include type="modules" name="below_content" style="xhtml" />
				<!-- End Content -->
			</main>
			<?php if ($this->countModules('right')) : ?>
				<aside id="right" class="span3">
					<jdoc:include type="modules" name="right" style="xhtml" />
				</aside>
			<?php endif; ?>
		</div>
	</div>
</div>
<!-- Footer -->
<footer class="footer" role="contentinfo">
	<div class="container">
		<jdoc:include type="modules" name="footer" style="xhtml" />
		<p class="pull-right">
			<a href="#top" id="back-top">Back to top</a>
		</p>
		<p>
			&copy; <?php echo date('Y'); ?> <?php echo $sitename; ?>
		</p>
	</div>
</footer>

<jdoc:include type="modules" name="debug" style="none" />

</body>

</html>
