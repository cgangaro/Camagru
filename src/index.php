<?php
include_once 'View/Header/header.php';
?>

<style>
    <?php include 'View/all.css'; ?>
</style>

<?php
require_once 'Controller/home.inc.php';
?>

<style>
    <?php include 'View/Home/home.css'; ?>
</style>

<div id="homeGallery">
    <?php
    if (count($galleryToDisplay) > 0) {
        foreach ($galleryToDisplay as $item) {
            echo '
            <div class="card pictureItem">
            <p class="title">
            Posted by ' . $item['author_name'] . '
            </p>
            <div class="cardContent">
                <img class="galleryImage" src="data:image/png;base64,' . base64_encode($item['file_data']) . '"/>
                <div class="itemCommentsPart">
            ';
            echo '
                <div class="likePart">
                <p>
                ' . $item["likes"] . '
                </p>
                <form id="likeForm_' . $item["image_id"] . '" class="likeForm">
                    <input type="hidden" name="imageid" value="' . $item["image_id"] . '" />
                    <input type="hidden" name="liked" value="' . $item["liked"] . '" />';
            if ($item["liked"]) {
                echo '
                    <button ';
                if (!isset($_SESSION['userid'])) {
                    echo 'disabled ';
                }
                echo 'id="likeButton_' . $item["image_id"] . '" value="' . $item["image_id"] . '" class="button is-link sendLikeButton" type="button"><span class="icon">
                            <i class="fa-solid fa-heart"></i>
                        </span></button>
                </form>
                </div>
                ';
            } else {
                echo '
                    <button ';
                if (!isset($_SESSION['userid'])) {
                    echo 'disabled ';
                }
                echo 'id="likeButton_' . $item["image_id"] . '" value="' . $item["image_id"] . '" class="button is-link sendLikeButton" type="button"><span class="icon">
                        <i class="fa-regular fa-heart"></i>
                    </span></button>
                </form>
                </div>
                ';
            }
            echo '<div class="commentPart">';
            foreach ($item['comments'] as $comment) {
                echo '
                    <div class="comment">
                        <p><span class="authorName">' . $comment['author_name'] . '</span> ' . $comment['comment'] . '</p>
                    </div>
                ';
            }
            echo '</div>';
            echo '
                <form onsubmit="return false" id="commentForm_' . $item["image_id"] . '" class="commentInputDiv">
                    <input id="input_comment_' . $item["image_id"] . '" type="text" name="comment" />
                    <input type="hidden" name="imageid" value="' . $item["image_id"] . '" />
                    <input type="hidden" name="imageauthorid" value="' . $item["author_id"] . '" />';
            echo '
                    <button ';
            if (!isset($_SESSION['userid'])) {
                echo 'disabled ';
            }
            echo 'id="commentButton_' . $item["image_id"] . '" value="' . $item["image_id"] . '" class="button is-link sendCommentButton" type="button"><span class="icon">
                            <i class="fas fa-sharp fa-solid fa-plus"></i>
                        </span></button>
                </form>
            ';
            echo '
            </div>
            <p id="errorComment_' . $item["image_id"] . '" class="errorCommentPart">
            </p>
            </div>
            </div>
            ';
        }
        echo '<div id="pagination">';
        if ($page > 1) {
            echo '<a href="' . $_SERVER['SERVER_NAME'] . '/index.php?page=';
            echo ($page - 1);
            echo '">
                Page précédente
            </a>';
        }
        echo '<p>';
        echo $page;
        echo '/';
        echo $nbPage;
        echo '</p>';
        if ($page < $nbPage) {
            echo '<a href="' . $_SERVER['SERVER_NAME'] . '/index.php?page=';
            echo ($page + 1);
            echo '">
                    Page suivante
                </a>';
        }
        echo '</div>';
    } else {
        echo '
        <div class="card centerCard" id="emptyGalleryCard">
        <div class="card-content">
            <p class="title">
                The gallery is empty
            </p>
        </div>
    </div>
        ';
    }
    ?>
</div>

<script type="text/javascript" src="View/Home/home.js"></script>

<?php
include_once 'View/Footer/footer.php';
?>