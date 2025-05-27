<?php 
include('header.php');

// Securely fetch movie ID from URL
$movie_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch movie details from database
$qry2 = mysqli_query($con, "SELECT * FROM tbl_movie WHERE movie_id = $movie_id");
$movie = mysqli_fetch_array($qry2);

// If movie not found
if (!$movie) {
    echo "<div class='content'><div class='wrap'><h3 class='text-center'>Movie not found!</h3></div></div>";
    include('footer.php');
    exit;
}
?>

<div class="content">
    <div class="wrap">
        <div class="content-top">
            <div class="section group">
                <div class="about span_1_of_2">    
                    <h3 style="color:#444; font-size:23px;" class="text-center">
                        <?php echo htmlspecialchars($movie['movie_name']); ?>
                    </h3>    

                    <div class="about-top">    
                        <div class="grid images_3_of_2">
                            <?php
                            // Fix image path
                            $imageFile = basename($movie['image']);
                            $imagePath = "images/" . $imageFile;

                            if (!empty($imageFile) && file_exists($imagePath)) {
                                echo '<img src="' . $imagePath . '" alt="Movie Poster"/>';
                            } else {
                                echo '<img src="images/default-movie.png" alt="No Image Available"/>';
                            }
                            ?>
                        </div>

                        <div class="desc span_3_of_2">
                            <p class="p-link" style="font-size:15px"><b>Cast: </b><?php echo htmlspecialchars($movie['cast']); ?></p>
                            <p class="p-link" style="font-size:15px"><b>Release Date: </b><?php echo date('d-M-Y', strtotime($movie['release_date'])); ?></p>
                            <p style="font-size:15px"><?php echo nl2br(htmlspecialchars($movie['desc'])); ?></p>
                            <?php if (!empty($movie['video_url'])): ?>
                                <a href="<?php echo htmlspecialchars($movie['video_url']); ?>" target="_blank" class="watch_but" style="text-decoration:none;">Watch Trailer</a>
                            <?php endif; ?>
                        </div>
                        <div class="clear"></div>
                    </div>

                    <?php 
                    $s = mysqli_query($con, "SELECT DISTINCT theatre_id FROM tbl_shows WHERE movie_id = $movie_id");
                    if (mysqli_num_rows($s)) {
                    ?>
                        <h3 style="color:#444;" class="text-center">Available Shows</h3>
                        <table class="table table-hover table-bordered text-center">
                            <thead>
                                <tr>
                                    <th class="text-center" style="font-size:16px;"><b>Theatre</b></th>
                                    <th class="text-center" style="font-size:16px;"><b>Show Timings</b></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($shw = mysqli_fetch_array($s)) {
                                    $t = mysqli_query($con, "SELECT * FROM tbl_theatre WHERE id='" . $shw['theatre_id'] . "'");
                                    $theatre = mysqli_fetch_array($t);
                                ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($theatre['name']) . ", " . htmlspecialchars($theatre['place']); ?></td>
                                    <td>
                                        <?php 
                                        $tr = mysqli_query($con, "SELECT * FROM tbl_shows WHERE movie_id = $movie_id AND theatre_id = '" . $shw['theatre_id'] . "'");
                                        while ($shh = mysqli_fetch_array($tr)) {
                                            $ttm = mysqli_query($con, "SELECT * FROM tbl_show_time WHERE st_id='" . $shh['st_id'] . "'");
                                            $ttme = mysqli_fetch_array($ttm);
                                        ?>
                                            <a href="check_login.php?show=<?php echo $shh['s_id']; ?>&movie=<?php echo $shh['movie_id']; ?>&theatre=<?php echo $shw['theatre_id']; ?>">
                                                <button class="btn btn-default">
                                                    <?php echo date('h:i A', strtotime($ttme['start_time'])); ?>
                                                </button>
                                            </a>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php
                    } else {
                        echo "<h3 style='color:#444; font-size:23px;' class='text-center'>Currently there are no shows available!</h3>";
                        echo "<p class='text-center'>Please check back later!</p>";
                    }
                    ?>
                </div>            
                <?php include('movie_sidebar.php'); ?>
            </div>
            <div class="clear"></div>        
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
