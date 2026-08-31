<? $Self = _rt::self(); ?>
<i>{{ routeName }} </i>
<section v-for="item in list">
    <div><a
        <?//@click="item.click"?>
        @click="$router.push(item.route)"
    >{{ item.title }}</a></div>
</section>