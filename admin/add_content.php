<?php

include '../components/connect.php';

if(isset($_COOKIE['tutor_id'])){
   $tutor_id = $_COOKIE['tutor_id'];
}else{
   $tutor_id = '';
   header('location:login.php');
}

if(isset($_POST['submit'])){

   $id = unique_id();
   $status = $_POST['status'];
   $status = filter_var($status, FILTER_SANITIZE_STRING);
   $title = $_POST['title'];
   $title = filter_var($title, FILTER_SANITIZE_STRING);
   $description = $_POST['description'];
   $description = filter_var($description, FILTER_SANITIZE_STRING);
   $playlist = $_POST['playlist'];
   $playlist = filter_var($playlist, FILTER_SANITIZE_STRING);

   // If no playlist selected, auto-assign to the "No Playlist" course
   if($playlist == ''){
      // Look up the "No Playlist" playlist for this tutor, create if missing
      $find_np = $conn->prepare("SELECT id FROM `playlist` WHERE title = 'No Playlist' AND tutor_id = ? LIMIT 1");
      $find_np->execute([$tutor_id]);
      if($find_np->rowCount() > 0){
         $playlist = $find_np->fetchColumn();
      }else{
         $np_id = unique_id();
         $create_np = $conn->prepare("INSERT INTO `playlist`(id, tutor_id, title, description, thumb, status) VALUES(?,?,?,?,?,?)");
         $create_np->execute([$np_id, $tutor_id, 'No Playlist', 'Videos uploaded without a playlist are shown here.', 'no_playlist.jpg', 'active']);
         $playlist = $np_id;
      }
   }

   $thumb = $_FILES['thumb']['name'];
   $thumb = filter_var($thumb, FILTER_SANITIZE_STRING);
   $thumb_ext = pathinfo($thumb, PATHINFO_EXTENSION);
   $rename_thumb = unique_id().'.'.$thumb_ext;
   $thumb_size = $_FILES['thumb']['size'];
   $thumb_tmp_name = $_FILES['thumb']['tmp_name'];
   $thumb_folder = '../uploaded_files/'.$rename_thumb;

   // Handle video: either an uploaded file OR a pasted link (YouTube etc.)
   $video_link = '';
   if(!empty($_POST['video_link'])){
      $video_link = $_POST['video_link'];
      $video_link = filter_var($video_link, FILTER_SANITIZE_URL);
      $rename_video = '';
      $video_tmp_name = '';
      $video_folder = '';
   }else{
      $video_link = '';
      $video = $_FILES['video']['name'];
      $video = filter_var($video, FILTER_SANITIZE_STRING);
      $video_ext = pathinfo($video, PATHINFO_EXTENSION);
      $rename_video = unique_id().'.'.$video_ext;
      $video_tmp_name = $_FILES['video']['tmp_name'];
      $video_folder = '../uploaded_files/'.$rename_video;
   }

   if($thumb_size > 2000000){
      $message[] = 'image size is too large!';
   }else{
      $add_playlist = $conn->prepare("INSERT INTO `content`(id, tutor_id, playlist_id, title, description, video, video_link, thumb, status) VALUES(?,?,?,?,?,?,?,?,?)");
      $add_playlist->execute([$id, $tutor_id, $playlist, $title, $description, $rename_video, $video_link, $rename_thumb, $status]);
      move_uploaded_file($thumb_tmp_name, $thumb_folder);
      // only move the uploaded video if a file was provided
      if($video_tmp_name != ''){
         move_uploaded_file($video_tmp_name, $video_folder);
      }
      $message[] = 'new course uploaded!';
   }

   

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Dashboard</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>
   
<section class="video-form">

   <h1 class="heading">upload content</h1>

   <form action="" method="post" enctype="multipart/form-data">
      <p>video status <span>*</span></p>
      <select name="status" class="box" required>
         <option value="" selected disabled>-- select status</option>
         <option value="active">active</option>
         <option value="deactive">deactive</option>
      </select>
      <p>video title <span>*</span></p>
      <input type="text" name="title" maxlength="100" required placeholder="enter video title" class="box">
      <p>video description <span>*</span></p>
      <textarea name="description" class="box" required placeholder="write description" maxlength="1000" cols="30" rows="10"></textarea>
      <p>video playlist (optional)</p>
      <select name="playlist" class="box">
         <option value="" selected>-- none (not assigned) --</option>
         <?php
         $select_playlists = $conn->prepare("SELECT * FROM `playlist` WHERE tutor_id = ?");
         $select_playlists->execute([$tutor_id]);
         if($select_playlists->rowCount() > 0){
            while($fetch_playlist = $select_playlists->fetch(PDO::FETCH_ASSOC)){
         ?>
         <option value="<?= $fetch_playlist['id']; ?>"><?= $fetch_playlist['title']; ?></option>
         <?php
            }
         ?>
         <?php
         }else{
            echo '<option value="" disabled>no playlist created yet!</option>';
         }
         ?>
      </select>
      <p>select thumbnail <span>*</span></p>
      <input type="file" name="thumb" accept="image/*" required class="box">
      <p>select video or video link <span style="color:var(--light-color)">(choose one)</span></p>
      <div class="flex" style="gap:1rem; align-items:center; flex-wrap:wrap;">
         <input type="file" name="video" accept="video/*" class="box" style="flex:1 1 45%; min-width: 25rem;">
         <span style="color:var(--light-color); font-size:1.5rem;">—or—</span>
      </div>
      <input type="url" name="video_link" placeholder="paste video link (e.g. YouTube URL), no file upload needed" class="box">
      <input type="submit" value="upload video" name="submit" class="btn">
   </form>

</section>















<?php include '../components/footer.php'; ?>

<script src="../js/admin_script.js"></script>

</body>
</html>