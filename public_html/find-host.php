<?php
require_once('../private/init.php');


if ($_SERVER['REQUEST_METHOD'] === 'GET') {

} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//
}
?>
<?php $page_title = 'find / host act'; ?>
<?php include SHARED_PATH . '/shared_header.php' ?>


<style>

    .container {
        width: 70%;
        margin-left: 15%;
    }
    .grid-container {
        display: grid;
        grid-template-columns: auto auto;
        /*background-color: #cccccc;*/
        width: 70%;
        margin: 15%;
        /*padding: 10px;*/
    }
    .grid-item {
        /*width: 50%;*/
        background-color: rgba(255, 255, 255, 0.8);
        border: 1px solid rgba(0, 0, 0, 0.8);
        /*margin: 3%;*/
        /*padding: 20px;*/
        /*font-size: 30px;*/
        /*text-align: center;*/
    }

    div.gallery {
        display: inline-block;

        margin: 7%;
        border: 1px solid #f9f7f7;
        /*float: left;*/
        width: 30%;
        height: 12rem;
        background-color: #f9f7f7;
        border-color: #ddcccc;
        border-radius: 15px;
        margin-top: 200px;
        margin-left: auto;
        margin-right: auto;
    }





    h1
    {
        margin-top: 30px;
        color: #A1D8D0;
        text-align: center;
        font-family: "Rockwell"
    }


    div.gallery:hover {
        border: 1px solid #777;
        opacity: 0.8;
    }


</style>
   <main>

       <div class="container">

           <div class="row">

               <div class="gallery">
                   <a href="categories.php">
                       <h1>Search For Activity</h1>
                   </a>

               </div>

               <div class="gallery">
                   <a href="categories.php">
                       <h1>Add Activity</h1>
                   </a>
               </div>

           </div>

       </div>

   </main>


<?php
include SHARED_PATH . '/shared_footer.php';
