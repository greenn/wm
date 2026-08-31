<? include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';


class A1 {
	const A = 1;
}

class A2 extends A1 {
	const A = 11;
}

//A1::A = 12;

dx(A1::A, A2::A);