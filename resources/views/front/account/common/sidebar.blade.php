<ul class="profile-menu">
    <li class="profile-menu-item"><a href="{{ route('front.profile') }}"><i class="fas fa-user-alt"></i>My Profile</a></li>
    <li class="profile-menu-item"><a href="{{ route('front.userComment') }}"><i class="fa-solid fa-comment-dots"></i>Comments</a></li>
    <li class="profile-menu-item"><a href="{{ route('front.favPost') }}"><i class="fas fa-heart"></i>Favourite</a></li>
    <li class="profile-menu-item"><a href="{{ route('front.ChangeUserPassword') }}"><i class="fas fa-lock"></i>Change Password</a></li>
    <li class="profile-menu-item"><a href="{{ route('front.logout') }}"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
    <li class="profile-menu-item"><a href="{{ route('front.deleteUser') }}"><i class="fas fa-trash-alt"></i>Delete Account</a></li>
</ul>