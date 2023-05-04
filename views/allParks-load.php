<?php
// API used: Flickr: SmugMug(2004)Flickr.https://www.flickr.com/services/api/
require_once('../lib/private.php');
require_once('../lib/mysql.php');
require_once('../lib/queries.php');
require_once('../lib/util.php');

$areas = $_POST['areas'];

foreach($areas as $area) {
    $parks = getTopParksOf(10, $area);                
?>
    <article class="grid-article">
        <header class="section-header">
            <h2>Parks in Area: <?php echo $area; ?></h2>
        </header>
        <div class="three-col-grid">
        <?php
            foreach ($parks as $pk) {
                $park_id = $pk['park_id'];
                $park_name = $pk['park_name'];
                $address = $pk['address'];
        ?>
                <div>
                    <div class="card">
                        <div class="card-img-block">
                            <img src="<?php echo searchImg($park_name);?>" alt="<?php echo $park_name;?>">
                        </div>
                    
                        <h3><?php echo $park_name; ?></h3>
                        <p><?php echo $park_name; ?>, located in <?php echo $area; ?> area,
                        is a very beautiful park. People living near <?php echo $address; ?> love going there. 
                        This park have many types of facility, such as <?php echo resultToStr(getFacilitiesOfPark($park_id, 3)); ?> 
                        In addition, many interesting activities are held here, for instance <?php echo resultToStr(getActivitiesOfPark($park_id, 3)); ?></p>
                        <a href="/park/<?php echo $park_id; ?>" class="card-learn-more decoless">Learn&nbsp;More</a>
                    </div>
                </div>
        <?php } ?>
        </div>
    </article>
<?php } ?>