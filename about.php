<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

// Real-time stats from the database (Option B: live counters, no fake numbers)
$count_courses = $conn->query("SELECT COUNT(*) FROM `playlist` WHERE status = 'active'")->fetchColumn();
$count_students = $conn->query("SELECT COUNT(*) FROM `users`")->fetchColumn();
$count_teachers = $conn->query("SELECT COUNT(*) FROM `tutors`")->fetchColumn();
$count_videos = $conn->query("SELECT COUNT(*) FROM `content`")->fetchColumn();

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>

<!-- about section starts  -->

<section class="about">

   <div class="row">

      <div class="image">
         <img src="images/about-img.svg" alt="">
      </div>

      <div class="content">
               <h3>why choose us?</h3>
               <p>LuzAin provides a clean, responsive online learning platform where you can browse courses, open playlists, watch educational videos and follow expert tutors. Everything you need to keep learning is organized in one simple, fast website that works on any device.</p>
               <a href="courses.php" class="inline-btn">our courses</a>
            </div>

   </div>

   <div class="box-container">

         <div class="box">
            <i class="fas fa-graduation-cap"></i>
            <div>
               <h3><?= $count_courses; ?></h3>
               <span>online courses</span>
            </div>
         </div>

         <div class="box">
            <i class="fas fa-user-graduate"></i>
            <div>
               <h3><?= $count_students; ?></h3>
               <span>students</span>
            </div>
         </div>

         <div class="box">
            <i class="fas fa-chalkboard-user"></i>
            <div>
               <h3><?= $count_teachers; ?></h3>
               <span>expert teachers</span>
            </div>
         </div>

         <div class="box">
            <i class="fas fa-video"></i>
            <div>
               <h3><?= $count_videos; ?></h3>
               <span>learning videos</span>
            </div>
         </div>

      </div>

</section>

<!-- about section ends -->

<!-- reviews section starts  -->

<section class="reviews">

   <h1 class="heading">student's reviews</h1>

   <div class="box-container">

      <div class="box">
               <p>The interface is clean and the videos load smoothly. I love that I can bookmark lessons and come back to them later.</p>
               <div class="user">
                  <img src="images/pic-2.jpg" alt="">
                  <div>
                     <h3>Saujan Ngyasur</h3>
                     <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                     </div>
                  </div>
               </div>
            </div>

      </div>

</section>

<!-- reviews section ends -->










<?php include 'components/footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>
   
</body>
</html>