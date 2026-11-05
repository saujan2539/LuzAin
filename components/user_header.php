<?php
if(isset($message)){
   foreach($message as $msg){
      // Determine toast type by message content
      $lower = strtolower($msg);
      if(strpos($lower,'error')!==false || strpos($lower,'incorrect')!==false || strpos($lower,'fail')!==false || strpos($lower,'too large')!==false || strpos($lower,'already')!==false || strpos($lower,'not found')!==false || strpos($lower,'couldn\'t')!==false || strpos($lower,'unable')!==false || strpos($lower,'required')!==false){
         $type = 'error';
      }elseif(strpos($lower,'warning')!==false || strpos($lower,'careful')!==false || strpos($lower,'check')!==false){
         $type = 'warning';
      }else{
         $type = 'success';
      }
      // icon per type
      $icon = $type==='error' ? 'fa-circle-exclamation' : ($type==='warning' ? 'fa-triangle-exclamation' : 'fa-circle-check');
      echo '
      <div class="toast toast-'.$type.'">
         <i class="fas '.$icon.'"></i>
         <span>'.$msg.'</span>
         <i class="fas fa-xmark toast-close" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">

   <section class="flex">

      <div class="menu-area">
         <div id="menu-btn" class="fas fa-bars"></div>
         <a href="home.php" class="logo">
            <img src="images/final_logo_2.png" alt="LuzAin" class="logo-img">
         </a>
      </div>

      <form action="search_course.php" method="post" class="search-form">
         <input type="text" name="search_course" placeholder="search courses..." required maxlength="100">
         <button type="submit" class="fas fa-search" name="search_course_btn"></button>
      </form>

      <div class="icons">
         <div id="search-btn" class="fas fa-search"></div>
         <?php
            $select_avatar = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_avatar->execute([$user_id]);
            if($select_avatar->rowCount() > 0){
               $fetch_avatar = $select_avatar->fetch(PDO::FETCH_ASSOC);
         ?>
            <div id="user-btn" class="user-avatar">
               <img src="uploaded_files/<?= $fetch_avatar['image']; ?>" alt="">
            </div>
         <?php }else{ ?>
            <div id="user-btn" class="fas fa-user"></div>
         <?php } ?>
         <div id="toggle-btn" class="fas fa-sun"></div>
      </div>

      <div class="profile">
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if($select_profile->rowCount() > 0){
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <img src="uploaded_files/<?= $fetch_profile['image']; ?>" alt="">
                  <h3><?= $fetch_profile['name']; ?></h3>
                  <span>student</span>
                  <a href="profile.php" class="btn">view profile</a>
                  <a href="components/user_logout.php" onclick="return confirm('logout from this website?');" class="delete-btn">logout</a>
                  <?php
                     }else{
                  ?>
         <h3>please login or register</h3>
          <div class="flex-btn">
            <a href="login.php" class="option-btn">login</a>
            <a href="register.php" class="option-btn">register</a>
         </div>
         <?php
            }
         ?>
      </div>

   </section>

</header>

<!-- header section ends -->

<!-- side bar section starts  -->

<div class="menu-overlay" onclick="document.querySelector('.side-bar').classList.remove('active'); document.body.classList.remove('active');"></div>

<div class="side-bar">

   <div class="side-head">
      <button class="close-side-bar" onclick="this.closest('.side-bar').classList.remove('active'); document.body.classList.remove('active');">
         <i class="fas fa-angle-left"></i><span>Close menu</span>
      </button>
   </div>

   <div class="profile">
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if($select_profile->rowCount() > 0){
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <img src="uploaded_files/<?= $fetch_profile['image']; ?>" alt="">
         <h3><?= $fetch_profile['name']; ?></h3>
         <span>student</span>
         <a href="profile.php" class="btn">view profile</a>
         <?php
            }else{
         ?>
         <h3>please login or register</h3>
          <div class="flex-btn" style="padding-top: .5rem;">
            <a href="login.php" class="option-btn">login</a>
            <a href="register.php" class="option-btn">register</a>
         </div>
         <?php
            }
         ?>
      </div>

   <nav class="navbar">
      <a href="home.php"><i class="fas fa-home"></i><span>home</span></a>
      <a href="about.php"><i class="fas fa-question"></i><span>about us</span></a>
      <a href="courses.php"><i class="fas fa-graduation-cap"></i><span>courses</span></a>
      <a href="teachers.php"><i class="fas fa-chalkboard-user"></i><span>teachers</span></a>
      <a href="contact.php"><i class="fas fa-headset"></i><span>contact us</span></a>
   </nav>

</div>

<!-- side bar section ends -->