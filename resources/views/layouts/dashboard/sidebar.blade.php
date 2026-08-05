  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('dashboard') ? '' : 'collapsed' }}" href="{{ route('dashboard') }}">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('permohonan.*') || request()->routeIs('import-data.*') ? '' : 'collapsed' }}" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Manajemen Data</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse {{ request()->routeIs('permohonan.*') || request()->routeIs('import-data.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ route('import-data.create') }}" class="{{ request()->routeIs('import-data.create') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Import Data</span>
            </a>
          </li>
          <li>
            <a href="{{ route('permohonan.index') }}" class="{{ request()->routeIs('permohonan.*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Data Permohonan</span>
            </a>
          </li>
         
          <li>
            <a href="{{ route('import-data.index') }}" class="{{ request()->routeIs('import-data.index') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Riwayat Import</span>
            </a>
          </li>
        </ul>
      </li><!-- End Components Nav -->

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('verifikasi.*') ? '' : 'collapsed' }}" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-journal-text"></i><span>Verifikasi</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forms-nav" class="nav-content collapse {{ request()->routeIs('verifikasi.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ route('verifikasi.index') }}" class="{{ request()->routeIs('verifikasi.*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Verifikasi Checklist</span>
            </a>
          </li>
        </ul>
      </li><!-- End Forms Nav -->

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('users.*') || request()->routeIs('laporan.*') ? '' : 'collapsed' }}" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-layout-text-window-reverse"></i><span>Administrasi</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="tables-nav" class="nav-content collapse {{ request()->routeIs('users.*') || request()->routeIs('laporan.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Manajemen Pengguna</span>
            </a>
          </li>
          <li>
            <a href="{{ route('laporan.index') }}" class="{{ request()->routeIs('laporan.*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Laporan Rekapitulasi</span>
            </a>
          </li>
        </ul>
      </li><!-- End Tables Nav -->

    </ul>

  </aside><!-- End Sidebar-->