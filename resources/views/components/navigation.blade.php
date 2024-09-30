 <nav class="navbar navbar-expand-lg bg-body">
     <div class="container">
         <a class="navbar-brand" href="/dashboard">Dashboard</a>
         <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
             aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
             <span class="navbar-toggler-icon"></span>
         </button>
         <div class="collapse navbar-collapse" id="navbarSupportedContent">
             <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                 <li class="nav-item">
                     <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" aria-current="page"
                         href="/dashboard">Home</a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link {{ Request::is('expenses*') ? 'active' : '' }}"
                         href="{{ route('expenses.index') }}">Expenses</a>
                 </li>
             </ul>
             <li class="nav-item dropdown d-flex">
                 <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                     aria-expanded="false">
                     {{ $loggeduser }}
                 </a>
                 <ul class="dropdown-menu">
                     <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                     <li>
                         <hr class="dropdown-divider">
                     </li>
                     <li>
                         <form action="auth/refresh" method="post">
                             @csrf
                             <button class="dropdown-item" type="submit">Refresh Token</button>
                         </form>
                     </li>
                     <li>
                         <form action="auth/logout" method="post">
                             @csrf
                             <button class="dropdown-item" type="submit">Logout</button>
                         </form>
                     </li>
                 </ul>
             </li>
         </div>
     </div>
 </nav>
