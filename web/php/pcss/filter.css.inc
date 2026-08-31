<? $arg;
    $val = isset($arg[1]) ? $arg[1] : '%s';
    switch ($val){};
?>
-webkit-filter: <?=$val?>;
-moz-filter: <?=$val?>;
-o-filter: <?=$val?>;
-ms-filter: <?=$val?>;
filter: <?=$val?>;

<?//=pcss('filter', 'blur(5px)')?>
<?//=pcss('filter', 'brightness(0.4)')?>
<?//=pcss('filter', 'contrast(200%)')?>
<?//=pcss('filter', 'rop-shadow(16px 16px 20px blue)')?>
<?//=pcss('filter', 'grayscale(50%)')?>
<?//=pcss('filter', 'hue-rotate(90deg)')?>
<?//=pcss('filter', 'invert(75%)')?>
<?//=pcss('filter', 'opacity(25%)')?>
<?//=pcss('filter', 'saturate(30%)')?>