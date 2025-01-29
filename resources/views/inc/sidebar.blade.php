<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Main</h6>
                    <ul>
                        <li class="active">
                            <a href="/dashboard" wire:navigate>
                                <i data-feather="grid"></i><span>Dashboard</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Product Management</h6>
                    <ul>
                        <li>
                            <a href="/products"  accesskey="p">
                                <i data-feather="box"></i><span>Products (p)</span>
                            </a>
                        </li>
                       
                        <li>
                            <a href="/categories" href="/categories" accesskey="t">
                                <i data-feather="codepen"></i><span>Categories (t)</span>
                            </a>
                        </li>
                        <li>
                            <a href="/barcodes" >
                                <i data-feather="align-justify"></i><span>Print Barcode</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Billing</h6>
                    <ul>
                        <li>
                            <a href="/billing" accesskey="b" >
                                <i data-feather="shopping-cart"></i><span>New Bill (b)</span>
                            </a>
                        </li>
                        <li>
                            <a href="/saleslist" wire:navigate>
                                <i data-feather="file-text"></i><span>Bill History</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Customer Management</h6>
                    <ul>
                        <li>
                            <a href="/customers" accesskey="c">
                                <i data-feather="user"></i><span>Customers</span>
                            </a>
                        </li>
                       
                    </ul>
                </li>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">User Management</h6>
                    <ul>
                        <li>
                            <a href="/users" accesskey="u">
                                <i data-feather="users"></i><span>Users (u)</span>
                            </a>
                        </li>
                        <li>
                            <a href="/users/create" wire:navigate>
                                <i data-feather="user-plus"></i><span>Add User</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Settings</h6>
                    <ul>
                        <li>
                            <a href="/settings/business" wire:navigate>
                                <i data-feather="settings"></i><span>Business Settings</span>
                            </a>
                        </li>
                        <li>
                            <a href="/settings/tax" wire:navigate>
                                <i data-feather="percent"></i><span>Tax Settings</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="/logout" wire:navigate>
                        <i data-feather="log-out"></i><span>Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
