<style>
.navbar-custom {
  background: rgba(255,255,255,0.72);
  backdrop-filter: blur(14px);
  -webkit-backdrop-filter: blur(14px);
  border-radius: 0 0 18px 18px;
  box-shadow: 0 2px 14px rgba(30,40,60,0.11);
  padding: 0 32px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  min-height: 68px;
  position: sticky;
  top: 0;
  z-index: 99;
  transition: box-shadow 0.2s;
}
.navbar-logo {
  display: flex;
  align-items: center;
  font-weight: 800;
  font-size: 1.32rem;
  color: #1976D2;
  letter-spacing: 1px;
  gap: 8px;
}
.navbar-logo img {
  height: 38px;
  margin-right: 6px;
  border-radius: 9px;
}
.navbar-menu {
  display: flex;
  gap: 28px;
  align-items: center;
  flex: 1;
  justify-content: center;
}
.navbar-menu a {
  color: #222;
  font-weight: 500;
  font-size: 1.07rem;
  text-decoration: none;
  padding: 8px 10px;
  border-radius: 7px;
  transition: background 0.18s, color 0.18s;
}
.navbar-menu a:hover {
  background: #e3f0fa;
  color: #1976D2;
}
.navbar-actions {
  display: flex;
  gap: 10px;
  align-items: center;
}
.btn-login {
  border: 2px solid #1976D2;
  background: #fff;
  color: #1976D2;
  font-weight: 700;
  border-radius: 8px;
  padding: 7px 18px;
  font-size: 1.04rem;
  transition: background 0.18s, color 0.18s;
}
.btn-login:hover {
  background: #e3f0fa;
}
.btn-register {
  background: #1976D2;
  color: #fff;
  font-weight: 700;
  border-radius: 8px;
  padding: 7px 18px;
  font-size: 1.04rem;
  border: none;
  transition: background 0.18s;
}
.btn-register:hover {
  background: #1251a3;
}
/* Hamburger for mobile */
.navbar-hamburger {
  display: none;
  flex-direction: column;
  gap: 4px;
  cursor: pointer;
  margin-left: 16px;
}
.navbar-hamburger span {
  width: 26px;
  height: 3px;
  background: #1976D2;
  border-radius: 2px;
  display: block;
}
@media (max-width: 900px) {
  .navbar-menu, .navbar-actions { display: none; }
  .navbar-hamburger { display: flex; }
}
@media (max-width: 600px) {
  .navbar-custom { padding: 0 10px; }
  .navbar-logo { font-size: 1.02rem; }
}
/* Show menu when active (handled by JS) */
.navbar-menu.active, .navbar-actions.active {
  display: flex !important;
  flex-direction: column;
  position: absolute;
  top: 68px;
  left: 0;
  width: 100vw;
  background: #fff;
  border-radius: 0 0 18px 18px;
  box-shadow: 0 7px 24px rgba(30,40,60,0.13);
  padding: 20px 0 18px 0;
  z-index: 101;
  gap: 18px;
}
</style>
<div class="navbar-custom">
  <div class="navbar-logo">
    <a href="{{ route('landing') }}" style="display:flex; align-items:center; text-decoration:none; color:inherit;">
      <img src="/images/orangbaiklogo.png" alt="OrangBaik" style="height:38px; width:auto; margin-right:7px;">
      OrangBaik
    </a>
  </div>
  <div class="navbar-menu">
    <a href="{{ route('landing') }}">Home</a>
    <a href="{{ route('landing') }}#aksi">Aksi</a>
    <a href="{{ route('landing') }}#fitur">Fitur</a>
    <a href="{{ route('landing') }}#berita">Berita</a>
    <a href="{{ route('landing') }}#testimoni">Testimoni</a>
    <a href="{{ route('landing') }}#kontak">Kontak</a>
    
    @auth
      @if(Auth::user()->usertype !== 'admin')
        
        @php
          $relawan = App\Models\Relawan::where('user_id', Auth::id())->first();
          $unreadNotificationsCount = 0;
          if ($relawan) {
              $unreadNotificationsCount = App\Models\VolunteerNotification::where('relawan_id', $relawan->id)
                  ->where('is_read', false)
                  ->count();
          }
        @endphp
        
        <a href="{{ route('volunteer.notifications.index') }}" style="display:flex; align-items:center; position:relative;">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:3px;">
            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
          </svg>
          @if($unreadNotificationsCount > 0)
            <span style="position:absolute; top:-5px; right:-5px; background:#e53e3e; color:white; border-radius:9999px; min-width:18px; height:18px; font-size:0.75rem; font-weight:bold; display:inline-flex; align-items:center; justify-content:center; padding:0 4px;">
              {{ $unreadNotificationsCount }}
            </span>
          @endif
        </a>
      @endif
    @endauth
  </div>
  <div class="navbar-actions" style="position:relative;">
  @auth
    <button id="accountDropdownBtn" onclick="toggleAccountDropdown(event)" style="border:2px solid #1976D2; background:rgba(255,255,255,0.68); backdrop-filter:blur(10px); -webkit-backdrop-filter:blur(10px); color:#1976D2; font-weight:700; border-radius:8px; padding:7px 18px; font-size:1.04rem; display:flex; align-items:center; gap:7px; cursor:pointer;">
      {{ Auth::user()->name }}
      <svg width="18" height="18" fill="none" viewBox="0 0 24 24"><path d="M7 10l5 5 5-5" stroke="#1976D2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
    </button>
    <div id="accountDropdownMenu" style="display:none; position:absolute; top:48px; right:0; min-width:160px; background:#fff; border-radius:10px; box-shadow:0 6px 32px rgba(30,40,60,0.14); padding:12px 0; z-index:200;">
      <a href="{{ route('relawan.show') }}" style="display:block; padding:12px 20px; color:#222; font-weight:500; text-decoration:none; transition:background 0.13s;">Profile</a>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" style="display:block; padding:12px 20px; color:#222; font-weight:500; text-decoration:none; transition:background 0.13s;">Keluar</a>
      </form>
    </div>
  @else
    <button id="accountDropdownBtn" onclick="toggleAccountDropdown(event)" style="border:2px solid #1976D2; background:rgba(255,255,255,0.68); backdrop-filter:blur(10px); -webkit-backdrop-filter:blur(10px); color:#1976D2; font-weight:700; border-radius:8px; padding:7px 18px; font-size:1.04rem; display:flex; align-items:center; gap:7px; cursor:pointer;">
      Masuk / Buat Akun
      <svg width="18" height="18" fill="none" viewBox="0 0 24 24"><path d="M7 10l5 5 5-5" stroke="#1976D2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
    </button>
    <div id="accountDropdownMenu" style="display:none; position:absolute; top:48px; right:0; min-width:160px; background:#fff; border-radius:10px; box-shadow:0 6px 32px rgba(30,40,60,0.14); padding:12px 0; z-index:200;">
      <a href="{{ route('login') }}" style="display:block; padding:12px 20px; color:#222; font-weight:500; text-decoration:none; transition:background 0.13s;">Masuk</a>
      <a href="{{ route('register') }}" style="display:block; padding:12px 20px; color:#222; font-weight:500; text-decoration:none; transition:background 0.13s;">Buat Akun</a>
    </div>
  @endauth
</div>
<script>
function toggleAccountDropdown(e) {
  e.stopPropagation();
  const menu = document.getElementById('accountDropdownMenu');
  menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
}
document.addEventListener('click', function(e) {
  const menu = document.getElementById('accountDropdownMenu');
  if(menu) menu.style.display = 'none';
});
// Optional: close on escape
window.addEventListener('keydown', function(e) {
  if(e.key === 'Escape') {
    const menu = document.getElementById('accountDropdownMenu');
    if(menu) menu.style.display = 'none';
  }
});
</script>
  <div class="navbar-hamburger" onclick="toggleNavbarMenu()">
    <span></span>
    <span></span>
    <span></span>
  </div>
</div>
<script>
function toggleNavbarMenu() {
  const menu = document.querySelector('.navbar-menu');
  const actions = document.querySelector('.navbar-actions');
  menu.classList.toggle('active');
  actions.classList.toggle('active');
}
</script>
