<?php
header("Flag-Part-5: 4nd_4_l0t_");

if (!isset($_COOKIE['Part_4'])) {
    setcookie("Part_4", "3_3nerg0n_", time() + 3600, "/");
}

if (isset($_GET['flag'])) {
    die("Part 5: 0f_1uck!!}");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autobot Team - Transformers</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/style.css">
</head>

<body>
    <!-- Part 1: -->
    <!-- CTF{n0w_4l  -->
    <section id="autobot-carousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="public/optimus.jpg" alt="Optimus Prime">
                <div class="carousel-caption">
                    <h3>Optimus Prime</h3>
                    <p>Leader of the Autobots, a wise and powerful protector of Earth.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="public/bumblebee.jpg" alt="Bumblebee">
                <div class="carousel-caption">
                    <h3>Bumblebee</h3>
                    <p>A brave scout with a lot of courage and a big heart.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="public/ratchet.jpg" alt="Ratchet">
                <div class="carousel-caption">
                    <h3>Ratchet</h3>
                    <p>The Autobot's medic, always ready to repair and support his team.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="public/ironhide.jpg" alt="Ironhide">
                <div class="carousel-caption">
                    <h3>Ironhide</h3>
                    <p>A tough and fearless warrior, always ready for battle.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="public/jazz.jpg" alt="Jazz">
                <div class="carousel-caption">
                    <h3>Jazz</h3>
                    <p>A cool and stylish Autobot, known for his love of Earth's culture.</p>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#autobot-carousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#autobot-carousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </section>

    <section class="team-section">
        <div class="container">
            <h2>Meet the Autobots</h2>
            <div class="team-gallery">
                <div class="gallery-item">
                    <img src="public/optimus.jpg" alt="Optimus Prime">
                    <h3>Optimus Prime</h3>
                </div>
                <div class="gallery-item">
                    <img src="public/bumblebee.jpg" alt="Bumblebee">
                    <h3>Bumblebee</h3>
                </div>
                <div class="gallery-item">
                    <img src="public/ratchet.jpg" alt="Ratchet">
                    <h3>Ratchet</h3>
                </div>
                <div class="gallery-item">
                    <img src="public/ironhide.jpg" alt="Ironhide">
                    <h3>Ironhide</h3>
                </div>
                <div class="gallery-item">
                    <img src="public/jazz.jpg" alt="Jazz">
                    <h3>Jazz</h3>
                </div>
            </div>
        </div>
    </section>

    <section class="team-section">
        <div class="container">
            <h2>About the Autobots</h2>
            <p>The Autobots are a group of brave and noble robots who fight to protect the universe from the evil Decepticons. Led by the wise and powerful Optimus Prime, the Autobots work together to defend Earth and its inhabitants from harm. Each Autobot has unique abilities and strengths, making them a formidable team against their enemies. With courage, loyalty, and teamwork, the Autobots are true heroes who inspire others to stand up for what is right.</p>
        </div>
    </section>

    <section class="team-section">
        <div class="container">
            <h2>Autobot Timeline</h2>
            <ul class="list-group">
                <li class="list-group-item">1984 - The Autobots arrive on Earth and form an alliance with the humans.</li>
                <li class="list-group-item">2007 - The Autobots battle the Decepticons in Mission City.</li>
                <li class="list-group-item">2011 - The Autobots uncover a Cybertronian spacecraft on the moon.</li>
                <li class="list-group-item">2014 - The Autobots face a new threat from the mysterious Lockdown.</li>
                <li class="list-group-item">2017 - The Autobots join forces with the humans to stop Quintessa and her plan to destroy Earth.</li>
            </ul>
        </div>
    </section>

    <footer class="text-center p-3">
        <p>&copy; 2024 Autobot Team - Transformers</p>
    </footer>
    <!--???????????? ?flag ??????????? -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>