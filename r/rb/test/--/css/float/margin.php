<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

?>
<link type="text/css" rel="stylesheet" href="/r/rb/css/aq.css.php" />

<style>
	[ghost] {

	}

	SECTION {
		width: 220px;
		height: 100px;

	}
	[half] {
		width: 100px;
		float: left;
		height: 100px;
	}
	[half="od"] {
		margin-right: 10px;
	}
	[half="o2"] {
		margin-left: 10px;
	}

</style>

<section wrapper r o1>
	<div ghost a="lb" o2>ghost</div>
	<div half="od" o3>half od</div>
	<div half="o2" o3>half o2</div>
</section>
<?// pre tt code kbd?>
<tt>== margin'ы не стакуются</tt>

