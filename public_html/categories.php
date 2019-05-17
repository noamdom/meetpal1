<?php
require_once('../private/init.php');



if ($_SERVER['REQUEST_METHOD'] === 'GET') {

} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//
}
?>
<?php $page_title = 'categories'; ?>
<?php include SHARED_PATH . '/shared_header.php' ?>

<style>
    div.gallery {
        margin: 5px;
        border: 1px solid #f9f7f7;
        float: left;
        width: 150px;
        height: 150px;
        background-color: #f9f7f7;
        border-color: #ddcccc;
        border-radius: 15px;
    }



    .medi-class
    {
        height: 100px;
    }
    h1
    {
        margin-top: 50px;
        color: #A1D8D0;
        text-align: center;
        font-family: "Rockwell"
    }

    .all-catogories
    {
        margin-left: 33%;
        margin-bottom: 100px;

    }

    .pic{
        height: 50px;
        width: 50px;
        /* padding: 20px; */
        margin-top: 20px;
        margin-left: auto;
        margin-right: auto;
    }

    .pic-meditation
    {
        height: 99px;
        width: 100px;
        margin-left: auto;
        margin-right: auto;

    }
    .container {
        width: 50%;
    }

    div.gallery:hover {
        border: 1px solid #777;
        opacity: 0.8;
    }

    div.gallery img {
        width: 100%;
        height: auto;
    }

    div.desc {
        /* padding: 20px; */
        text-align: center;
        color: #A1D8D0;
        font-family: "Rockwell";
        position: relative;
        margin-top: 30%

    }

    .footer {
        position: fixed;
        left: 0;
        bottom: 0;
        height: 6%;
        width: 100%;
        background: #f9f7f7;
        color: white;
        text-align: center;
        border: 4px solid #EDE4E4;

    }

    .logo {
        margin-left: 20%;
        margin-right: 35%;
    }


    .header {
        background:  #f9f7f7;
        color: white;
        height: 70px;
        border-bottom: 4px solid #EDE4E4;
    }
</style>
    <main>
        <h1>Choose Category</h1>
        <div class="all-catogories">
            <div class="container">

                <div class="row">

                    <div class="gallery">
                        <a  href="choose-act.php?cate=arts">
                            <div class="pic"><img src="assets/arts.png" class="pic" alt="Cinque Terre" width="600" height="400"></div>
                            <div class="desc">Arts</div>
                        </a>

                    </div>

                    <div class="gallery">
                        <a  href="choose-act.php?cate=baking">
                            <div class="pic"><img src="assets/baking.png" class="pic" alt="Forest" width="600" height="400"></div>
                            <div class="desc">Baking</div>
                        </a>

                    </div>

                    <div class="gallery">
                        <a  href="choose-act.php?cate=cooking">
                            <div class="pic"><img src="assets/cooking.png" class="pic" alt="Northern Lights" width="2" height="2"></div>
                            <div class="desc">Cooking</div>
                        </a>

                    </div>
                </div>


                <div class="row">
                    <div class="gallery">
                        <a  href="choose-act.php?cate=design">
                            <div class="pic"><img src="assets/design.png" class="pic" alt="design" width="600" height="400"></div>
                            <div class="desc">Design</div>
                        </a>

                    </div>


                    <div class="gallery">
                        <a  href="choose-act.php?cate=massage">
                            <div class="pic"> <img src="assets/Massage.png" class="pic" alt="Cinque Terre" width="600" height="400"></div>
                            <div class="desc">Massage</div>
                        </a>

                    </div>

                    <div class="gallery">
                        <a  href="choose-act.php?cate=meditation">
                            <div class="pic"><img src="assets/meditation.png" class="pic" alt="meditation" width="600" height="400" class="medi-class"></div>
                            <div class="desc">Meditation</div>
                        </a>

                    </div>

                </div>

                <div class="row">
                    <div class="gallery">
                        <a  href="choose-act.php?cate=run">
                            <div class="pic"> <img src="assets/run.png" class="pic" alt="run" width="600" height="400"></div>
                            <div class="desc">Running</div>
                        </a>

                    </div>

                    <div class="gallery">
                        <a  href="choose-act.php?cate=yoga">
                            <div class="pic"><img src="assets/yoga.png" class="pic" alt="yoga" width="600" height="400"></div>
                            <div class="desc">Yoga</div>
                        </a>

                    </div>

                    <div class="gallery">
                        <a  href="choose-act.php?cate=music">
                            <div class="pic"><img src="assets/music.png" class="pic" alt="music" width="600" height="400"></div>
                            <div class="desc">Music</div>
                        </a>

                    </div>


                </div>


            </div>
        </div>
        <br>
        <br>
        <br>
        <br>
        <br>

    </main>



<?php
include SHARED_PATH . '/shared_footer.php';
