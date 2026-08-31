<?#0.1

_needphp('dataPath');
function x_slice($name, $slice1/*, $sliceN*/){
	$args = func_get_args();
	$slices = array_slice($args, 1);
	return x_slice_path($name, $slices);
}

function x_slice_path($name, $path, $otherwise = null){
	$data = x($name);
	return dataPath($path, $data, $otherwise);
}