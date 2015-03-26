<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='utf-8'>
    <title><?php echo dv3_title(); ?></title>
    <meta name="viewport" content="initial-scale=1">
    <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Dancing+Script' type='text/css' media='screen' />
    <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Open+Sans' type='text/css' media='screen' />
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <link rel='stylesheet' href='<?php echo get_stylesheet_uri(); ?>' type='text/css' media='screen' />
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
</head>

<body>

<div id='wrapper'>

<header class='header'>

    <section class='header__logo'>
        <a href='<?php echo site_url(); ?>' title='<?php echo get_bloginfo('name'); ?>'>
            <img class='header__logo__img' src='<?php echo get_stylesheet_directory_uri(); ?>/logo.png' alt='<?php echo get_bloginfo('name'); ?>' title='<?php echo get_bloginfo('name'); ?>'>
            <span class='header__logo__title'><?php echo get_bloginfo('name'); ?></span>
        </a>
    </section>

</header>

<section class='teaser'>
    <div class='teaser__page'>
        <header class='teaser__page__header'>
            <h1>Lorem ipsum</h1>
        </header>
        <section class='teaser__page__message'>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum sed sodales ex. Donec luctus, nisi semper suscipit faucibus, metus lorem efficitur mi, quis pellentesque risus metus et urna. Interdum et malesuada fames ac ante ipsum primis in faucibus. In nec congue libero. Sed facilisis tortor et ipsum aliquam ornare. Aenean nec lectus id ipsum accumsan commodo ac eget nisl.</p>
        </section>
    </div>
    <section class='teaser__page__icon'>
        <i class='fa fa-comments fa-5x page-image'></i>
    </section>
</section>

<section class="breadcrumbs">
    <nav>
        <ul><?php dv3_breadcrumbs(); ?></ul>
    </nav>
</section>

<main class='content'>
