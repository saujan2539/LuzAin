<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

$select_likes = $conn->prepare("SELECT * FROM `likes` WHERE user_id = ?");
$select_likes->execute([$user_id]);
$total_likes = $select_likes->rowCount();

$select_comments = $conn->prepare("SELECT * FROM `comments` WHERE user_id = ?");
$select_comments->execute([$user_id]);
$total_comments = $select_comments->rowCount();

$select_bookmark = $conn->prepare("SELECT * FROM `bookmark` WHERE user_id = ?");
$select_bookmark->execute([$user_id]);
$total_bookmarked = $select_bookmark->rowCount();

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>

<!-- hero section starts -->
<section class="hero">
   <span class="hero-tag">learn &middot; grow &middot; succeed</span>
   <h1>Master New Skills,<br><span>Anytime, Anywhere.</span></h1>
   <p>Explore curated courses, learn from expert tutors, and track your progress &mdash; all in one place.</p>
   <div class="hero-btns">
         <a href="courses.php" class="btn">explore courses</a>
         <?php if($user_id == ''): ?>
            <a href="register.php" class="option-btn">join for free</a>
         <?php endif; ?>
      </div>
</section>
<!-- hero section ends -->

<!-- quick select section starts  -->

<section class="quick-select">

   <h1 class="heading">quick options</h1>

   <div class="box-container">

      <?php
         if($user_id != ''){
      ?>
      <div class="box">
         <h3 class="title">likes and comments</h3>
         <div class="ig-actions">
            <a href="likes.php" class="ig-action">
               <i class="fas fa-heart"></i>
               <span class="ig-count"><?= $total_likes; ?></span>
               <span class="ig-label">likes</span>
            </a>
            <a href="comments.php" class="ig-action">
               <i class="fas fa-comment"></i>
               <span class="ig-count"><?= $total_comments; ?></span>
               <span class="ig-label">comments</span>
            </a>
            <a href="bookmark.php" class="ig-action">
               <i class="fas fa-bookmark"></i>
               <span class="ig-count"><?= $total_bookmarked; ?></span>
               <span class="ig-label">saved</span>
            </a>
         </div>
      </div>
      <?php
         }else{ 
      ?>
      <div class="box" style="text-align: center;">
         <h3 class="title">please login or register</h3>
          <div class="flex-btn" style="padding-top: .5rem;">
            <a href="login.php" class="option-btn">login</a>
            <a href="register.php" class="option-btn">register</a>
         </div>
      </div>
      <?php
      }
      ?>

      <div class="box">
         <h3 class="title">top categories</h3>
         <div class="flex">
            <a href="search_course.php?"><i class="fas fa-code"></i><span>development</span></a>
            <a href="#"><i class="fas fa-chart-simple"></i><span>business</span></a>
            <a href="#"><i class="fas fa-pen"></i><span>design</span></a>
            <a href="#"><i class="fas fa-chart-line"></i><span>marketing</span></a>
            <a href="#"><i class="fas fa-music"></i><span>music</span></a>
            <a href="#"><i class="fas fa-camera"></i><span>photography</span></a>
            <a href="#"><i class="fas fa-cog"></i><span>software</span></a>
            <a href="#"><i class="fas fa-vial"></i><span>science</span></a>
         </div>
      </div>

      <div class="box">
         <h3 class="title">popular topics</h3>
         <div class="flex">
            <a href="#"><i class="fab fa-html5"></i><span>HTML</span></a>
            <a href="#"><i class="fab fa-css3"></i><span>CSS</span></a>
            <a href="#"><i class="fab fa-js"></i><span>javascript</span></a>
            <a href="#"><i class="fab fa-react"></i><span>react</span></a>
            <a href="#"><i class="fab fa-php"></i><span>PHP</span></a>
            <a href="#"><i class="fab fa-bootstrap"></i><span>bootstrap</span></a>
            <a href="#"><i class="fas fa-graduation-cap"></i><span>SEE</span></a>
            <a href="#"><i class="fas fa-user-graduate"></i><span>+2</span></a>
            <a href="#"><i class="fas fa-landmark"></i><span>Loksewa</span></a>
         </div>
      </div>

   </div>

</section>

<!-- quick select section ends -->

<!-- courses section starts  -->

<section class="courses">

   <h1 class="heading">latest courses</h1>

   <div class="box-container">

      <?php
         $select_courses = $conn->prepare("SELECT * FROM `playlist` WHERE status = ? ORDER BY date DESC LIMIT 6");
         $select_courses->execute(['active']);
         if($select_courses->rowCount() > 0){
            while($fetch_course = $select_courses->fetch(PDO::FETCH_ASSOC)){
               $course_id = $fetch_course['id'];

               $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE id = ?");
                              $select_tutor->execute([$fetch_course['tutor_id']]);
                              $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);

                              $count_videos = $conn->prepare("SELECT * FROM `content` WHERE playlist_id = ? AND status = ?");
                              $count_videos->execute([$course_id, 'active']);
                              $total_videos = $count_videos->rowCount();
                     ?>
                     <div class="box">
                        <a href="playlist.php?get_id=<?= $course_id; ?>" class="box-tutor-link">
                           <div class="tutor">
                              <img src="uploaded_files/<?= $fetch_tutor['image']; ?>" alt="">
                              <div>
                                 <h3><?= $fetch_tutor['name']; ?></h3>
                                 <span><?= $fetch_course['date']; ?></span>
                              </div>
                           </div>
                        </a>
                        <a href="playlist.php?get_id=<?= $course_id; ?>" class="yt-thumb-wrap">
                           <img src="uploaded_files/<?= $fetch_course['thumb']; ?>" class="thumb" alt="">
                           <?php if($total_videos > 0): ?><span class="yt-vids"><?= $total_videos; ?> videos</span><?php endif; ?>
                           <span class="yt-play"><i class="fas fa-play"></i></span>
                        </a>
                        <h3 class="title"><?= $fetch_course['title']; ?></h3>
                        <a href="playlist.php?get_id=<?= $course_id; ?>" class="inline-btn">view playlist</a>
                     </div>
      <?php
         }
      }else{
         echo '<p class="empty">no courses added yet!</p>';
      }
      ?>

   </div>

   <div class="more-btn">
      <a href="courses.php" class="inline-btn">view more</a>
   </div>

</section>

<!-- courses section ends -->












<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->

<!-- custom js file link  -->
<script src="js/script.js"></script>
   
</body>
</html>