<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">

        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
                <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <?=\app\widgets\LeftsideMenu::create()?>
        <?php /*dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget' => 'tree'],
                'items' => [
                    ['label' => 'Menu', 'options' => ['class' => 'header']],
                    [
                        'label' => 'Contacts', 
                        'icon' => 'table', 
                        'options' => ['class' => 'treeview'],
                        'items' => [
                            ['label' => 'New Contact', 'url' => ['/contacts/create']],
                            ['label' => 'List of Contacts', 'url' => ['/contacts/index']],
                        ]
                    ],
                    [
                        'label' => 'Leads', 
                        'icon' => 'table', 
                        'options' => ['class' => 'treeview'],
                        'items' => [
                            ['label' => 'New Lead', 'url' => ['/leads/create']],
                            ['label' => 'List of Leads', 'url' => ['/leads/index']],
                        ]
                    ],
                    [
                        'label' => 'Sale',
                        'icon' => 'table', 
                        'options' => ['class' => 'treeview'],
                        'items' => [
                            ['label' => 'New Sale', 'url' => ['/sale/create']],
                            ['label' => 'List of Sales', 'url' => ['/sale/index']],
                        ]
                    ],
                    ['label' => 'Import', 'icon' => 'cloud-upload', 'url' => ['/import_export/import/index']],
                    ['label' => 'Calendar', 'icon' => 'calendar', 'url' => ['/calendar/index']],
                ],
            ]
        ) */ ?>

    </section>

</aside>
