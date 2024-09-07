<?php
header("Content-Type:text/css");
$color = "#f0f"; // Change your Color Here
$secondColor = "#ff8"; // Change your Color Here

function checkhexcolor($color){
    return preg_match('/^#[a-f0-9]{6}$/i', $color);
}

function hex2rgba($color, $opacity = false) {
 
	$default = 'rgb(0,0,0)';
 
	//Return default if no color provided
	if(empty($color))
          return $default; 
 
	//Sanitize $color if "#" is provided 
        if ($color[0] == '#' ) {
        	$color = substr( $color, 1 );
        }
 
        //Check if color has 6 or 3 characters and get values
        if (strlen($color) == 6) {
                $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        } elseif ( strlen( $color ) == 3 ) {
                $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
        } else {
                return $default;
        }
 
        //Convert hexadec to rgb
        $rgb =  array_map('hexdec', $hex);
 
        //Check if opacity is set(rgba or rgb)
        if($opacity){
        	if(abs($opacity) > 1)
        		$opacity = 1.0;
        	$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
        } else {
        	$output = 'rgb('.implode(",",$rgb).')';
        }
 
        //Return rgb(a) color string
        return $output;
}

if (isset($_GET['color']) AND $_GET['color'] != '') {
    $color = "#" . $_GET['color'];
}

if (!$color OR !checkhexcolor($color)) {
    $color = "#336699";
}
?>

.text-theme{
    color: <?php echo $color ?> !important;
}
.custom-button.theme, .theme-button, .video-button::before, .video-button::after, .video-button, .how-item .how-thumb, .faq-item.open .faq-title, .scrollToTop, .pagination .page-item a, .pagination .page-item span, .contact-form-group button, .support-search button, .btn--info{
    background: <?php echo $color ?>;
}

.menu li .submenu li:hover > a, .contact__item:hover .contact__icon, .header-wrapper .list li.selected.focus{
	background: <?php echo $color ?>;
}

.header-wrapper .list li:hover {
    background: <?php echo $color ?> !important;
}

.contact-form-group .select-item .list li.selected.focus, .contact-form-group .select-bar .list li.selected.focus {
    background: <?php echo $color ?>;
}

.contact-form-group .select-item .list li:hover,.contact-form-group .select-bar .list li:hover {
    background: <?php echo $color ?> !important;
}


.custom-button.theme,.verification-code span {
    border-color: <?php echo $color ?>;
}

.counter-item .counter-thumb i, .plan-item .plan-header .icon, .footer-bottom p a, .dashboard-item .dashboard-content .amount, .pagination .page-item.active span, .pagination .page-item.active a, .pagination .page-item:hover span, .pagination .page-item:hover a, .post-item:hover .post-content .blog-header .title a, .widget.widget-post ul li .content .sub-title a:hover, .contact__item .contact__icon, .contact__item .contact__body a, .breadcrumb li a:hover{
    color: <?php echo $color ?>;
}
.counter-item .counter-thumb i {
    border-bottom: 1px solid <?php echo $color ?>;
}
.custom--btn, .custom--badge, .custom--table {
    background-color: <?php echo $color ?> !important;
}

.btn--base{
    background: <?php echo $color ?>!important;
    border: <?php echo $color ?>!important;
    height: 50px
}

.border--base{
    border: <?php echo $color ?>!important;
}

.btn--base:hover{
    background: <?php echo hex2rgba($color, 0.9); ?>!important
}

.base--color, .base-color, .color--base{
    color: <?php echo $color ?>!important
}

.badge--base, .bg--base, .deposit-table thead tr {
    background-color: <?php echo $color ?> !important;
}

.form-control.referral-input[readonly]{
    background: -webkit-linear-gradient(-90deg, #124656 0%, #063a4a 45%, #063b46 100%)!important;
}