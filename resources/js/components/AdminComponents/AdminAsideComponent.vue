<template>
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../../index3.html" class="brand-link">
      <img src=""
           alt="AdminLTE Logo"
           class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Admin Pannel</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/dashboard" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard</p>
                </router-link>
              </li>

            </ul>
          </li>

            <li class="nav-item">
            <router-link to="/categories" class="nav-link" v-if="$store.getters.getAdminStatus">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Categories
              </p>
            </router-link>
          </li>
               <li class="nav-item">
            <router-link to="/items" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Items
              </p>
            </router-link>
          </li>
            <li class="nav-item">
                <router-link to="/checkout" class="nav-link">
                    <i class="nav-icon fas fa-th"></i>
                    <p>
                        Checkout
                    </p>
                </router-link>
            </li>
            <li class="nav-item">
                <router-link to="/users" class="nav-link">
                    <i class="nav-icon fas fa-th"></i>
                    <p>
                        Users
                    </p>
                </router-link>
            </li>
            <li class="nav-item">
                <router-link to="/orders" class="nav-link">
                    <i class="nav-icon fas fa-th"></i>
                    <p>
                        Orders
                    </p>
                </router-link>
            </li>

















        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
</template>
<script>
export default {
    mounted:function(){
        console.log('Admin Aside COmponent has been mounted');
    }
}
</script>
