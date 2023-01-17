<nav id="sidebar">
            <div class="sidebar-header text-center">
                <h4><?php echo Config::getConfig('app.name'); ?></h4>
                <strong><?php echo Config::getConfig('app.short_code'); ?></strong>
            </div>

            <ul class="list-unstyled components">
                <li class="<?php echo Helper::setMenuActive('dashboard') ?>">
                    <a href="<?php echo BASE_URL;?>">
                        <i class="fas fa-home"></i>
                        Home
                    </a>
                </li>
                <li class="<?php echo Helper::setMenuActive('product') ?>">
                    <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="fas fa-product"></i>
                        Product
                    </a>
                    <ul class="collapse list-unstyled" id="homeSubmenu">
                        <li>
                            <a href="<?php echo BASE_URL.'?q=product/list';?>">Product list</a>
                        </li>
                        <li>
                            <a href="<?php echo BASE_URL.'?q=product/create';?>">Add new</a>
                        </li>
                    </ul>
                </li>
                <li class="<?php echo Helper::setMenuActive('supplier') ?>">
                    <a href="<?php echo BASE_URL.'?q=supplier/list';?>">
                        <i class="fas fa-user"></i>
                        Supplier
                    </a>
                </li>
                <li class="<?php echo Helper::setMenuActive('customer') ?>">
                    <a href="<?php echo BASE_URL.'?q=customer/list';?>">
                        <i class="fas fa-user"></i>
                        Customer
                    </a>
                </li>
                <li class="<?php echo Helper::setMenuActive('purchase') ?>">
                    <a href="#purchaseSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="fas fa-product"></i>
                        Purchase
                    </a>
                    <ul class="collapse list-unstyled" id="purchaseSubmenu">
                        <li>
                            <a href="<?php echo BASE_URL.'?q=purchase/list';?>">Purchase list</a>
                        </li>
                        <li>
                            <a href="<?php echo BASE_URL.'?q=purchase/create';?>">New Purchase</a>
                        </li>
                    </ul>
                </li>
                <li class="<?php echo Helper::setMenuActive('purchase') ?>">
                    <a href="#salesSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="fa fa-dollar-sign"></i>
                        Sales
                    </a>
                    <ul class="collapse list-unstyled" id="salesSubmenu">
                        <li>
                            <a href="<?php echo BASE_URL.'?q=sales/list';?>">Sales list</a>
                        </li>
                        <li>
                            <a href="<?php echo BASE_URL.'?q=sales/create';?>">New Sales</a>
                        </li>
                    </ul>
                </li>
                <li class="<?php echo Helper::setMenuActive('user') ?>">
                    <a href="<?php echo BASE_URL.'?q=user/list';?>">
                        <i class="fas fa-user"></i>
                        Users
                    </a>
                </li>
            </ul>
        </nav>