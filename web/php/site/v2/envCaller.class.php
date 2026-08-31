<?#0.3.1

class envCaller {
	private $callable;
	private $type;

	// Конструктор принимает либо функцию и 'call', либо объект и 'class'
	public function __construct($callable, $type, $cfg = array()) {
		//is_object($callable)
		//is_callable($callable)
		//is_string($callable) && class_exists($callable)
		$this->type = $type;
		if ($type === 'call') {
			$this->callable = $callable;
		} elseif ($type === 'class') {
			if (!is_object($callable) && !class_exists($callable)) {
				//throw new InvalidArgumentException("$callable должен быть объектом или именем существующего класса.");
			}
			if ($cfg) {
				$reflection = new ReflectionClass($callable);
				$this->callable = $reflection->newInstanceArgs($cfg);
			} else {
				$this->callable = is_string($callable) ? new $callable() : $callable;
			}
		}
	}

	// Магический метод, позволяющий вызывать объект как функцию
	public function __invoke(...$args) {
		if ($this->type === 'call') {
			// Если тип 'call', вызываем функцию с аргументами
			//dx($this->callable, $args);
			return call_user_func_array($this->callable, $args);
		} elseif ($this->type === 'class') {
			if (count($args) < 1) {
				if (is_callable($this->callable)) {
					return call_user_func($this->callable); //ak envoke object
				} else {
					return $this->callable;
				}

			} else {
				$methodName = array_shift($args); // Извлекаем имя метода
				//dx(method_exists($this->callable, $methodName));
				return call_user_func_array([$this->callable, $methodName], $args);
			}
		}
	}
}