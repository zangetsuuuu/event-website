<?php
session_start();
ob_start();
$id = $_SESSION["user_id"];

include "../includes/header.logged.php";
require "../includes/session.php";
require "../scripts/functions.php";
require "../includes/pagination.php";

$events = sqlQuery("SELECT events.* FROM participants
                    JOIN events ON participants.event_id = events.event_id
                    WHERE participants.user_id = '$id'
                    ORDER BY
                        CASE
                            WHEN events.event_date >= CURRENT_DATE() THEN 0
                            ELSE 1
                        END,
                        events.event_date ASC
                    LIMIT $offset, $pageData");

if (isset($_GET["keyword"])) {
    $keyword = htmlspecialchars($_GET["keyword"]);
    $events = searchEvent($keyword, $id);

    if (empty($events)) {
        $notFound = true;
    }
}

if (isset($_POST["unjoinEvent"])) {

    if (unjoinEvent($_POST) > 0) {
        echo "
            <script>
                alert('You have cancelled event participation!');
                window.location.href = 'joined_events.php';
            </script>";
    }
}

else if (isset($_POST["logout"])) {
    logoutAccount();
    exit;
}
?>

<main>
    <div class="container mt-5 pt-5">
        <div class="d-flex mb-4 border-bottom animate__animated animate__fadeInDown animate__delay-1s">
            <div class="h3">Joined Events</div>
        </div>
        <div class="row g-4 d-flex justify-content-start mb-4">

            <?php if (empty($events) && !isset($notFound)): ?>
                <div class="alert alert-light text-center animate__animated animate__fadeInDown animate__delay-1s" role="alert">
                    <i class="fa-solid fa-info-circle me-2 pe-1"></i>You have not joined an event
                </div>
            <?php elseif (isset($notFound)): ?>
                <div class="alert alert-danger text-center animate__animated animate__fadeInDown animate__delay-1s" role="alert">
                    <i class="fa-solid fa-warning me-2 pe-1"></i>No event found
                </div>
                <?php unset($notFound); ?>
            <?php endif; ?>

            <?php foreach ($events as $row): ?>
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="card shadow-sm animate__animated animate__fadeInLeft animate__delay-1s">
                        <div class="position-relative">
                            <img src="../public/img/uploads/<?= $row['event_image']; ?>"
                                class="card-img-top img-fluid object-fit-cover" alt="<?= $row['event_name']; ?>"
                                style="height: 220px;">
                            <div class="position-absolute bottom-0 start-0 px-3 py-2 w-100"
                                style="backdrop-filter: blur(6px); background-color: rgba(0, 0, 0, 0.2);">
                                <div class="d-flex justify-content-between" style="font-size: 14px;">
                                    <div class="text-light">
                                        <i class="fa-solid fa-calendar me-1"></i>
                                        <?= date('d M Y', strtotime($row['event_date'])); ?>
                                    </div>
                                    <div class="text-light">
                                        <?= $row['registration_fee'] == 0 ? "Free" : 'Rp. ' . number_format($row['registration_fee'], 0, ',', '.'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold mb-2 text-truncate">
                                <?= $row['event_name']; ?>
                            </h5>
                            <p class="card-text text-secondary d-flex align-items-center">
                                <i class="fa-solid fa-xs fa-user-group me-2"></i>
                                <?= $row['organizer_name']; ?>
                            </p>
                            <p class="card-text mb-4 overflow-y-auto" style="height: 48px;">
                                <?= $row['event_description']; ?>
                            </p>
                            <div class="row g-2">
                                <div class="col-12 col-lg-8">        
                                    <?php 
                                    $isUpcoming = timeToEvent($row['event_date']);         
                                    $isPassed = isDatePassed($row['event_date']); 
                                    ?>         
                                    <form action="" method="post">
                                        <input type="hidden" name="eventID" value="<?= $row['event_id']; ?>">
                                        <input type="hidden" name="userID" value="<?= $id; ?>">
                                        <?php if ($isUpcoming && !$isPassed): ?>
                                            <button class="btn btn-dark w-100" disabled>
                                                <i class="fa-solid fa-hourglass-start me-2"></i><?= $isUpcoming; ?>
                                            </button>
                                        <?php else: ?>
                                            <button class="btn btn-success w-100" disabled>
                                                <i class="fa-solid fa-check me-2"></i>Event Passed
                                            </button>
                                        <?php endif; ?>
                                    </form>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="dropup">
                                        <button class="btn btn-outline-secondary dropdown-toggle w-100" type="button"
                                            id="eventMenu" data-bs-toggle="dropdown" aria-expanded="false">
                                            More
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="eventMenu">
                                            <li>
                                                <a class="dropdown-item" href="event_details.php?id=<?= $row['event_id']; ?>">Details</a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <button class="btn btn-link dropdown-item text-danger fw-bold" data-bs-toggle="modal" data-bs-target="#unjoinID<?= $row['event_id']; ?>" <?= ($isPassed) ? 'disabled' : '' ?>>
                                                    <i class="fa-solid fa-calendar-minus me-2"></i>Unjoin
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php include "../includes/events.unjoin.php"; ?>

            <?php endforeach; ?>
        </div>
    </div>

    <?php include "../includes/page.navigation.php"; ?>

    <?php include "../includes/events.search.php"; ?>
    
    <?php include "../includes/logout.popup.php"; ?>
</main>

<?php include "../includes/footer.php"; ?>