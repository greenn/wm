<?#5-2/3.3.116
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp(
    'strLess'
);

$Self = _rb::self();
$relDir = pathLess(dirname(__FILE__), $Self->path('/'));
//dx($relDir);
$selfName = $Self::cfg('rName');



ob_start();
####################################################
//vue::req('login-form', $selfName, "$relDir/login-form/cmpt");
?>
    <section class="todoapp">
        <header class="header">
            <h1>todos</h1>
            <input
                    class="new-todo"
                    autofocus
                    autocomplete="off"
                    placeholder="What needs to be done?"
                    v-model="newTodo"
                    @keyup.enter="addTodo"
            />
        </header>
        <section class="main" v-show="todos.length" v-cloak>
            <input
                    id="toggle-all"
                    class="toggle-all"
                    type="checkbox"
                    v-model="allDone"
            />
            <label for="toggle-all"></label>
            <ul class="todo-list">
                <li
                        v-for="todo in filteredTodos"
                        class="todo"
                        :key="todo.id"
                        :class="{ completed: todo.completed, editing: todo == editedTodo }"
                >
                    <div class="view">
                        <input class="toggle" type="checkbox" v-model="todo.completed" />
                        <label @dblclick="editTodo(todo)">{{ todo.title }}</label>
                        <button class="destroy" @click="removeTodo(todo)"></button>
                    </div>
                    <input
                            class="edit"
                            type="text"
                            v-model="todo.title"
                            v-todo-focus="todo == editedTodo"
                            @blur="doneEdit(todo)"
                            @keyup.enter="doneEdit(todo)"
                            @keyup.esc="cancelEdit(todo)"
                    />
                </li>
            </ul>
        </section>
        <footer class="footer" v-show="todos.length" v-cloak>
    <span class="todo-count">
      <strong>{{ remaining }}</strong> {{ remaining | pluralize }} left
    </span>
            <ul class="filters">
                <li>
                    <a href="#/all" :class="{ selected: visibility == 'all' }">All</a>
                </li>
                <li>
                    <a href="#/active" :class="{ selected: visibility == 'active' }">Active</a>
                </li>
                <li>
                    <a
                            href="#/completed"
                            :class="{ selected: visibility == 'completed' }">Completed</a>
                </li>
            </ul>
            <button
                    class="clear-completed"
                    @click="removeCompleted"
                    v-show="todos.length > remaining"
            >
                Clear completed
            </button>
        </footer>
    </section>
    <footer class="info">
        <p>Double-click to edit a todo</p>
        <p>Written by <a href="http://evanyou.me">Evan You</a></p>
        <p>Part of <a href="http://todomvc.com">TodoMVC</a></p>
    </footer>

<?//=js::html_link($Self::uri("$relDir/app.js.php"))?>
<script><?=$Self::tpl("$relDir/app", false, 'js.inc')?></script>

<?###################################################
$body = ob_get_clean();

$Self::req_css("$relDir/styles");
$Self::req_css("$relDir/app");

print rb_tpl('page', 'page', array(
	'body' => $body,
	'webkit' => array(
        'jquery', 'lodash',
        //'llog',
        'vue', array('vue-init', 'Editor')
    ),
));
