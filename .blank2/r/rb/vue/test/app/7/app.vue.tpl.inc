


    <div f class="panel-w">
        <panel></panel>
    </div>

    <div fxc class="body-w">


        <div class="head-w">
            A p p
            <div class="section-w">
                <login></login>
            </div>
            <div class="section-w">
                <dashboard></dashboard>
            </div>
        </div>

        <div fg1 class="main-w">
            <div class="section-w">
                <router-view v-slot="{ Component }">
                    <keep-alive>
                        <component :is="Component" />
                    </keep-alive>
                </router-view>
            </div>
        </div>

    </div>

