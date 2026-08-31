<div>
    v-menu
    <div v-for="item in list">
        <a @click="item.click">{{ item.text }}</a>
    </div>
</div>