<aside class="left-sidebar">
        <!-- Sidebar scroll-->
        <div>
          <div
            class="brand-logo d-flex align-items-center justify-content-between"
          >
            <a href="./index.html" class="text-nowrap logo-img">
              <img src="{{ asset('assets')}}/images/logos/logo.svg" alt="" />
            </a>
            <div
              class="close-btn d-xl-none d-block sidebartoggler cursor-pointer"
              id="sidebarCollapse"
            >
              <i class="ti ti-x fs-6"></i>
            </div>
          </div>
          <!-- Sidebar navigation-->
          <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">
              <li class="nav-small-cap">
                <iconify-icon
                  icon="solar:menu-dots-linear"
                  class="nav-small-cap-icon fs-4"
                ></iconify-icon>
                <span class="hide-menu">Home</span>
              </li>
              <li class="sidebar-item">
                <a
                  class="sidebar-link"
                  href="./index.html"
                  aria-expanded="false"
                >
                  <i class="ti ti-atom"></i>
                  <span class="hide-menu">Dashboard</span>
                </a>
              </li>
              <!-- ---------------------------------- -->
              <!-- Dashboard -->
              <!-- ---------------------------------- -->


              <li>
                <span class="sidebar-divider lg"></span>
              </li>
              <li class="nav-small-cap">
                <iconify-icon
                  icon="solar:menu-dots-linear"
                  class="nav-small-cap-icon fs-4"
                ></iconify-icon>
                <span class="hide-menu">Apps</span>
              </li>
            </ul>
          </nav>
          <!-- End Sidebar navigation -->
        </div>
        <!-- End Sidebar scroll-->
      </aside>