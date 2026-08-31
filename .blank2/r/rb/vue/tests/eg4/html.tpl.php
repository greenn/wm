<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

?>

<div id="app" class="demo">
    <div>
        {{message}}
    </div>

    <div>
        <i v-bind:title="title">AttributeBinding</i>
    </div>

    <div>Счётчик: {{ counter }}</div>

    <div id="event-handling">
        <p>{{ message }}</p>
        <button v-on:click="reverseMessage">Перевернуть сообщение</button>
    </div>



    <form>
        <p>{{ input }}</p>
        <input v-model="input" />
    </form>

    <div v-if="visible">
        <span>Сейчас меня видно</span>
    </div>


    <button @click="visible = !visible; toggleVisible()">
        Переключить
    </button>



    <p v-if="visible === false">!isVisible2</p>
    <p v-if="visible === true">isVisible2</p>

    <p v-if="isVisible()">isVisible3</p>
    <p v-else>!isVisible3</p>

    <transition name="fade">
        <p v-if="visible">isVisible</p>
        <p v-else>!isVisible</p>
    </transition>

    <ol>
        <li v-for="todo in todos">
            {{ todo.text }}
        </li>
    </ol>


    <div>
        <blog-post title="My journey with Vue"></blog-post>
        <blog-post title="Blogging with Vue"></blog-post>
        <blog-post title="Why Vue is so fun"></blog-post>
    </div>

    <ol>
        <!-- Создание экземпляра компонента todo-item -->
        <todo-item1></todo-item1>

        <!--
          Теперь можно передавать каждому компоненту todo-item объект с информацией
          о задаче, который может динамически изменяться. Также каждому компоненту
          определяем "key", назначение которого разберём далее в руководстве.
        -->

        <todo-item2
            v-for="item in groceryList"
            v-bind:todo="item"
            v-bind:key="item.id"
        ></todo-item2>

    </ol>

</div>