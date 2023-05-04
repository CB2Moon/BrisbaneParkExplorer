<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include "navigator.php" ?>
    <p style="position: fixed; width: 100%; bottom: 0; left: 0; background-color: white; font-size: 0.7rem; border: 1px solid grey; margin: 0; z-index: 10000;">
        <b>Plugins & APIs used in this page: </b>
        Flickr: <i>SmugMug(2004)Flickr.https://www.flickr.com/services/api/</i> <b>|</b> 
        ToroPHP: <i>Anand, K.(2015)ToroPHP(Version 2.0.1)[Source code] https://github.com/anandkunal/ToroPHP</i>
    </p>

    <main>
        <header class="colored-header">
            <h1>Welcome to Brisbane Park</h1>
        </header>
        <section class="body">
            <article id="hot-parks" class="grid-article">
                <header class="section-header">
                    <h2>Beautiful Brisbane Parks</h2>
                    <p class="park-brief-intro"><i>The hottest parks in Brisbane City</i></p>
                </header>

                <div class="three-col-grid">
                    <?php
                    $results = getTopParksOf(5, 'all');
                    foreach ($results as $result) {
                        $id = $result['park_id'];
                        $name = $result['park_name'];
                        $address = $result['address'];
                        $area = $result['area'];
                    ?>
                        <div>
                            <div class="card">
                                <div class="card-img-block">
                                    <img src="<?php echo searchImg($name);?>" alt="<?php echo $name;?>">
                                </div>
                            
                                <h3><?php echo $name; ?></h3>
                                <p><?php echo $name; ?>, located in <?php echo $area; ?> area,
                                 is a very beautiful park. People living near <?php echo $address; ?> love going there. 
                                 This park have many types of facility, such as <?php echo resultToStr(getFacilitiesOfPark($id, 3)); ?> 
                                 In addition, many interesting activities are held here, for instance <?php echo resultToStr(getActivitiesOfPark($id, 3)); ?></p>
                                <a href="/park/<?php echo $id; ?>" class="card-learn-more decoless">Learn&nbsp;More</a>
                            </div>
                        </div>
                    <?php } ?>                    
                </div>
                <a href="/allParks" class="view-more decoless">View&nbsp;All&nbsp;Parks</a>
            </article>

            <article id="infrastructure-category" class="grid-article">
                <header class="section-header">
                    <h2>Infrastructure in Brisbane Parks</h2>
                    <p class="park-brief-intro"><i>The four main categories of facilities in Brisbane Parks</i></p>
                </header>

                <div class="two-col-grid">
                    <?php
                    $results = getFacilitiesOf(4, 'all');
                    foreach ($results as $result) {
                        $type = $result['item_type'];
                    ?>
                        <div>
                            <div class="card">
                                <div class="card-img-block">
                                    <img src="<?php echo searchImg($type);?>" alt="<?php echo $type;?>">
                                </div>
                            
                                <h3><?php echo $type; ?></h3>
                                <p>People can come to the park and use the <?php echo $type; ?> for free.</p>
                                <!--<a href="#" class="card-learn-more decoless">Learn&nbsp;More</a>-->
                            </div>
                        </div>
                    <?php } ?> 
                </div>
                <!--<a href="#" class="view-more decoless">View&nbsp;All&nbsp;Facilities</a>-->
            </article>
        </section>
    </main>
    <?php include "footer.php" ?>
</body>
</html>