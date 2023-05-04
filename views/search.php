<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search</title>
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="../css/leaflet.css" />
    <link rel="stylesheet" href="../css/MarkerCluster.css" />
    <link rel="stylesheet" href="../css/MarkerCluster.Default.css" />
    <script src="../js/jquery-3.6.1.min.js"></script>
    <script src="../js/search.js"></script>
    <script src="../js/leaflet.js"></script>
    <script src="../js/leaflet.markercluster.js"></script>
</head>
<body class="scroll-bar">
<?php include "navigator.php" ?>
<p style="position: fixed; width: 100%; bottom: 0; left: 0; background-color: white; font-size: 0.7rem; border: 1px solid grey; margin: 0; z-index: 10000;">
    <b>Plugins & APIs used in this page: </b>
    Flickr: <i>SmugMug(2004)Flickr.https://www.flickr.com/services/api/</i> <b>|</b> 
    jQuery: <i>jQuery(2006)jQuery(Version 3.6.1)[Source code] https://github.com/jquery</i> <b>|</b> 
    Leaflet: <i>Agafonkin, V.(2011)Leaflet(Version 1.9.2)[Source code] https://github.com/Leaflet/Leaflet</i> <b>|</b> 
    ToroPHP: <i>Anand, K.(2015)ToroPHP(Version 2.0.1)[Source code] https://github.com/anandkunal/ToroPHP</i>
</p>
    <main id="search-main">
        <header class="colored-header">
            <h1>Search&#x1F50E;</h1>
        </header>
        <form action="#">
            <span>&#x1F50E;</span>
            <input id="search-input" name="search" type="text" placeholder="Search parks, facilities, or activities">
            <ul id="search-suggestions" class="scroll-bar">
            </ul>
        </form>
        <section id="map-search-container">
            <article id="map"></article>
            <article id="marker-result">
                <div style="display: <?php echo $hasSearched ? 'none': 'block';?>;" id="no-marker-clicked">
                    <p>: )</p>
                    <p>Click a marker to show information of the park</p>
                </div>
                <div style="display: <?php echo $hasSearched ? 'flex': 'none';?>;"  id="marker-clicked">
                </div>
            </article>
        </section>
    </main>
</body>
</html>