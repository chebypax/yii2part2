<aside class="main-sidebar">

    <section class="sidebar">





        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Menu Yii2', 'options' => ['class' => 'header']],
                    ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
                    ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug']],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    ['label' => 'Projects', 'icon' => 'list', 'url' => ['/projects']],
                    ['label' => 'Tasks', 'icon' => 'file', 'url' => ['/tasks']],
                    ['label' => 'Users', 'icon' => 'user', 'url' => ['/users']],

                ],
            ]
        ) ?>

    </section>

</aside>
