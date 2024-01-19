<div class="topnav">
    <div class="container-fluid">
        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link arrow-none" href="{{ route('dashboard') }}" id="topnav-dashboard" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-view-dashboard me-1"></i> Dashboard
                        </a>
                    </li>

                    @canany(['view_users', 'view_roles', 'view_category'])
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-components" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="mdi mdi-lifebuoy me-1"></i> Master <div class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="topnav-components">
                                @can('view_users')
                                    <a href="{{ route('users.index') }}" class="dropdown-item">User</a>
                                @endcan
                                @can('view_roles')
                                    <a href="{{ route('roles.index') }}" class="dropdown-item">Hak Akses</a>
                                @endcan
                                @can('view_jenis-armada')
                                    <a href="{{ route('jenis-armada.index') }}" class="dropdown-item">Jenis Armada</a>
                                @endcan
                                @can('view_customer')
                                    <a href="{{ route('customer.index') }}" class="dropdown-item">Customer</a>
                                @endcan
                                @can('view_armada')
                                    <a href="{{ route('armada.index') }}" class="dropdown-item">Armada</a>
                                @endcan
                            </div>
                        </li>
                    @endcanany

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-components" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-lifebuoy me-1"></i> Manage <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-components">
                            <a href="#" class="dropdown-item">Transaksi</a>
                        </div>
                    </li>
                </ul> <!-- end navbar-->
            </div> <!-- end .collapsed-->
        </nav>
    </div> <!-- end container-fluid -->
</div> 